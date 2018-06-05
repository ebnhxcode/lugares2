<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoOrganismo extends Model {

   use SoftDeletes;
   protected $dates = ['deleted_at'];

   protected $table = 'tipos_organismos';
   protected $primaryKey = 'id_tipo_organismo';
   protected $fillable = [
      # columns
      'nom_tipo_organismo',
      'det_tipo_organismo',

      # relaciones
      'id_usuario_registra',
      'id_usuario_modifica',
   ];

   public function organismos () {
      return $this->hasMany(TipoOrganismo::class, 'id_tipo_organismo');
   }

}
