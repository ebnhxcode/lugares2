@extends('layouts.app')
@section('content')

   <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">

   <!-- Vista del menu principal con tarjetas dinámicas -->
   <main role="main" class="ml-sm-auto {{-- col-md-12  col-lg-12 pt-3 px-4--}}" id="{{$nombre_controller}}">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 sticky-top">
         &nbsp;
         <h2 class="h2" style="padding-top: 10px;">{{$nombre_detalle}}</h2>

         <!-- Filtro para la lista de manus en esta vista -->
         <div class="input-group input-group-sm">
               <input type="text" class="form-control" style="padding-left: 10px;padding-top: 0px !important;"
                      data-placement="top" data-toggle="tooltip" title="FILTRAR"
                      placeholder="FILTRAR" v-model="filtro_head" id="filtro_head">
         </div><!-- input-* -->

      </div><!-- .d-flex .justify-* .flex-wrap .flex-md-nowrap .align-items-center -->


      <!-- Seccion de menus -->
      <div v-if="home_items && home_items.length > 0" class="col-md-4">
         <h3>
            <i class="fa fa-sort-alpha-asc btn btn-info btn-sm float-right" @click.prevent="cambiar_orden_lista('nom_menu','home_items')" aria-hidden="true"
               data-placement="top" data-toggle="tooltip" title="Clic para ordenar menu principal"></i>
            Menu Principal
         </h3>

         <!-- Tarjetas dinámicas -->
         <div class="card-deck{{--card-columns--}}" v-show="filterBy(home_items, filtro_head).length > 0">
            <div class="card bg-primary text-white border-light" v-for="i in filterBy(home_items, filtro_head)">
               <div class="card-header">@{{ i.nom_menu }}</div>
               <div class="img-responsive">
                  <img class="card-img-top" :src="i.imagen_menu || `/img/logo180-180.png`">
               </div>
               <div class="card-body">
                  <h5 class="card-title">
                     <div class="media">
                        <i :class="i.font_icon_menu" aria-hidden="true"></i>
                        <div class="media-body">
                           <span class=" h5 mt-0">@{{ i.nom_menu }}</span>
                           <p style="font-size: 14px;">
                              @{{ i.det_menu }}
                           </p>
                        </div>
                     </div>
                  </h5>
                  <p class="card-text">

                  </p>
               </div><!-- -card-body -->
               <div class="card-footer">
                  <form :action="i.url_menu" method="GET">
                     <button type="submit" class="btn btn-primary">
                        <i class="fa fa-sign-in" aria-hidden="true"></i>
                        Ingresar
                     </button>
                  </form>
               </div>
            </div><!-- .card -->

         </div><!-- .card-columns -->

         <!-- Mensaje para informar que no hay registros -->
         <div v-show="filterBy(home_items, filtro_head).length <= 0">No se encontró lo que buscas ${`@{{ filtro_head }}`}</div>
      </div>

      <hr>


      <!-- Seccion de mantenedores -->
      <div v-if="mantenedores && mantenedores.length > 0">
         <h3>
            <i class="fa fa-sort-alpha-asc btn btn-info btn-sm float-right" @click.prevent="cambiar_orden_lista('nom_mantenedor','mantenedores')" aria-hidden="true"
               data-placement="top" data-toggle="tooltip" title="Clic para ordenar mantenedores"></i>
            Mantenedores
         </h3>

         <!-- Tarjetas dinámicas -->
         <div class="card-columns" v-show="filterBy(mantenedores, filtro_head).length > 0">
            <div class="card bg-primary text-white border-light" v-for="m in filterBy(mantenedores, filtro_head)">
               <div class="card-header">@{{ m.nom_mantenedor }}</div>
               <div class="img-responsive">
                  {{--<img class="card-img-top" :src="`/img/mosaicomini.jpg`" /><!-- m.imagen_mantenedor ||  -->--}}
               </div>
               <div class="card-body">
                  <h5 class="card-title">
                     <div class="media">
                        <i :class="m.font_icon_mantenedor" aria-hidden="true"></i>
                        &nbsp;&nbsp;&nbsp;
                        <div class="media-body">
                           <p style="font-size: 12px;">
                              @{{ m.det_mantenedor }}
                           </p>
                        </div>
                     </div>
                  </h5>
                  <p class="card-text">

                  </p>
               </div><!-- -card-body -->
               <div class="card-footer">
                  <form :action="m.url_mantenedor" method="GET">
                     <button type="submit" class="btn btn-primary">
                        <i class="fa fa-sign-in" aria-hidden="true"></i>
                        Ingresar
                     </button>
                  </form>
               </div>
            </div><!-- .card -->

            </div><!-- .card-columns -->

         <!-- Mensaje para informar que no hay registros -->
         <div v-show="filterBy(mantenedores, filtro_head).length <= 0">No se encontró lo que buscas ${`@{{ filtro_head }}`}</div>
      </div>

      <!-- Componente para mostrar notificaciones en el costado inferior derecho -->
      <notifications group="global" position="bottom right" />

   </main>



@endsection

<!-- Llamado al controlador JS -->
@section('VueControllers')
   <script src="{{ asset("js/controllers/$nombre_controller.js") }}"></script>
@endsection