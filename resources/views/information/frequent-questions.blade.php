<!DOCTYPE html>
<html>
<head>
    <link href="{{asset('libs/fontawesome/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('libs/sbadmin/css/sb-admin-2.min.css')}}" rel="stylesheet">

	{{-- Css styles --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/components/frequent-questions.css') }}">
</head>
<body>
    <div id="accordion" class="list-container">
        <h2 class="font-weight-bold">Preguntas frecuentes:</h2>
        <br>
        
        <form class="form-inline my-2 my-lg-0 w-50 d-flex align-items-center justify-content-center">
            <input list="preguntas" class="form-control mr-sm-2 w-50" type="search" placeholder="Buscar" aria-label="Search">
            <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Buscar</button>
        </form>

        <datalist id="preguntas">
            <option value="¿Cómo iniciar sesión?"></option>
            <option value="¿Qué pasa si accidentalmente ingreso datos incorrectos y quiero corregirlos?"></option>
            <option value="¿Cómo puedo registrarme?"></option>
        </datalist>

        <div class="card container">
            <span>1</span>
            <div class="card-header" id="headingOne">
                <h4 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        ¿Cómo iniciar sesión?
                    </button>
                </h4>
            </div>
            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    Para iniciar sesión, por favor ingrese sus credenciales en la página de inicio de sesión y haga clic en "Iniciar sesión".
                </div>
            </div>
        </div>

        <div class="card container">
            <span>2</span>
            <div class="card-header" id="headingTwo">
                <h4 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        ¿Qué pasa si accidentalmente ingreso datos incorrectos y quiero corregirlos?
                    </button>
                </h4>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="card-body">
                    Si ingresó datos incorrectos, puede corregirlos de manera sencilla ingresando a la sección de registros y dando clic a la opción "Solicitar revisión" seguida de una descripción breve sobre los cambios a corregir.
                </div>
            </div>
        </div>

        <div class="card container">
            <span>3</span>
            <div class="card-header" id="headingThree">
                <h4 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        ¿Cómo puedo registrarme?
                    </button>
                </h4>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                <div class="card-body">
                    Lamentablemente el registro a esta plataforma no está autorizado, sin embargo, puede solicitar la creación de una cuenta o las credenciales necesarias al administrador.
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('libs/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('libs/sbadmin/js/sb-admin-2.min.js')}}"></script>

	{{-- Scripts own --}}
    <script src="{{asset('js/components/frequent-questions.js')}}"></script>
</body>
</html>