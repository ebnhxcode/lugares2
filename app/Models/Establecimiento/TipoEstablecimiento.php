<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoEstablecimiento extends Model {

   use SoftDeletes;
   protected $dates = ['deleted_at'];

   protected $table = 'tipos_establecimientos';
   protected $primaryKey = 'id_tipo_establecimiento';
   protected $fillable = [
      # columns
      'nom_tipo_establecimiento',
      'det_tipo_establecimiento',

      # relaciones
      'id_usuario_registra',
      'id_usuario_modifica',
   ];

   public function establecimientos () {
      return $this->hasMany(Establecimiento::class, 'id_tipo_establecimiento');
   }

}
