<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () { return view('welcome'); });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@index')->name('dashboard');
Route::get('/', function () {
    return redirect()->to('/login');
});

#Rutas para los ajax de cada index. (No olvidar proteger por perfilamiento, roles y si la peticion es ajax request. )
#Primeras rutas

#Rutas que le siguen a la mecanica de ruteos.
Route::get('/ajax/roles', 'RoleController@index_ajax');
Route::get('/ajax/cargos', 'CargoController@index_ajax');
Route::get('/ajax/estados', 'EstadoController@index_ajax');
Route::get('/ajax/permisos', 'PermisoController@index_ajax');
Route::get('/ajax/usuarios', 'UsuarioController@index_ajax');
Route::get('/ajax/mantenedores', 'MantenedorController@index_ajax');
Route::get('/ajax/menus', 'MenuController@index_ajax');

Route::get('/ajax/paises', 'PaisController@index_ajax');
Route::get('/ajax/regiones', 'RegionController@index_ajax');
Route::get('/ajax/comunas', 'ComunaController@index_ajax');


Route::get('/ajax/establecimientos', 'EstablecimientoController@index_ajax');
Route::get('/ajax/tipos_establecimientos', 'TipoEstablecimientoController@index_ajax');
Route::get('/ajax/telefonos', 'TelefonoController@index_ajax');
Route::get('/ajax/tipos_telefonos', 'TipoTelefonoController@index_ajax');
Route::get('/ajax/organismos', 'OrganismoController@index_ajax');
Route::get('/ajax/tipos_organismos', 'TipoOrganismoController@index_ajax');
Route::get('/ajax/dependencias', 'DependenciaController@index_ajax');
Route::get('/ajax/profesionales', 'ProfesionalController@index_ajax');
Route::get('/ajax/tipos_profesionales', 'TipoProfesionalController@index_ajax');
Route::get('/ajax/servicios_salud', 'ServicioSaludController@index_ajax');
Route::get('/ajax/horarios_atencion_profesionales', 'HorarioAtencionProfesionalController@index_ajax');
Route::get('/ajax/horarios_atencion_establecimientos', 'HorarioAtencionEstablecimientoController@index_ajax');
Route::get('/ajax/horarios_visita_establecimientos', 'HorarioVisitaEstablecimientoController@index_ajax');
Route::get('/ajax/dias_semana', 'DiaSemanaController@index_ajax');






/*
 * Grupos :
 * Se define arreglo (de grupos) con los middlewares que serán distribuídos los recursos
 * Esto aplica solo para las rutas que eran resource , es una forma de mapear las url/rutas
 *
 *    En este caso :
 *
 *    r = read -> nivel 1
 *       :-> por defecto: nada ;
 *       :-> adicional: puede leer -> recursos del sistema
 *
 *    c = create -> nivel 2
 *       :-> por defecto: puede leer ;
 *       :-> adicional: puede crear -> recursos del sistema
 *
 *    u = update -> nivel 3
 *       :-> por defecto: puede leer y crear ;
 *       :-> adicional: puede modificar -> recursos del sistema
 *
 *    d = delete -> nivel 4
 *       :-> por defecto: puede leer, crear y modificar ;
 *       :-> adicional: puede eliminar -> recursos del sistema
 *
 * */
$groups = ['r','c','u','d'];

#Docs
/*
 * Peticiones Http
 * Se define arreglo (de métodos y tipo de peticiones) asociados a cada grupo de middlewares
 *
 * Path de middlewares definidos para este aplicativo -> en Http/Middleware/Role/*
 *
 * ***
 *
 *    En caso 'r':
 *
 *    El middleware RMiddleware (Registrado en el Kernel como => 'r')
 *    Tiene asociado el método 'index' y 'show', ya que 'r' representa a 'read',
 *    y read es una peticion http de tipo get|head que es para solo lectura.
 *
 *    Finalmente, con esto se logra que para cada controlador, se autodefina una ruta get para los metodos index|show.
 *
 * ***
 *
 *    En caso 'c':
 *
 *    El middleware CMiddleware (Registrado en el Kernel como => 'c')
 *    Tiene asociado el método 'store', ya que 'c' representa a 'create',
 *    y store es una peticion http de tipo post que es para escribir recursos en el servidor.
 *
 *    Finalmente, con esto se logra que para cada controlador, se autodefina una ruta post para el metodo store.
 *
 * ***
 *
 *    En caso 'u':
 *
 *    El middleware UMiddleware (Registrado en el Kernel como => 'u')
 *    Tiene asociado el método 'update', ya que 'u' representa a 'update',
 *    y store es una peticion http de tipo put|patch que es para sobreescribir recursos en el servidor.
 *
 *    Finalmente, con esto se logra que para cada controlador, se autodefina una ruta put|patch para el metodo update.
 *
 * ***
 *
 *    En caso 'd':
 *
 *    El middleware DMiddleware (Registrado en el Kernel como => 'd')
 *    Tiene asociado el método 'destroy', ya que 'd' representa a 'delete',
 *    y delete es una peticion http de tipo delete que es para eliminar recursos en el servidor.
 *
 *    Finalmente, con esto se logra que para cada controlador, se autodefina una ruta delete para el metodo destroy.
 *
 *
 *
 * Se pueden incluir todos los métodos que son compartidos entre controladores y rutas (preferentemente rutas de recursos)
 * */
$http_requests = [
   'r' => ['index' => 'get', 'show' => 'get'],
   'c' => ['store' => 'post'],
   'u' => ['update' => 'put'],
   'd' => ['destroy' => 'delete']
];

/*
 * Modulos :
 * Se define arreglo (de módulos) con las rutas de recursos para crud básico (resources)
 * Y el controller asociado a esta ruta
 *
 *    En este caso :
 *
 *
 * */
$modules = [

   ['route'=>'roles', 'controller'=>'RoleController'],
   ['route'=>'cargos','controller'=>'CargoController'],
   ['route'=>'estados','controller'=>'EstadoController'],
   ['route'=>'permisos','controller'=>'PermisoController'],
   ['route'=>'usuarios','controller'=>'UsuarioController'],
   ['route'=>'menus','controller'=>'MenuController'],
   ['route'=>'mantenedores','controller'=>'MantenedorController'],

   #Heredado
   ['route'=>'paises','controller'=>'PaisController'],
   ['route'=>'regiones','controller'=>'RegionController'],
   ['route'=>'comunas','controller'=>'ComunaController'],

   #Completar controller
   ['route'=>'establecimientos','controller'=>'EstablecimientoController'],
   ['route'=>'tipos_establecimientos','controller'=>'TipoEstablecimientoController'],
   ['route'=>'telefonos','controller'=>'TelefonoController'],
   ['route'=>'tipos_telefonos','controller'=>'TipoTelefonoController'],
   ['route'=>'organismos','controller'=>'OrganismoController'],
   ['route'=>'tipos_organismos','controller'=>'TipoOrganismoController'],
   ['route'=>'dependencias','controller'=>'DependenciaController'],
   ['route'=>'profesionales','controller'=>'ProfesionalController'],
   ['route'=>'tipos_profesionales','controller'=>'TipoProfesionalController'],
   ['route'=>'servicios_salud','controller'=>'ServicioSaludController'],
   ['route'=>'horarios_atencion_profesionales','controller'=>'HorarioAtencionProfesionalController'],
   ['route'=>'horarios_atencion_establecimientos','controller'=>'HorarioAtencionEstablecimientoController'],
   ['route'=>'horarios_visita_establecimientos','controller'=>'HorarioVisitaEstablecimientoController'],
   ['route'=>'dias_semana','controller'=>'DiaSemanaController'],



];


foreach ($groups as $group) {
    Route::group(['middleware' => "${group}"], function() use ($modules,$http_requests,$group){
        foreach ($http_requests["${group}"] as $method => $http):
            foreach ($modules as $module):
               eval("Route::${http}('/${module['route']}/".(in_array($method,["show","update","destroy"])?"{id}":"")."', '${module['controller']}@${method}');");
            endforeach;
        endforeach;
    });
}