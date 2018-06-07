<h5>Datos básicos</h5>
<div class="row">
   <div class="col-sm-4 col-md-4">

      <dt>Id comuna</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <input type="text" v-model="comuna.id_comuna" name="id_comuna"
                   v-validate="{required:true,regex:/^[a-zA-Z0-9_ áéíóúñÁÉÍÓÚÑ]+$/i}" data-vv-delay="500"
                   class="form-control" />

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
   <div class="col-sm-4 col-md-4">

      <dt>Nombre comuna</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <input type="text" v-model="comuna.nom_comuna" name="nom_comuna"
                   v-validate="{required:true,regex:/^[a-zA-Z0-9_ áéíóúñÁÉÍÓÚÑ]+$/i}" data-vv-delay="500"
                   class="form-control" />

            <transition name="bounce">
               <i v-show="errors.has('nom_comuna')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('nom_comuna')" class="text-danger small">
                  @{{ errors.first('nom_comuna') }}
               </span>
            </transition>
         </p>
      </dd>


   </div><!-- .col -->

   <div class="col-sm-4 col-md-4">

      <dt>Detalle comuna</dt>
      <dd>

         <p class="control has-icon has-icon-right">
            <textarea cols="15" rows="1" v-model="comuna.det_comuna" name="det_comuna"
                      v-validate="{regex:/^[a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+$/i}" data-vv-delay="500"
                      class="form-control"></textarea>

            <transition name="bounce">
               <i v-show="errors.has('det_comuna')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('det_comuna')" class="text-danger small">
                  @{{ errors.first('det_comuna') }}
               </span>
            </transition>
         </p>
      </dd>

   </div><!-- .col -->

   <div class="col-sm-4 col-md-4">

      <dt>Alias comuna</dt>
      <dd>

         <p class="control has-icon has-icon-right">
            <input type="text" v-model="comuna.alias" name="alias"
                   v-validate="{regex:/^[a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+$/i}" data-vv-delay="500"
                   class="form-control" />

            <transition name="bounce">
               <i v-show="errors.has('alias')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('alias')" class="text-danger small">
                  @{{ errors.first('alias') }}
               </span>
            </transition>
         </p>
      </dd>

   </div><!-- .col -->

   <div class="col-sm-4 col-md-4">

      <dt>Orden comuna</dt>
      <dd>

         <p class="control has-icon has-icon-right">
            <input type="text" v-model="comuna.orden" name="orden"
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
            <select class="form-control" v-model="comuna.id_region" name="id_region"
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