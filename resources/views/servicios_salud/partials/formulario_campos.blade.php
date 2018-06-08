<h5>Datos básicos</h5>
<div class="row">
   <div class="col-sm-4 col-md-4">

      <dt>Nombre servicio salud</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <input type="text" v-model="servicio_salud.nom_servicio_salud" name="nom_servicio_salud"
                   v-validate="{required:true,regex:/^[a-zA-Z0-9_ áéíóúñÁÉÍÓÚÑ]+$/i}" data-vv-delay="500"
                   class="form-control" />

            <transition name="bounce">
               <i v-show="errors.has('nom_servicio_salud')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('nom_servicio_salud')" class="text-danger small">
                  @{{ errors.first('nom_servicio_salud') }}
               </span>
            </transition>
         </p>
      </dd>


   </div><!-- .col -->

   <div class="col-sm-4 col-md-4">

      <dt>Detalle servicio salud</dt>
      <dd>

         <p class="control has-icon has-icon-right">
            <textarea cols="15" rows="1" v-model="servicio_salud.det_servicio_salud" name="det_servicio_salud"
                      v-validate="{regex:/^[a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+$/i}" data-vv-delay="500"
                      class="form-control"></textarea>

            <transition name="bounce">
               <i v-show="errors.has('det_servicio_salud')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('det_servicio_salud')" class="text-danger small">
                  @{{ errors.first('det_servicio_salud') }}
               </span>
            </transition>
         </p>
      </dd>

   </div><!-- .col -->

   <div class="col-sm-4 col-md-4">

      <dt>Orden</dt>
      <dd>

         <p class="control has-icon has-icon-right">
            <input type="text" v-model="servicio_salud.orden" name="orden"
                   v-validate="{regex:/^[a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+$/i}" data-vv-delay="500"
                   class="form-control" />

            <transition name="bounce">
               <i v-show="errors.has('orden')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('orden')" class="text-danger small">
                  @{{ errors.first('orden') }}
               </span>
            </transition>
         </p>
      </dd>

   </div><!-- .col -->

</div><!-- .row -->
<h5>Region</h5>
<div class="row">
   <div class="col-sm-4 col-md-4">

      <dt>Region</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <select class="custom-select" v-model="servicio_salud.id_region" name="id_region"
                    v-validate="{required:true,regex:/^[0-9]+$/i}" data-vv-delay="500">
               <option :value="r.id_region" v-for="r in regiones">
                  @{{ `${r.nom_region} -> ${r.det_region}` }}
               </option>
            </select>

            <transition name="bounce">
               <i v-show="errors.has('id_region')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('id_region')" class="text-danger small">
                  @{{ errors.first('id_region') }}
               </span>
            </transition>
         </p>

      </dd>

   </div><!-- .col -->

</div><!-- .row -->