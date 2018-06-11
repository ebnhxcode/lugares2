
import swal from 'sweetalert2';

//Se importan todas las librerias compartidas y se cargan en el objeto instanciado como alias -> hp
import { inyeccion_funciones_compartidas } from './libs/HelperPackage';

import VModal from 'vue-js-modal';
Vue.use(VModal, {dialog: true});

import Clipboard from 'v-clipboard';
Vue.use(Clipboard);

Vue.component('download-excel', require('../components/DownloadExcel.vue'));
Vue.component('paginators', require('../components/Paginators.vue'));

const RegionController = new Vue({
   el: '#RegionController',
   data(){
      return {
         '$':window.jQuery,
         'pk_tabla': 'id_region',
         'nombre_tabla':'regiones', //nombre tabla o de ruta
         'nombre_ruta':'regiones', //nombre tabla o de ruta
         'nombre_model':'region',
         'nombre_model_limpio': 'region_limpio',
         'nombre_detalle':'Regiones',
         'nombre_controller':'RegionController',

         'filtro_head':null,
         'region':{
            'nom_region':null,
            'det_region':null,
            'alias':null,
            'orden':null,

            'id_usuario_registra':null,
            'id_usuario_modifica':null,
            'created_at':null,
            'updated_at':null,
            'deleted_at':null,
         },
         'permitido_guardar':[
            'nom_region',
            'det_region',
            'alias',
            'orden',
         ],
         'relaciones_clase':[],
         'lom':{},
         'lista_objs_model':[],
         'regiones':[],
         'datos_excel':[],
         'usuario_auth':{},

         'campos_formularios':[],
         'errores_campos':[],

         'pagination': {
            'per_page':null,
         },

         //Variables para validar si se está creando o editando
         'modal_crear_activo': false,
         'modal_actualizar_activo': false,

         //Estas var se deben conservar para todos los controllers por que se ejecutan para el modal crear (blanquea)
         'lista_actualizar_activo':false,

         'id_en_edicion': null,

         'orden_lista':'asc',

         /* Campos que se ven en el tablero */
         'tabla_campos': {
            'id_region':{'visibility':false,'value':null},
            'nom_region':{'visibility':true,'value':null},
            'alias':{'visibility':false,'value':null},
            'orden':{'visibility':false,'value':null},

            'created_at':{'visibility':false,'value':null},
            'updated_at':{'visibility':false,'value':null},
            'deleted_at':{'visibility':false,'value':null},
         },

         /* Etiquetas */
         'tabla_labels': {
            'id_region':'Id region',
            'nom_region':'Nombre region',
            'alias':'Alias',
            'orden':'Orden',

            'id_usuario_registra':'Usuario registra',
            'id_usuario_modifica':'Usuario modifica',
            'created_at':'Creado en',
            'updated_at':'Actualizado en',
            'deleted_at':'Eliminado en'
         },

         /* Campos del modelo en el excel */
         'excel_json_campos': {
            'id_region': 'String',
            'nom_region': 'String',
            'alias': 'String',
            'orden': 'String',

            'created_at': 'String',
            'updated_at': 'String',
            'deleted_at': 'String'
         },

         'excel_json_datos': [],
         'excel_data_contador': 0,

         'append_to_json_excel': {},

      }
   },
   computed: {},
   watch: {
      //Lo que hace este watcher o funcion de seguimiento es que cuando id en edicion es null se blanquea el region
      // o el objeto al que se le está haciendo seguimiento y permite que no choque con el que se está creando
      id_en_edicion: function (id_en_edicion) {
         if (id_en_edicion == null) { this.limpiar_objeto_clase_local(); }
         else { this.buscar_objeto_clase(id_en_edicion); }
      },
      //regiones se mantiene en el watcher para actualizar la lista de lo que se esta trabajando y/o filtrando en grid
      regiones: function (regiones) {
         var self = this;
         this.excel_json_datos = [];
         return regiones.map(function (region, index) {
            return self.excel_json_datos.push({
               'id_region': region.id_region || '-',
               'nom_region': region.nom_region || '-',
               'alias': region.alias || '-',
               'orden': region.orden || '-',

               'created_at': region.created_at || '-',
               'updated_at': region.updated_at || '-',
               'deleted_at': region.deleted_at || '-'
            });
         });
      },
   },
   components: {
      //'download-excel': DownloadExcel,
   },
   created(){
      this.inicializar();
   },
   ready: {},
   filters: {},
   mixins: [ inyeccion_funciones_compartidas ],
   methods: {

      asignar_recursos: function (response) {

         /* Datos intrinsecos de la entidad */
         this.lista_objs_model = response.body.regiones.data || null;
         this.regiones = response.body.regiones.data || null;
         this.datos_excel = response.body.regiones.data || null;

         /* Datos de la entidad hacia el paginador */
         this.pagination = response.body.regiones || null;

         /* Datos de la sesion actual del usuario */
         this.usuario_auth = response.body.usuario_auth || null;

      },
   }
});
