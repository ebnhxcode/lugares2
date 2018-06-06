
import swal from 'sweetalert2';

//Se importan todas las librerias compartidas y se cargan en el objeto instanciado como alias -> hp
import { inyeccion_funciones_compartidas } from './libs/HelperPackage';

import VModal from 'vue-js-modal';
Vue.use(VModal, {dialog: true});

import Clipboard from 'v-clipboard';
Vue.use(Clipboard);

Vue.component('download-excel', require('../components/DownloadExcel.vue'));
Vue.component('paginators', require('../components/Paginators.vue'));

const DiaSemanaController = new Vue({
   el: '#DiaSemanaController',
   data(){
      return {
         '$':window.jQuery,
         'pk_tabla': 'id_dia_semana',
         'nombre_tabla':'dias_semana', //nombre tabla o de ruta
         'nombre_ruta':'dias_semana', //nombre tabla o de ruta
         'nombre_model':'dia_semana',
         'nombre_model_limpio': 'dia_semana_limpio',
         'nombre_detalle':'Dias Semana',
         'nombre_controller':'DiaSemanaController',

         'filtro_head':null,
         'dia_semana':{
            'id_dia':null,
            'nom_dia':null,
            'orden':null,

            'id_usuario_registra':null,
            'id_usuario_modifica':null,
            'created_at':null,
            'updated_at':null,
            'deleted_at':null,
         },
         'permitido_guardar':[
            'nom_dia',
            'orden',
         ],
         'relaciones_clase':[],
         'lom':{},
         'lista_objs_model':[],
         'dias_semana':[],
         'idiomas':[],
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
            'id_dia':false,
            'nom_dia':true,
            'orden':true,

            'created_at':false,
            'updated_at':false,
            'deleted_at':false,
         },

         /* Etiquetas */
         'tabla_labels': {
            'id_dia':'Id dia semana',
            'nom_dia':'Nombre dia',
            'orden':'Orden',

            'id_usuario_registra':'Usuario registra',
            'id_usuario_modifica':'Usuario modifica',
            'created_at':'Creado en',
            'updated_at':'Actualizado en',
            'deleted_at':'Eliminado en'
         },

         /* Campos del modelo en el excel */
         'excel_json_campos': {
            'id_dia': 'String',
            'nom_dia': 'String',
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
      //Lo que hace este watcher o funcion de seguimiento es que cuando id en edicion es null se blanquea el dia_semana
      // o el objeto al que se le está haciendo seguimiento y permite que no choque con el que se está creando
      id_en_edicion: function (id_en_edicion) {
         if (id_en_edicion == null) { this.limpiar_objeto_clase_local(); }
         else { this.buscar_objeto_clase_config_relaciones(id_en_edicion, this.relaciones_clase); }
      },
      //dias_semana se mantiene en el watcher para actualizar la lista de lo que se esta trabajando y/o filtrando en grid
      dias_semana: function (dias_semana) {
         var self = this;
         this.excel_json_datos = [];
         return dias_semana.map(function (dia_semana, index) {
            return self.excel_json_datos.push({
               'id_dia': dia_semana.id_dia || '-',
               'nom_dia': dia_semana.nom_dia || '-',
               'orden': dia_semana.orden || '-',

               'id_tipo_dia_semana': dia_semana.id_tipo_dia_semana || '-',
               'nom_tipo_dia_semana': dia_semana.nom_tipo_dia_semana || '-',
               'created_at': dia_semana.created_at || '-',
               'updated_at': dia_semana.updated_at || '-',
               'deleted_at': dia_semana.deleted_at || '-'
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
         this.lista_objs_model = response.body.dias_semana.data || null;
         this.dias_semana = response.body.dias_semana.data || null;
         this.datos_excel = response.body.dias_semana.data || null;

         /* Datos de la entidad hacia el paginador */
         this.pagination = response.body.dias_semana || null;

         /* Datos de la sesion actual del usuario */
         this.usuario_auth = response.body.usuario_auth || null;

      },
   }
});