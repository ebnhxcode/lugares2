<?php

namespace App\Http\Controllers;

use App\DiaSemana;
use Illuminate\Http\Request;
use Auth;

use Illuminate\Support\Facades\Validator;

class DiaSemanaController extends Controller {

   private $nombre_modelo;
   private $nombre_tabla;
   private $nombre_ruta;
   private $nombre_detalle;
   private $nombre_controller;

   private $dias_semana;
   private $dia_semana;
   private $new_dia_semana;
   private $validacion;
   private $per_page;

   public function __construct () {
      $this->middleware('auth');
      $this->middleware('d');
      $this->nombre_modelo = "dia_semana"; //nombre tabla o de ruta
      $this->nombre_tabla = $this->nombre_ruta = "dias_semana";
      $this->nombre_detalle = "Dias Semana";
      $this->nombre_controller = "DiaSemanaController";
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
      if ($request->wantsJson() && $request->ajax() && $request->isXmlHttpRequest()) {
         $this->validar_paginacion($request);

         $this->dias_semana = DiaSemana::paginate((int)$this->per_page);

         $this->usuario_auth = Auth::user();
         return response()->json([
            'status' => 200,
            'dias_semana' => $this->dias_semana,
            'usuario_auth' => $this->usuario_auth->load('usuario_role.role'),
         ]);
      }
   }

   public function index() {
      return view("layouts.main", [
         'nombre_modelo' => $this->nombre_modelo,
         'nombre_tabla' => $this->nombre_tabla,
         'nombre_ruta' => $this->nombre_ruta,
         'nombre_detalle' => $this->nombre_detalle,
         'nombre_controller' => $this->nombre_controller,
      ]);
   }

   public function show (Request $request, $id) {
      $result = preg_match('/(^([0-9]+)(\d+)?$)/u', $id);
      if ($this->es_vacio($id) == true || $result == 0) {
         return response()->json([
            'status' => 200, //Para los popups con alertas de sweet alert
            'tipo' => 'error_datos_invalidos', //Para las notificaciones
            'mensajes' => ["new_$this->nombre_modelo" => [0=>"Lo buscado, no se encontró."]],
         ]);
      }

      $this->dia_semana = DiaSemana::where("id_$this->nombre_modelo",'=',$id)->first();

      #Valida si role existe y busca si tiene servidor_permiso
      if ($this->dia_semana) {
         return response()->json([
            'status' => 200, //Para los popups con alertas de sweet alert
            'tipo' => 'eliminacion_exitosa', //Para las notificaciones
            'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro encontrado exitosamente."]],
            'dia_semana' => $this->dia_semana,
            //Para mostrar los mensajes que van desde el backend
         ]);
      }else{
         return response()->json([
            'status' => 200, //Para los popups con alertas de sweet alert
            'tipo' => 'error_datos_invalidos', //Para las notificaciones
            'mensajes' => ["new_$this->nombre_modelo" => [0=>"Lo buscado, no se encontró."]],
         ]);
      }

   }

   public function store(Request $request) {
      #Se realiza validacion de los parametros de entrada que vienen desde el formulario
      $this->validacion = Validator::make($request->all(), [
         'nom_dia_semana' => "regex:/(^([a-zA-Z0-9_ -áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|required|max:255",
         'orden' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&-áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|required|max:255",

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
      $this->dia_semana = $request->all();
      #Se crea el nuevo registro
      $this->new_dia_semana = DiaSemana::create([
         'nom_dia_semana' => $this->dia_semana['nom_dia_semana'],
         'orden' => $this->dia_semana['orden'],

         'id_usuario_registra' => Auth::user()->id_usuario,
         'id_usuario_modifica' => Auth::user()->id_usuario,
      ]);

      unset($this->dia_semana, $this->validacion);

      return response()->json([
         'status' => 200, //Para los popups con alertas de sweet alert
         'tipo' => 'creacion_exitosa', //Para las notificaciones
         'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro ($this->nombre_modelo) creado exitosamente."]],
         //Para mostrar los mensajes que van desde el backend
         'dia_semana' => $this->new_dia_semana
      ]);
   }

   public function update(Request $request, $id) {
      #Se realiza validacion de los parametros de entrada que vienen desde el formulario
      $this->validacion = Validator::make($request->all(), [
         'id_dia_semana' => 'regex:/(^([0-9]+)(\d+)?$)/u|required|max:255',
         'nom_dia_semana' => "regex:/(^([a-zA-Z0-9_ -áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|required|max:255",
         'orden' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&-áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|required|max:255",
      ]);
      #Valida si la informacion que se envia para editar al dia_semana son iguales los ids
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
      $this->dia_semana = DiaSemana::find($request["id_$this->nombre_modelo"]);
      $request['id_usuario_modifica'] = Auth::user()->id_usuario;
      $this->dia_semana->update($request->all());

      #unset($this->new_dia_semana_permiso, $this->permiso);
      return response()->json([
         'status' => 200, //Para los popups con alertas de sweet alert
         'tipo' => 'actualizacion_exitosa', //Para las notificaciones
         'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro actualizado exitosamente."]],
         //Para mostrar los mensajes que van desde el backend
         'dia_semana' => $this->dia_semana,
      ]);
   }

   public function destroy($id) {
      #Valida si la informacion que se envia para editar al dia_semana son iguales los ids
      if ($this->es_vacio($id) == true || preg_match("/^[0-9]*$/",$id) == 0) {
         return response()->json([
            'status' => 200, //Para los popups con alertas de sweet alert
            'tipo' => 'error_datos_invalidos', //Para las notificaciones
            'mensajes' => ["new_$this->nombre_modelo" => [0=>"Los datos a eliminar son incorrectos."]],
         ]);
      }

      $this->dia_semana = DiaSemana::find($id);

      #Valida si dia_semana existe y busca si tiene dia_semana_permiso
      if ($this->dia_semana) {
         $this->dia_semana->delete();
      }

      return response()->json([
         'status' => 200, //Para los popups con alertas de sweet alert
         'tipo' => 'eliminacion_exitosa', //Para las notificaciones
         'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro eliminado exitosamente."]],
         //Para mostrar los mensajes que van desde el backend
      ]);
   }
}
