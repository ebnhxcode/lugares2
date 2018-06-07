<h5>Datos básicos</h5>
<div class="row">
   <div class="col-sm-4 col-md-4">

      <dt>Nombre establecimiento</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <input type="text" v-model="establecimiento.nom_establecimiento" name="nom_establecimiento"
                   v-validate="{required:true,regex:/^[a-zA-Z0-9_ ]+$/i}" data-vv-delay="500"
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


</div><!-- .row -->
