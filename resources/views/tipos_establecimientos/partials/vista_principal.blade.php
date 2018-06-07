<div class="row">
   <div class="col-sm-10 col-md-10">
      dsad
   </div>
   <div class="col-sm-2 col-md-2">

      <!-- este bloque será reemplazado dinamicamente -->
      <div class="card pro" style="{{--width: 18rem;--}}">
         <img class="card-img-top" src="{{ url('/img/datacentro.png') }}" alt="Card image cap">
         <div class="card-body">
            <h5 class="card-title">
               @{{ tipo_establecimiento.nom_tipo_establecimiento || '' }}
            </h5>
            <p class="card-text">

            <dl class="row" v-if="tipo_establecimiento">

               <dd class="col-md-12">@{{ tipo_establecimiento.det_tipo_establecimiento || '' }}</dd>

            </dl>

            <dl v-else>
               No hay información del tipo_establecimiento.
            </dl>

            </p>
            {{--<a href="#" class="btn btn-primary">Go somewhere</a>--}}
         </div><!-- .card-body -->
      </div><!-- .card -->

      <br>

   </div><!-- .col -->


</div><!-- .row -->
