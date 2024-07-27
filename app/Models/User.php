<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const ROLE_ADMINISTRADOR = 1;
    const ROLE_VENTAS = 2;
    const ROLE_OPERADOR = 3;

    //protected $perPage = 20;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public static function recuperaUsuario($email, $pass)
    {
        if (Auth::attempt(['email' => $email, 'password' => $pass])) {
            // Si la autenticación es exitosa, devuelve el usuario autenticado
            return Auth::user();
        }      

        return null;
    }

    /**
     * Get the role name associated with the user.
     *
     * @return string
     */
    public function getRoleNameAttribute()
    {
        $roles = [
            self::ROLE_ADMINISTRADOR => 'Administrador',
            self::ROLE_VENTAS => 'Ventas',
            self::ROLE_OPERADOR => 'Operador',
        ];

        return $roles[$this->role] ?? 'Desconocido';
    }
}
