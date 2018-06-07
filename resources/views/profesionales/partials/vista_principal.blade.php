<div class="row">
   <div class="col-sm-4 col-md-4">

      <!-- este bloque será reemplazado dinamicamente -->
      <div class="card pro" style="{{--width: 18rem;--}}">
         <img class="card-img-top" src="{{ url('/img/datacentro.png') }}" alt="Card image cap">
         <div class="card-body">
            <h5 class="card-title">
               @{{ profesional.nom_profesional || '' }}
            </h5>
            <p class="card-text">

            <dl class="row" v-if="profesional">

               <dd class="col-md-12">@{{ profesional.det_profesional || '' }}</dd>

            </dl>

            <dl v-else>
               No hay información del profesional.
            </dl>

            </p>
            {{--<a href="#" class="btn btn-primary">Go somewhere</a>--}}
         </div><!-- .card-body -->
      </div><!-- .card -->

      <br>

   </div><!-- .col -->


</div><!-- .row -->
