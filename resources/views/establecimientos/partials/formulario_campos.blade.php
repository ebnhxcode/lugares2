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
            <select class="custom-select" v-model="establecimiento.id_tipo_establecimiento" name="id_tipo_establecimiento"
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
</div><!-- .row -->

<h5>Datos de ubicación</h5>
<div class="row">

   <div class="col-sm-4 col-md-4">

      <dt>Calle</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <input type="text" v-model="establecimiento.nom_direccion" name="nom_direccion"
                   v-validate="{required:true,regex:/^[a-zA-Z0-9_ áéíóúñÁÉÍÓÚÑ]+$/i}" data-vv-delay="500"
                   class="form-control" />

            <transition name="bounce">
               <i v-show="errors.has('nom_direccion')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('nom_direccion')" class="text-danger small">
                  @{{ errors.first('nom_direccion') }}
               </span>
            </transition>
         </p>
      </dd>


   </div><!-- .col -->

   <div class="col-sm-4 col-md-4">

      <dt>Número Ej: 1234-B</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <input type="text" v-model="establecimiento.num_calle" name="num_calle"
                   v-validate="{required:true,regex:/^[a-zA-Z0-9_ -áéíóúñÁÉÍÓÚÑ]+$/i}" data-vv-delay="500"
                   class="form-control" />

            <transition name="bounce">
               <i v-show="errors.has('num_calle')" class="fa fa-exclamation-circle"></i>
            </transition>

            <transition name="bounce">
               <span v-show="errors.has('num_calle')" class="text-danger small">
                  @{{ errors.first('num_calle') }}
               </span>
            </transition>
         </p>
      </dd>


   </div><!-- .col -->

   <div class="col-sm-4 col-md-4">

      <dt>Dependencia</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <select class="custom-select" v-model="establecimiento.id_dependencia" name="id_dependencia"
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
            <select class="custom-select" v-model="establecimiento.id_tipo_organismo" name="id_tipo_organismo"
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
            <select class="custom-select" v-model="establecimiento.id_organismo" name="id_organismo"
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

<h5>Datos de geolocalización</h5>
<div class="row">
   <div class="col-sm-4 col-md-4">

      <dt>Region</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <select class="custom-select" v-model="establecimiento.id_region" name="id_region"
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

   <div class="col-sm-4 col-md-4">

      <dt>Comuna</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <select class="custom-select" v-model="establecimiento.id_comuna" name="id_comuna"
                    v-validate="{required:true,regex:/^[0-9]+$/i}" data-vv-delay="500">
               <option :value="c.id_comuna" v-for="c in comunas" v-if="establecimiento.id_region==c.id_region">
                  @{{ `${c.nom_comuna} -> ${c.det_comuna}` }}
               </option>
            </select>

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
</div><!-- .row -->

<h5>Datos del Responsable</h5>
<div class="row">
   <div class="col-sm-4 col-md-4">

      <dt>Nombre responsable</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <input type="text" v-model="establecimiento.nom_responsable" name="nom_responsable"
                   v-validate="{required:true,regex:/^[a-zA-Z0-9_ áéíóúñÁÉÍÓÚÑ]+$/i}" data-vv-delay="500"
                   class="form-control" />

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

<h5>Datos de Contacto</h5>
<div class="row">

   <div class="col-sm-2 col-md-2">
      <dt>Código área Fax</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <input type="text" v-model="establecimiento.cod_area_fax" name="cod_area_fax"
                   v-validate="{required:true,regex:/^[0-9_ áéíóúñÁÉÍÓÚÑ]+$/i}" data-vv-delay="500"
                   class="form-control" />

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

   <div class="col-sm-4 col-md-4">
      <dt>Fax</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <input type="text" v-model="establecimiento.fax" name="fax"
                   v-validate="{required:true,regex:/^[0-9_ áéíóúñÁÉÍÓÚÑ]+$/i}" data-vv-delay="500"
                   class="form-control" />

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

   <div class="col-sm-4 col-md-4">
      <dt>Email</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <input type="text" v-model="establecimiento.email" name="email"
                   v-validate="{required:true,email:true}" data-vv-delay="500"
                   class="form-control" />

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

   <div class="col-sm-4 col-md-4">
      <dt>Sitio web</dt>
      <dd>
         <p class="control has-icon has-icon-right">
            <input type="text" v-model="establecimiento.sitio_web" name="sitio_web"
                   v-validate="{required:true,url:true}" data-vv-delay="500"
                   class="form-control" />

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


<h5>Otros Telefonos</h5>

<div class="row">

   <div class="col-md-6">
      <div class="row">

         <div class="col-sm-12 col-md-12">

            <dt>Tipo Telefono</dt>
            <dd>
               <select class="custom-select" v-model="telefono.id_tipo_telefono" name="id_tipo_telefono"
                       v-validate="{required:true,regex:/^[0-9]+$/i}" data-vv-delay="500">
                  <option :value="t.id_tipo_telefono" v-for="t in tipos_telefonos">
                     @{{ `${t.nom_tipo_telefono} -> ${t.det_tipo_telefono}` }}
                  </option>
               </select>

               <transition name="bounce">
                  <i v-show="errors.has('id_tipo_telefono')" class="fa fa-exclamation-circle"></i>
               </transition>

               <transition name="bounce">
               <span v-show="errors.has('id_tipo_telefono')" class="text-danger small">
                  @{{ errors.first('id_tipo_telefono') }}
               </span>
               </transition>
            </dd>

         </div><!-- .col -->

         <div class="col-sm-3 col-md-3">
            <dt>Código Área</dt>
            <dd>
               <p class="control has-icon has-icon-right">
                  <input type="text" v-model="telefono.cod_area" name="cod_area"
                         v-validate="{required:true,regex:/^[0-9]+$/i}" data-vv-delay="500"
                         class="form-control" />

                  <transition name="bounce">
                     <i v-show="errors.has('cod_area')" class="fa fa-exclamation-circle"></i>
                  </transition>

                  <transition name="bounce">
                     <span v-show="errors.has('cod_area')" class="text-danger small">
                        @{{ errors.first('cod_area') }}
                     </span>
                  </transition>
               </p>
            </dd>
         </div><!-- .col -->

         <div class="col-sm-7 col-md-7">

            <dt>Número teléfono</dt>
            <dd>

               <p class="control has-icon has-icon-right">
                  <input type="text" v-model="telefono.num_telefono" name="num_telefono"
                         v-validate="{regex:/^[0-9_ ]+$/i}" data-vv-delay="500"
                         class="form-control" />

                  <transition name="bounce">
                     <i v-show="errors.has('num_telefono')" class="fa fa-exclamation-circle"></i>
                  </transition>

                  <transition name="bounce">
                     <span v-show="errors.has('num_telefono')" class="text-danger small">
                        @{{ errors.first('num_telefono') }}
                     </span>
                  </transition>
               </p>
            </dd>

         </div><!-- .col -->

         <div class="col-sm-2 col-md-2">
            <dt>Guardar</dt>
            <dd>
               <button class="btn btn-success" @click.prevent="guardar_telefono">
                  Guardar
               </button>
            </dd>
         </div>

      </div>
   </div>
   <div class="col-md-6">

   </div>

</div><!-- .row -->



   {{--
   <table class="table table-striped table-hover table-sm">
      <thead>
      <tr class="text-center">
         <th v-for="c,i in tabla_campos" v-if="c">
            <a href="#!" class="btn btn-primary" @click.prevent="cambiar_orden_lista(i)">
               <i class="fa fa-sort" aria-hidden="true"></i>&nbsp;
               @{{ tabla_labels[i] }}
            </a>
         </th>
         <th>
            <a href="#!" class="btn btn-primary" @click.prevent="cambiar_orden_lista(`id_${nombre_model}`)">
               <i class="fa fa-sort" aria-hidden="true"></i>&nbsp;
               Acción
            </a>
         </th>
      </tr>
      </thead>
      <tbody>
      <tr class="text-center" v-for="lom in filterBy(lista_objs_model, filtro_head)">
         <template v-if="id_en_edicion != lom[`id_${nombre_model}`] || modal_actualizar_activo == true">
            <td v-for="c,i in tabla_campos" v-show="c" class="text-left">
               @{{ lom[i] }}
            </td>
         </template>
         <template v-else>
            <td>
            <span v-clipboard="lom[`id_${nombre_model}`]" class="btn btn-primary"
                  data-placement="top" data-toggle="tooltip" title="Clic para copiar el id">
               Id @{{ nombre_model }}: @{{ lom[`id_${nombre_model}`] }}
            </span>
            </td>
            <td :colspan="filterBy(tabla_campos, true).length-1">
               @include("$nombre_tabla.partials.formulario_campos")
            </td>
         </template>




         <!-- Botonera de acciones -->
         <td>
            <div class="btn-group btn-group-sm" style="margin:0;" role="group" aria-label="Basic example">
               <button class="btn btn-primary"
                       v-show="id_en_edicion != lom[`id_${nombre_model}`] &&
                        id_en_edicion == null &&
                        modal_actualizar_activo == false &&
                        en_array(['Administrador','Jefe de Area','Lider Equipo','App Manager'],usuario_auth.usuario_role.role.nom_role)"
                       data-placement="top" data-toggle="tooltip" title="Editar desde aquí"
                       @click.prevent="editar(lom[`id_${nombre_model}`])">
                  <i class="fa fa-edit"></i>
               </button>
               <button class="btn btn-success" v-show="id_en_edicion == lom[`id_${nombre_model}`] && modal_actualizar_activo == false"
                       data-placement="top" data-toggle="tooltip" title="Guardar"
                       @click.prevent="guardar_editado">
                  <i class="fa fa-save"></i>
               </button>
               <button class="btn btn-secondary"
                       data-placement="top" data-toggle="tooltip" title="Actualizar desde modal"
                       @click.prevent="mostrar_modal_actualizar(lom[`id_${nombre_model}`])"
                       v-show="id_en_edicion == null">
                  <i class="fa fa-rocket" ></i>
               </button>
               <button class="btn btn-secondary"
                       data-placement="top" data-toggle="tooltip" title="Dejar de editar"
                       @click.prevent="dejar_de_editar()"
                       v-if="id_en_edicion === lom[`id_${nombre_model}`]">
                  <i class="fa fa-close"></i>
               </button>
               <button class="btn btn-danger" v-show="id_en_edicion == null"
                       v-if="en_array(['Administrador','Jefe de Area','Lider Equipo','App Manager'],usuario_auth.usuario_role.role.nom_role)"
                       @click.prevent="eliminar(lom[`id_${nombre_model}`])"
                       data-placement="top" data-toggle="tooltip" title="Eliminar">
                  <i class="fa fa-close"></i>
               </button>
            </div>
         </td>

      </tr>
      <tr v-if="lista_objs_model && lista_objs_model.length == 0 || filterBy(lista_objs_model, filtro_head).length == 0">
         <td class="text-center" :colspan="filterBy(tabla_campos, true).length+1">No hay más registros</td>
      </tr>
      </tbody>
   </table>
   --}}
