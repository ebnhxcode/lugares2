
import swal from 'sweetalert2';

//Se importan todas las librerias compartidas y se cargan en el objeto instanciado como alias -> hp
import { inyeccion_funciones_compartidas } from './libs/HelperPackage';

import VModal from 'vue-js-modal';
Vue.use(VModal, {dialog: true});

import Clipboard from 'v-clipboard';
Vue.use(Clipboard);

Vue.component('download-excel', require('../components/DownloadExcel.vue'));
Vue.component('paginators', require('../components/Paginators.vue'));

const ProfesionalController = new Vue({
   el: '#ProfesionalController',
   data(){
      return {
         '$':window.jQuery,
         'pk_tabla': 'id_profesional',
         'nombre_tabla':'profesionales', //nombre tabla o de ruta
         'nombre_ruta':'profesionales', //nombre tabla o de ruta
         'nombre_model':'profesional',
         'nombre_model_limpio': 'profesional_limpio',
         'nombre_detalle':'Profesionales',
         'nombre_controller':'ProfesionalController',

         'filtro_head':null,
         'profesional':{
            'nom_profesional':null,
            'det_profesional':null,

            'id_tipo_profesional':null,
            'nom_tipo_profesional':null,
            'id_cargo':null,
            'nom_cargo':null,
            'id_estado':null,
            'nom_estado':null,

            'id_usuario_registra':null,
            'id_usuario_modifica':null,
            'created_at':null,
            'updated_at':null,
            'deleted_at':null,
         },
         'permitido_guardar':[
            'nom_profesional',
            'det_profesional',
            'id_tipo_profesional',
            'id_cargo',
            'id_estado',
         ],
         'relaciones_clase':[
            {'tipo_profesional':['id_tipo_profesional','nom_tipo_profesional']},
            {'cargo':['id_cargo','nom_cargo']},
            {'estado':['id_estado','nom_estado']},
         ],
         'lom':{},
         'lista_objs_model':[],
         'profesionales':[],
         'tipos_profesionales':[],
         'cargos':[],
         'estados':[],

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
            'id_profesional':{'visibility':false,'value':null},
            'nom_profesional':{'visibility':true,'value':null},
            'det_profesional':{'visibility':false,'value':null},
            'nom_tipo_profesional':{'visibility':false,'value':null},
            'nom_cargo':{'visibility':false,'value':null},
            'nom_estado':{'visibility':false,'value':null},
            'created_at':{'visibility':false,'value':null},
            'updated_at':{'visibility':false,'value':null},
            'deleted_at':{'visibility':false,'value':null},
         },

         /* Etiquetas */
         'tabla_labels': {
            'id_profesional':'Id profesional',
            'nom_profesional':'Nombre profesional',
            'det_profesional':'Detalle profesional',

            'id_tipo_profesional':'Id tipo profesional',
            'nom_tipo_profesional':'Nombre tipo profesional',
            'id_cargo':'Id cargo',
            'nom_cargo':'Nombre cargo',
            'id_estado':'Id estado',
            'nom_estado':'Nombre estado',

            'id_usuario_registra':'Usuario registra',
            'id_usuario_modifica':'Usuario modifica',
            'created_at':'Creado en',
            'updated_at':'Actualizado en',
            'deleted_at':'Eliminado en'
         },

         /* Campos del modelo en el excel */
         'excel_json_campos': {
            'id_profesional': 'String',
            'nom_profesional': 'String',
            'det_profesional': 'String',

            'id_tipo_profesional':'String',
            'nom_tipo_profesional':'String',
            'id_cargo':'String',
            'nom_cargo':'String',
            'id_estado':'String',
            'nom_estado':'String',

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
      //Lo que hace este watcher o funcion de seguimiento es que cuando id en edicion es null se blanquea el profesional
      // o el objeto al que se le está haciendo seguimiento y permite que no choque con el que se está creando
      id_en_edicion: function (id_en_edicion) {
         if (id_en_edicion == null) { this.limpiar_objeto_clase_local(); }
         else { this.buscar_objeto_clase(id_en_edicion); }
      },
      //profesionales se mantiene en el watcher para actualizar la lista de lo que se esta trabajando y/o filtrando en grid
      profesionales: function (profesionales) {
         var self = this;
         this.excel_json_datos = [];
         return profesionales.map(function (profesional, index) {
            return self.excel_json_datos.push({
               'id_profesional': profesional.id_profesional || '-',
               'nom_profesional': profesional.nom_profesional || '-',
               'det_profesional': profesional.det_profesional || '-',

               'id_tipo_profesional': profesional.id_tipo_profesional || '-',
               'nom_tipo_profesional': profesional.nom_tipo_profesional || '-',
               'id_cargo': profesional.id_cargo || '-',
               'nom_cargo': profesional.nom_cargo || '-',
               'id_estado': profesional.id_estado || '-',
               'nom_estado': profesional.nom_estado || '-',

               'created_at': profesional.created_at || '-',
               'updated_at': profesional.updated_at || '-',
               'deleted_at': profesional.deleted_at || '-'
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
         this.lista_objs_model = response.body.profesionales.data || null;
         this.profesionales = response.body.profesionales.data || null;
         this.datos_excel = response.body.profesionales.data || null;

         /* Relaciones con la entidad */
         this.tipos_profesionales = response.body.tipos_profesionales || null;
         this.cargos = response.body.cargos || null;
         this.estados = response.body.estados || null;

         /* Datos de la entidad hacia el paginador */
         this.pagination = response.body.profesionales || null;

         /* Datos de la sesion actual del usuario */
         this.usuario_auth = response.body.usuario_auth || null;

      },
   }
});
