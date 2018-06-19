<h5>EXTENSIÓN HORARIA</h5>
<div class="row">

   <div class="col-sm-12 col-md-4">

      <dt>Extensión Horaria</dt>
      <dd>
         <p class="control has-icon has-icon-right">

            <select class="custom-select" v-model="establecimiento.ext_horaria" name="ext_horaria"
                    v-validate="{required:true,regex:/^[a-z]+$/i}" data-vv-delay="500">
               <option value="si">Si</option>
               <option value="no">No</option>
            </select>

            <transition name="bounce">
               <i v-show="errors.has('ext_horaria')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('ext_horaria')" class="text-danger small">
                  @{{ errors.first('ext_horaria') }}
               </span>
            </transition>
         </p>
      </dd>

   </div><!-- .col -->

</div><!-- .row -->

<hr>

<div class="row" v-if="establecimiento.ext_horaria=='si'">

   <div class="col-sm-12 col-md-6">
      <h5>HORARIO DE ANTENCIÓN DE PROFESIONALES</h5>
      <div class="row">

         <div class="col-sm-12 col-md-12">

            <dt>Profesional</dt>
            <dd>
               <p class="control has-icon has-icon-right">
                  <select class="custom-select" v-model="horario_atencion_profesional.id_profesional" name="id_profesional"
                          v-validate="{required:true,regex:/^[0-9]+$/i}" data-vv-delay="500">
                     <option :value="p.id_profesional" v-for="p in profesionales">
                        @{{ `${p.nom_profesional}` }}
                     </option>
                  </select>

                  <transition name="bounce">
                     <i v-show="errors.has('id_profesional')" class="fa fa-exclamation-circle"></i>
                  </transition>

                  <transition name="bounce">
               <span v-show="errors.has('id_profesional')" class="text-danger small">
                  @{{ errors.first('id_profesional') }}
               </span>
                  </transition>
               </p>

            </dd>


         </div><!-- .col -->

         <div class="col-sm-4 col-md-4">

            <dt>Horario de Atención</dt>
            <dd>
               <p class="control has-icon has-icon-right">
                  <select class="custom-select" v-model="horario_atencion_profesional.id_dia_profesional" name="id_dia_profesional"
                          v-validate="{required:true,regex:/^[0-9]+$/i}" data-vv-delay="500">
                     <option :value="d.id_dia_semana" v-for="d in dias_semana">
                        @{{ `${d.nom_dia_semana}` }}
                     </option>
                  </select>

                  <transition name="bounce">
                     <i v-show="errors.has('id_dia_profesional')" class="fa fa-exclamation-circle"></i>
                  </transition>

                  <transition name="bounce">
               <span v-show="errors.has('id_dia_profesional')" class="text-danger small">
                  @{{ errors.first('id_dia_profesional') }}
               </span>
                  </transition>
               </p>

            </dd>


         </div><!-- .col -->

         <div class="col-sm-3 col-md-3">

            <dt>Hora de Inicio</dt>
            <dd>
               <p class="control has-icon has-icon-right">
                  <input type="time" v-model="horario_atencion_profesional.hora_inicio_profesional" name="hora_inicio_profesional"
                         v-validate="{required:true,regex:/^[0-9_ :]+$/i}" data-vv-delay="500"
                         class="form-control"/>

                  <transition name="bounce">
                     <i v-show="errors.has('hora_inicio_profesional')" class="fa fa-exclamation-circle"></i>
                  </transition>

                  <transition name="bounce">
               <span v-show="errors.has('hora_inicio_profesional')" class="text-danger small">
                  @{{ errors.first('hora_inicio_profesional') }}
               </span>
                  </transition>
               </p>

            </dd>


         </div><!-- .col -->

         <div class="col-sm-3 col-md-3">

            <dt>Hora de Término</dt>
            <dd>
               <p class="control has-icon has-icon-right">
                  <input type="time" v-model="horario_atencion_profesional.hora_termino_profesional" name="hora_termino_profesional"
                         v-validate="{required:true,regex:/^[0-9_ :]+$/i}" data-vv-delay="500"
                         class="form-control"/>

                  <transition name="bounce">
                     <i v-show="errors.has('hora_termino_profesional')" class="fa fa-exclamation-circle"></i>
                  </transition>

                  <transition name="bounce">
               <span v-show="errors.has('hora_termino_profesional')" class="text-danger small">
                  @{{ errors.first('hora_termino_profesional') }}
               </span>
                  </transition>
               </p>

            </dd>


         </div><!-- .col -->

         <div class="col-sm-2 col-md-2">
            <dt>Guardar</dt>
            <dd>
               <button class="btn btn-success" @click.prevent="guardar_horario_profesional">
                  Guardar
               </button>
            </dd>
         </div>

      </div>

      <hr>

      <div class="row">
         <div class="col-sm-12 col-md-12">
            <dt>Observaciones generales para horario de atención</dt>
            <dd>

               <p class="control has-icon has-icon-right">
            <textarea cols="15" rows="1" v-model="establecimiento.observaciones_horario_profesionales" name="observaciones_horario_profesionales"
                      v-validate="{regex:/^[a-zA-Z0-9_ ,.!@#$%*&-áéíóúñÁÉÍÓÚÑ]+$/i}" data-vv-delay="500"
                      class="form-control"></textarea>

                  <transition name="bounce">
                     <i v-show="errors.has('observaciones_horario_profesionales')" class="fa fa-exclamation-circle"></i>
                  </transition>

                  <transition name="bounce">
               <span v-show="errors.has('observaciones_horario_profesionales')" class="text-danger small">
                  @{{ errors.first('observaciones_horario_profesionales') }}
               </span>
                  </transition>
               </p>
            </dd>
         </div><!-- .col -->
      </div>

   </div>



   <div class="col-sm-12 col-md-6">
      <h5>HORARIOS DE ATENCIÓN DISPONIBLES</h5>
      <div class="table-responsive">

         <table class="table table-striped table-hover table-sm"
                v-if="establecimiento.horarios_atencion_profesionales && establecimiento.horarios_atencion_profesionales.length > 0">
            <thead>
            <tr>
               <th>Nombre Establecimiento</th>
               <th>Profesional</th>
               <th>Día</th>
               <th>Hora Inicio</th>
               <th>Hora Término</th>
               <th>Acción</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="h in establecimiento.horarios_atencion_profesionales">
               <td>@{{ h.establecimiento.nom_establecimiento }}</td>
               <td>@{{ h.profesional.nom_profesional }}</td>
               <td>@{{ h.dia.nom_dia_semana }}</td>
               <td>@{{ h.hora_inicio_profesional || 'Sin definir' }}</td>
               <td>@{{ h.hora_termino_profesional || 'Sin definir' }}</td>
               <td>
                  <button class="btn btn-danger"
                          v-if="en_array(['Administrador','Jefe de Area','Lider Equipo','App Manager'],usuario_auth.usuario_role.role.nom_role)"
                          @click.prevent="eliminar_horario_profesional(h.id_horario_atencion_profesional)"
                          data-placement="top" data-toggle="tooltip" title="Quitar">
                     <i class="fa fa-close"></i>
                  </button>
               </td>
            </tr>
            </tbody>

         </table><!-- .table -->
         <div class="card card-body bg-light" v-else>
            Hasta el momento no existen horarios registrados.
         </div><!-- .card -->
      </div>
   </div>







</div><!-- .row -->
<br>