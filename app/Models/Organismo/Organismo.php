<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organismo extends Model {

   use SoftDeletes;
   protected $dates = ['deleted_at'];

   protected $table = 'organismos';
   protected $primaryKey = 'id_organismo';
   protected $fillable = [
      # columns
      'nom_organismo',
      'det_organismo',
      'cod_organismo',

      # relaciones -> pks
      'id_tipo_organismo',

      # relaciones
      'id_usuario_registra',
      'id_usuario_modifica',
   ];

   public function tipo_organismo () {
      return $this->belongsTo(TipoOrganismo::class, 'id_tipo_organismo');
   }

}
