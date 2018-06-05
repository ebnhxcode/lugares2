<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HorarioAtencionProfesional extends Model {

   use SoftDeletes;
   protected $dates = ['deleted_at'];

   protected $table = 'horarios_atencion_profesionales';
   protected $primaryKey = 'id_horario_atencion';
   protected $fillable = [
      # columns
      'hora_inicio',
      'hora_termino',

      # relaciones -> pks
      'id_establecimiento',
      'id_profesional',
      'id_dia',

      # relaciones
      'id_usuario_registra',
      'id_usuario_modifica',
   ];

   public function establecimiento () {
      return $this->belongsTo(Establecimiento::class, 'id_establecimiento');
   }

   public function profesional () {
      return $this->belongsTo(Profesional::class, 'id_profesional');
   }

   public function dia () {
      return $this->belongsTo(DiaSemana::class, 'id_dia');
   }


}
