import swal from 'sweetalert2';

//Se importan todas las librerias compartidas y se cargan en el objeto instanciado como alias -> hp
import { inyeccion_funciones_compartidas } from './libs/HelperPackage';

import VModal from 'vue-js-modal';
Vue.use(VModal, {dialog: true});

import Clipboard from 'v-clipboard';
Vue.use(Clipboard);

Vue.component('download-excel', require('../components/DownloadExcel.vue'));
Vue.component('paginators', require('../components/Paginators.vue'));

const TipoProfesionalController = new Vue({
   el: '#TipoProfesionalController',
   data(){
      return {
         '$':window.jQuery,
         'pk_tabla': 'id_tipo_profesional',
         'nombre_tabla': 'tipos_profesionales', //nombre tabla o de ruta
         'nombre_ruta': 'tipos_profesionales', //nombre tabla o de ruta
         'nombre_model': 'tipo_profesional',
         'nombre_model_limpio': 'tipo_profesional_limpio',
         'nombre_detalle': 'Tipos Profesionales',
         'nombre_controller': 'TipoProfesionalController',


         'filtro_head': null,
         'tipo_profesional': {
            'nom_tipo_profesional': null,
            'det_tipo_profesional': null,

            'id_usuario_registra': null,
            'id_usuario_modifica': null,
            'created_at': null,
            'updated_at': null,
            'deleted_at': null,
         },
         'permitido_guardar':[
            'nom_tipo_profesional',
            'det_tipo_profesional',

         ],
         'relaciones_clase':[],
         'lom':{},
         'lista_objs_model':[],
         'tipos_profesionales': [],


         'spinner_table':true,

         'datos_excel': [],
         'usuario_auth': {},

         'campos_formularios': [],
         'errores_campos': [],

         'pagination': {
            'per_page':null,
         },

         //Variables para validar si se está creando o editando
         'modal_crear_activo': false,
         'modal_actualizar_activo': false,

         //Estas var se deben conservar para todos los controllers por que se ejecutan para el modal crear (blanquea)
         'lista_actualizar_activo': false,

         'id_en_edicion': null,

         'orden_lista': 'asc',

         /* Campos que se ven en el tablero */
         'tabla_campos': {
            'id_tipo_profesional': {'visibility':false,'value':null},
            'nom_tipo_profesional': {'visibility':true,'value':null},
            'det_tipo_profesional': {'visibility':false,'value':null},

            'created_at': {'visibility':false,'value':null},
            'updated_at': {'visibility':false,'value':null},
            'deleted_at': {'visibility':false,'value':null},
         },

         /* Etiquetas */
         'tabla_labels': {
            'id_tipo_profesional': 'Id tipo profesional',
            'nom_tipo_profesional': 'Nombre tipo profesional',
            'det_tipo_profesional': 'Detalle tipo profesional',

            'id_usuario_registra': 'Usuario registra',
            'id_usuario_modifica': 'Usuario modifica',
            'created_at': 'Creado en',
            'updated_at': 'Actualizado en',
            'deleted_at': 'Eliminado en'
         },

         /* Campos del modelo en el excel */
         'excel_json_campos': {
            'id_tipo_profesional': 'String',
            'nom_tipo_profesional': 'String',
            'det_tipo_profesional': 'String',

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
      //Lo que hace este watcher o funcion de seguimiento es que cuando id en edicion es null se blanquea el tipo_profesional
      // o el objeto al que se le está haciendo seguimiento y permite que no choque con el que se está creando
      id_en_edicion: function (id_en_edicion) {
         if (id_en_edicion == null) { this.limpiar_objeto_clase_local(); }
         else { this.buscar_objeto_clase(id_en_edicion); }
      },
      //tipos_profesionales se mantiene en el watcher para actualizar la lista de lo que se esta trabajando y/o filtrando en grid
      tipos_profesionales: function (tipos_profesionales) {
         var self = this;
         this.excel_json_datos = [];
         return tipos_profesionales.map(function (tipo_profesional, index) {
            return self.excel_json_datos.push({
               'id_tipo_profesional': tipo_profesional.id_tipo_profesional || '-',
               'nom_tipo_profesional': tipo_profesional.nom_tipo_profesional || '-',
               'det_tipo_profesional': tipo_profesional.det_tipo_profesional || '-',

               'created_at': tipo_profesional.created_at || '-',
               'updated_at': tipo_profesional.updated_at || '-',
               'deleted_at': tipo_profesional.deleted_at || '-'
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
   mixins: [inyeccion_funciones_compartidas],
   methods: {

      asignar_recursos: function (response) {

         /* Datos intrinsecos de la entidad */
         this.lista_objs_model = response.body.tipos_profesionales.data || null;
         this.tipos_profesionales = response.body.tipos_profesionales.data || null;
         this.datos_excel = response.body.tipos_profesionales.data || null;

         /* Datos de la entidad hacia el paginador */
         this.pagination = response.body.tipos_profesionales || null;

         /* Datos de la sesion actual del usuario */
         this.usuario_auth = response.body.usuario_auth || null;

      },

   }
});
