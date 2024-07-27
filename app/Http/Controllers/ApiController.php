<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Models\Estante;
use App\Models\ReportesEstante;
use DateTime;
use DateTimeZone;
use App\Models\Area;
use App\Models\Maquina;
use App\Models\Operador;

class ApiController extends Controller
{
    // OBTENER ESTANTES
    public function obtenerEstantes()
    {
        $estantes = Estante::all();

        if ($estantes->isEmpty()) {
            return response()->json(['estantes' => null], 403);
        }

        return response()->json(['estantes' => $estantes], 200);
    }

    // OBTENER AREAS-MAQUINAS-OPERADORES
    public function obtenerAreas()
    {
        try {
            $areas = DB::table('areas')->get();

            if ($areas->isEmpty()) {
                return Response::json(['areas' => null], 403);
            }

            $infoAreas = ['areas' => []];

            foreach ($areas as $area) {
                $idArea = $area->id;
                $maquinas = DB::table('maquinas')->where('id_area', $idArea)->get();
                $operadores = DB::table('operadores')->where('id_area', $idArea)->get();

                $area->maquinas = $maquinas;
                $area->operadores = $operadores;

                $infoAreas['areas'][] = $area;
            }

            return Response::json($infoAreas, 200);
        } catch (\Exception $e) {
            return Response::json(['error' => 'La conexion falló: ' . $e->getMessage()], 500);
        }
    }

    // MANEJO DE REGISTROS MAQUINADO
    public function manejarRegistrosMaquinado(Request $request)
    {
        date_default_timezone_set('America/Mexico_City');

        $datos = $request->query('datos', '');
        $area = $request->query('area', '');
        $id_maquina = $request->query('maquina', '');
        $operador = $request->query('operador', '');
        $accion = $request->query('accion', '');

        $separador = "-";
        $separada = explode($separador, $datos);

        $codigo_proyecto = $separada[0] . "-" . $separada[1];
        $codigo_partida = $datos;

        $turno = $this->determinarTurno();
        $incompletos = $this->verificarRegistrosIncompletos($id_maquina, $codigo_proyecto, $codigo_partida);

        if (count($incompletos) > 0) {
            $this->manejarRegistrosIncompletos($incompletos, $turno, $area, $operador);
            return response()->json(['message' => 'Registros incompletos manejados'], 200);
        }

        if ($accion == 'entrada') {
            $accion_ultimo_registro = $this->obtenerAccionUltimoRegistro($codigo_proyecto, $codigo_partida, $id_maquina);
    
            if ($accion_ultimo_registro == null || $accion_ultimo_registro == 'turno terminado' || $accion_ultimo_registro == 'pieza terminada') {
                if ($this->insertarRegistroMaquinado($codigo_proyecto, $codigo_partida, $turno, $accion, 'proceso', $area, $id_maquina, $operador)) {
                    return response()->json(['message' => 'Entrada insertada'], 201);
                } else {
                    return response()->json(['message' => 'Error al insertar entrada'], 500);
                }
            } else {
                return response()->json(['message' => 'Falta un registro de salida'], 402);
            }
    
        } else {
            $accion_ultimo_registro = $this->obtenerAccionUltimoRegistro($codigo_proyecto, $codigo_partida, $id_maquina);
    
            if ($accion_ultimo_registro == 'entrada') {
                if ($this->insertarRegistroMaquinado($codigo_proyecto, $codigo_partida, $turno, $accion, 'proceso', $area, $id_maquina, $operador)) {
                    return response()->json(['message' => 'Salida insertada'], 202);
                } else {
                    return response()->json(['message' => 'Error al insertar salida'], 500);
                }
            } else {
                return response()->json(['message' => 'Falta un registro de entrada'], 401);
            }
        }
    }

    private function determinarTurno()
    {
        $hora_actual = new DateTime('now', new DateTimeZone('America/Mexico_City'));
        $hora = (int) $hora_actual->format('H');

        if ($hora >= 7 && $hora < 15) {
            return 'primero';
        } elseif ($hora >= 15 && $hora < 22) {
            return 'segundo';
        }
    }

    private function insertarRegistroMaquinado($codigo_proyecto, $codigo_partida, $turno, $accion, $estatus, $area, $maquina, $operador)
    {
        try {
            DB::select('CALL insertarRegistroMaquinado(?, ?, ?, ?, ?, ?, ?, ?)', [
                $codigo_proyecto, $codigo_partida, $turno, $accion, $estatus, $area, $maquina, $operador
            ]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function obtenerAccionUltimoRegistro($codigo_proyecto, $codigo_partida, $id_maquina)
    {
        $result = DB::table('reportes_maquinado')
            ->where('codigo_proyecto', $codigo_proyecto)
            ->where('codigo_partida', $codigo_partida)
            ->where('id_maquina', $id_maquina)
            ->orderBy('fecha', 'desc')
            ->orderBy('hora', 'desc')
            ->first();

        return $result ? $result->accion : null;
    }

    // MANEJO DE REGISTROS INCOMPLETOS
    public function verificarRegistrosIncompletos($id_maquina, $codigo_proyecto_ignore, $codigo_partida_ignore)
    {
        $entradas = DB::table('reportes_maquinado')
            ->select('codigo_proyecto', 'codigo_partida', 'id_maquina', 'id_operador', 'id_area', DB::raw('COUNT(*) AS entradas'))
            ->where('accion', 'entrada')
            ->where('id_maquina', $id_maquina)
            ->groupBy('codigo_proyecto', 'codigo_partida', 'id_maquina', 'id_operador', 'id_area')
            ->get()
            ->toArray();

        $salidas = DB::table('reportes_maquinado')
            ->select('codigo_proyecto', 'codigo_partida', 'id_maquina', 'id_operador', 'id_area', DB::raw('COUNT(*) AS salidas'))
            ->whereIn('accion', ['turno terminado', 'pieza terminada'])
            ->where('id_maquina', $id_maquina)
            ->groupBy('codigo_proyecto', 'codigo_partida', 'id_maquina', 'id_operador', 'id_area')
            ->get()
            ->toArray();

        $incompletos = [];

        // Convertir los resultados a arrays para procesar
        $entradas_array = json_decode(json_encode($entradas), true);
        $salidas_array = json_decode(json_encode($salidas), true);

        foreach ($entradas_array as $entrada) {
            if ($entrada['codigo_proyecto'] == $codigo_proyecto_ignore && $entrada['codigo_partida'] == $codigo_partida_ignore) {
                continue;
            }

            $encontrado = false;
            foreach ($salidas_array as $salida) {
                if ($entrada['codigo_proyecto'] == $salida['codigo_proyecto'] &&
                    $entrada['codigo_partida'] == $salida['codigo_partida'] &&
                    $entrada['id_maquina'] == $salida['id_maquina'] &&
                    $entrada['id_area'] == $salida['id_area'] &&
                    $entrada['id_operador'] == $salida['id_operador']) {
                    $encontrado = true;
                    if ($entrada['entradas'] > $salida['salidas']) {
                        $incompletos[] = array_merge($entrada, ['faltante' => 'pieza terminada']);
                    }
                    break;
                }
            }
            if (!$encontrado) {
                $incompletos[] = array_merge($entrada, ['faltante' => 'pieza terminada']);
            }
        }

        foreach ($salidas_array as $salida) {
            if ($salida['codigo_proyecto'] == $codigo_proyecto_ignore && $salida['codigo_partida'] == $codigo_partida_ignore) {
                continue;
            }

            $encontrado = false;
            foreach ($entradas_array as $entrada) {
                if ($salida['codigo_proyecto'] == $entrada['codigo_proyecto'] &&
                    $salida['codigo_partida'] == $entrada['codigo_partida'] &&
                    $salida['id_maquina'] == $entrada['id_maquina'] &&
                    $salida['id_area'] == $entrada['id_area'] &&
                    $salida['id_operador'] == $entrada['id_operador']) {
                    $encontrado = true;
                    break;
                }
            }
            if (!$encontrado) {
                $incompletos[] = array_merge($salida, ['faltante' => 'entrada']);
            }
        }

        return $incompletos;
    }

    private function manejarRegistrosIncompletos($incompletos, $turno, $area, $operador)
    {
        foreach ($incompletos as $incompleto) {
            $codigo_proyecto = $incompleto->codigo_proyecto;
            $codigo_partida = $incompleto->codigo_partida;
            $maquinaF = $incompleto->id_maquina;
            $areaF = $incompleto->id_area;
            $operadorF = $incompleto->id_operador;
            $accion_faltante = $incompleto->faltante;
            $estatus = 'revisar';

            $this->insertarRegistroMaquinado($codigo_proyecto, $codigo_partida, $turno, $accion_faltante, $estatus, $areaF, $maquinaF, $operadorF);
        }
    }

    // INSERTAR REGISTROS FALTANTES MAQUINADO
    public function insertarRegistrosFaltantesMaquinado(Request $request)
    {
        date_default_timezone_set('America/Mexico_City');

        $datos = $request->query('datos', '');
        $area = $request->query('area', '');
        $id_maquina = $request->query('maquina', '');
        $operador = $request->query('operador', '');
        $accion = $request->query('accion', '');
        $faltante = $request->query('faltante', '');

        $separador = "-";
        $separada = explode($separador, $datos);

        $codigo_proyecto = $separada[0] . "-" . $separada[1];
        $codigo_partida = $datos;

        $turno = $this->determinarTurno();
        
        if ($faltante == 402) {
            return $this->insertarRegistrosEnOrden($codigo_proyecto, $codigo_partida, $turno, 'turno terminado', $accion, 'proceso', $area, $id_maquina, $operador);
        } elseif ($faltante == 401) {
            return $this->insertarRegistrosEnOrden($codigo_proyecto, $codigo_partida, $turno, 'entrada', $accion, 'proceso', $area, $id_maquina, $operador);
        } else {
            return response()->json(['message' => 'Valor de faltante no válido'], 400);
        }
    }

    private function insertarRegistrosEnOrden($codigo_proyecto, $codigo_partida, $turno, $accion_faltante, $accion, $estatus, $area, $maquina, $operador)
    {
        if ($this->insertarRegistroMaquinado($codigo_proyecto, $codigo_partida, $turno, $accion_faltante, 'revisar', $area, $maquina, $operador)) {
            sleep(1);
            
            if ($this->insertarRegistroMaquinado($codigo_proyecto, $codigo_partida, $turno, $accion, $estatus, $area, $maquina, $operador)) {
                return response()->json(['message' => 'Registros insertados correctamente'], 200);
            } else {
                return response()->json(['message' => 'No se pudo insertar el registro: ' . $accion], 500);
            }
        } else {
            return response()->json(['message' => 'No se pudo insertar el registro faltante: ' . $accion_faltante], 500);
        }
    }

    // MANEJO DE REGISTROS ESTANTE
    public function manejarRegistrosEstante(Request $request)
    {
        date_default_timezone_set('America/Mexico_City');

        $datos = $request->query('datos', '');
        $estante = $request->query('estante', '');

        $separador = "-";
        $separada = explode($separador, $datos);

        $codigo_proyecto = $separada[0] . "-" . $separada[1];
        $codigo_partida = $datos;

        // Obtener la acción del último registro
        $accion_ultimo_registro = $this->obtenerAccionUltimoRegistroEstante($codigo_proyecto, $codigo_partida, $estante);

        // Verificar si el registro es una salida o una entrada
        if (is_null($accion_ultimo_registro) || $accion_ultimo_registro == 'salida') {
            if (!$this->verificarRegistroDuplicado($codigo_proyecto, $codigo_partida, $estante)) {

                if ($this->insertarRegistroEstante($codigo_proyecto, $codigo_partida, 'entrada', 'conforme', $estante)) {
                    return response()->json(['message' => 'Entrada insertada'], 201);
                } else {
                    return response()->json(['message' => 'No se insertó el registro'], 500);
                }

            } else {
                return response()->json(['message' => 'Registro duplicado'], 410);
            }
        } else {
            if (!$this->verificarRegistroDuplicado($codigo_proyecto, $codigo_partida, $estante)) {

                if ($this->insertarRegistroEstante($codigo_proyecto, $codigo_partida, 'salida', 'conforme', $estante)) {
                    return response()->json(['message' => 'Salida insertada'], 202);
                } else {
                    return response()->json(['message' => 'No se insertó el registro'], 500);
                }

            } else {
                return response()->json(['message' => 'Registro duplicado'], 410);
            }
        }
    }

    private function verificarRegistroSalida($codigo_proyecto, $codigo_partida, $estante)
    {
        return ReportesEstante::where('codigo_proyecto', $codigo_proyecto)
            ->where('codigo_partida', $codigo_partida)
            ->where('accion', 'salida')
            ->where('id_estante', $estante)
            ->exists();
    }

    private function verificarRegistroDuplicado($codigo_proyecto, $codigo_partida, $estante)
    {
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        $hora_hace_1_minutos = date('H:i:s', strtotime('-1 minutes'));

        $count = ReportesEstante::where('codigo_proyecto', $codigo_proyecto)
            ->where('codigo_partida', $codigo_partida)
            ->where('id_estante', $estante)
            ->where('fecha', $fecha)
            ->whereBetween('hora', [$hora_hace_1_minutos, $hora])
            ->count();

        return $count > 0;
    }

    private function insertarRegistroEstante($codigo_proyecto, $codigo_partida, $accion, $estatus, $estante)
    {
        try {
            DB::statement('CALL insertarRegistroEstante(?, ?, ?, ?, ?)', [
                $codigo_proyecto, $codigo_partida, $accion, $estatus, $estante
            ]);
            return true;
        } catch (\Exception $e) {
            // Manejo de errores
            return false;
        }
    }

    private function obtenerAccionUltimoRegistroEstante($codigo_proyecto, $codigo_partida, $estante)
    {
        $registro = ReportesEstante::where('codigo_proyecto', $codigo_proyecto)
            ->where('codigo_partida', $codigo_partida)
            ->where('id_estante', $estante)
            ->orderBy('fecha', 'desc')
            ->orderBy('hora', 'desc')
            ->first();

        return $registro ? $registro->accion : null;
    }

    // http://127.0.0.1:8000/manejar-registros-maquinado?datos=123-0987-09.01&area=1&maquina=1&operador=1&accion=turno terminado
    // http://127.0.0.1:8000/manejar-registros-estante?datos=098-0987-09.09&estante=1
    // http://127.0.0.1:8000/insertar-registros-faltantes-maquinado?datos=123-0987-09.01&area=1&maquina=1&operador=1&accion=turno terminado&faltante=401
    // http://127.0.0.1:8000/obtener-areas
    // http://127.0.0.1:8000/obtener-estantes
}
