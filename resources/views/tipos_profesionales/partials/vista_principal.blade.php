<div class="row">
   <div class="col-sm-4 col-md-4">

      <!-- este bloque será reemplazado dinamicamente -->
      <div class="card pro" style="{{--width: 18rem;--}}">
         <img class="card-img-top" src="{{ url('/img/datacentro.png') }}" alt="Card image cap">
         <div class="card-body">
            <h5 class="card-title">
               @{{ tipo_profesional.nom_tipo_profesional || '' }}
            </h5>
            <p class="card-text">

            <dl class="row" v-if="tipo_profesional">

               <dd class="col-md-12">@{{ tipo_profesional.det_tipo_profesional || '' }}</dd>

            </dl>

            <dl v-else>
               No hay información del tipo_profesional.
            </dl>

            </p>
            {{--<a href="#" class="btn btn-primary">Go somewhere</a>--}}
         </div><!-- .card-body -->
      </div><!-- .card -->

      <br>

   </div><!-- .col -->


</div><!-- .row -->
