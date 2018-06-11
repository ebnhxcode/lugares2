
import swal from 'sweetalert2';

//Se importan todas las librerias compartidas y se cargan en el objeto instanciado como alias -> hp
import { inyeccion_funciones_compartidas } from './libs/HelperPackage';

import VModal from 'vue-js-modal';
Vue.use(VModal, {dialog: true});

import Clipboard from 'v-clipboard';
Vue.use(Clipboard);

Vue.component('download-excel', require('../components/DownloadExcel.vue'));
Vue.component('paginators', require('../components/Paginators.vue'));

const OrganismoController = new Vue({
   el: '#OrganismoController',
   data(){
      return {
         '$':window.jQuery,
         'pk_tabla': 'id_organismo',
         'nombre_tabla':'organismos', //nombre tabla o de ruta
         'nombre_ruta':'organismos', //nombre tabla o de ruta
         'nombre_model':'organismo',
         'nombre_model_limpio': 'organismo_limpio',
         'nombre_detalle':'Organismos',
         'nombre_controller':'OrganismoController',

         'filtro_head':null,
         'organismo':{
            'nom_organismo':null,
            'det_organismo':null,
            'cod_organismo':null,

            'id_tipo_organismo':null,
            'nom_tipo_organismo':null,

            'id_usuario_registra':null,
            'id_usuario_modifica':null,
            'created_at':null,
            'updated_at':null,
            'deleted_at':null,
         },
         'permitido_guardar':[
            'nom_organismo',
            'det_organismo',
            'cod_organismo',
            'id_tipo_organismo',
         ],
         'relaciones_clase':[
            {'organismo':['id_tipo_organismo','nom_tipo_organismo']},
         ],
         'lom':{},
         'lista_objs_model':[],
         'organismos':[],
         'tipos_organismos':[],
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
            'id_organismo':{'visibility':false,'value':null},
            'nom_organismo':{'visibility':true,'value':null},
            'det_organismo':{'visibility':false,'value':null},
            'cod_organismo':{'visibility':false,'value':null},

            'nom_tipo_organismo':{'visibility':false,'value':null},

            'created_at':{'visibility':false,'value':null},
            'updated_at':{'visibility':false,'value':null},
            'deleted_at':{'visibility':false,'value':null},
         },

         /* Etiquetas */
         'tabla_labels': {
            'id_organismo':'Id organismo',
            'nom_organismo':'Nombre organismo',
            'det_organismo':'Detalle organismo',
            'cod_organismo':'Codigo organismo',

            'id_tipo_organismo':'Id Tipo Organismo',
            'nom_tipo_organismo':'Tipo Organismo',

            'created_at':'Creado en',
            'updated_at':'Actualizado en',
            'deleted_at':'Eliminado en'
         },

         /* Campos del modelo en el excel */
         'excel_json_campos': {
            'id_organismo': 'String',
            'nom_organismo': 'String',
            'det_organismo': 'String',
            'cod_organismo': 'String',

            'id_tipo_organismo':'String',
            'nom_tipo_organismo':'String',

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
      //Lo que hace este watcher o funcion de seguimiento es que cuando id en edicion es null se blanquea el organismo
      // o el objeto al que se le está haciendo seguimiento y permite que no choque con el que se está creando
      id_en_edicion: function (id_en_edicion) {
         if (id_en_edicion == null) { this.limpiar_objeto_clase_local(); }
         else { this.buscar_objeto_clase(id_en_edicion); }
      },
      //organismos se mantiene en el watcher para actualizar la lista de lo que se esta trabajando y/o filtrando en grid
      organismos: function (organismos) {
         var self = this;
         this.excel_json_datos = [];
         return organismos.map(function (organismo, index) {
            return self.excel_json_datos.push({
               'id_organismo': organismo.id_organismo || '-',
               'nom_organismo': organismo.nom_organismo || '-',
               'det_organismo': organismo.det_organismo || '-',

               'id_tipo_organismo': organismo.id_tipo_organismo || '-',
               'nom_tipo_organismo': organismo.nom_tipo_organismo || '-',

               'created_at': organismo.created_at || '-',
               'updated_at': organismo.updated_at || '-',
               'deleted_at': organismo.deleted_at || '-'
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
         this.lista_objs_model = response.body.organismos.data || null;
         this.organismos = response.body.organismos.data || null;
         this.datos_excel = response.body.organismos.data || null;

         /* Datos de la entidad hacia el paginador */
         this.pagination = response.body.organismos || null;

         /* Relaciones con la entidad */
         this.tipos_organismos = response.body.tipos_organismos || null;

         /* Datos de la sesion actual del usuario */
         this.usuario_auth = response.body.usuario_auth || null;

      },
   }
});
