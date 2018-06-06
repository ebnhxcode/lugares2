let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

/*
mix.js(
   'resources/assets/js/app/api/controllers/FormularioController.js',
   'public/js/app/api/controllers/FormularioController.js'
);

   mix
      .scripts([
         'resources/assets/js/jquery.min.js',
         'resources/assets/js/bootstrap.js',
         'resources/assets/js/vue.js',
         'resources/assets/js/app.js'
      ],
      'public/js/app.js')// Este archivo se creara y compilara todos los JS que en el array se encuentren.

      .styles([
         'resources/assets/css/bootstrap.css',
         'resources/assets/css/style.css'
      ],
      'public/css/all.css'); // Este archivo se creara y compilara todos los CSS que en el array se encuentren.
*/


mix.js('resources/assets/js/components/DownloadExcel.vue','public/js/components/DownloadExcel.vue');
mix.js('resources/assets/js/components/Paginators.vue','public/js/components/Paginators.vue');
mix.js('resources/assets/js/controllers/SideMenuController.js','public/js/controllers/SideMenuController.js');
mix.js('resources/assets/js/controllers/HomeController.js','public/js/controllers/HomeController.js');

mix.js('resources/assets/js/controllers/RoleController.js','public/js/controllers/RoleController.js');
mix.js('resources/assets/js/controllers/CargoController.js','public/js/controllers/CargoController.js');
mix.js('resources/assets/js/controllers/EstadoController.js','public/js/controllers/EstadoController.js');
mix.js('resources/assets/js/controllers/PermisoController.js','public/js/controllers/PermisoController.js');
mix.js('resources/assets/js/controllers/UsuarioController.js','public/js/controllers/UsuarioController.js');
mix.js('resources/assets/js/controllers/MenuController.js','public/js/controllers/MenuController.js');
mix.js('resources/assets/js/controllers/MantenedorController.js','public/js/controllers/MantenedorController.js');



/* Los nuevos para este aplicativo */
//mix.js('resources/assets/js/controllers/EstablecimientoController.js','public/js/controllers/EstablecimientoController.js');
//mix.js('resources/assets/js/controllers/TipoEstablecimientoController.js','public/js/controllers/TipoEstablecimientoController.js');
//mix.js('resources/assets/js/controllers/TelefonoController.js','public/js/controllers/TelefonoController.js');
//mix.js('resources/assets/js/controllers/TipoTelefonoController.js','public/js/controllers/TipoTelefonoController.js');
//mix.js('resources/assets/js/controllers/OrganismoController.js','public/js/controllers/OrganismoController.js');
//mix.js('resources/assets/js/controllers/TipoOrganismoController.js','public/js/controllers/TipoOrganismoController.js');
//mix.js('resources/assets/js/controllers/ProfesionalController.js','public/js/controllers/ProfesionalController.js');
//mix.js('resources/assets/js/controllers/TipoProfesionalController.js','public/js/controllers/TipoProfesionalController.js');
//mix.js('resources/assets/js/controllers/DependenciaController.js','public/js/controllers/DependenciaController.js');
//mix.js('resources/assets/js/controllers/ServicioSaludController.js','public/js/controllers/ServicioSaludController.js');
//mix.js('resources/assets/js/controllers/RegionController.js','public/js/controllers/RegionController.js');
//mix.js('resources/assets/js/controllers/ComunaController.js','public/js/controllers/ComunaController.js');
//mix.js('resources/assets/js/controllers/DiaSemanaController.js','public/js/controllers/DiaSemanaController.js');
//mix.js('resources/assets/js/controllers/HorarioAtencionProfesionalController.js','public/js/controllers/HorarioAtencionProfesionalController.js');
//mix.js('resources/assets/js/controllers/HorarioAtencionEstablecimientoController.js','public/js/controllers/HorarioAtencionEstablecimientoController.js');
//mix.js('resources/assets/js/controllers/HorarioVisitaEstablecimientoController.js','public/js/controllers/HorarioVisitaEstablecimientoController.js');


mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');
