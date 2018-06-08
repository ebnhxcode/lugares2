<h5>Datos básicos</h5>
<div class="row">
   <div class="col-sm-4 col-md-4">

      <dt>Nombre profesional</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <input type="text" v-model="profesional.nom_profesional" name="nom_profesional"
                   v-validate="{required:true,regex:/^[a-zA-Z0-9_ áéíóúñÁÉÍÓÚÑ]+$/i}" data-vv-delay="500"
                   class="form-control" />

            <transition name="bounce">
               <i v-show="errors.has('nom_profesional')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('nom_profesional')" class="text-danger small">
                  @{{ errors.first('nom_profesional') }}
               </span>
            </transition>
         </p>
      </dd>


   </div><!-- .col -->

   <div class="col-sm-4 col-md-4">

      <dt>Detalle profesional</dt>
      <dd>

         <p class="control has-icon has-icon-right">
            <textarea cols="15" rows="1" v-model="profesional.det_profesional" name="det_profesional"
                      v-validate="{regex:/^[a-zA-Z0-9_ ,.!@#$%*&áéíóúñÁÉÍÓÚÑ]+$/i}" data-vv-delay="500"
                      class="form-control"></textarea>

            <transition name="bounce">
               <i v-show="errors.has('det_profesional')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('det_profesional')" class="text-danger small">
                  @{{ errors.first('det_profesional') }}
               </span>
            </transition>
         </p>
      </dd>

   </div><!-- .col -->


</div><!-- .row -->
<h5>Tipo de profesional, cargo y estado</h5>
<div class="row">
   <div class="col-sm-4 col-md-4">

      <dt>Tipo profesional</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <select class="custom-select" v-model="profesional.id_tipo_profesional" name="id_tipo_profesional"
                    v-validate="{regex:/^[0-9]+$/i}" data-vv-delay="500">
               <option :value="tp.id_tipo_profesional" v-for="tp in tipos_profesionales">
                  @{{ `${tp.nom_tipo_profesional} -> ${tp.det_tipo_profesional}` }}
               </option>
            </select>

            <transition name="bounce">
               <i v-show="errors.has('id_tipo_profesional')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('id_tipo_profesional')" class="text-danger small">
                  @{{ errors.first('id_tipo_profesional') }}
               </span>
            </transition>
         </p>

      </dd>

   </div><!-- .col -->


   <div class="col-sm-4 col-md-4">

      <dt>Cargo</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <select class="custom-select" v-model="profesional.id_cargo" name="id_cargo"
                    v-validate="{required:true,regex:/^[0-9]+$/i}" data-vv-delay="500">
               <option :value="c.id_cargo" v-for="c in cargos">
                  @{{ `${c.nom_cargo} -> ${c.det_cargo}` }}
               </option>
            </select>

            <transition name="bounce">
               <i v-show="errors.has('id_cargo')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('id_cargo')" class="text-danger small">
                  @{{ errors.first('id_cargo') }}
               </span>
            </transition>
         </p>

      </dd>

   </div><!-- .col -->

   <div class="col-sm-4 col-md-4">

      <dt>Estado</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <select class="custom-select" v-model="profesional.id_estado" name="id_estado"
                    v-validate="{required:true,regex:/^[0-9]+$/i}" data-vv-delay="500">
               <option :value="e.id_estado" v-for="e in estados">
                  @{{ `${e.nom_estado} -> ${e.det_estado}` }}
               </option>
            </select>

            <transition name="bounce">
               <i v-show="errors.has('id_estado')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('id_estado')" class="text-danger small">
                  @{{ errors.first('id_estado') }}
               </span>
            </transition>
         </p>

      </dd>

   </div><!-- .col -->


</div><!-- .row -->