<?php

namespace App\Http\Controllers;

use App\ServicioSalud;
use App\Region;
use Illuminate\Http\Request;
use Auth;

use Illuminate\Support\Facades\Validator;

class ServicioSaludController extends Controller {

   private $nombre_modelo;
   private $nombre_tabla;
   private $nombre_ruta;
   private $nombre_detalle;
   private $nombre_controller;

   private $servicios_salud;
   private $regiones;
   private $servicio_salud;
   private $new_servicio_salud;
   private $validacion;
   private $per_page;

   public function __construct () {
      $this->middleware('auth');
      $this->middleware('d');
      $this->nombre_modelo = "servicio_salud"; //nombre tabla o de ruta
      $this->nombre_tabla = $this->nombre_ruta = "servicios_salud";
      $this->nombre_detalle = "ServicioSalud";
      $this->nombre_controller = "ServicioSaludController";
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

         $this->servicios_salud = ServicioSalud::with(['region'])->paginate((int)$this->per_page);
         $this->regiones = Region::all();

         $this->usuario_auth = Auth::user();
         return response()->json([
            'status' => 200,
            'servicios_salud' => $this->servicios_salud,
            'regiones' => $this->regiones,
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

      $this->servicio_salud = ServicioSalud::with(['region'])->where("id_$this->nombre_modelo",'=',$id)->first();

      #Valida si role existe y busca si tiene servidor_permiso
      if ($this->servicio_salud) {
         return response()->json([
            'status' => 200, //Para los popups con alertas de sweet alert
            'tipo' => 'eliminacion_exitosa', //Para las notificaciones
            'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro encontrado exitosamente."]],
            'servicio_salud' => $this->servicio_salud,
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
         'nom_servicio_salud' => "regex:/(^([a-zA-Z0-9_ -áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|required|max:255",
         'det_servicio_salud' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&-áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'orden' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&-áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|required|max:255",

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
      $this->servicio_salud = $request->all();
      #Se crea el nuevo registro
      $this->new_servicio_salud = ServicioSalud::create([
         'nom_servicio_salud' => $this->servicio_salud['nom_servicio_salud'],
         'det_servicio_salud' => $this->servicio_salud['det_servicio_salud'],
         'orden' => $this->servicio_salud['orden'],

         'id_region' => $this->servicio_salud['id_region'],
         'id_usuario_registra' => Auth::user()->id_usuario,
         'id_usuario_modifica' => Auth::user()->id_usuario,
      ]);

      unset($this->servicio_salud, $this->validacion);

      return response()->json([
         'status' => 200, //Para los popups con alertas de sweet alert
         'tipo' => 'creacion_exitosa', //Para las notificaciones
         'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro ($this->nombre_modelo) creado exitosamente."]],
         //Para mostrar los mensajes que van desde el backend
         'servicio_salud' => $this->new_servicio_salud
      ]);
   }

   public function update(Request $request, $id) {
      #Se realiza validacion de los parametros de entrada que vienen desde el formulario
      $this->validacion = Validator::make($request->all(), [
         'id_servicio_salud' => 'regex:/(^([0-9]+)(\d+)?$)/u|required|max:255',
         'nom_servicio_salud' => "regex:/(^([a-zA-Z0-9_ -áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|required|max:255",
         'det_servicio_salud' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&-áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'orden' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&-áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|required|max:255",

         'id_region' => "regex:/(^([0-9]+)(\d+)?$)/u|required|max:255",
      ]);
      #Valida si la informacion que se envia para editar al servicio_salud son iguales los ids
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
      $this->servicio_salud = ServicioSalud::find($request["id_$this->nombre_modelo"]);
      $request['id_usuario_modifica'] = Auth::user()->id_usuario;
      $this->servicio_salud->update($request->all());

      #unset($this->new_servicio_salud_permiso, $this->permiso);
      return response()->json([
         'status' => 200, //Para los popups con alertas de sweet alert
         'tipo' => 'actualizacion_exitosa', //Para las notificaciones
         'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro actualizado exitosamente."]],
         //Para mostrar los mensajes que van desde el backend
         'servicio_salud' => $this->servicio_salud,
      ]);
   }

   public function destroy($id) {
      #Valida si la informacion que se envia para editar al servicio_salud son iguales los ids
      if ($this->es_vacio($id) == true || preg_match("/^[0-9]*$/",$id) == 0) {
         return response()->json([
            'status' => 200, //Para los popups con alertas de sweet alert
            'tipo' => 'error_datos_invalidos', //Para las notificaciones
            'mensajes' => ["new_$this->nombre_modelo" => [0=>"Los datos a eliminar son incorrectos."]],
         ]);
      }

      $this->servicio_salud = ServicioSalud::find($id);

      #Valida si servicio_salud existe y busca si tiene servicio_salud_permiso
      if ($this->servicio_salud) {
         $this->servicio_salud->delete();
      }

      return response()->json([
         'status' => 200, //Para los popups con alertas de sweet alert
         'tipo' => 'eliminacion_exitosa', //Para las notificaciones
         'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro eliminado exitosamente."]],
         //Para mostrar los mensajes que van desde el backend
      ]);
   }

}
