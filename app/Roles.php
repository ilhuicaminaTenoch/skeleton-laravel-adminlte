<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    public $timestamps = false;
    public $table = 'roles';
    public $fillable = ['nombre', 'descripcion', 'activo'];

    public function users(){
        return $this->hasMany('App\User');
    }
}
