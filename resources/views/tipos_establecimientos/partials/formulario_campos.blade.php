<h5>Datos básicos</h5>
<div class="row">
   <div class="col-sm-6 col-md-6">
      <dt>Nombre tipo establecimiento</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <input type="text" v-model="tipo_establecimiento.nom_tipo_establecimiento" name="nom_tipo_establecimiento"
                   v-validate="{required:true,regex:/^[a-zA-Z0-9_ áéíóúñÁÉÍÓÚÑ]+$/i}" data-vv-delay="500"
                   class="form-control" />

            <transition name="bounce">
               <i v-show="errors.has('nom_tipo_establecimiento')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('nom_tipo_establecimiento')" class="text-danger small">
                  @{{ errors.first('nom_tipo_establecimiento') }}
               </span>
            </transition>
         </p>
      </dd>


   </div><!-- .col -->

   <div class="col-sm-6 col-md-6">

      <dt>Detalle tipo establecimiento</dt>
      <dd>

         <p class="control has-icon has-icon-right">
            <textarea cols="15" rows="1" v-model="tipo_establecimiento.det_tipo_establecimiento" name="det_tipo_establecimiento"
                      v-validate="{regex:/^[a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+$/i}" data-vv-delay="500"
                      class="form-control"></textarea>

            <transition name="bounce">
               <i v-show="errors.has('det_tipo_establecimiento')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('det_tipo_establecimiento')" class="text-danger small">
                  @{{ errors.first('det_tipo_establecimiento') }}
               </span>
            </transition>
         </p>
      </dd>

   </div><!-- .col -->


</div><!-- .row -->
