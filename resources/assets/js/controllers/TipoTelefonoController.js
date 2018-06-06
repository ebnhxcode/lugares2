import swal from 'sweetalert2';

//Se importan todas las librerias compartidas y se cargan en el objeto instanciado como alias -> hp
import { inyeccion_funciones_compartidas } from './libs/HelperPackage';

import VModal from 'vue-js-modal';
Vue.use(VModal, {dialog: true});

import Clipboard from 'v-clipboard';
Vue.use(Clipboard);

Vue.component('download-excel', require('../components/DownloadExcel.vue'));
Vue.component('paginators', require('../components/Paginators.vue'));

const TipoTelefonoController = new Vue({
   el: '#TipoTelefonoController',
   data(){
      return {
         '$':window.jQuery,
         'pk_tabla': 'id_tipo_telefono',
         'nombre_tabla': 'tipos_telefonos', //nombre tabla o de ruta
         'nombre_ruta': 'tipos_telefonos', //nombre tabla o de ruta
         'nombre_model': 'tipo_telefono',
         'nombre_model_limpio': 'tipo_telefono_limpio',
         'nombre_detalle': 'Tipos Telefonos',
         'nombre_controller': 'TipoTelefonoController',


         'filtro_head': null,
         'tipo_telefono': {
            'nom_tipo_telefono': null,
            'det_tipo_telefono': null,
            'id_usuario_registra': null,
            'id_usuario_modifica': null,
            'created_at': null,
            'updated_at': null,
            'deleted_at': null,
         },
         'permitido_guardar':[
            'nom_tipo_telefono',
            'det_tipo_telefono',
         ],
         'relaciones_clase':[],
         'lom':{},
         'lista_objs_model':[],
         'tipos_telefonos': [],
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
            'id_tipo_telefono': false,
            'nom_tipo_telefono': true,
            'det_tipo_telefono': true,
            'created_at': false,
            'updated_at': false,
            'deleted_at': false,
         },

         /* Etiquetas */
         'tabla_labels': {
            'id_tipo_telefono': 'Id tipo aplicacion',
            'nom_tipo_telefono': 'Nombre tipo aplicacion',
            'det_tipo_telefono': 'Detalle tipo aplicacion',
            'created_at': 'Creado en',
            'updated_at': 'Actualizado en',
            'deleted_at': 'Eliminado en'
         },

         /* Campos del modelo en el excel */
         'excel_json_campos': {
            'id_tipo_telefono': 'String',
            'nom_tipo_telefono': 'String',
            'det_tipo_telefono': 'String',
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
      //Lo que hace este watcher o funcion de seguimiento es que cuando id en edicion es null se blanquea el tipo_telefono
      // o el objeto al que se le está haciendo seguimiento y permite que no choque con el que se está creando
      id_en_edicion: function (id_en_edicion) {
         if (id_en_edicion == null) { this.limpiar_objeto_clase_local(); }
         else { this.buscar_objeto_clase(id_en_edicion); }
      },
      //tipos_telefonos se mantiene en el watcher para actualizar la lista de lo que se esta trabajando y/o filtrando en grid
      tipos_telefonos: function (tipos_telefonos) {
         var self = this;
         this.excel_json_datos = [];
         return tipos_telefonos.map(function (tipo_telefono, index) {
            return self.excel_json_datos.push({
               'id_tipo_telefono': tipo_telefono.id_tipo_telefono || '-',
               'nom_tipo_telefono': tipo_telefono.nom_tipo_telefono || '-',
               'det_tipo_telefono': tipo_telefono.det_tipo_telefono || '-',
               'created_at': tipo_telefono.created_at || '-',
               'updated_at': tipo_telefono.updated_at || '-',
               'deleted_at': tipo_telefono.deleted_at || '-'
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
         this.lista_objs_model = response.body.tipos_telefonos.data || null;
         this.tipos_telefonos = response.body.tipos_telefonos.data || null;
         this.datos_excel = response.body.tipos_telefonos.data || null;

         /* Datos de la entidad hacia el paginador */
         this.pagination = response.body.tipos_telefonos || null;

         /* Datos de la sesion actual del usuario */
         this.usuario_auth = response.body.usuario_auth || null;

      },

   }
});
