<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profesional extends Model {

   use SoftDeletes;
   protected $dates = ['deleted_at'];

   protected $table = 'profesionales';
   protected $primaryKey = 'id_profesional';
   protected $fillable = [
      # columns
      'nom_profesional',
      'det_profesional',

      # relaciones -> pks
      'id_tipo_profesional',
      'id_cargo',
      'id_estado',

      # relaciones
      'id_usuario_registra',
      'id_usuario_modifica',
   ];

   public function tipo_profesional () {
      return $this->belongsTo(TipoProfesional::class, 'id_tipo_profesional');
   }

   public function cargo () {
      return $this->belongsTo(Cargo::class, 'id_cargo');
   }

   public function estado () {
      return $this->belongsTo(Estado::class, 'id_estado');
   }

}
