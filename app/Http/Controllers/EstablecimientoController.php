<?php

namespace App\Http\Controllers;

use App\Comuna;
use App\Dependencia;
use App\Organismo;
use App\Region;
use App\ServicioSalud;
use App\TipoOrganismo;
use App\TipoTelefono;
use Illuminate\Http\Request;
use App\Establecimiento;
use App\TipoEstablecimiento;
use Auth;
use Illuminate\Support\Facades\Validator;

class EstablecimientoController extends Controller {
   private $usuario_auth;

   private $nombre_modelo;
   private $nombre_tabla;
   private $nombre_ruta;
   private $nombre_detalle;
   private $nombre_controller;

   private $establecimientos;
   private $tipos_establecimientos;
   private $tipos_telefonos;
   private $servicios_salud;
   private $dependencias;
   private $organismos;
   private $tipos_organismos;
   private $regiones;
   private $comunas;


   private $establecimiento;
   private $new_establecimiento;
   private $validacion;
   private $per_page;

   public function __construct () {
      $this->middleware('auth');
      $this->middleware('mantenedor');#resrtinge a solo usuarios con permiso bajo -> D
      $this->nombre_modelo = "establecimiento"; //nombre tabla o de ruta
      $this->nombre_tabla = $this->nombre_ruta = "establecimientos";
      $this->nombre_detalle = "Establecimientos";
      $this->nombre_controller = "EstablecimientoController";
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
         $this->per_page = 25;
      } else {
         $this->per_page = $request->per_page;
      }
   }

   /*
 * Index ajax aplica para traer la data de las interfaces
 * */
   public function index_ajax (Request $request) {
      if ($request->wantsJson() && $request->ajax() && $request->isXmlHttpRequest()) {
         $this->validar_paginacion($request);
         $this->establecimientos = Establecimiento::with([
            'tipo_establecimiento',
            'servicio_salud',
            'dependencia',
            'organismo',
            'region',
            'comuna',
            'telefonos.tipo_telefono',
         ])->paginate((int)$this->per_page);
         $this->tipos_establecimientos = TipoEstablecimiento::all();
         $this->tipos_telefonos = TipoTelefono::all();
         $this->servicios_salud = ServicioSalud::all();
         $this->dependencias = Dependencia::all();
         $this->organismos = Organismo::all();
         $this->tipos_organismos = TipoOrganismo::all();
         $this->regiones = Region::all();
         $this->comunas = Comuna::all();


         $this->usuario_auth = Auth::user();
         return response()->json([
            'status' => 200,
            'establecimientos' => $this->establecimientos,
            'tipos_establecimientos' => $this->tipos_establecimientos,
            'tipos_telefonos' => $this->tipos_telefonos,
            'servicios_salud' => $this->servicios_salud,
            'dependencias' => $this->dependencias,
            'organismos' => $this->organismos,
            'tipos_organismos' => $this->tipos_organismos,
            'regiones' => $this->regiones,
            'comunas' => $this->comunas,
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

      $this->establecimiento = Establecimiento::with([
         'tipo_establecimiento',
         'servicio_salud',
         'dependencia',
         'organismo',
         'region',
         'comuna',
         'telefonos.tipo_telefono',
      ])->where("id_$this->nombre_modelo",'=',$id)->first();

      #Valida si role existe y busca si tiene servidor_permiso
      if ($this->establecimiento) {
         return response()->json([
            'status' => 200, //Para los popups con alertas de sweet alert
            'tipo' => 'eliminacion_exitosa', //Para las notificaciones
            'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro encontrado exitosamente."]],
            'establecimiento' => $this->establecimiento,
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
         'id_establecimiento' => "regex:/(^([0-9]+)(\d+)?$)/u|required|unique:$this->nombre_tabla|max:255",
         'nom_establecimiento' => "regex:/(^([a-zA-Z0-9_ áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|required|max:255",
         'observaciones' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'nom_direccion' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'num_calle' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'nom_responsable' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'sitio_web' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'email' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'cod_area_fax' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'fax' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'vigencia_desde' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'fecha_cierre' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'id_establecimiento_antiguo' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",

         'id_tipo_establecimiento' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&]+)(\d+)?$)/u|max:255",
         'id_servicio_salud' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&]+)(\d+)?$)/u|max:255",
         'id_dependencia' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&]+)(\d+)?$)/u|max:255",
         'id_organismo' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&]+)(\d+)?$)/u|max:255",
         'id_region' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&]+)(\d+)?$)/u|max:255",
         'id_comuna' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&]+)(\d+)?$)/u|max:255",
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
      $this->establecimiento = $request->all();
      #Se crea el nuevo registro
      $this->new_establecimiento = Establecimiento::create([
         'id_establecimiento' => $this->establecimiento['id_establecimiento'],
         'nom_establecimiento' => $this->establecimiento['nom_establecimiento'],
         'observaciones' => $this->establecimiento['observaciones'],
         'nom_direccion' => $this->establecimiento['nom_direccion'],
         'num_calle' => $this->establecimiento['num_calle'],
         'nom_responsable' => $this->establecimiento['nom_responsable'],
         'sitio_web' => $this->establecimiento['sitio_web'],
         'email' => $this->establecimiento['email'],
         'cod_area_fax' => $this->establecimiento['cod_area_fax'],
         'fax' => $this->establecimiento['fax'],
         'vigencia_desde' => $this->establecimiento['vigencia_desde'],
         'fecha_cierre' => $this->establecimiento['fecha_cierre'],
         'id_establecimiento_antiguo' => $this->establecimiento['id_establecimiento_antiguo'],

         'id_tipo_establecimiento' => $this->establecimiento['id_tipo_establecimiento'],
         'id_servicio_salud' => $this->establecimiento['id_servicio_salud'],
         'id_dependencia' => $this->establecimiento['id_dependencia'],
         'id_organismo' => $this->establecimiento['id_organismo'],
         'id_region' => $this->establecimiento['id_region'],
         'id_comuna' => $this->establecimiento['id_comuna'],

         'id_usuario_registra' => Auth::user()->id_usuario,
         'id_usuario_modifica' => Auth::user()->id_usuario,
      ]);

      unset($this->establecimiento, $this->validacion);

      return response()->json([
         'status' => 200, //Para los popups con alertas de sweet alert
         'tipo' => 'creacion_exitosa', //Para las notificaciones
         'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro ($this->nombre_modelo) creado exitosamente."]],
         //Para mostrar los mensajes que van desde el backend
         'establecimiento' => $this->new_establecimiento
      ]);
   }

   public function update(Request $request, $id) {
      #Se realiza validacion de los parametros de entrada que vienen desde el formulario
      $this->validacion = Validator::make($request->all(), [
         'id_establecimiento' => "regex:/(^([0-9]+)(\d+)?$)/u|required|unique:$this->nombre_tabla|max:255",
         'nom_establecimiento' => "regex:/(^([a-zA-Z0-9_ áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|required|max:255",
         'observaciones' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'nom_direccion' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'nom_responsable' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'num_calle' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'sitio_web' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'email' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'cod_area_fax' => "regex:/(^([0-9]+)(\d+)?$)/u|max:255",
         'fax' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'vigencia_desde' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'fecha_cierre' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'id_establecimiento_antiguo' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",

         'id_tipo_establecimiento' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'id_servicio_salud' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'id_dependencia' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'id_organismo' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'id_region' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
         'id_comuna' => "regex:/(^([a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+)(\d+)?$)/u|max:255",
      ]);
      #Valida si la informacion que se envia para editar al establecimiento son iguales los ids
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
      $this->establecimiento = Establecimiento::find($request["id_$this->nombre_modelo"]);
      $request['id_usuario_modifica'] = Auth::user()->id_usuario;
      $this->establecimiento->update($request->all());

      return response()->json([
         'status' => 200, //Para los popups con alertas de sweet alert
         'tipo' => 'actualizacion_exitosa', //Para las notificaciones
         'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro actualizado exitosamente."]],
         //Para mostrar los mensajes que van desde el backend
         'establecimiento' => $this->establecimiento,
      ]);
   }

   public function destroy($id) {
      #Valida si la informacion que se envia para editar al establecimiento son iguales los ids
      if ($this->es_vacio($id) == true || preg_match("/^[0-9]*$/",$id) == 0) {
         return response()->json([
            'status' => 200, //Para los popups con alertas de sweet alert
            'tipo' => 'error_datos_invalidos', //Para las notificaciones
            'mensajes' => ["new_$this->nombre_modelo" => [0=>"Los datos a eliminar son incorrectos."]],
         ]);
      }

      $this->establecimiento = Establecimiento::find($id);

      if ($this->establecimiento) {
         $this->establecimiento->delete();
      }

      return response()->json([
         'status' => 200, //Para los popups con alertas de sweet alert
         'tipo' => 'eliminacion_exitosa', //Para las notificaciones
         'mensajes' => ["new_$this->nombre_modelo" => [0=>"Registro eliminado exitosamente."]],
         //Para mostrar los mensajes que van desde el backend
      ]);
   }


}
