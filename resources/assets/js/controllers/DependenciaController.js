
import swal from 'sweetalert2';

//Se importan todas las librerias compartidas y se cargan en el objeto instanciado como alias -> hp
import { inyeccion_funciones_compartidas } from './libs/HelperPackage';

import VModal from 'vue-js-modal';
Vue.use(VModal, {dialog: true});

import Clipboard from 'v-clipboard';
Vue.use(Clipboard);

Vue.component('download-excel', require('../components/DownloadExcel.vue'));
Vue.component('paginators', require('../components/Paginators.vue'));

const DependenciaController = new Vue({
   el: '#DependenciaController',
   data(){
      return {
         '$':window.jQuery,
         'pk_tabla': 'id_dependencia',
         'nombre_tabla':'dependencias', //nombre tabla o de ruta
         'nombre_ruta':'dependencias', //nombre tabla o de ruta
         'nombre_model':'dependencia',
         'nombre_model_limpio': 'dependencia_limpio',
         'nombre_detalle':'Dependencias',
         'nombre_controller':'DependenciaController',

         'filtro_head':null,
         'dependencia':{
            'nom_dependencia':null,
            'det_dependencia':null,
            'id_usuario_registra':null,
            'id_usuario_modifica':null,
            'created_at':null,
            'updated_at':null,
            'deleted_at':null,
         },
         'permitido_guardar':[
            'nom_dependencia',
            'det_dependencia',
         ],
         'relaciones_clase':[],
         'lom':{},
         'lista_objs_model':[],
         'dependencias':[],
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
            'id_dependencia':false,
            'nom_dependencia':true,
            'det_dependencia':true,
            //'id_usuario_registra':false,
            //'id_usuario_modifica':false,
            'created_at':false,
            'updated_at':false,
            'deleted_at':false,
         },

         /* Etiquetas */
         'tabla_labels': {
            'id_dependencia':'Id dependencia',
            'nom_dependencia':'Nombre dependencia',
            'det_dependencia':'Detalle dependencia',
            'id_usuario_registra':'Usuario registra',
            'id_usuario_modifica':'Usuario modifica',
            'created_at':'Creado en',
            'updated_at':'Actualizado en',
            'deleted_at':'Eliminado en'
         },

         /* Campos del modelo en el excel */
         'excel_json_campos': {
            'id_dependencia': 'String',
            'nom_dependencia': 'String',
            'det_dependencia': 'String',
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
      //Lo que hace este watcher o funcion de seguimiento es que cuando id en edicion es null se blanquea el dependencia
      // o el objeto al que se le está haciendo seguimiento y permite que no choque con el que se está creando
      id_en_edicion: function (id_en_edicion) {
         if (id_en_edicion == null) { this.limpiar_objeto_clase_local(); }
         else { this.buscar_objeto_clase(id_en_edicion); }
      },
      //dependencias se mantiene en el watcher para actualizar la lista de lo que se esta trabajando y/o filtrando en grid
      dependencias: function (dependencias) {
         var self = this;
         this.excel_json_datos = [];
         return dependencias.map(function (dependencia, index) {
            return self.excel_json_datos.push({
               'id_dependencia': dependencia.id_dependencia || '-',
               'nom_dependencia': dependencia.nom_dependencia || '-',
               'det_dependencia': dependencia.det_dependencia || '-',
               'created_at': dependencia.created_at || '-',
               'updated_at': dependencia.updated_at || '-',
               'deleted_at': dependencia.deleted_at || '-'
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
         this.lista_objs_model = response.body.dependencias.data || null;
         this.dependencias = response.body.dependencias.data || null;
         this.datos_excel = response.body.dependencias.data || null;

         /* Datos de la entidad hacia el paginador */
         this.pagination = response.body.dependencias || null;

         /* Datos de la sesion actual del usuario */
         this.usuario_auth = response.body.usuario_auth || null;

      },
   }
});
