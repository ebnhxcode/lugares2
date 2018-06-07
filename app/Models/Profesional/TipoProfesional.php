<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoProfesional extends Model {

   use SoftDeletes;
   protected $dates = ['deleted_at'];

   protected $table = 'tipos_profesionales';
   protected $primaryKey = 'id_tipo_profesional';
   protected $fillable = [
      # columns
      'nom_tipo_profesional',
      'det_tipo_profesional',

      # relaciones
      'id_usuario_registra',
      'id_usuario_modifica',
   ];

   public function profesionales () {
      return $this->hasMany(Profesional::class, 'id_tipo_profesional');
   }
}
