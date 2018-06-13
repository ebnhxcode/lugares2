<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model {

   use SoftDeletes;
   protected $dates = ['deleted_at'];

   protected $table="regiones";
   protected $primaryKey="id_region";
   protected $fillable=[
      'nom_region',
      'det_region',
      'alias',
      'orden',
      'cod_area',

      # relaciones
      'id_usuario_registra',
      'id_usuario_modifica',
   ];

   public function comunas () {
      return $this->hasMany(Comuna::class, 'id_region');
   }
}
