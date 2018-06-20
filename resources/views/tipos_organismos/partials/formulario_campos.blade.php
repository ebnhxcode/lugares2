<div class="card">
   <div class="card-body pro">
      <h5>Datos básicos</h5>
      <div class="row">
         <div class="col-sm-6 col-md-6">
            <dt>Nombre tipo organismo</dt>
            <dd>
               <p class="control has-icon has-icon-right">
                  <input type="text" v-model="tipo_organismo.nom_tipo_organismo" name="nom_tipo_organismo"
                         v-validate="{required:true,regex:/^[a-zA-Z0-9_ áéíóúñÁÉÍÓÚÑ]+$/i}" data-vv-delay="500"
                         class="form-control" />

                  <transition name="bounce">
                     <i v-show="errors.has('nom_tipo_organismo')" class="fa fa-exclamation-circle"></i>
                  </transition>

                  <transition name="bounce">
               <span v-show="errors.has('nom_tipo_organismo')" class="text-danger small">
                  @{{ errors.first('nom_tipo_organismo') }}
               </span>
                  </transition>
               </p>
            </dd>


         </div><!-- .col -->

         <div class="col-sm-6 col-md-6">

            <dt>Detalle tipo organismo</dt>
            <dd>

               <p class="control has-icon has-icon-right">
            <textarea cols="15" rows="1" v-model="tipo_organismo.det_tipo_organismo" name="det_tipo_organismo"
                      v-validate="{regex:/^[a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+$/i}" data-vv-delay="500"
                      class="form-control"></textarea>

                  <transition name="bounce">
                     <i v-show="errors.has('det_tipo_organismo')" class="fa fa-exclamation-circle"></i>
                  </transition>

                  <transition name="bounce">
               <span v-show="errors.has('det_tipo_organismo')" class="text-danger small">
                  @{{ errors.first('det_tipo_organismo') }}
               </span>
                  </transition>
               </p>
            </dd>

         </div><!-- .col -->


      </div><!-- .row -->
   </div>
</div>