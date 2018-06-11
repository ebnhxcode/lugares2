<h5>HORARIO DE ANTENCIÓN</h5>
<div class="row">

   <div class="col-sm-3 col-md-3">

      <dt>Horario de Atención</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <select class="custom-select" v-model="horario_atencion_establecimiento.id_dia" name="id_dia"
                    v-validate="{required:true,regex:/^[0-9]+$/i}" data-vv-delay="500">
               <option :value="d.id_dia" v-for="d in dias_semana">
                  @{{ `${d.nom_dia_semana}` }}
               </option>
            </select>

            <transition name="bounce">
               <i v-show="errors.has('id_dia')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('id_dia')" class="text-danger small">
                  @{{ errors.first('id_dia') }}
               </span>
            </transition>
         </p>

      </dd>


   </div><!-- .col -->

</div><!-- .row -->