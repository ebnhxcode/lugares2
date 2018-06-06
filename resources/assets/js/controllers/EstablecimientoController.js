
import swal from 'sweetalert2';

//Se importan todas las librerias compartidas y se cargan en el objeto instanciado como alias -> hp
import { inyeccion_funciones_compartidas } from './libs/HelperPackage';

import VModal from 'vue-js-modal';
Vue.use(VModal, {dialog: true});

import Clipboard from 'v-clipboard';
Vue.use(Clipboard);

Vue.component('download-excel', require('../components/DownloadExcel.vue'));
Vue.component('paginators', require('../components/Paginators.vue'));

const EstablecimientoController = new Vue({
   el: '#EstablecimientoController',
   data(){
      return {
         '$':window.jQuery,
         'pk_tabla': 'id_establecimiento',
         'nombre_tabla':'establecimientos', //nombre tabla o de ruta
         'nombre_ruta':'establecimientos', //nombre tabla o de ruta
         'nombre_model':'establecimiento',
         'nombre_model_limpio': 'establecimiento_limpio',
         'nombre_detalle':'Establecimientos',
         'nombre_controller':'EstablecimientoController',

         'filtro_head':null,
         'establecimiento':{
            'nom_establecimiento':null,
            'tipo_establecimiento':null,
            'observaciones':null,
            'nom_direccion':null,
            'nom_responsable':null,
            'sitio_web':null,
            'email':null,
            'fax':null,
            'vigencia_desde':null,
            'fecha_cierre':null,

            'id_establecimiento_antiguo':null,

            'id_tipo_establecimiento':null,
            'nom_tipo_establecimiento':null,
            'id_servicio_salud':null,
            'nom_servicio_salud':null,
            'id_dependencia':null,
            'nom_dependencia':null,
            'id_organismo':null,
            'nom_organismo':null,
            'id_region':null,
            'nom_region':null,
            'id_comuna':null,
            'nom_comuna':null,

            'id_usuario_registra':null,
            'id_usuario_modifica':null,
            'created_at':null,
            'updated_at':null,
            'deleted_at':null,
         },
         'permitido_guardar':[
            'nom_establecimiento',
            'tipo_establecimiento',
            'observaciones',
            'nom_direccion',
            'nom_responsable',
            'sitio_web',
            'email',
            'fax',
            'vigencia_desde',
            'fecha_cierre',
            'id_establecimiento_antiguo',

            'id_tipo_establecimiento',
            'id_servicio_salud',
            'id_dependencia',
            'id_organismo',
            'id_region',
            'id_comuna',
         ],
         'relaciones_clase':[
            {'id_tipo_establecimiento':['id_tipo_establecimiento','nom_tipo_establecimiento']},
            {'id_servicio_salud':['id_servicio_salud','nom_servicio_salud']},
            {'id_dependencia':['id_dependencia','nom_dependencia']},
            {'id_organismo':['id_organismo','nom_organismo']},
            {'id_region':['id_region','nom_region']},
            {'id_comuna':['id_comuna','nom_comuna']},
         ],
         'lom':{},
         'lista_objs_model':[],
         'establecimientos':[],
         'tipos_establecimientos':[],
         'servicios_salud':[],
         'dependencias':[],
         'organismos':[],
         'regiones':[],
         'comunas':[],
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
            'id_establecimiento':false,
            'nom_establecimiento':true,
            'tipo_establecimiento':false,
            'observaciones':false,
            'nom_direccion':false,
            'nom_responsable':false,
            'sitio_web':false,
            'email':false,
            'fax':false,
            'vigencia_desde':false,
            'fecha_cierre':false,
            'id_establecimiento_antiguo':false,

            //'id_tipo_establecimiento':false,
            'nom_tipo_establecimiento':false,
            //'id_servicio_salud':false,
            'nom_servicio_salud':false,
            //'id_dependencia':false,
            'nom_dependencia':false,
            //'id_organismo':false,
            'nom_organismo':false,
            //'id_region':false,
            'nom_region':false,
            //'id_comuna':false,
            'nom_comuna':false,

            'created_at':false,
            'updated_at':false,
            'deleted_at':false,
         },

         /* Etiquetas */
         'tabla_labels': {
            'id_establecimiento':'Id establecimiento',
            'nom_establecimiento':'Nombre establecimiento',
            'tipo_establecimiento':'Tipo establecimiento',
            'observaciones':'Observaciones',
            'nom_direccion':'Nombre direccion',
            'nom_responsable':'Nombre responsable',
            'sitio_web':'Sitio web',
            'email':'Email',
            'fax':'Fax',
            'vigencia_desde':'Vigencia desde',
            'fecha_cierre':'Fecha cierre',
            'id_establecimiento_antiguo':'Id establecimiento antiguo',

            'id_tipo_establecimiento':'Id Tipo Establecimiento',
            'nom_tipo_establecimiento':'Nombre Tipo Establecimiento',
            'id_servicio_salud':'Id Servicio Salud',
            'nom_servicio_salud':'Nombre Servicio Salud',
            'id_dependencia':'Id Dependencia',
            'nom_dependencia':'Nombre Dependencia',
            'id_organismo':'Id Organismo',
            'nom_organismo':'Nombre Organismo',
            'id_region':'Id Region',
            'nom_region':'Nombre Region',
            'id_comuna':'Id Comuna',
            'nom_comuna':'Nombre Comuna',

            'id_usuario_registra':'Usuario registra',
            'id_usuario_modifica':'Usuario modifica',
            'created_at':'Creado en',
            'updated_at':'Actualizado en',
            'deleted_at':'Eliminado en',
         },

         /* Campos del modelo en el excel */
         'excel_json_campos': {
            'id_establecimiento':'String',
            'nom_establecimiento':'String',
            'tipo_establecimiento':'String',
            'observaciones':'String',
            'nom_direccion':'String',
            'nom_responsable':'String',
            'sitio_web':'String',
            'email':'String',
            'fax':'String',
            'vigencia_desde':'String',
            'fecha_cierre':'String',
            'id_establecimiento_antiguo':'String',
            'id_tipo_establecimiento':'String',
            'nom_tipo_establecimiento':'String',
            'id_servicio_salud':'String',
            'nom_servicio_salud':'String',
            'id_dependencia':'String',
            'nom_dependencia':'String',
            'id_organismo':'String',
            'nom_organismo':'String',
            'id_region':'String',
            'nom_region':'String',
            'id_comuna':'String',
            'nom_comuna':'String',

            //'id_usuario_registra':'String',
            //'id_usuario_modifica':'String',
            'created_at':'String',
            'updated_at':'String',
            'deleted_at':'String',
         },

         'excel_json_datos': [],
         'excel_data_contador': 0,

         'append_to_json_excel': {},

      }
   },
   computed: {},
   watch: {
      //Lo que hace este watcher o funcion de seguimiento es que cuando id en edicion es null se blanquea el establecimiento
      // o el objeto al que se le está haciendo seguimiento y permite que no choque con el que se está creando
      id_en_edicion: function (id_en_edicion) {
         if (id_en_edicion == null) { this.limpiar_objeto_clase_local(); }
         else { this.buscar_objeto_clase_config_relaciones(id_en_edicion, this.relaciones_clase); }
      },
      //establecimientos se mantiene en el watcher para actualizar la lista de lo que se esta trabajando y/o filtrando en grid
      establecimientos: function (establecimientos) {
         var self = this;
         this.excel_json_datos = [];
         return establecimientos.map(function (establecimiento, index) {
            return self.excel_json_datos.push({
               'id_establecimiento': establecimiento.id_establecimiento || '-',
               'nom_establecimiento': establecimiento.nom_establecimiento || '-',
               'tipo_establecimiento': establecimiento.tipo_establecimiento || '-',
               'observaciones': establecimiento.observaciones || '-',
               'nom_direccion': establecimiento.nom_direccion || '-',
               'nom_responsable': establecimiento.nom_responsable || '-',
               'sitio_web': establecimiento.sitio_web || '-',
               'email': establecimiento.email || '-',
               'fax': establecimiento.fax || '-',
               'vigencia_desde': establecimiento.vigencia_desde || '-',
               'fecha_cierre': establecimiento.fecha_cierre || '-',
               'id_establecimiento_antiguo': establecimiento.id_establecimiento_antiguo || '-',
               'id_tipo_establecimiento': establecimiento.id_tipo_establecimiento || '-',
               'nom_tipo_establecimiento': establecimiento.nom_tipo_establecimiento || '-',
               'id_servicio_salud': establecimiento.id_servicio_salud || '-',
               'nom_servicio_salud': establecimiento.nom_servicio_salud || '-',
               'id_dependencia': establecimiento.id_dependencia || '-',
               'nom_dependencia': establecimiento.nom_dependencia || '-',
               'id_organismo': establecimiento.id_organismo || '-',
               'nom_organismo': establecimiento.nom_organismo || '-',
               'id_region': establecimiento.id_region || '-',
               'nom_region': establecimiento.nom_region || '-',
               'id_comuna': establecimiento.id_comuna || '-',
               'nom_comuna': establecimiento.nom_comuna || '-',

               //'id_usuario_registra': establecimiento.id_usuario_registra || '-',
               //'id_usuario_modifica': establecimiento.id_usuario_modifica || '-',
               'created_at': establecimiento.created_at || '-',
               'updated_at': establecimiento.updated_at || '-',
               'deleted_at': establecimiento.deleted_at || '-',
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
         this.lista_objs_model = response.body.establecimientos.data || null;
         this.establecimientos = response.body.establecimientos.data || null;
         this.datos_excel = response.body.establecimientos.data || null;

         /* Datos de la entidad hacia el paginador */
         this.pagination = response.body.establecimientos || null;

         /* Datos de las relaciones con la entidad */
         this.tipos_establecimientos = response.body.tipos_establecimientos || null;
         this.servicios_salud = response.body.servicios_salud || null;
         this.dependencias = response.body.dependencias || null;
         this.organismos = response.body.organismos || null;
         this.regiones = response.body.regiones || null;
         this.comunas = response.body.comunas || null;

         /* Datos de la sesion actual del usuario */
         this.usuario_auth = response.body.usuario_auth || null;
      },



   }
});
