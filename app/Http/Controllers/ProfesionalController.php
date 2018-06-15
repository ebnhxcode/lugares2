<?php

namespace App\Http\Controllers;

use App\Cargo;
use App\Estado;
use App\Profesional;
use App\TipoProfesional;
use Illuminate\Http\Request;
use Auth;

use Illuminate\Support\Facades\Validator;

class ProfesionalController extends Controller {

   private $nombre_modelo;
   private $nombre_tabla;
   private $nombre_ruta;
   private $nombre_detalle;
   private $nombre_controller;

   private $profesionales;
   private $tipos_profesionales;
   private $cargos;
   private $estados;
   private $profesional;
   private $new_profesional;
   private $validacion;
   private $per_page;

   public function __construct () {
      $this->middleware('auth');
      $this->middleware('d');
      $this->nombre_modelo = "profesional"; //nombre tabla o de ruta
      $this->nombre_tabla = $this->nombre_ruta = "profesionales";
      $this->nombre_detalle = "Profesionales";
      $this->nombre_controller = "ProfesionalController";
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

         $this->profesionales = Profesional::with([
            'tipo_profesional','cargo','estado'
         ])->paginate((int)$this->per_page);
         $this->tipos_profesionales = TipoProfesional::all();
         $this->cargos = Cargo::all();
         $this->estados = Estado::all();

         $this->usuario_auth = Auth::user();
         return response()->json([
            'status' => 200,
            'profesionales' => $this->profesionales,
            'tipos_profesionales' => $this->tipos_profesionales,
            'cargos' => $this->cargos,
            'estados' => $this->estados,
            'usuario_auth' => $this->usuario_auth,
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

      $this->profesional = Profesional::with([
         'tipo_profesional','cargo','estado'
      ])->where("id_$this->nombre_modelo",'=',$id)->first();

      #Valida si role existe y busca si tiene servidor_permiso
      if ($this->profesional) {
         return response()->json([
            'status' => 200, //Para los popups con alertas de sweet alert
            'tipo' => 'eliminacion_exitosa', //Para las notificaciones
            'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro encontrado exitosamente."]],
            'profesional' => $this->profesional,
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
         'nom_profesional' => "regex:/(^([a-zA-Z0-9_ -áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|required|max:255",
         'det_profesional' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&-áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",

         'id_tipo_profesional' => "regex:/(^([0-9]+)(\d+)?$)/u|required|max:255",
         'id_cargo' => "regex:/(^([0-9]+)(\d+)?$)/u|required|max:255",
         'id_estado' => "regex:/(^([0-9]+)(\d+)?$)/u|required|max:255",
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
      $this->profesional = $request->all();
      #Se crea el nuevo registro
      $this->new_profesional = Profesional::create([
         'nom_profesional' => $this->profesional['nom_profesional'],
         'det_profesional' => $this->profesional['det_profesional'],

         'id_tipo_profesional' => $this->profesional['id_tipo_profesional'],
         'id_cargo' => $this->profesional['id_cargo'],
         'id_estado' => $this->profesional['id_estado'],
         'id_usuario_registra' => Auth::user()->id_usuario,
         'id_usuario_modifica' => Auth::user()->id_usuario,
      ]);

      unset($this->profesional, $this->validacion);

      return response()->json([
         'status' => 200, //Para los popups con alertas de sweet alert
         'tipo' => 'creacion_exitosa', //Para las notificaciones
         'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro ($this->nombre_modelo) creado exitosamente."]],
         //Para mostrar los mensajes que van desde el backend
         'profesional' => $this->new_profesional
      ]);
   }

   public function update(Request $request, $id) {
      #Se realiza validacion de los parametros de entrada que vienen desde el formulario
      $this->validacion = Validator::make($request->all(), [
         'id_profesional' => 'regex:/(^([0-9]+)(\d+)?$)/u|required|max:255',
         'nom_profesional' => "regex:/(^([a-zA-Z0-9_ -áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|required|max:255",
         'det_profesional' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&-áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",

         'id_tipo_profesional' => "regex:/(^([0-9]+)(\d+)?$)/u|required|max:255",
         'id_cargo' => "regex:/(^([0-9]+)(\d+)?$)/u|required|max:255",
         'id_estado' => "regex:/(^([0-9]+)(\d+)?$)/u|required|max:255",
      ]);
      #Valida si la informacion que se envia para editar al profesional son iguales los ids
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
      $this->profesional = Profesional::find($request["id_$this->nombre_modelo"]);
      $request['id_usuario_modifica'] = Auth::user()->id_usuario;
      $this->profesional->update($request->all());

      #unset($this->new_profesional_permiso, $this->permiso);
      return response()->json([
         'status' => 200, //Para los popups con alertas de sweet alert
         'tipo' => 'actualizacion_exitosa', //Para las notificaciones
         'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro actualizado exitosamente."]],
         //Para mostrar los mensajes que van desde el backend
         'profesional' => $this->profesional,
      ]);
   }

   public function destroy($id) {
      #Valida si la informacion que se envia para editar al profesional son iguales los ids
      if ($this->es_vacio($id) == true || preg_match("/^[0-9]*$/",$id) == 0) {
         return response()->json([
            'status' => 200, //Para los popups con alertas de sweet alert
            'tipo' => 'error_datos_invalidos', //Para las notificaciones
            'mensajes' => ["new_$this->nombre_modelo" => [0=>"Los datos a eliminar son incorrectos."]],
         ]);
      }

      $this->profesional = Profesional::find($id);

      #Valida si profesional existe y busca si tiene profesional_permiso
      if ($this->profesional) {
         $this->profesional->delete();
      }

      return response()->json([
         'status' => 200, //Para los popups con alertas de sweet alert
         'tipo' => 'eliminacion_exitosa', //Para las notificaciones
         'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro eliminado exitosamente."]],
         //Para mostrar los mensajes que van desde el backend
      ]);
   }
}
