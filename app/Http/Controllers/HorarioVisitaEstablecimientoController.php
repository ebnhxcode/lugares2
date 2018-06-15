<?php

namespace App\Http\Controllers;

use App\DiaSemana;
use App\Establecimiento;
use App\HorarioVisitaEstablecimiento;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;

class HorarioVisitaEstablecimientoController extends Controller {
   private $usuario_auth;

   private $nombre_modelo;
   private $nombre_tabla;
   private $nombre_ruta;
   private $nombre_detalle;
   private $nombre_controller;

   private $horarios_visita_establecimientos;
   private $dias_semana;
   private $establecimientos;
   private $horario_visita_establecimiento;
   private $new_horario_visita_establecimiento;
   private $validacion;
   private $per_page;

   public function __construct () {
      $this->middleware('auth');
      $this->middleware('c');
      $this->nombre_modelo = "horario_visita_establecimiento"; //nombre tabla o de ruta
      $this->nombre_tabla = $this->nombre_ruta = "horarios_visita_establecimientos";
      $this->nombre_detalle = "HorarioVisitaEstablecimientos";
      $this->nombre_controller = "HorarioVisitaEstablecimientoController";
   }

   private function es_vacio ($variable) {
      if (isset($variable) && !in_array($variable, [null, 'null', ''])) {
         return false;
      } else {
         return true;
      }
   }

   private function validar_paginacion ($request) {
      if (!$request->per_page) {
         $this->per_page = 20;
      } else {
         $this->per_page = $request->per_page;
      }
   }

   public function index_ajax (Request $request) {
      return null;
   }

   public function index() {
      return null;
   }

   public function show (Request $request, $id) {
      return null;
   }

   public function store(Request $request) {
      #Se realiza validacion de los parametros de entrada que vienen desde el formulario
      $this->validacion = Validator::make($request->all(), [
         'id_establecimiento' => "regex:/(^([0-9]+)(\d+)?$)/u|required|max:255",
         'id_dia_visita' => "regex:/(^([0-9]+)(\d+)?$)/u|required|max:255",
         'hora_inicio_visita' => "regex:/(^([0-9_ :]+)(\d+)?$)/u|required|max:255",
         'hora_termino_visita' => "regex:/(^([0-9_ :]+)(\d+)?$)/u|required|max:255",
      ]);
      #Se valida la respuesta con la salida de la validacion
      if ($this->validacion->fails() == true) {
         return response()->json([
            'status' => 200, //Para los popups con alertas de sweet alert
            'tipo' => 'errores_campos_requeridos', //Para las notificaciones
            'mensajes' => $this->validacion->messages(), //Para mostrar los mensajes que van desde el backend
         ]);
      }
      #Como pasó todas las validaciones, se asigna al objeto
      $this->horario_visita_establecimiento = $request->all();
      #Se crea el nuevo registro
      $this->new_horario_visita_establecimiento = HorarioVisitaEstablecimiento::create([
         'id_establecimiento' => $this->horario_visita_establecimiento['id_establecimiento'],
         'id_dia_visita' => $this->horario_visita_establecimiento['id_dia_visita'],
         'hora_inicio_visita' => $this->horario_visita_establecimiento['hora_inicio_visita'],
         'hora_termino_visita' => $this->horario_visita_establecimiento['hora_termino_visita'],
         'id_usuario_registra' => Auth::user()->id_usuario,
         'id_usuario_modifica' => Auth::user()->id_usuario,
      ]);

      unset($this->horario_visita_establecimiento, $this->validacion);

      return response()->json([
         'status' => 200, //Para los popups con alertas de sweet alert
         'tipo' => 'creacion_exitosa', //Para las notificaciones
         'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro ($this->nombre_modelo) creado exitosamente."]],
         //Para mostrar los mensajes que van desde el backend
         'horario_visita_establecimiento' => $this->new_horario_visita_establecimiento->load('establecimiento','dia')
      ]);
   }

   public function update(Request $request, $id) {
      #Se realiza validacion de los parametros de entrada que vienen desde el formulario
      $this->validacion = Validator::make($request->all(), [
         'id_horario_visita_establecimiento' => 'regex:/(^([0-9]+)(\d+)?$)/u|required|max:255',
         'id_establecimiento' => 'regex:/(^([0-9]+)(\d+)?$)/u|required|max:255',
         'id_dia_visita' => "regex:/(^([0-9]+)(\d+)?$)/u|required|max:255",
         'hora_inicio_visita' => "regex:/(^([0-9_ :]+)(\d+)?$)/u|required|max:255",
         'hora_termino_visita' => "regex:/(^([0-9_ :]+)(\d+)?$)/u|required|max:255",
      ]);
      #Valida si la informacion que se envia para editar al horario_visita_establecimiento son iguales los ids
      if ($id != $request["id_$this->nombre_modelo"]) {
         return response()->json([
            'status' => 200, //Para los popups con alertas de sweet alert
            'tipo' => 'error_datos_invalidos', //Para las notificaciones
            'mensajes' => ["new_$this->nombre_modelo" => [0=>"Los datos a guardar son incorrectos."]],
         ]);
      }
      #Se valida la respuesta con la salida de la validacion
      if ($this->validacion->fails() == true) {
         return response()->json([
            'status' => 200, //Para los popups con alertas de sweet alert
            'tipo' => 'errores_campos_requeridos', //Para las notificaciones
            'mensajes' => $this->validacion->messages(), //Para mostrar los mensajes que van desde el backend
         ]);
      }
      $this->horario_visita_establecimiento = HorarioVisitaEstablecimiento::find($request["id_$this->nombre_modelo"]);
      $request['id_usuario_modifica'] = Auth::user()->id_usuario;
      $this->horario_visita_establecimiento->update($request->all());

      #unset($this->new_horario_visita_establecimiento_permiso, $this->permiso);
      return response()->json([
         'status' => 200, //Para los popups con alertas de sweet alert
         'tipo' => 'actualizacion_exitosa', //Para las notificaciones
         'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro actualizado exitosamente."]],
         //Para mostrar los mensajes que van desde el backend
         'horario_visita_establecimiento' => $this->horario_visita_establecimiento,
      ]);
   }

   public function destroy($id) {
      #Valida si la informacion que se envia para editar al horario_visita_establecimiento son iguales los ids
      if ($this->es_vacio($id) == true || preg_match("/^[0-9]*$/",$id) == 0) {
         return response()->json([
            'status' => 200, //Para los popups con alertas de sweet alert
            'tipo' => 'error_datos_invalidos', //Para las notificaciones
            'mensajes' => ["new_$this->nombre_modelo" => [0=>"Los datos a eliminar son incorrectos."]],
         ]);
      }

      $this->horario_visita_establecimiento = HorarioVisitaEstablecimiento::find($id);

      #Valida si horario_visita_establecimiento existe y busca si tiene horario_visita_establecimiento_permiso
      if ($this->horario_visita_establecimiento) {
         $this->horario_visita_establecimiento->delete();
      }

      return response()->json([
         'status' => 200, //Para los popups con alertas de sweet alert
         'tipo' => 'eliminacion_exitosa', //Para las notificaciones
         'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro eliminado exitosamente."]],
         //Para mostrar los mensajes que van desde el backend
      ]);
   }
}
