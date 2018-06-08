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
      'id_establecimiento', #se define ya que el dato se ingresa manual y NO autoincremental -> PK

      # columns
      'nom_establecimiento',
      'observaciones',
      'nom_direccion',
      'num_calle',
      'nom_responsable',
      'sitio_web',
      'email',
      'cod_area_fax',
      'fax',
      'vigencia_desde',
      'fecha_cierre',

      # relaciones -> pks

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

   public function tipo_establecimiento() {
      return $this->belongsTo(TipoEstablecimiento::class, 'id_tipo_establecimiento');
   }

   public function servicio_salud() {
      return $this->belongsTo(ServicioSalud::class, 'id_servicio_salud');
   }

   public function dependencia() {
      return $this->belongsTo(Dependencia::class, 'id_dependencia');
   }

   public function organismo() {
      return $this->belongsTo(Organismo::class, 'id_organismo');
   }

   public function region() {
      return $this->belongsTo(Region::class, 'id_region');
   }

   public function comuna() {
      return $this->belongsTo(Comuna::class, 'id_comuna');
   }

   public function telefonos () {
      return $this->hasMany(Telefono::class, 'id_establecimiento');
   }

}