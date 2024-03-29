<div class="card">
   <div class="card-body pro">
      <h5>Datos básicos</h5>
      <div class="row">
         <div class="col-sm-6 col-md-6">
            <dt>Nombre tipo telefono</dt>
            <dd>
               <p class="control has-icon has-icon-right">
                  <input type="text" v-model="tipo_telefono.nom_tipo_telefono" name="nom_tipo_telefono"
                         v-validate="{required:true,regex:/^[a-zA-Z0-9_ áéíóúñÁÉÍÓÚÑ]+$/i}" data-vv-delay="500"
                         class="form-control" />

                  <transition name="bounce">
                     <i v-show="errors.has('nom_tipo_telefono')" class="fa fa-exclamation-circle"></i>
                  </transition>

                  <transition name="bounce">
               <span v-show="errors.has('nom_tipo_telefono')" class="text-danger small">
                  @{{ errors.first('nom_tipo_telefono') }}
               </span>
                  </transition>
               </p>
            </dd>


         </div><!-- .col -->

         <div class="col-sm-6 col-md-6">

            <dt>Detalle tipo telefono</dt>
            <dd>

               <p class="control has-icon has-icon-right">
            <textarea cols="15" rows="1" v-model="tipo_telefono.det_tipo_telefono" name="det_tipo_telefono"
                      v-validate="{regex:/^[a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+$/i}" data-vv-delay="500"
                      class="form-control"></textarea>

                  <transition name="bounce">
                     <i v-show="errors.has('det_tipo_telefono')" class="fa fa-exclamation-circle"></i>
                  </transition>

                  <transition name="bounce">
               <span v-show="errors.has('det_tipo_telefono')" class="text-danger small">
                  @{{ errors.first('det_tipo_telefono') }}
               </span>
                  </transition>
               </p>
            </dd>

         </div><!-- .col -->

         <div class="col-sm-4 col-md-4">

            <dt>Sub Tipo Telefono</dt>
            <dd>
               <select class="custom-select" v-model="tipo_telefono.sub_tipo_telefono" name="sub_tipo_telefono"
                       v-validate="{required:true,regex:/^[a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+$/i}" data-vv-delay="500">
                  <option value="movil">Teléfono Móvil</option>
                  <option value="fijo">Fijo</option>
                  <option value="linea800">Línea 800</option>
               </select>

               <transition name="bounce">
                  <i v-show="errors.has('sub_tipo_telefono')" class="fa fa-exclamation-circle"></i>
               </transition>

               <transition name="bounce">
               <span v-show="errors.has('sub_tipo_telefono')" class="text-danger small">
                  @{{ errors.first('sub_tipo_telefono') }}
               </span>
               </transition>
            </dd>

         </div><!-- .col -->

      </div><!-- .row -->
   </div>
</div>