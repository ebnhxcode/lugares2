<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Establecimiento extends Model {

   use SoftDeletes;
   protected $dates = ['deleted_at'];

   protected $table = 'establecimientos';
   protected $primaryKey = 'id_establecimiento';
   protected $fillable = [
      # columns
      'sitio_web',
      'nom_direccion',
      'nom_responsable',
      'vigencia_desde',
      'fecha_cierre',
      'email',
      'fax',
      'tipo_establecimiento', #este era un dato anterior, ahora se definio tabla de tipos
      'observaciones',
      'nom_establecimiento',

      # relaciones -> pks
      'id_establecimiento', #se define ya que el dato se ingresa manual y NO autoincremental
      'id_establecimiento_antiguo', #debe ser string porque es un dato anterior
      'id_tipo_establecimiento',
      'id_servicio_salud',
      'id_dependencia',
      'id_organismo',
      'id_region',
      'id_comuna',

      # relaciones
      'id_usuario_registra',
      'id_usuario_modifica',
   ];

   public function establecimiento_antiguo() {
      return $this->belongsTo(Establecimiento::class, 'id_establecimiento_antiguo');
   }

   public function servicio_salud() {
      return $this->belongsTo(ServicioSalud::class, 'id_servicio_salud');
   }

   public function region() {
      return $this->belongsTo(Region::class, 'id_region');
   }

   public function comuna() {
      return $this->belongsTo(Comuna::class, 'id_comuna');
   }

}