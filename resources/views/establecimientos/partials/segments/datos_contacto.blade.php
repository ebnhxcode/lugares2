<h5>DATOS DE CONTACTO</h5>
<div class="row">

   <div class="col-sm-12 col-md-2">
      <dt>Código área Fax</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <input type="text" v-model="establecimiento.cod_area_fax" name="cod_area_fax"
                   v-validate="{regex:/^[0-9_ áéíóúñÁÉÍÓÚÑ]+$/i}" data-vv-delay="500"
                   class="form-control"/>

            <transition name="bounce">
               <i v-show="errors.has('cod_area_fax')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
                  <span v-show="errors.has('cod_area_fax')" class="text-danger small">
                     @{{ errors.first('cod_area_fax') }}
                  </span>
            </transition>
         </p>
      </dd>
   </div><!-- .col -->

   <div class="col-sm-12 col-md-2">
      <dt>Fax</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <input type="text" v-model="establecimiento.fax" name="fax"
                   v-validate="{regex:/^[0-9_ áéíóúñÁÉÍÓÚÑ]+$/i}" data-vv-delay="500"
                   class="form-control"/>

            <transition name="bounce">
               <i v-show="errors.has('fax')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
                  <span v-show="errors.has('fax')" class="text-danger small">
                     @{{ errors.first('fax') }}
                  </span>
            </transition>
         </p>
      </dd>
   </div><!-- .col -->

   <div class="col-sm-5 col-md-2">
      <dt>Email</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <input type="text" v-model="establecimiento.email" name="email"
                   v-validate="{regex:/^[a-zA-Z0-9_ ,.]+$/i}" data-vv-delay="500"
                   class="form-control"/>

            <transition name="bounce">
               <i v-show="errors.has('email')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
                  <span v-show="errors.has('email')" class="text-danger small">
                     @{{ errors.first('email') }}
                  </span>
            </transition>
         </p>
      </dd>
   </div><!-- .col -->

   <div class="col-sm-5 col-md-1">
      <dt>
         &nbsp;
      </dt>
      <dd style="font-size: 22px;">
         @
      </dd>
   </div><!-- .col -->
   <div class="col-sm-5 col-md-2">
      <dt>Dominio Email</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <input type="text" v-model="establecimiento.dominio_email" name="dominio_email"
                   v-validate="{regex:/^[a-zA-Z0-9_ ,.]+$/i}" data-vv-delay="500"
                   class="form-control"/>

            <transition name="bounce">
               <i v-show="errors.has('dominio_email')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
                  <span v-show="errors.has('dominio_email')" class="text-danger small">
                     @{{ errors.first('dominio_email') }}
                  </span>
            </transition>
         </p>
      </dd>
   </div><!-- .col -->

   <div class="col-sm-12 col-md-3">
      <dt>Sitio web</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <input type="text" v-model="establecimiento.sitio_web" name="sitio_web"
                   v-validate="{url:true}" data-vv-delay="500"
                   class="form-control"/>

            <transition name="bounce">
               <i v-show="errors.has('sitio_web')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
                  <span v-show="errors.has('sitio_web')" class="text-danger small">
                     @{{ errors.first('sitio_web') }}
                  </span>
            </transition>
         </p>
      </dd>
   </div><!-- .col -->

   <div class="col-sm-12 col-md-12">
      <dt>Observaciones</dt>
      <dd>

         <p class="control has-icon has-icon-right">
            <textarea cols="15" rows="1" v-model="establecimiento.observaciones" name="observaciones"
                      v-validate="{regex:/^[a-zA-Z0-9_ ,.!@#$%*&-áéíóúñÁÉÍÓÚÑ]+$/i}" data-vv-delay="500"
                      class="form-control"></textarea>

            <transition name="bounce">
               <i v-show="errors.has('observaciones')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('observaciones')" class="text-danger small">
                  @{{ errors.first('observaciones') }}
               </span>
            </transition>
         </p>
      </dd>
   </div><!-- .col -->

</div><!-- .row -->