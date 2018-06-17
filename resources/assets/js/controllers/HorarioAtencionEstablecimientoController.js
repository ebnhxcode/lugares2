
import swal from 'sweetalert2';

//Se importan todas las librerias compartidas y se cargan en el objeto instanciado como alias -> hp
import { inyeccion_funciones_compartidas } from './libs/HelperPackage';

import VModal from 'vue-js-modal';
Vue.use(VModal, {dialog: true});

import Clipboard from 'v-clipboard';
Vue.use(Clipboard);

Vue.component('download-excel', require('../components/DownloadExcel.vue'));
Vue.component('paginators', require('../components/Paginators.vue'));

const HorarioAtencionEstablecimientoController = new Vue({
   el: '#HorarioAtencionEstablecimientoController',
   data(){
      return {
         '$':window.jQuery,
         'pk_tabla': 'id_horario_atencion_establecimiento',
         'nombre_tabla':'horarios_atencion_establecimientos', //nombre tabla o de ruta
         'nombre_ruta':'horarios_atencion_establecimientos', //nombre tabla o de ruta
         'nombre_model':'horario_atencion_establecimiento',
         'nombre_model_limpio': 'horario_atencion_establecimiento_limpio',
         'nombre_detalle':'Usuarios Bitacora Servicios',
         'nombre_controller':'HorarioAtencionEstablecimientoController',

         'filtro_head':null,
         'horario_atencion_establecimiento':{
            'id_horario_atencion_establecimiento':null,
            'id_establecimiento':null,
            'nom_establecimiento':null,
            'id_dia':null,
            'nom_dia':null,
            'hora_inicio':null,
            'hora_termino':null,

            'id_usuario_registra':null,
            'id_usuario_modifica':null,
            'created_at':null,
            'updated_at':null,
            'deleted_at':null,
         },
         'permitido_guardar':[
            'id_establecimiento',
            'id_dia',
            'hora_inicio',
            'hora_termino',
         ],
         'relaciones_clase':[
            {'establecimiento':['id_establecimiento','nom_establecimiento']},
            {'dia':['id_dia','nom_dia']},
         ],
         'lom':{},
         'lista_objs_model':[],
         'horarios_atencion_establecimientos':[],

         'spinner_table':true,

         'datos_excel':[],
         'usuario_auth':[],

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

         'tabla_campos': {
            //'id_horario_atencion_establecimiento':{'visibility':false,'value':null},
            'id_establecimiento':{'visibility':false,'value':null},
            'nom_establecimiento':{'visibility':false,'value':null},
            'id_dia':{'visibility':false,'value':null},
            'nom_dia':{'visibility':false,'value':null},
            'hora_inicio':{'visibility':false,'value':null},
            'hora_termino':{'visibility':false,'value':null},

            //'id_usuario_registra':{'visibility':false,'value':null},
            //'id_usuario_modifica':{'visibility':false,'value':null},
            'created_at':{'visibility':false,'value':null},
            'updated_at':{'visibility':false,'value':null},
            'deleted_at':{'visibility':false,'value':null},
         },

         /* Etiquetas */
         'tabla_labels': {
            'id_horario_atencion_establecimiento':'Id horario atencion',
            'id_establecimiento':'Id establecimiento',
            'nom_establecimiento':'Nombre establecimiento',
            'id_dia':'Id dia',
            'nom_dia':'Nombre dia',
            'hora_inicio':'Hora Inicio',
            'hora_termino':'Hora Termino',

            'id_usuario_registra':'Usuario registra',
            'id_usuario_modifica':'Usuario modifica',
            'created_at':'Creado en',
            'updated_at':'Actualizado en',
            'deleted_at':'Eliminado en'
         },

         /* Campos del modelo en el excel */
         'excel_json_campos': {
            'id_horario_atencion_establecimiento': 'String',
            'id_establecimiento': 'String',
            'nom_establecimiento': 'String',
            'id_dia': 'String',
            'nom_dia': 'String',
            'hora_inicio': 'String',
            'hora_termino': 'String',

            //'id_usuario_registra': 'String',
            //'id_usuario_modifica': 'String',
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
      //Lo que hace este watcher o funcion de seguimiento es que cuando id en edicion es null se blanquea el horario_atencion_establecimiento
      // o el objeto al que se le está haciendo seguimiento y permite que no choque con el que se está creando
      id_en_edicion: function (id_en_edicion) {
         if (id_en_edicion == null) { this.limpiar_objeto_clase_local(); }
         else { this.buscar_objeto_clase_config_relaciones(id_en_edicion, this.relaciones_clase); }
      },
      //horarios_atencion_establecimientos se mantiene en el watcher para actualizar la lista de lo que se esta trabajando y/o filtrando en grid
      horarios_atencion_establecimientos: function (horarios_atencion_establecimientos) {
         var self = this;
         this.excel_json_datos = [];
         return horarios_atencion_establecimientos.map(function (horario_atencion_establecimiento, index) {
            return self.excel_json_datos.push({
               'id_horario_atencion_establecimiento': horario_atencion_establecimiento.id_horario_atencion_establecimiento || '-',
               'id_establecimiento': horario_atencion_establecimiento.id_establecimiento || '-',
               'nom_establecimiento': horario_atencion_establecimiento.nom_establecimiento || '-',
               'id_dia': horario_atencion_establecimiento.id_dia || '-',
               'nom_dia': horario_atencion_establecimiento.nom_dia || '-',
               'hora_inicio': horario_atencion_establecimiento.hora_inicio || '-',
               'hora_termino': horario_atencion_establecimiento.hora_termino || '-',

               //'id_usuario_registra': horario_atencion_establecimiento.id_usuario_registra || '-',
               //'id_usuario_modifica': horario_atencion_establecimiento.id_usuario_modifica || '-',
               'created_at': horario_atencion_establecimiento.created_at || '-',
               'updated_at': horario_atencion_establecimiento.updated_at || '-',
               'deleted_at': horario_atencion_establecimiento.deleted_at || '-'
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
         this.lista_objs_model = response.body.horarios_atencion_establecimientos.data || null;
         this.horarios_atencion_establecimientos = response.body.horarios_atencion_establecimientos.data || null;
         this.datos_excel = response.body.horarios_atencion_establecimientos.data || null;

         /* Datos de la entidad hacia el paginador */
         this.pagination = response.body.horarios_atencion_establecimientos || null;

         /* Relaciones con la entidad */
         this.dias_semana = response.body.dias_semana || null;
         this.establecimientos = response.body.establecimientos || null;

         /* Datos de la sesion actual del usuario */
         this.usuario_auth = response.body.usuario_auth || null;

      },

   }
});