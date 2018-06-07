<h5>Datos básicos</h5>
<div class="row">

   <div class="col-sm-4 col-md-4">

      <dt>Código area</dt>
      <dd>

         <p class="control has-icon has-icon-right">
            <input type="text" v-model="telefono.cod_area" name="cod_area"
                   v-validate="{required:true,regex:/^[0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+$/i}" data-vv-delay="500"
                   class="form-control" />

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

   <div class="col-sm-4 col-md-4">

      <dt>Numero telefono</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <input type="text" v-model="telefono.num_telefono" name="num_telefono"
                   v-validate="{required:true,regex:/^[0-9_ -áéíóúñÁÉÍÓÚÑ]+$/i}" data-vv-delay="500"
                   class="form-control" />

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



   <div class="col-sm-4 col-md-4">

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


</div><!-- .row -->
<h5>Tipo de telefono</h5>
<div class="row">
   <div class="col-sm-4 col-md-4">

      <dt>Tipo telefono</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <select class="form-control" v-model="telefono.id_tipo_telefono" name="id_tipo_telefono"
                    v-validate="{required:true,regex:/^[0-9]+$/i}" data-vv-delay="500">
               <option :value="tt.id_tipo_telefono" v-for="tt in tipos_telefonos">
                  @{{ `${tt.nom_tipo_telefono} -> ${tt.det_tipo_telefono}` }}
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
         </p>

      </dd>

   </div><!-- .col -->

</div><!-- .row -->


