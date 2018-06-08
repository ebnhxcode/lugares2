<?php

namespace App\Http\Controllers;

use App\Telefono;
use App\TipoTelefono;
use App\Establecimiento;
use Illuminate\Http\Request;
use Auth;


use Illuminate\Support\Facades\Validator;

class TelefonoController extends Controller {

   private $nombre_modelo;
   private $nombre_tabla;
   private $nombre_ruta;
   private $nombre_detalle;
   private $nombre_controller;

   private $telefonos;
   private $establecimientos;
   private $tipos_telefonos;
   private $telefono;
   private $new_telefono;
   private $validacion;
   private $per_page;

   public function __construct () {
      $this->middleware('auth');
      $this->middleware('mantenedor');
      $this->nombre_modelo = "telefono"; //nombre tabla o de ruta
      $this->nombre_tabla = $this->nombre_ruta = "telefonos";
      $this->nombre_detalle = "Telefonos";
      $this->nombre_controller = "TelefonoController";
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

         $this->telefonos = Telefono::with(['tipo_telefono'])->paginate((int)$this->per_page);
         $this->tipos_telefonos = TipoTelefono::all();
         $this->establecimientos = Establecimiento::all();

         $this->usuario_auth = Auth::user();
         return response()->json([
            'status' => 200,
            'telefonos' => $this->telefonos,
            'tipos_telefonos' => $this->tipos_telefonos,
            'establecimientos' => $this->establecimientos,
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

      $this->telefono = Telefono::with(['tipo_telefono'])->where("id_$this->nombre_modelo",'=',$id)->first();

      #Valida si role existe y busca si tiene servidor_permiso
      if ($this->telefono) {
         return response()->json([
            'status' => 200, //Para los popups con alertas de sweet alert
            'tipo' => 'eliminacion_exitosa', //Para las notificaciones
            'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro encontrado exitosamente."]],
            'telefono' => $this->telefono,
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
         'num_telefono' => "regex:/(^([0-9_ -áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|required|max:255",
         'det_telefono' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&-áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'cod_area' => "regex:/(^([0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|required|max:255",
         'id_tipo_telefono' => "regex:/(^([0-9]+)(\d+)?$)/u|required|max:255",
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
      $this->telefono = $request->all();
      #Se crea el nuevo registro
      $this->new_telefono = Telefono::create([
         'num_telefono' => $this->telefono['num_telefono'],
         'det_telefono' => $this->telefono['det_telefono'],
         'cod_area' => $this->telefono['cod_area'],
         'id_tipo_telefono' => $this->telefono['id_tipo_telefono'],
         'id_usuario_registra' => Auth::user()->id_usuario,
         'id_usuario_modifica' => Auth::user()->id_usuario,
      ]);

      unset($this->telefono, $this->validacion);

      return response()->json([
         'status' => 200, //Para los popups con alertas de sweet alert
         'tipo' => 'creacion_exitosa', //Para las notificaciones
         'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro ($this->nombre_modelo) creado exitosamente."]],
         //Para mostrar los mensajes que van desde el backend
         'telefono' => $this->new_telefono
      ]);
   }

   public function update(Request $request, $id) {
      #Se realiza validacion de los parametros de entrada que vienen desde el formulario
      $this->validacion = Validator::make($request->all(), [
         'id_telefono' => 'regex:/(^([0-9]+)(\d+)?$)/u|required|max:255',
         'num_telefono' => "regex:/(^([0-9_ -áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|required|max:255",
         'det_telefono' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&-áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'cod_area' => "regex:/(^([0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|required|max:255",
         'id_tipo_telefono' => "regex:/(^([0-9]+)(\d+)?$)/u|required|max:255",
      ]);
      #Valida si la informacion que se envia para editar al telefono son iguales los ids
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
      $this->telefono = Telefono::find($request["id_$this->nombre_modelo"]);
      $request['id_usuario_modifica'] = Auth::user()->id_usuario;
      $this->telefono->update($request->all());

      #unset($this->new_telefono_permiso, $this->permiso);
      return response()->json([
         'status' => 200, //Para los popups con alertas de sweet alert
         'tipo' => 'actualizacion_exitosa', //Para las notificaciones
         'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro actualizado exitosamente."]],
         //Para mostrar los mensajes que van desde el backend
         'telefono' => $this->telefono,
      ]);
   }

   public function destroy($id) {
      #Valida si la informacion que se envia para editar al telefono son iguales los ids
      if ($this->es_vacio($id) == true || preg_match("/^[0-9]*$/",$id) == 0) {
         return response()->json([
            'status' => 200, //Para los popups con alertas de sweet alert
            'tipo' => 'error_datos_invalidos', //Para las notificaciones
            'mensajes' => ["new_$this->nombre_modelo" => [0=>"Los datos a eliminar son incorrectos."]],
         ]);
      }

      $this->telefono = Telefono::find($id);

      #Valida si telefono existe y busca si tiene telefono_permiso
      if ($this->telefono) {
         $this->telefono->delete();
      }

      return response()->json([
         'status' => 200, //Para los popups con alertas de sweet alert
         'tipo' => 'eliminacion_exitosa', //Para las notificaciones
         'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro eliminado exitosamente."]],
         //Para mostrar los mensajes que van desde el backend
      ]);
   }

}
