<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id', 'created_at', 'updated'];
    protected $dates = ['fecha_de_nacimiento', 'fecha_de_ingreso'];

    protected $fillable = [
        'qr',
        'número_de_empleado',
        'name',
        'email',
        'curp',
        'fecha_de_nacimiento',
        'fecha_de_ingreso',
        'whatsapp',
        'password',
        'estatus',
        'rh',
        'puesto',
        'tipo_de_puesto',
        'tipo',
        'salario_legal',
        'salario_complemento',
        'número_de_inscripción_al_imss',
        'rfc',
        'número_del_infonavit',
        'company_id',
        'cost_center_id',
        'address',
        'document_id',
        'setting_id',
        'slug',
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //Uno a uno polimorficab
    public function image(){
        return $this->morphOne('App\Models\Image', 'imageable');
    }
}
