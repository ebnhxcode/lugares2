<h5>HORARIO DE ANTENCIÓN</h5>
<div class="row">

   <div class="col-sm-4 col-md-4">

      <dt>Extensión Horaria</dt>
      <dd>
         <p class="control has-icon has-icon-right">

            <div class="btn-group" data-toggle="buttons">

               <label :class="establecimiento.ext_horaria=='si'?'btn btn-primary active':'btn btn-primary'">
                  <input type="radio" v-model="establecimiento.ext_horaria" name="ext_horaria"
                         v-validate="{regex:/^(?:si)+$/i}" data-vv-delay="500"
                         value="si" class="form-control"/>
                  SI
               </label>
               <label :class="establecimiento.ext_horaria=='no'?'btn btn-primary active':'btn btn-primary'">
                  <input type="radio" v-model="establecimiento.ext_horaria" name="ext_horaria"
                         v-validate="{regex:/^(?:no)+$/i}" data-vv-delay="500"
                         value="no" class="form-control"/>
                  NO
               </label>

            </div>

            <transition name="bounce">
               <i v-show="errors.has('ext_horaria')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('ext_horaria')" class="text-danger small">
                  @{{ errors.first('ext_horaria') }}
               </span>
            </transition>
         </p>
      </dd>


   </div><!-- .col -->

</div><!-- .row -->