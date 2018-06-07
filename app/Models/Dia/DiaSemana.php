<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiaSemana extends Model {

   use SoftDeletes;
   protected $dates = ['deleted_at'];

   protected $table = 'dias_semana';
   protected $primaryKey = 'id_dia_semana';
   protected $fillable = [
      # columns
      'nom_dia_semana',
      'orden',

      # relaciones
      'id_usuario_registra',
      'id_usuario_modifica',
   ];
}
