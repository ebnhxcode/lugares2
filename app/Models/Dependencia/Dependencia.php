<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dependencia extends Model {

   use SoftDeletes;
   protected $dates = ['deleted_at'];

   protected $table = 'dependencias';
   protected $primaryKey = 'id_dependencia';
   protected $fillable = [
      # columns
      'nom_dependencia',
      'det_dependencia',

      # relaciones
      'id_usuario_registra',
      'id_usuario_modifica',
   ];

}
