<?php

namespace App\Http\Controllers;

use App\HorarioAtencionProfesional;
use Illuminate\Http\Request;

class HorarioAtencionProfesionalController extends Controller {
   private $usuario_auth;

   private $nombre_modelo;
   private $nombre_tabla;
   private $nombre_ruta;
   private $nombre_detalle;
   private $nombre_controller;

   private $horarios_atencion_profesionales;
   private $dias_semana;
   private $profesionales;
   private $horario_atencion_profesional;
   private $new_horario_atencion_profesional;
   private $validacion;
   private $per_page;

   public function __construct () {
      $this->middleware('auth');
      $this->middleware('mantenedor');#resrtinge a solo usuarios con permiso bajo -> D
      $this->nombre_modelo = "horario_atencion_profesional"; //nombre tabla o de ruta
      $this->nombre_tabla = $this->nombre_ruta = "horarios_atencion_profesionales";
      $this->nombre_detalle = "HorarioAtencionProfesional";
      $this->nombre_controller = "HorarioAtencionProfesionalController";
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
         'id_dia_profesional' => "regex:/(^([0-9]+)(\d+)?$)/u|required|max:255",
         'hora_inicio_profesional' => "regex:/(^([0-9_ :]+)(\d+)?$)/u|required|max:255",
         'hora_termino_profesional' => "regex:/(^([0-9_ :]+)(\d+)?$)/u|required|max:255",
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
      $this->horario_atencion_profesional = $request->all();
      #Se crea el nuevo registro
      $this->new_horario_atencion_profesional = HorarioAtencionProfesional::create([
         'id_establecimiento' => $this->horario_atencion_profesional['id_establecimiento'],
         'id_dia_profesional' => $this->horario_atencion_profesional['id_dia_profesional'],
         'hora_inicio_profesional' => $this->horario_atencion_profesional['hora_inicio_profesional'],
         'hora_termino_profesional' => $this->horario_atencion_profesional['hora_termino_profesional'],
         'id_usuario_registra' => Auth::user()->id_usuario,
         'id_usuario_modifica' => Auth::user()->id_usuario,
      ]);

      unset($this->horario_atencion_profesional, $this->validacion);

      return response()->json([
         'status' => 200, //Para los popups con alertas de sweet alert
         'tipo' => 'creacion_exitosa', //Para las notificaciones
         'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro ($this->nombre_modelo) creado exitosamente."]],
         //Para mostrar los mensajes que van desde el backend
         'horario_atencion_profesional' => $this->new_horario_atencion_profesional->load('establecimiento','dia')
      ]);
   }

   public function update(Request $request, $id) {
      #Se realiza validacion de los parametros de entrada que vienen desde el formulario
      $this->validacion = Validator::make($request->all(), [
         'id_horario_atencion_profesional' => 'regex:/(^([0-9]+)(\d+)?$)/u|required|max:255',
         'id_establecimiento' => 'regex:/(^([0-9]+)(\d+)?$)/u|required|max:255',
         'id_dia_profesional' => "regex:/(^([0-9]+)(\d+)?$)/u|required|max:255",
         'hora_inicio_profesional' => "regex:/(^([0-9_ :]+)(\d+)?$)/u|required|max:255",
         'hora_termino_profesional' => "regex:/(^([0-9_ :]+)(\d+)?$)/u|required|max:255",
      ]);
      #Valida si la informacion que se envia para editar al horario_atencion_profesional son iguales los ids
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
      $this->horario_atencion_profesional = HorarioAtencionProfesional::find($request["id_$this->nombre_modelo"]);
      $request['id_usuario_modifica'] = Auth::user()->id_usuario;
      $this->horario_atencion_profesional->update($request->all());

      #unset($this->new_horario_atencion_profesional_permiso, $this->permiso);
      return response()->json([
         'status' => 200, //Para los popups con alertas de sweet alert
         'tipo' => 'actualizacion_exitosa', //Para las notificaciones
         'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro actualizado exitosamente."]],
         //Para mostrar los mensajes que van desde el backend
         'horario_atencion_profesional' => $this->horario_atencion_profesional,
      ]);
   }

   public function destroy($id) {
      #Valida si la informacion que se envia para editar al horario_atencion_profesional son iguales los ids
      if ($this->es_vacio($id) == true || preg_match("/^[0-9]*$/",$id) == 0) {
         return response()->json([
            'status' => 200, //Para los popups con alertas de sweet alert
            'tipo' => 'error_datos_invalidos', //Para las notificaciones
            'mensajes' => ["new_$this->nombre_modelo" => [0=>"Los datos a eliminar son incorrectos."]],
         ]);
      }

      $this->horario_atencion_profesional = HorarioAtencionProfesional::find($id);

      #Valida si horario_atencion_profesional existe y busca si tiene horario_atencion_profesional_permiso
      if ($this->horario_atencion_profesional) {
         $this->horario_atencion_profesional->delete();
      }

      return response()->json([
         'status' => 200, //Para los popups con alertas de sweet alert
         'tipo' => 'eliminacion_exitosa', //Para las notificaciones
         'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro eliminado exitosamente."]],
         //Para mostrar los mensajes que van desde el backend
      ]);
   }
}
