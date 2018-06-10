<h5>Datos del Responsable</h5>
<div class="row">
   <div class="col-sm-4 col-md-4">

      <dt>Nombre responsable</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <input type="text" v-model="establecimiento.nom_responsable" name="nom_responsable"
                   v-validate="{required:true,regex:/^[a-zA-Z0-9_ áéíóúñÁÉÍÓÚÑ]+$/i}" data-vv-delay="500"
                   class="form-control"/>

            <transition name="bounce">
               <i v-show="errors.has('nom_responsable')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('nom_responsable')" class="text-danger small">
                  @{{ errors.first('nom_responsable') }}
               </span>
            </transition>
         </p>
      </dd>
   </div><!-- .col -->

</div><!-- .row -->