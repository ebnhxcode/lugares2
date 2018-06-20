<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HorarioAtencionEstablecimiento extends Model {

   use SoftDeletes;
   protected $dates = ['deleted_at'];

   protected $table = 'horarios_atencion_establecimientos';
   protected $primaryKey = 'id_horario_atencion_establecimiento';
   protected $fillable = [
      # columns
      'hora_inicio_atencion',
      'hora_termino_atencion',
      'obs_atencion_establecimiento',

      # relaciones -> pks
      'id_establecimiento',
      'id_dia_atencion',

      # relaciones
      'id_usuario_registra',
      'id_usuario_modifica',
   ];

   public function establecimiento () {
      return $this->belongsTo(Establecimiento::class, 'id_establecimiento');
   }

   public function dia () {
      return $this->belongsTo(DiaSemana::class, 'id_dia_atencion');
   }
}
