<h5>EXTENSIÓN HORARIA</h5>
<div class="row">

   <div class="col-sm-4 col-md-4">

      <dt>Extensión Horaria</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <input type="text" v-model="establecimiento.id_establecimiento" name="id_establecimiento"
                   v-validate="{required:true,regex:/^[0-9]+$/i}" data-vv-delay="500"
                   class="form-control"/>

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

</div><!-- .row -->