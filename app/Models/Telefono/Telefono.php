<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Telefono extends Model {
   use SoftDeletes;
   protected $dates = ['deleted_at'];

   protected $table = 'telefonos';
   protected $primaryKey = 'id_telefono';
   protected $fillable = [
      # columns
      'num_telefono',
      'det_telefono',
      'cod_area',

      # relaciones -> pks
      'id_tipo_telefono',

      # relaciones
      'id_usuario_registra',
      'id_usuario_modifica',
   ];

   public function tipo_telefono () {
      return $this->belongsTo(TipoTelefono::class, 'id_tipo_telefono');
   }
}
