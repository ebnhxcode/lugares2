<h5>Datos básicos</h5>
<div class="row">

   <div class="col-sm-4 col-md-4">

      <dt>Código establecimiento</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <input type="text" v-model="establecimiento.id_establecimiento" name="id_establecimiento"
                   v-validate="{required:true,regex:/^[0-9]+$/i}" data-vv-delay="500"
                   class="form-control" />

            <transition name="bounce">
               <i v-show="errors.has('id_establecimiento')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('id_establecimiento')" class="text-danger small">
                  @{{ errors.first('id_establecimiento') }}
               </span>
            </transition>
         </p>
      </dd>


   </div><!-- .col -->

   <div class="col-sm-4 col-md-4">

      <dt>Nombre establecimiento</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <input type="text" v-model="establecimiento.nom_establecimiento" name="nom_establecimiento"
                   v-validate="{required:true,regex:/^[a-zA-Z0-9_ áéíóúñÁÉÍÓÚÑ]+$/i}" data-vv-delay="500"
                   class="form-control" />

            <transition name="bounce">
               <i v-show="errors.has('nom_establecimiento')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('nom_establecimiento')" class="text-danger small">
                  @{{ errors.first('nom_establecimiento') }}
               </span>
            </transition>
         </p>
      </dd>


   </div><!-- .col -->

   <div class="col-sm-4 col-md-4">

      <dt>Tipo establecimiento</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <select class="form-control" v-model="establecimiento.id_tipo_establecimiento" name="id_tipo_establecimiento"
                    v-validate="{required:true,regex:/^[0-9]+$/i}" data-vv-delay="500">
               <option :value="t.id_tipo_establecimiento" v-for="t in tipos_establecimientos">
                  @{{ `${t.nom_tipo_establecimiento} -> ${t.det_tipo_establecimiento}` }}
               </option>
            </select>

            <transition name="bounce">
               <i v-show="errors.has('id_tipo_establecimiento')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('id_tipo_establecimiento')" class="text-danger small">
                  @{{ errors.first('id_tipo_establecimiento') }}
               </span>
            </transition>
         </p>

      </dd>

   </div><!-- .col -->

   <div class="col-sm-4 col-md-4">

      <dt>Dependencia</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <select class="form-control" v-model="establecimiento.id_dependencia" name="id_dependencia"
                    v-validate="{required:true,regex:/^[0-9]+$/i}" data-vv-delay="500">
               <option :value="t.id_dependencia" v-for="t in dependencias">
                  @{{ `${t.nom_dependencia} -> ${t.det_dependencia}` }}
               </option>
            </select>

            <transition name="bounce">
               <i v-show="errors.has('id_dependencia')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('id_dependencia')" class="text-danger small">
                  @{{ errors.first('id_dependencia') }}
               </span>
            </transition>
         </p>

      </dd>

   </div><!-- .col -->

   <div class="col-sm-4 col-md-4">

      <dt>Tipo organismo</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <select class="form-control" v-model="establecimiento.id_tipo_organismo" name="id_tipo_organismo"
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

   <div class="col-sm-4 col-md-4">

      <dt>Organismo</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <select class="form-control" v-model="establecimiento.id_organismo" name="id_organismo"
                    v-validate="{required:true,regex:/^[0-9]+$/i}" data-vv-delay="500">
               <option :value="to.id_organismo" v-for="to in organismos" v-if="establecimiento.id_tipo_organismo==to.id_tipo_organismo">
                  @{{ `${to.nom_organismo} -> ${to.det_organismo}` }}
               </option>
            </select>

            <transition name="bounce">
               <i v-show="errors.has('id_organismo')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('id_organismo')" class="text-danger small">
                  @{{ errors.first('id_organismo') }}
               </span>
            </transition>
         </p>

      </dd>

   </div><!-- .col -->

</div><!-- .row -->
