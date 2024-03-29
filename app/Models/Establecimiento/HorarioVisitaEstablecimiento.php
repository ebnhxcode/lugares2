<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HorarioVisitaEstablecimiento extends Model {

   use SoftDeletes;
   protected $dates = ['deleted_at'];

   protected $table = 'horarios_visita_establecimientos';
   protected $primaryKey = 'id_horario_visita_establecimiento';
   protected $fillable = [
      # columns
      'hora_inicio_visita',
      'hora_termino_visita',
      'obs_visita_establecimiento',

      # relaciones -> pks
      'id_establecimiento',
      'id_dia_visita',

      # relaciones
      'id_usuario_registra',
      'id_usuario_modifica',
   ];

   public function establecimiento () {
      return $this->belongsTo(Establecimiento::class, 'id_establecimiento');
   }

   public function dia () {
      return $this->belongsTo(DiaSemana::class, 'id_dia_visita');
   }
}
