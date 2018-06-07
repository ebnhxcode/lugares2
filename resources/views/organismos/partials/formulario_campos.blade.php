<h5>Datos básicos</h5>
<div class="row">

   <div class="col-sm-4 col-md-4">

      <dt>Nombre organismo</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <input type="text" v-model="organismo.nom_organismo" name="nom_organismo"
                   v-validate="{required:true,regex:/^[a-zA-Z0-9_ -]+$/i}" data-vv-delay="500"
                   class="form-control" />

            <transition name="bounce">
               <i v-show="errors.has('nom_organismo')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('nom_organismo')" class="text-danger small">
                  @{{ errors.first('nom_organismo') }}
               </span>
            </transition>
         </p>
      </dd>


   </div><!-- .col -->



   <div class="col-sm-4 col-md-4">

      <dt>Detalle organismo</dt>
      <dd>

         <p class="control has-icon has-icon-right">
            <textarea cols="15" rows="1" v-model="organismo.det_organismo" name="det_organismo"
                      v-validate="{required:true,regex:/^[a-zA-Z0-9_ ,.!@#$%*&-]+$/i}" data-vv-delay="500"
                      class="form-control"></textarea>

            <transition name="bounce">
               <i v-show="errors.has('det_organismo')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('det_organismo')" class="text-danger small">
                  @{{ errors.first('det_organismo') }}
               </span>
            </transition>
         </p>
      </dd>

   </div><!-- .col -->

   <div class="col-sm-4 col-md-4">

      <dt>Código organismo</dt>
      <dd>

         <p class="control has-icon has-icon-right">
            <input type="text" v-model="organismo.cod_organismo" name="cod_organismo"
                   v-validate="{required:true,regex:/^[a-zA-Z0-9_ ,.!@#$%*&]+$/i}" data-vv-delay="500"
                   class="form-control" />

            <transition name="bounce">
               <i v-show="errors.has('cod_organismo')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('cod_organismo')" class="text-danger small">
                  @{{ errors.first('cod_organismo') }}
               </span>
            </transition>
         </p>
      </dd>

   </div><!-- .col -->




</div><!-- .row -->
<h5>Tipo de organismo</h5>
<div class="row">
   <div class="col-sm-4 col-md-4">

      <dt>Tipo organismo</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <select class="form-control" v-model="organismo.id_tipo_organismo" name="id_tipo_organismo"
                    v-validate="{required:true,regex:/^[0-9]+$/i}" data-vv-delay="500">
               <option :value="to.id_tipo_organismo" v-for="to in tipos_organismos">
                  @{{ `${to.nom_tipo_organismo} -> ${to.det_tipo_organismo}` }}
               </option>
            </select>

            <transition name="bounce">
               <i v-show="errors.has('id_tipo_organismo')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('id_tipo_organismo')" class="text-danger small">
                  @{{ errors.first('id_tipo_organismo') }}
               </span>
            </transition>
         </p>

      </dd>

   </div><!-- .col -->

</div><!-- .row -->


