<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comuna extends Model {

   use SoftDeletes;
   protected $dates = ['deleted_at'];

   protected $table="comunas";
   protected $primaryKey="id_comuna";
   protected $fillable=[
      'id_comuna',
      'nom_comuna',
      'det_comuna',
      'alias',
      'orden',

      # relaciones -> pks
      'id_region',

      # relaciones
      'id_usuario_registra',
      'id_usuario_modifica',
   ];

   public function region () {
      return $this->belongsTo(Region::class, 'id_region');
   }

}
