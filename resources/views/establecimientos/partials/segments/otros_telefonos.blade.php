<h5 v-if="modal_actualizar_activo==true">Otros Telefonos</h5>
<div class="row" v-if="modal_actualizar_activo==true">

   <div class="col-md-6">
      <div class="row">

         <div class="col-sm-6 col-md-6">

            <dt>Tipo Telefono</dt>
            <dd>
               <select class="custom-select" v-model="telefono.id_tipo_telefono" name="id_tipo_telefono"
                       v-validate="{required:true,regex:/^[0-9]+$/i}" data-vv-delay="500">
                  <option :value="t.id_tipo_telefono" v-for="t in tipos_telefonos">
                     @{{ `${t.nom_tipo_telefono} -> ${t.det_tipo_telefono}` }}
                  </option>
               </select>

               <transition name="bounce">
                  <i v-show="errors.has('id_tipo_telefono')" class="fa fa-exclamation-circle"></i>
               </transition>

               <transition name="bounce">
               <span v-show="errors.has('id_tipo_telefono')" class="text-danger small">
                  @{{ errors.first('id_tipo_telefono') }}
               </span>
               </transition>
            </dd>

         </div><!-- .col -->

         <div class="col-sm-6 col-md-6">

            <dt>Detalle telefono</dt>
            <dd>

               <p class="control has-icon has-icon-right">
                      <textarea cols="15" rows="1" v-model="telefono.det_telefono" name="det_telefono"
                                v-validate="{regex:/^[a-zA-Z0-9_ ,.!@#$%*&-áéíóúñÁÉÍÓÚÑ]+$/i}" data-vv-delay="500"
                                class="form-control"></textarea>

                  <transition name="bounce">
                     <i v-show="errors.has('det_telefono')" class="fa fa-exclamation-circle"></i>
                  </transition>

                  <transition name="bounce">
                         <span v-show="errors.has('det_telefono')" class="text-danger small">
                            @{{ errors.first('det_telefono') }}
                         </span>
                  </transition>
               </p>
            </dd>

         </div><!-- .col -->

         <div class="col-sm-3 col-md-3">
            <dt>Código Área</dt>
            <dd>
               <p class="control has-icon has-icon-right">
                  <input type="text" v-model="telefono.cod_area" name="cod_area"
                         v-validate="{required:true,regex:/^[0-9]+$/i}" data-vv-delay="500"
                         class="form-control"/>

                  <transition name="bounce">
                     <i v-show="errors.has('cod_area')" class="fa fa-exclamation-circle"></i>
                  </transition>

                  <transition name="bounce">
                     <span v-show="errors.has('cod_area')" class="text-danger small">
                        @{{ errors.first('cod_area') }}
                     </span>
                  </transition>
               </p>
            </dd>
         </div><!-- .col -->

         <div class="col-sm-7 col-md-7">

            <dt>Número teléfono</dt>
            <dd>

               <p class="control has-icon has-icon-right">
                  <input type="text" v-model="telefono.num_telefono" name="num_telefono"
                         v-validate="{required:true,regex:/^[0-9_ ]+$/i}" data-vv-delay="500"
                         class="form-control"/>

                  <transition name="bounce">
                     <i v-show="errors.has('num_telefono')" class="fa fa-exclamation-circle"></i>
                  </transition>

                  <transition name="bounce">
                     <span v-show="errors.has('num_telefono')" class="text-danger small">
                        @{{ errors.first('num_telefono') }}
                     </span>
                  </transition>
               </p>
            </dd>

         </div><!-- .col -->

         <div class="col-sm-2 col-md-2">
            <dt>Guardar</dt>
            <dd>
               <button class="btn btn-success" @click.prevent="guardar_telefono">
                  Guardar
               </button>
            </dd>
         </div>

      </div>
   </div>
   <div class="col-md-6">
      <div class="table-responsive">
         <table class="table table-striped table-hover table-sm" v-if="establecimiento.telefonos && establecimiento.telefonos.length > 0">
            <thead>
            <tr>
               <th>Cod. Área</th>
               <th>Numero</th>
               <th>Detalle</th>
               <th>Tipo</th>
               <th>Acción</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="t in establecimiento.telefonos">
               <td>@{{ t.cod_area }}</td>
               <td>@{{ t.num_telefono }}</td>
               <td>@{{ t.det_telefono }}</td>
               <td>@{{ t.tipo_telefono.nom_tipo_telefono }}</td>
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