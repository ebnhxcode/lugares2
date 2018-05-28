<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ambiente extends Model {
   use SoftDeletes;
   protected $dates = ['deleted_at'];

   protected $table = "ambientes";
   protected $primaryKey = "id_ambiente";
   protected $fillable = [
      #columns
      'nom_ambiente',
      'det_ambiente',

      #relaciones -> pks

      'id_usuario_registra',
      'id_usuario_modifica',
   ];

   public function servidores  () {
      return $this->hasMany(Servidor::class, 'id_ambiente');
   }

   public function usuario_registra() {
      return $this->belongsTo(User::class, 'id_usuario_registra');
   }

   public function usuario_modifica() {
      return $this->belongsTo(User::class, 'id_usuario_modifica');
   }
}
