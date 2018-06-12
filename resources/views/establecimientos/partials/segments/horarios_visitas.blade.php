<h5>HORARIO DE VISITAS</h5>
<div class="row">

   <div class="col-sm-2 col-md-2">

      <dt>Horario de Visita</dt>
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

   <div class="col-sm-1 col-md-1">

      <dt>Hora de Inicio</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <input type="time" v-model="horario_visita_establecimiento.hora_inicio" name="hora_inicio"
                   v-validate="{required:true,regex:/^[0-9_ :]+$/i}" data-vv-delay="500"
                   class="form-control"/>

            <transition name="bounce">
               <i v-show="errors.has('hora_inicio')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('hora_inicio')" class="text-danger small">
                  @{{ errors.first('hora_inicio') }}
               </span>
            </transition>
         </p>

      </dd>


   </div><!-- .col -->

   <div class="col-sm-1 col-md-1">

      <dt>Hora de Término</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <input type="time" v-model="horario_visita_establecimiento.hora_termino" name="hora_termino"
                   v-validate="{required:true,regex:/^[0-9_ :]+$/i}" data-vv-delay="500"
                   class="form-control"/>

            <transition name="bounce">
               <i v-show="errors.has('hora_termino')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('hora_termino')" class="text-danger small">
                  @{{ errors.first('hora_termino') }}
               </span>
            </transition>
         </p>

      </dd>


   </div><!-- .col -->

   <div class="col-sm-2 col-md-2">
      <dt>Confirmar y guardar</dt>
      <dd>
         <button class="btn btn-success" @click.prevent="guardar_horario_visita">
            Guardar
         </button>
      </dd>
   </div>

   <div class="col-sm-6 col-md-6">
      <div class="table-responsive">
         <table class="table table-striped table-hover table-sm" {{--v-if="establecimiento.telefonos && establecimiento.telefonos.length > 0"--}}>
            <thead>
            <tr>
               <th>1</th>
               <th>2</th>
               <th>3</th>
               <th>4</th>
               <th>Acción</th>
            </tr>
            </thead>
            <tbody>
            <tr {{--v-for="t in establecimiento.telefonos"--}}>
               <td>@{{-- t.cod_area }}</td>
               <td>@{{ t.num_telefono }}</td>
               <td>@{{ t.det_telefono }}</td>
               <td>@{{ t.tipo_telefono.nom_tipo_telefono --}}</td>
               <td>
                  <button class="btn btn-danger"
                          v-if="en_array(['Administrador','Jefe de Area','Lider Equipo','App Manager'],usuario_auth.usuario_role.role.nom_role)"
                          @click.prevent="eliminar_telefono(t.id_telefono)"
                          data-placement="top" data-toggle="tooltip" title="Quitar">
                     <i class="fa fa-close"></i>
                  </button>
               </td>
            </tr>
            </tbody>

         </table><!-- .table -->
         <div class="card card-body bg-light" v-else>
            Hasta el momento no existen teléfonos registrados.
         </div><!-- .card -->
      </div>
   </div>


</div><!-- .row -->