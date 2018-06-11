<h5>DATOS DE GEOLOCALIZACIÓN</h5>
<div class="row">
   <div class="col-sm-4 col-md-4">

      <dt>Region</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <select class="custom-select" v-model="establecimiento.id_region" name="id_region"
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

   <div class="col-sm-4 col-md-4">

      <dt>Comuna</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <select class="custom-select" v-model="establecimiento.id_comuna" name="id_comuna"
                    v-validate="{required:true,regex:/^[0-9]+$/i}" data-vv-delay="500">
               <option :value="c.id_comuna" v-for="c in comunas" v-if="establecimiento.id_region==c.id_region">
                  @{{ `${c.nom_comuna} -> ${c.det_comuna}` }}
               </option>
            </select>

            <transition name="bounce">
               <i v-show="errors.has('id_comuna')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('id_comuna')" class="text-danger small">
                  @{{ errors.first('id_comuna') }}
               </span>
            </transition>
         </p>

      </dd>

   </div><!-- .col -->
</div><!-- .row -->