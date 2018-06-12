@extends('layouts.app')
@section('content')
   <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
   <main role="main" class="ml-sm-auto {{--pt-3 px-4--}}" id="{{$nombre_controller}}">
      <div class="{{----}} flex-md-nowrap flex-wrap align-items-center d-flex justify-content-between pb-2 mb-3 sticky-top"
           style="z-index: 10;">
         &nbsp;
         <h2 class="h2" style="padding-top: 10px;">{{$nombre_detalle}}</h2>

         <div class="btn-toolbar mb-2 mb-md-0">
            <div class="input-group input-group-sm">

               <div class="btn-group mr-0 ml-auto d-md-block d-sm-none">

                  <a href="{{url('/home')}}" class="btn btn-secondary"
                          data-placement="top" data-toggle="tooltip" title="Volver al menú">
                     <i class="fa fa-arrow-left" aria-hidden="true"></i>
                     Ir al Menu
                  </a>

                  <button class="btn btn-success"
                          v-if="en_array(['Administrador','Jefe de Area','Lider Equipo','Jefe Proyecto','App Manager'],usuario_auth.usuario_role.role.nom_role)"
                          data-placement="top" data-toggle="tooltip" title="Crear nuevo/a {{$nombre_modelo}}"
                          @click.prevent="mostrar_modal_crear">
                     Crear {{str_replace('_',' ',$nombre_modelo)}}
                  </button>

                  <button class="btn btn-secondary dropdown-toggle"
                          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Lista de opciones">
                     Opciones
                  </button>

                  <div class="dropdown-menu">
                     <!-- Esta seccion ya es un componente, se podria estandarizar solo el nombre de los obj para excel -->
                     <download-excel
                        v-if="(excel_data_contador = filterBy(datos_excel, filtro_head).length) > 0 &&
                           en_array(['Administrador','Jefe de Area','Lider Equipo','App Manager'],usuario_auth.usuario_role.role.nom_role)"
                        :data="filterBy(excel_json_datos, filtro_head)"
                        :fields="excel_json_campos"
                        :labels="tabla_labels"
                        :name="`${nombre_tabla}.xls`"
                        class="dropdown-item">
                        Descargar Excel
                     </download-excel>

                     <a class="dropdown-item" href="#!" @click.prevent="inicializar">
                        Actualizar tabla
                     </a>
                     <a class="dropdown-item" href="#!" @click.prevent="filtro_head=null">
                        Limpiar filtro
                     </a>
                     <div class="dropdown-divider"></div>
                     <a class="dropdown-item" href="{{ url('/home') }}">
                        Volver al menú principal
                     </a>

                  </div>
               </div><!-- .btn-group mr-0 #mr->margin -->


            </div><!-- input-* -->
         </div><!-- .btn .btn-toolbar -->
      </div><!-- .d-flex .justify-* .flex-wrap .flex-md-nowrap .align-items-center -->

      <!-- Esto puede ser pasado como componente, se le pasa el objeto en json con los campos de la tabla -->
      <div class="card">
         <div class="card-body pro">
         <h5>TABLERO</h5>
         <div class="pro btn-group btn-group-sm btn-group-toggle" v-for="v,c,i in tabla_campos" style="z-index: 0 !important;">
            <label :class="v.visibility==true?'btn btn-success active':'btn btn-secondary'" @click.prevent="cambiar_visibilidad(c)"
                   data-placement="top" data-toggle="tooltip" title="Clic para mostrar u ocultar">
                  <span style="font-size: 85%;">
                     <i class="fa fa-check" v-if="v==true"></i>
                     @{{ tabla_labels[c] }}
                  </span>
            </label>
         </div>
         </div>
      </div>

      <br>

      <div class="card">

         <div class="card-body pro">

            <span class="btn btn-warning float-right" @click.prevent="recargar_filtros_tablero">
               <i class="fa fa-refresh" aria-hidden="true"
                  data-placement="top" data-toggle="tooltip" title="Recarga datos y elimina los filtros"></i>
               Re-Carga Completa
            </span>

            <span class="btn btn-success float-right" @click.prevent="recargar_filtros_tablero_sin_limpiar_filtros">
               <i class="fa fa-refresh" aria-hidden="true"
                  data-placement="top" data-toggle="tooltip" title="Mantiene contenido de los filtros"></i>
               Re-Carga Blanda
            </span>

            <h5>FILTROS POR REFERENCIA</h5>
            <br>
            <div class="row">
               <div class="col-md-3 col-lg-3" v-for="c,key,i in tabla_campos" v-if="c.visibility == true">
                  @{{ tabla_labels[key] }}
                  <input type="text" class="form-control input-sm"
                         data-placement="top" data-toggle="tooltip" title="FILTRAR"
                         @change.prevent="recargar_filtros_tablero_sin_limpiar_filtros" v-model="tabla_campos[key].value" id="">

               </div>
            </div>
            {{--@if(in_array(Request::path(), ['establecimientos']))@endif--}}
         </div>
      </div>

      <br>

      @if(in_array(Request::path(), ['establecimientos']))
         <div class="card">
            <div class="card-body pro">

               <h5>FILTROS ADICIONALES</h5>
               <br>
               <div class="row">
                  <div class="col-md-3 col-lg-3">
                     Filtro por Región
                     <select class="custom-select" v-model="filtros.id_region" name="id_region"
                             @change.prevent="filtrar_adicional('id_region')"
                             v-validate="{required:true,regex:/^[0-9]+$/i}" data-vv-delay="500">
                        <option value=""></option>
                        <option :value="r.id_region" v-for="r in regiones">
                           @{{ `${r.nom_region}` }}
                        </option>
                     </select>
                  </div>
                  <div class="col-md-3 col-lg-3">
                     Filtro por Comuna
                     <select class="custom-select" v-model="filtros.id_comuna" name="id_comuna"
                             @change.prevent="filtrar_adicional('id_comuna')"
                             v-validate="{required:true,regex:/^[0-9]+$/i}" data-vv-delay="500">
                        <option value=""></option>
                        <option :value="c.id_comuna" v-for="c in comunas" v-if="filtros.id_region==c.id_region">
                           @{{ `${c.nom_comuna}` }}
                        </option>
                     </select>
                  </div>
                  <div class="col-md-3 col-lg-3">

                  </div>
               </div>
               {{--@if(in_array(Request::path(), ['establecimientos']))@endif--}}
            </div>
         </div>

         <br>
      @endif

      <!-- Sección de la tabla que lista los elementos del módulo -->
      <div class="card">
         <div class="card-body pro">

            <!-- Filtro grid -->
            <div class="float-right" style="padding-left: 15px;">
               <input type="text" class="form-control input-sm"
                      data-placement="top" data-toggle="tooltip" title="FILTRAR EN LA LISTA"
                      placeholder="FILTRAR EN LA LISTA" v-model="filtro_head" id="filtro_head">
            </div><!-- .btn-group mr-2 #mr->margin -->

            <!-- Componente paginador -->
            <div class="float-right" style="padding-left: 15px;">
               <paginators :pagination="pagination" @navigate="navigate"></paginators>
            </div>

            <!-- Cantidad a paginar -->
            <div class="float-right" style="padding-left: 15px;">
               <select v-model="pagination.per_page" @change="navigateCustom"
                       class="custom-select custom-select-sm btn btn-outline-success">
                  <option selected disabled>@{{ pagination.per_page }}</option>
                  <option :value="5">5</option>
                  <option :value="10">10</option>
                  <option :value="15">15</option>
                  <option :value="20">20</option>
                  <option :value="25">25</option>
                  <option :value="30">30</option>
                  <option :value="35">35</option>
                  <option :value="40">40</option>
                  <option :value="45">45</option>
                  <option :value="50">50</option>
                  <option :value="100">100</option>
                  <option :value="250">250</option>
                  <option :value="500">500</option>
                  <option :value="750">750</option>
                  <option :value="1000">1000</option>
                  <option :value="1250">1250</option>
                  <option :value="1500">1500</option>
                  <option :value="1750">1750</option>
                  <option :value="2000">2000</option>
                  <option :value="3000">3000</option>
                  <option :value="4000">4000</option>
                  <option :value="5000">5000</option>
               </select>

            </div>

            <h5>LISTA DE {{strtoupper($nombre_detalle)}}</h5>

            <!-- Detalle de lo filtrado -->
            <div class="float-left">
               <div v-if="filterBy(lista_objs_model, filtro_head).length">
                  <small class="float-right">@{{ filterBy(lista_objs_model, filtro_head).length || 0 }} resultados.</small>
               </div>
               <div v-else>
                  <small class="float-right">
                     @{{ `Sin resultados para` }} ${`@{{ `${filtro_head}` }}`}
                  </small>
               </div>
            </div>

            <div class="table-responsive">
               <!-- dir ./partials -->
               @include("layouts.tabla_listar")
            </div>


            <!-- Paginador footer tabla opcional segun cantidad -->
            <div v-if="pagination.per_page>=50">
               <!-- Detalle de lo filtrado -->
               <div class="float-left">
                  <div v-if="filterBy(lista_objs_model, filtro_head).length">
                     <small class="float-right">@{{ filterBy(lista_objs_model, filtro_head).length || 0 }} resultados.</small>
                  </div>
                  <div v-else>
                     <small class="float-right">
                        @{{ `Sin resultados para` }} ${`@{{ `${filtro_head}` }}`}
                     </small>
                  </div>
               </div>

               <!-- Componente paginador -->
               <div class="float-right" style="padding-left: 15px;">
                  <paginators :pagination="pagination" @navigate="navigate"></paginators>
               </div>

            </div>

         </div>
      </div>


      <div>
         <!-- dir ./partials -->
         @include("layouts.modal.modal_crear")
         @include("layouts.modal.modal_actualizar")

      </div>

      {{--<notifications group="top_center" position="top center" />--}}
      <notifications group="global" position="bottom right" />

   </main>



@endsection

@section('VueControllers')
   <script src="{{ asset("js/controllers/$nombre_controller.js") }}"></script>
@endsection