<h5>Datos básicos</h5>
<div class="row">

   <div class="col-sm-4 col-md-4">

      <dt>Nombre dia semana</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <input type="text" v-model="dia_semana.nom_dia_semana" name="nom_dia_semana"
                   v-validate="{required:true,regex:/^[a-zA-Z0-9_ -]+$/i}" data-vv-delay="500"
                   class="form-control" />

            <transition name="bounce">
               <i v-show="errors.has('nom_dia_semana')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('nom_dia_semana')" class="text-danger small">
                  @{{ errors.first('nom_dia_semana') }}
               </span>
            </transition>
         </p>
      </dd>


   </div><!-- .col -->



   <div class="col-sm-4 col-md-4">

      <dt>Orden</dt>
      <dd>

         <p class="control has-icon has-icon-right">
            <textarea cols="15" rows="1" v-model="dia_semana.orden" name="orden"
                      v-validate="{required:true,regex:/^[a-zA-Z0-9_ ,.!@#$%*&-]+$/i}" data-vv-delay="500"
                      class="form-control"></textarea>

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

