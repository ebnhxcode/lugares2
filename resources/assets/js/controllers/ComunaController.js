
import swal from 'sweetalert2';

//Se importan todas las librerias compartidas y se cargan en el objeto instanciado como alias -> hp
import { inyeccion_funciones_compartidas } from './libs/HelperPackage';

import VModal from 'vue-js-modal';
Vue.use(VModal, {dialog: true});

import Clipboard from 'v-clipboard';
Vue.use(Clipboard);

Vue.component('download-excel', require('../components/DownloadExcel.vue'));
Vue.component('paginators', require('../components/Paginators.vue'));

const ComunaController = new Vue({
   el: '#ComunaController',
   data(){
      return {
         '$':window.jQuery,
         'pk_tabla': 'id_comuna',
         'nombre_tabla':'comunas', //nombre tabla o de ruta
         'nombre_ruta':'comunas', //nombre tabla o de ruta
         'nombre_model':'comuna',
         'nombre_model_limpio': 'comuna_limpio',
         'nombre_detalle':'Comuna',
         'nombre_controller':'ComunaController',

         'filtro_head':null,
         'comuna':{

            'id_comuna':null,
            'nom_comuna':null,
            'det_comuna':null,
            'alias':null,
            'orden':null,

            'id_region':null,
            'nom_region':null,

            'id_usuario_registra':null,
            'id_usuario_modifica':null,
            'created_at':null,
            'updated_at':null,
            'deleted_at':null,
         },
         'permitido_guardar':[
            'id_comuna',
            'nom_comuna',
            'det_comuna',
            'alias',
            'orden',
            'id_region',
         ],
         'relaciones_clase':[
            {'region':['id_region','nom_region']},
         ],
         'lom':{},
         'lista_objs_model':[],
         'comunas':[],
         'regiones':[],

         'spinner_table':true,

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
            'id_comuna':{'visibility':false,'value':null},
            'nom_comuna':{'visibility':true,'value':null},
            'det_comuna':{'visibility':false,'value':null},
            'alias':{'visibility':false,'value':null},
            'orden':{'visibility':false,'value':null},
            'nom_region':{'visibility':false,'value':null},

            'created_at':{'visibility':false,'value':null},
            'updated_at':{'visibility':false,'value':null},
            'deleted_at':{'visibility':false,'value':null},
         },

         /* Etiquetas */
         'tabla_labels': {
            'id_comuna':'Id comuna',
            'nom_comuna':'Nombre comuna',
            'det_comuna':'Detalle comuna',
            'alias':'Alias comuna',
            'orden':'Orden comuna',

            'id_region':'Id Region',
            'nom_region':'Nombre Region',

            'id_usuario_registra':'Usuario registra',
            'id_usuario_modifica':'Usuario modifica',
            'created_at':'Creado en',
            'updated_at':'Actualizado en',
            'deleted_at':'Eliminado en'
         },

         /* Campos del modelo en el excel */
         'excel_json_campos': {
            'id_comuna': 'String',
            'nom_comuna': 'String',
            'alias': 'String',
            'orden': 'String',

            'id_region': 'String',
            'nom_region': 'String',

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
      //Lo que hace este watcher o funcion de seguimiento es que cuando id en edicion es null se blanquea el comuna
      // o el objeto al que se le está haciendo seguimiento y permite que no choque con el que se está creando
      id_en_edicion: function (id_en_edicion) {
         if (id_en_edicion == null) { this.limpiar_objeto_clase_local(); }
         else { this.buscar_objeto_clase(id_en_edicion); }
      },
      //comunas se mantiene en el watcher para actualizar la lista de lo que se esta trabajando y/o filtrando en grid
      comunas: function (comunas) {
         var self = this;
         this.excel_json_datos = [];
         return comunas.map(function (comuna, index) {
            return self.excel_json_datos.push({
               'id_comuna': comuna.id_comuna || '-',
               'nom_comuna': comuna.nom_comuna || '-',
               'alias': comuna.alias || '-',
               'orden': comuna.orden || '-',

               'id_region': comuna.id_region || '-',
               'nom_region': comuna.nom_region || '-',

               'created_at': comuna.created_at || '-',
               'updated_at': comuna.updated_at || '-',
               'deleted_at': comuna.deleted_at || '-'
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
         this.lista_objs_model = response.body.comunas.data || null;
         this.comunas = response.body.comunas.data || null;
         this.datos_excel = response.body.comunas.data || null;

         /* Relaciones con la entidad */
         this.regiones = response.body.regiones || null;

         /* Datos de la entidad hacia el paginador */
         this.pagination = response.body.comunas || null;

         /* Datos de la sesion actual del usuario */
         this.usuario_auth = response.body.usuario_auth || null;

      },
   }
});
