<?php

namespace App\Http\Controllers;

use App\Region;
use App\Comuna;
use Illuminate\Http\Request;
use Auth;

use Illuminate\Support\Facades\Validator;

class ComunaController extends Controller {

   private $nombre_modelo;
   private $nombre_tabla;
   private $nombre_ruta;
   private $nombre_detalle;
   private $nombre_controller;

   private $comunas;
   private $regiones;
   private $comuna;
   private $new_comuna;
   private $validacion;
   private $per_page;

   public function __construct () {
      $this->middleware('auth');
      $this->middleware('d');
      $this->nombre_modelo = "comuna"; //nombre tabla o de ruta
      $this->nombre_tabla = $this->nombre_ruta = "comunas";
      $this->nombre_detalle = "Comunas";
      $this->nombre_controller = "ComunaController";
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

         $this->comunas = Comuna::with(['region'])->paginate((int)$this->per_page);
         $this->regiones = Region::all();

         $this->usuario_auth = Auth::user();
         return response()->json([
            'status' => 200,
            'comunas' => $this->comunas,
            'regiones' => $this->regiones,
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

      $this->comuna = Comuna::with(['region'])->where("id_$this->nombre_modelo",'=',$id)->first();

      #Valida si role existe y busca si tiene servidor_permiso
      if ($this->comuna) {
         return response()->json([
            'status' => 200, //Para los popups con alertas de sweet alert
            'tipo' => 'eliminacion_exitosa', //Para las notificaciones
            'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro encontrado exitosamente."]],
            'comuna' => $this->comuna,
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
         'id_comuna' => "regex:/(^([a-zA-Z0-9_ -]+)(\d+)?$)/u|required|max:255",
         'nom_comuna' => "regex:/(^([a-zA-Z0-9_ -áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|required|max:255",
         'det_comuna' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&-áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'alias' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'orden' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'id_region' => "regex:/(^([0-9]+)(\d+)?$)/u|required|max:255",
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
      $this->comuna = $request->all();
      #Se crea el nuevo registro
      $this->new_comuna = Comuna::create([
         'nom_comuna' => $this->comuna['nom_comuna'],
         'det_comuna' => $this->comuna['det_comuna'],
         'alias' => $this->comuna['alias'],
         'orden' => $this->comuna['orden'],
         'id_region' => $this->comuna['id_region'],
         'id_usuario_registra' => Auth::user()->id_usuario,
         'id_usuario_modifica' => Auth::user()->id_usuario,
      ]);

      unset($this->comuna, $this->validacion);

      return response()->json([
         'status' => 200, //Para los popups con alertas de sweet alert
         'tipo' => 'creacion_exitosa', //Para las notificaciones
         'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro ($this->nombre_modelo) creado exitosamente."]],
         //Para mostrar los mensajes que van desde el backend
         'comuna' => $this->new_comuna
      ]);
   }

   public function update(Request $request, $id) {
      #Se realiza validacion de los parametros de entrada que vienen desde el formulario
      $this->validacion = Validator::make($request->all(), [
         'id_comuna' => 'regex:/(^([0-9]+)(\d+)?$)/u|required|max:255',
         'nom_comuna' => "regex:/(^([a-zA-Z0-9_ -áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|required|max:255",
         'det_comuna' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&-áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'alias' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'orden' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'id_region' => "regex:/(^([0-9]+)(\d+)?$)/u|required|max:255",
      ]);
      #Valida si la informacion que se envia para editar al comuna son iguales los ids
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
      $this->comuna = Comuna::find($request["id_$this->nombre_modelo"]);
      $request['id_usuario_modifica'] = Auth::user()->id_usuario;
      $this->comuna->update($request->all());

      #unset($this->new_comuna_permiso, $this->permiso);
      return response()->json([
         'status' => 200, //Para los popups con alertas de sweet alert
         'tipo' => 'actualizacion_exitosa', //Para las notificaciones
         'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro actualizado exitosamente."]],
         //Para mostrar los mensajes que van desde el backend
         'comuna' => $this->comuna,
      ]);
   }

   public function destroy($id) {
      #Valida si la informacion que se envia para editar al comuna son iguales los ids
      if ($this->es_vacio($id) == true || preg_match("/^[0-9]*$/",$id) == 0) {
         return response()->json([
            'status' => 200, //Para los popups con alertas de sweet alert
            'tipo' => 'error_datos_invalidos', //Para las notificaciones
            'mensajes' => ["new_$this->nombre_modelo" => [0=>"Los datos a eliminar son incorrectos."]],
         ]);
      }

      $this->comuna = Comuna::find($id);

      #Valida si comuna existe y busca si tiene comuna_permiso
      if ($this->comuna) {
         $this->comuna->delete();
      }

      return response()->json([
         'status' => 200, //Para los popups con alertas de sweet alert
         'tipo' => 'eliminacion_exitosa', //Para las notificaciones
         'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro eliminado exitosamente."]],
         //Para mostrar los mensajes que van desde el backend
      ]);
   }
}
