<?php

namespace App\Http\Controllers;

use App\TipoProfesional;
use Illuminate\Http\Request;
use Auth;


use Illuminate\Support\Facades\Validator;

class TipoProfesionalController extends Controller {
   private $usuario_auth;

   private $nombre_modelo;
   private $nombre_tabla;
   private $nombre_ruta;
   private $nombre_detalle;
   private $nombre_detalle_singular;
   private $nombre_controller;

   private $tipos_profesionales;
   private $tipo_profesional;
   private $new_tipo_profesional;
   private $validacion;
   private $per_page;

   public function __construct () {
      $this->middleware('auth');
      $this->middleware('d');
      $this->nombre_modelo = "tipo_profesional"; //nombre tabla o de ruta
      $this->nombre_tabla = $this->nombre_ruta = "tipos_profesionales";
      $this->nombre_detalle = "Tipos Profesionales";
      $this->nombre_detalle_singular = "Tipo Profesional";
      $this->nombre_controller = "TipoProfesionalController";
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

   /*
    * Index componente aplica para las pantallas que estan hechas con iframes
    * que son interfaces mas livianas como accesos directos
    * */
   public function index_componente () {
      return view("layouts.main_para_componentes", [
         'nombre_modelo' => $this->nombre_modelo,
         'nombre_tabla' => $this->nombre_tabla,
         'nombre_ruta' => $this->nombre_ruta,
         'nombre_detalle' => $this->nombre_detalle,
         'nombre_controller' => $this->nombre_controller,
      ]);
   }

   /*
   * Index ajax aplica para traer la data de las interfaces
   * */
   public function index_ajax (Request $request) {
      if ($request->wantsJson() && $request->ajax() && $request->isXmlHttpRequest()) {
         $this->validar_paginacion($request);

         $this->tipos_profesionales = TipoProfesional::paginate((int)$this->per_page);
         $this->usuario_auth = Auth::user();
         return response()->json([
            'status' => 200,
            'tipos_profesionales' => $this->tipos_profesionales,
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
         'nombre_detalle_singular' => $this->nombre_detalle_singular,
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

      $this->tipo_profesional = TipoProfesional::where("id_$this->nombre_modelo",'=',$id)->first();


      if ($this->tipo_profesional) {
         return response()->json([
            'status' => 200, //Para los popups con alertas de sweet alert
            'tipo' => 'eliminacion_exitosa', //Para las notificaciones
            'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro encontrado exitosamente."]],
            'tipo_profesional' => $this->tipo_profesional,
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
         'nom_tipo_profesional' => "regex:/(^([a-zA-Z0-9_ áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|required|max:255",
         'det_tipo_profesional' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
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
      $this->tipo_profesional = $request->all();
      #Se crea el nuevo registro
      $this->new_tipo_profesional = TipoProfesional::create([
         'nom_tipo_profesional' => $this->tipo_profesional['nom_tipo_profesional'],
         'det_tipo_profesional' => $this->tipo_profesional['det_tipo_profesional'],
         'id_usuario_registra' => Auth::user()->id_usuario,
         'id_usuario_modifica' => Auth::user()->id_usuario,
      ]);

      unset($this->tipo_profesional, $this->validacion);

      return response()->json([
         'status' => 200, //Para los popups con alertas de sweet alert
         'tipo' => 'creacion_exitosa', //Para las notificaciones
         'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro ($this->nombre_modelo) creado exitosamente."]],
         //Para mostrar los mensajes que van desde el backend
         'tipo_profesional' => $this->new_tipo_profesional
      ]);
   }

   public function update(Request $request, $id) {
      #Se realiza validacion de los parametros de entrada que vienen desde el formulario
      $this->validacion = Validator::make($request->all(), [
         'id_tipo_profesional' => 'regex:/(^([0-9]+)(\d+)?$)/u|required|max:255',
         'nom_tipo_profesional' => "regex:/(^([a-zA-Z0-9_ áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|required|max:255",
         'det_tipo_profesional' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
      ]);
      #Valida si la informacion que se envia para editar al tipo_profesional son iguales los ids
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
      $this->tipo_profesional = TipoProfesional::find($request["id_$this->nombre_modelo"]);
      $request['id_usuario_modifica'] = Auth::user()->id_usuario;
      $this->tipo_profesional->update($request->all());

      #unset($this->new_tipo_profesional_permiso, $this->permiso);
      return response()->json([
         'status' => 200, //Para los popups con alertas de sweet alert
         'tipo' => 'actualizacion_exitosa', //Para las notificaciones
         'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro actualizado exitosamente."]],
         //Para mostrar los mensajes que van desde el backend
         'tipo_profesional' => $this->tipo_profesional,
      ]);
   }

   public function destroy($id) {
      #Valida si la informacion que se envia para editar al tipo_profesional son iguales los ids
      if ($this->es_vacio($id) == true || preg_match("/^[0-9]*$/",$id) == 0) {
         return response()->json([
            'status' => 200, //Para los popups con alertas de sweet alert
            'tipo' => 'error_datos_invalidos', //Para las notificaciones
            'mensajes' => ["new_$this->nombre_modelo" => [0=>"Los datos a eliminar son incorrectos."]],
         ]);
      }

      $this->tipo_profesional = TipoProfesional::find($id);

      #Valida si tipo_profesional existe y busca si tiene tipo_profesional_permiso
      if ($this->tipo_profesional) {
         $this->tipo_profesional->delete();
      }

      return response()->json([
         'status' => 200, //Para los popups con alertas de sweet alert
         'tipo' => 'eliminacion_exitosa', //Para las notificaciones
         'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro eliminado exitosamente."]],
         //Para mostrar los mensajes que van desde el backend
      ]);
   }
}
