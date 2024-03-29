
import swal from 'sweetalert2';

//Se importan todas las librerias compartidas y se cargan en el objeto instanciado como alias -> hp
import { inyeccion_funciones_compartidas } from './libs/HelperPackage';

import VModal from 'vue-js-modal';
Vue.use(VModal, {dialog: true});

import Clipboard from 'v-clipboard';
Vue.use(Clipboard);

Vue.component('download-excel', require('../components/DownloadExcel.vue'));
Vue.component('paginators', require('../components/Paginators.vue'));

const ServicioSaludController = new Vue({
   el: '#ServicioSaludController',
   data(){
      return {
         '$':window.jQuery,
         'pk_tabla': 'id_servicio_salud',
         'nombre_tabla':'servicios_salud', //nombre tabla o de ruta
         'nombre_ruta':'servicios_salud', //nombre tabla o de ruta
         'nombre_model':'servicio_salud',
         'nombre_model_limpio': 'servicio_salud_limpio',
         'nombre_detalle':'Servicios Salud',
         'nombre_controller':'ServicioSaludController',

         'filtro_head':null,
         'servicio_salud':{
            'id_servicio_salud':null,
            'nom_servicio_salud':null,
            'det_servicio_salud':null,
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
            'nom_servicio_salud',
            'det_servicio_salud',
            'orden',

            'id_region',
         ],
         'relaciones_clase':[
            {'region':['id_region','nom_region']},
         ],
         'lom':{},
         'lista_objs_model':[],
         'servicios_salud':[],
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
            'id_servicio_salud':{'visibility':false,'value':null},
            'nom_servicio_salud':{'visibility':true,'value':null},
            'det_servicio_salud':{'visibility':false,'value':null},
            'orden':{'visibility':false,'value':null},

            'nom_region':{'visibility':false,'value':null},

            'created_at':{'visibility':false,'value':null},
            'updated_at':{'visibility':false,'value':null},
            'deleted_at':{'visibility':false,'value':null},
         },

         /* Etiquetas */
         'tabla_labels': {
            'id_servicio_salud':'Id servicio salud',
            'nom_servicio_salud':'Nombre servicio salud',
            'det_servicio_salud':'Detalle servicio salud',
            'orden':'Orden',

            'id_region':'Id region',
            'nom_region':'Nombre region',

            'id_usuario_registra':'Usuario registra',
            'id_usuario_modifica':'Usuario modifica',
            'created_at':'Creado en',
            'updated_at':'Actualizado en',
            'deleted_at':'Eliminado en'
         },

         /* Campos del modelo en el excel */
         'excel_json_campos': {
            'id_servicio_salud': 'String',
            'nom_servicio_salud': 'String',
            'det_servicio_salud': 'String',
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
      //Lo que hace este watcher o funcion de seguimiento es que cuando id en edicion es null se blanquea el servicio_salud
      // o el objeto al que se le está haciendo seguimiento y permite que no choque con el que se está creando
      id_en_edicion: function (id_en_edicion) {
         if (id_en_edicion == null) { this.limpiar_objeto_clase_local(); }
         else { this.buscar_objeto_clase_config_relaciones(id_en_edicion, this.relaciones_clase); }
      },
      //servicios_salud se mantiene en el watcher para actualizar la lista de lo que se esta trabajando y/o filtrando en grid
      servicios_salud: function (servicios_salud) {
         var self = this;
         this.excel_json_datos = [];
         return servicios_salud.map(function (servicio_salud, index) {
            return self.excel_json_datos.push({
               'id_servicio_salud': servicio_salud.id_servicio_salud || '-',
               'nom_servicio_salud': servicio_salud.nom_servicio_salud || '-',
               'det_servicio_salud': servicio_salud.det_servicio_salud || '-',
               'orden': servicio_salud.orden || '-',

               'id_region': servicio_salud.id_region || '-',
               'nom_region': servicio_salud.nom_region || '-',

               'created_at': servicio_salud.created_at || '-',
               'updated_at': servicio_salud.updated_at || '-',
               'deleted_at': servicio_salud.deleted_at || '-'
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
         this.lista_objs_model = response.body.servicios_salud.data || null;
         this.servicios_salud = response.body.servicios_salud.data || null;
         this.datos_excel = response.body.servicios_salud.data || null;

         /* Datos de la entidad hacia el paginador */
         this.pagination = response.body.servicios_salud || null;

         /* Relaciones con la entidad */
         this.regiones = response.body.regiones || null;

         /* Datos de la sesion actual del usuario */
         this.usuario_auth = response.body.usuario_auth || null;

      },
   }
});