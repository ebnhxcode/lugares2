<h5>HORARIO DE ANTENCIÓN</h5>
<div class="row">

   <div class="col-sm-6 col-md-6">
      <div class="row">

         <div class="col-sm-4 col-md-4">

            <dt>Horario de Atención</dt>
            <dd>
               <p class="control has-icon has-icon-right">
                  <select class="custom-select" v-model="horario_visita_establecimiento.id_dia_visita" name="id_dia_visita"
                          v-validate="{required:true,regex:/^[0-9]+$/i}" data-vv-delay="500">
                     <option :value="d.id_dia_semana" v-for="d in dias_semana">
                        @{{ `${d.nom_dia_semana}` }}
                     </option>
                  </select>

                  <transition name="bounce">
                     <i v-show="errors.has('id_dia_visita')" class="fa fa-exclamation-circle"></i>
                  </transition>

                  <transition name="bounce">
               <span v-show="errors.has('id_dia_visita')" class="text-danger small">
                  @{{ errors.first('id_dia_visita') }}
               </span>
                  </transition>
               </p>

            </dd>


         </div><!-- .col -->

         <div class="col-sm-3 col-md-3">

            <dt>Hora de Inicio</dt>
            <dd>
               <p class="control has-icon has-icon-right">
                  <input type="time" v-model="horario_visita_establecimiento.hora_inicio_visita" name="hora_inicio_visita"
                         v-validate="{required:true,regex:/^[0-9_ :]+$/i}" data-vv-delay="500"
                         class="form-control"/>

                  <transition name="bounce">
                     <i v-show="errors.has('hora_inicio_visita')" class="fa fa-exclamation-circle"></i>
                  </transition>

                  <transition name="bounce">
               <span v-show="errors.has('hora_inicio_visita')" class="text-danger small">
                  @{{ errors.first('hora_inicio_visita') }}
               </span>
                  </transition>
               </p>

            </dd>


         </div><!-- .col -->

         <div class="col-sm-3 col-md-3">

            <dt>Hora de Término</dt>
            <dd>
               <p class="control has-icon has-icon-right">
                  <input type="time" v-model="horario_visita_establecimiento.hora_termino_visita" name="hora_termino_visita"
                         v-validate="{required:true,regex:/^[0-9_ :]+$/i}" data-vv-delay="500"
                         class="form-control"/>

                  <transition name="bounce">
                     <i v-show="errors.has('hora_termino_visita')" class="fa fa-exclamation-circle"></i>
                  </transition>

                  <transition name="bounce">
               <span v-show="errors.has('hora_termino_visita')" class="text-danger small">
                  @{{ errors.first('hora_termino_visita') }}
               </span>
                  </transition>
               </p>

            </dd>


         </div><!-- .col -->

         <div class="col-sm-2 col-md-2">
            <dt>Guardar</dt>
            <dd>
               <button class="btn btn-success" @click.prevent="guardar_horario_visita">
                  Guardar
               </button>
            </dd>
         </div>

      </div>
   </div>



   <div class="col-sm-6 col-md-6">
      <h5>HORARIOS DE VISITA DISPONIBLES</h5>
      <div class="table-responsive">

         <table class="table table-striped table-hover table-sm"
                v-if="establecimiento.horarios_visita_establecimientos && establecimiento.horarios_visita_establecimientos.length > 0">
            <thead>
            <tr>
               <th>Nombre Establecimiento</th>
               <th>Día</th>
               <th>Hora Inicio</th>
               <th>Hora Término</th>
               <th>Acción</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="h in establecimiento.horarios_visita_establecimientos">
               <td>@{{ h.establecimiento.nom_establecimiento }}</td>
               <td>@{{ h.dia.nom_dia_semana }}</td>
               <td>@{{ h.hora_inicio_visita || 'Sin definir' }}</td>
               <td>@{{ h.hora_termino_visita || 'Sin definir' }}</td>
               <td>
                  <button class="btn btn-danger"
                          v-if="en_array(['Administrador','Jefe de Area','Lider Equipo','App Manager'],usuario_auth.usuario_role.role.nom_role)"
                          @click.prevent="eliminar_horario_visita(h.id_horario_visita_establecimiento)"
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