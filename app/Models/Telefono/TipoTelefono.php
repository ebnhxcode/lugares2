<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoTelefono extends Model {

   use SoftDeletes;
   protected $dates = ['deleted_at'];

   protected $table = 'tipos_telefonos';
   protected $primaryKey = 'id_tipo_telefono';
   protected $fillable = [
      # columns
      'nom_tipo_telefono',
      'det_tipo_telefono',

      # relaciones
      'id_usuario_registra',
      'id_usuario_modifica',
   ];

   public function telefonos () {
      return $this->hasMany(TipoTelefono::class, 'id_tipo_telefono');
   }

}