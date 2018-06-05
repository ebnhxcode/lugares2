<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HorarioVisitaEstablecimiento extends Model {

   use SoftDeletes;
   protected $dates = ['deleted_at'];

   protected $table = 'horarios_visita_establecimiento';
   protected $primaryKey = 'id_horario_visita';
   protected $fillable = [
      # columns
      'hora_inicio',
      'hora_termino',

      # relaciones -> pks
      'id_establecimiento',
      'id_dia',

      # relaciones
      'id_usuario_registra',
      'id_usuario_modifica',
   ];

   public function establecimiento () {
      return $this->belongsTo(Establecimiento::class, 'id_establecimiento');
   }

   public function dia () {
      return $this->belongsTo(DiaSemana::class, 'id_dia');
   }
}
