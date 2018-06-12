
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
            'observaciones':null,
            'nom_direccion':null,
            'num_calle':null,
            'nom_responsable':null,
            'sitio_web':null,
            'email':null,
            'cod_area_fax':null,
            'fax':null,
            'ext_horaria':null,
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
         'telefono':{
            'num_telefono':null,
            'det_telefono':null,
            'id_tipo_telefono':null,
            'cod_area':null,
         },
         'horario_atencion_establecimiento':{
            'id_establecimiento':null,
            'id_dia_atencion':null,
            'hora_inicio':null,
            'hora_termino':null,
         },
         'horario_visita_establecimiento':{
            'id_establecimiento':null,
            'id_dia_visita':null,
            'hora_inicio':null,
            'hora_termino':null,
         },

         'permitido_guardar':[
            'id_establecimiento',
            'nom_establecimiento',
            'observaciones',
            'nom_direccion',
            'num_calle',
            'nom_responsable',
            'sitio_web',
            'email',
            'cod_area_fax',
            'fax',
            'ext_horaria',
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
            {'tipo_establecimiento':['id_tipo_establecimiento','nom_tipo_establecimiento']},
            {'servicio_salud':['id_servicio_salud','nom_servicio_salud']},
            {'dependencia':['id_dependencia','nom_dependencia']},
            {'organismo':['id_organismo','nom_organismo']},
            {'region':['id_region','nom_region']},
            {'comuna':['id_comuna','nom_comuna']},
         ],
         'lom':{},
         'lista_objs_model':[],
         'establecimientos':[],
         'tipos_establecimientos':[],
         'tipos_telefonos':[],
         'servicios_salud':[],
         'dependencias':[],
         'organismos':[],
         'tipos_organismos':[],
         'regiones':[],
         'comunas':[],
         'dias_semana':[],
         
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
            'id_establecimiento':{'visibility':false,'value':null},
            'nom_establecimiento':{'visibility':true,'value':null},
            //'observaciones':{'visibility':true,'value':null},
            'nom_direccion':{'visibility':false,'value':null},
            'num_calle':{'visibility':false,'value':null},
            'nom_responsable':{'visibility':false,'value':null},
            //'sitio_web':{'visibility':true,'value':null},
            //'email':{'visibility':true,'value':null},
            //'cod_area_fax':{'visibility':true,'value':null},
            //'fax':{'visibility':true,'value':null},
            'ext_horaria':{'visibility':false,'value':null},
            //'vigencia_desde':{'visibility':true,'value':null},
            //'fecha_cierre':{'visibility':true,'value':null},
            'id_establecimiento_antiguo':{'visibility':false,'value':null},

            //'id_tipo_establecimiento':{'visibility':true,'value':null},
            'nom_tipo_establecimiento':{'visibility':false,'value':null},
            //'id_servicio_salud':{'visibility':true,'value':null},
            'nom_servicio_salud':{'visibility':false,'value':null},
            //'id_dependencia':{'visibility':true,'value':null},
            'nom_dependencia':{'visibility':false,'value':null},
            //'id_organismo':{'visibility':true,'value':null},
            'nom_organismo':{'visibility':false,'value':null},
            //'id_region':{'visibility':true,'value':null},
            'nom_region':{'visibility':false,'value':null},
            //'id_comuna':{'visibility':true,'value':null},
            'nom_comuna':{'visibility':false,'value':null},

            'created_at':{'visibility':false,'value':null},
            'updated_at':{'visibility':false,'value':null},
            //'deleted_at':{'visibility':false,'value':null},
         },

         /* Etiquetas */
         'tabla_labels': {
            'id_establecimiento':'Codigo establecimiento',
            'nom_establecimiento':'Nombre establecimiento',
            'observaciones':'Observaciones',
            'nom_direccion':'Nombre direccion',
            'num_calle':'Numero calle',
            'nom_responsable':'Nombre responsable',
            'sitio_web':'Sitio web',
            'email':'Email',
            'cod_area_fax':'Codigo area Fax',
            'fax':'Fax',
            'ext_horaria':'Extension Horaria',
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
            'observaciones':'String',
            'nom_direccion':'String',
            'nom_responsable':'String',
            'num_calle':'String',
            'sitio_web':'String',
            'email':'String',
            'cod_area_fax':'String',
            'fax':'String',
            'ext_horaria':'String',
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
               'observaciones': establecimiento.observaciones || '-',
               'nom_direccion': establecimiento.nom_direccion || '-',
               'nom_responsable': establecimiento.nom_responsable || '-',
               'num_calle': establecimiento.num_calle || '-',
               'sitio_web': establecimiento.sitio_web || '-',
               'email': establecimiento.email || '-',
               'cod_area_fax': establecimiento.cod_area_fax || '-',
               'fax': establecimiento.fax || '-',
               'ext_horaria': establecimiento.ext_horaria || '-',
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
         this.lista_objs_model = {};
         this.establecimientos = {};
         this.datos_excel = {};
         this.lista_objs_model = response.body.establecimientos.data || null;
         this.establecimientos = response.body.establecimientos.data || null;
         this.datos_excel = response.body.establecimientos.data || null;

         /* Datos de la entidad hacia el paginador */
         this.pagination = response.body.establecimientos || null;

         /* Datos de las relaciones con la entidad */
         this.tipos_establecimientos = response.body.tipos_establecimientos || null;
         this.tipos_telefonos = response.body.tipos_telefonos || null;
         this.servicios_salud = response.body.servicios_salud || null;
         this.dependencias = response.body.dependencias || null;
         this.organismos = response.body.organismos || null;
         this.tipos_organismos = response.body.tipos_organismos || null;
         this.regiones = response.body.regiones || null;
         this.comunas = response.body.comunas || null;
         this.dias_semana = response.body.dias_semana || null;

         /* Datos de la sesion actual del usuario */
         this.usuario_auth = response.body.usuario_auth || null;
      },
      
      eliminar_telefono: function (id) {

        swal({
           title: "¿Estás seguro/a?",
           text: "¿Deseas confirmar la eliminación de este registro?",
           type: "warning",
           showCancelButton: true,
           closeOnConfirm: false,
           closeOnCancel: false,
           confirmButtonColor: '#DD6B55',
           confirmButtonClass: "btn-danger",
           confirmButtonText: 'Si, eliminar!',
           cancelButtonText: 'No, mantener.'
        }).then((result) => {
           if (result.value) {
              //Se adjunta el token
              Vue.http.headers.common['X-CSRF-TOKEN'] = $('#_token').val();

              this.$http.delete(`/telefonos/${id}`).then(response => {
                 if (response.status == 200) {
                    this.eliminar_de_array_por_modelo_e_id(id, this.establecimiento.telefonos, 'telefono');
                    //this.auto_alerta_corta("Eliminado!", "Registro eliminado correctamente", "success", 800);
                 } else {
                    this.checkear_estado_respuesta_http(response.status);
                    return false;
                 }

                 if (this.mostrar_notificaciones(response) == true) {
                    //Recargar la lista
                    //this.inicializar();
                 }
              }, response => { // error callback
                 this.checkear_estado_respuesta_http(response.status);
              })
           }
        });

      },


      guardar_telefono: function () {
         //Ejecuta validacion sobre los campos con validaciones
         this.$validator.validateAll({
            cod_area:this.telefono.cod_area,
            id_tipo_telefono:this.telefono.id_tipo_telefono,
            num_telefono:this.telefono.num_telefono,
            det_telefono:this.telefono.det_telefono,
         }).then( res => {
            if (res == true) {
               //Se adjunta el token
               Vue.http.headers.common['X-CSRF-TOKEN'] = $('#_token').val();
               //Instancia nuevo form data
               var formData = new FormData();
               //Conforma objeto paramétrico para solicitud http
               formData.append(`num_telefono`, this.telefono.num_telefono);
               formData.append(`det_telefono`, this.telefono.det_telefono);
               formData.append(`cod_area`, this.telefono.cod_area);
               formData.append(`id_tipo_telefono`, this.telefono.id_tipo_telefono);
               formData.append(`id_establecimiento`, this.establecimiento.id_establecimiento);

               this.$http.post(`/telefonos`, formData).then(response => { // success callback

                  //console.log(response.body);

                  if (response.status == 200) {
                     //this.inicializar();
                     this.telefono = {
                        'num_telefono':null,
                        'det_telefono':null,
                        'id_tipo_telefono':null,
                        'cod_area':null,
                     };
                     this.establecimiento.telefonos.push(response.body.telefono);

                  } else {
                     this.checkear_estado_respuesta_http(response.status);
                     return false;
                  }
                  if (this.mostrar_notificaciones(response) == true) {
                     return;
                  }
               }, response => { // error callback
                  this.checkear_estado_respuesta_http(response.status);
               });
            }
         });
         return;
      },

      guardar_horario_atencion: function () {
         //Ejecuta validacion sobre los campos con validaciones
         this.$validator.validateAll({
            id_dia_atencion:this.horario_atencion_establecimiento.id_dia_atencion,
            hora_inicio:this.horario_atencion_establecimiento.hora_inicio,
            hora_termino:this.horario_atencion_establecimiento.hora_termino,
         }).then( res => {
            if (res == true) {
               //Se adjunta el token
               Vue.http.headers.common['X-CSRF-TOKEN'] = $('#_token').val();
               //Instancia nuevo form data
               var formData = new FormData();
               //Conforma objeto paramétrico para solicitud http
               formData.append(`id_dia_atencion`, this.horario_atencion_establecimiento.id_dia_atencion);
               formData.append(`hora_inicio`, this.horario_atencion_establecimiento.hora_inicio);
               formData.append(`hora_termino`, this.horario_atencion_establecimiento.hora_termino);
               formData.append(`id_establecimiento`, this.establecimiento.id_establecimiento);

               this.$http.post(`/horarios_atencion_establecimientos`, formData).then(response => { // success callback

                  //console.log(response.body);

                  if (response.status == 200) {
                     //this.inicializar();

                     this.horario_atencion_establecimiento = {
                        'id_establecimiento':null,
                        'id_dia_atencion':null,
                        'hora_inicio':null,
                        'hora_termino':null,
                     };

                     this.establecimiento.horarios_atencion_establecimientos.push(response.body.horario_atencion_establecimiento);

                     this.establecimiento.horarios_atencion_establecimientos = _.orderBy(
                        this.establecimiento.horarios_atencion_establecimientos,
                        ['id_dia_atencion','hora_inicio'],
                        'asc'
                     );

                  } else {
                     this.checkear_estado_respuesta_http(response.status);
                     return false;
                  }
                  if (this.mostrar_notificaciones(response) == true) {
                     return;
                  }
               }, response => { // error callback
                  this.checkear_estado_respuesta_http(response.status);
               });
            }
         });
         return;
      },

      eliminar_horario_atencion: function (id) {

         swal({
            title: "¿Estás seguro/a?",
            text: "¿Deseas confirmar la eliminación de este registro?",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            closeOnCancel: false,
            confirmButtonColor: '#DD6B55',
            confirmButtonClass: "btn-danger",
            confirmButtonText: 'Si, eliminar!',
            cancelButtonText: 'No, mantener.'
         }).then((result) => {
            if (result.value) {
               //Se adjunta el token
               Vue.http.headers.common['X-CSRF-TOKEN'] = $('#_token').val();

               this.$http.delete(`/horarios_atencion_establecimientos/${id}`).then(response => {
                  if (response.status == 200) {
                     this.eliminar_de_array_por_modelo_e_id(id, this.establecimiento.horarios_atencion_establecimientos, 'horario_atencion_establecimiento');
                     //this.auto_alerta_corta("Eliminado!", "Registro eliminado correctamente", "success", 800);
                  } else {
                     this.checkear_estado_respuesta_http(response.status);
                     return false;
                  }

                  if (this.mostrar_notificaciones(response) == true) {
                     //Recargar la lista
                     //this.inicializar();
                  }
               }, response => { // error callback
                  this.checkear_estado_respuesta_http(response.status);
               })
            }
         });

      },

      guardar_horario_visita: function () {
         //Ejecuta validacion sobre los campos con validaciones
         this.$validator.validateAll({
            id_dia_visita:this.horario_visita_establecimiento.id_dia_visita,
            hora_inicio:this.horario_visita_establecimiento.hora_inicio,
            hora_termino:this.horario_visita_establecimiento.hora_termino,
         }).then( res => {
            if (res == true) {
               //Se adjunta el token
               Vue.http.headers.common['X-CSRF-TOKEN'] = $('#_token').val();
               //Instancia nuevo form data
               var formData = new FormData();
               //Conforma objeto paramétrico para solicitud http
               formData.append(`id_dia_visita`, this.horario_visita_establecimiento.id_dia_visita);
               formData.append(`hora_inicio`, this.horario_visita_establecimiento.hora_inicio);
               formData.append(`hora_termino`, this.horario_visita_establecimiento.hora_termino);
               formData.append(`id_establecimiento`, this.establecimiento.id_establecimiento);

               this.$http.post(`/horarios_visita_establecimientos`, formData).then(response => { // success callback

                  //console.log(response.body);

                  if (response.status == 200) {
                     //this.inicializar();

                     this.horario_visita_establecimiento = {
                        'id_establecimiento':null,
                        'id_dia_visita':null,
                        'hora_inicio':null,
                        'hora_termino':null,
                     };

                     this.establecimiento.horarios_visita_establecimientos.push(response.body.horario_visita_establecimiento);

                     this.establecimiento.horarios_visita_establecimientos = _.orderBy(
                        this.establecimiento.horarios_visita_establecimientos,
                        ['id_dia_visita','hora_inicio'],
                        'asc'
                     );

                  } else {
                     this.checkear_estado_respuesta_http(response.status);
                     return false;
                  }
                  if (this.mostrar_notificaciones(response) == true) {
                     return;
                  }
               }, response => { // error callback
                  this.checkear_estado_respuesta_http(response.status);
               });
            }
         });
         return;
      },

      eliminar_horario_visita: function (id) {

         swal({
            title: "¿Estás seguro/a?",
            text: "¿Deseas confirmar la eliminación de este registro?",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            closeOnCancel: false,
            confirmButtonColor: '#DD6B55',
            confirmButtonClass: "btn-danger",
            confirmButtonText: 'Si, eliminar!',
            cancelButtonText: 'No, mantener.'
         }).then((result) => {
            if (result.value) {
               //Se adjunta el token
               Vue.http.headers.common['X-CSRF-TOKEN'] = $('#_token').val();

               this.$http.delete(`/horarios_visita_establecimientos/${id}`).then(response => {
                  if (response.status == 200) {
                     this.eliminar_de_array_por_modelo_e_id(id, this.establecimiento.horarios_visita_establecimientos, 'horario_visita_establecimiento');
                     //this.auto_alerta_corta("Eliminado!", "Registro eliminado correctamente", "success", 800);
                  } else {
                     this.checkear_estado_respuesta_http(response.status);
                     return false;
                  }

                  if (this.mostrar_notificaciones(response) == true) {
                     //Recargar la lista
                     //this.inicializar();
                  }
               }, response => { // error callback
                  this.checkear_estado_respuesta_http(response.status);
               })
            }
         });

      },

   }
});
