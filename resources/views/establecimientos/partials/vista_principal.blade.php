<div class="row">
   <div class="col-sm-4 col-md-4">

      <!-- este bloque será reemplazado dinamicamente -->
      <div class="card pro" style="{{--width: 18rem;--}}">
         <img class="card-img-top" src="{{ url('/img/datacentro.png') }}" alt="Card image cap">
         <div class="card-body">
            <h5 class="card-title">
               @{{ establecimiento.nom_establecimiento || '' }}
            </h5>
            <p class="card-text">

            <dl class="row" v-if="establecimiento && establecimiento.tipo_establecimiento">
               <dd class="col-md-12">@{{ establecimiento.tipo_establecimiento.nom_tipo_establecimiento || '' }}</dd>
            </dl>

            <dl v-else>
               No hay información del establecimiento.
            </dl>

            </p>
            {{--<a href="#" class="btn btn-primary">Go somewhere</a>--}}
         </div><!-- .card-body -->
      </div><!-- .card -->

      <br>


      <!-- este bloque será reemplazado dinamicamente -->
      <div class="card pro" style="{{--width: 18rem;--}}" v-if="establecimiento && establecimiento.region">
         <div class="card-body">
            <h5 class="card-title">
               Region ➜ @{{ establecimiento.region.nom_region || 'No hay información sobre la region' }}
            </h5>
            <p class="card-title">

               <dl>
                  <dt>Detalle</dt>
                  <dd>@{{ establecimiento.region.det_region || 'Sin información de detalle' }}</dd>
                  <dt>Alias</dt>
                  <dd>@{{ establecimiento.region.alias || 'Sin información de alias' }}</dd>
               </dl>

            </p>
            {{--<a href="#" class="btn btn-primary">Go somewhere</a>--}}
         </div><!-- .card-body -->
      </div><!-- .card -->
      <div v-else>
         No hay información de la región.
      </div>
      <br>

      <!-- este bloque será reemplazado dinamicamente -->
      <div class="card pro" style="{{--width: 18rem;--}}" v-if="establecimiento && establecimiento.comuna">
         <div class="card-body">
            <h5 class="card-title">
               Comuna ➜ @{{ establecimiento.comuna.nom_comuna || 'No hay información sobre la comuna' }}
            </h5>
            <p class="card-title">

               <dl>
                  <dt>Detalle</dt>
                  <dd>@{{ establecimiento.comuna.det_comuna || 'Sin información de detalle' }}</dd>
                  <dt>Alias</dt>
                  <dd>@{{ establecimiento.comuna.alias || 'Sin información de alias' }}</dd>
               </dl>



            </p>
            {{--<a href="#" class="btn btn-primary">Go somewhere</a>--}}
         </div><!-- .card-body -->
      </div><!-- .card -->
      <div v-else>
         No hay información de la comuna.
      </div>

      <br>

      <!-- este bloque será reemplazado dinamicamente -->
      <div class="card pro" style="{{--width: 18rem;--}}">
         <img class="card-img-top" src="https://www.jqueryscript.net/images/Show-Nearby-Places-jQuery-Google-Maps-WhatsNearby.jpg" alt="Card image cap">
         <div class="card-body">
            <h5 class="card-title">
               Geolocalización
            </h5>
            <p class="card-text">
            </p>
            {{--<a href="#" class="btn btn-primary">Go somewhere</a>--}}
         </div><!-- .card-body -->
      </div><!-- .card -->

   </div><!-- .col -->


   <div class="col-sm-8 col-md-8">
      <h5>HORARIOS DE ATENCIÓN DISPONIBLES</h5>
      <div class="table-responsive">

         <table class="table table-striped table-hover table-sm"
                v-if="establecimiento.horarios_atencion_establecimientos && establecimiento.horarios_atencion_establecimientos.length > 0">
            <thead>
            <tr>
               <th>Nombre Establecimiento</th>
               <th>Día</th>
               <th>Hora Inicio</th>
               <th>Hora Término</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="h in establecimiento.horarios_atencion_establecimientos">
               <td>@{{ h.establecimiento.nom_establecimiento }}</td>
               <td>@{{ h.dia.nom_dia_semana }}</td>
               <td>@{{ h.hora_inicio_atencion || 'Sin definir' }}</td>
               <td>@{{ h.hora_termino_atencion || 'Sin definir' }}</td>
            </tr>
            </tbody>

         </table><!-- .table -->
         <div class="card card-body bg-light" v-else>
            Hasta el momento no existen horarios registrados.
         </div><!-- .card -->
      </div>

      <br>

      <h5>HORARIOS DE VISITA DISPONIBLES</h5>
      <div class="table-responsive">

         <table class="table table-striped table-hover table-sm"
                v-if="establecimiento.horarios_visita_establecimientos && establecimiento.horarios_visita_establecimientos.length > 0">
            <thead>
            <tr>
               <th>Nombre Establecimiento</th>
               <th>Día</th>
               <th>Hora Inicio</th>
               <th>Hora Término</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="h in establecimiento.horarios_visita_establecimientos">
               <td>@{{ h.establecimiento.nom_establecimiento }}</td>
               <td>@{{ h.dia.nom_dia_semana }}</td>
               <td>@{{ h.hora_inicio_visita || 'Sin definir' }}</td>
               <td>@{{ h.hora_termino_visita || 'Sin definir' }}</td>
            </tr>
            </tbody>

         </table><!-- .table -->
         <div class="card card-body bg-light" v-else>
            Hasta el momento no existen horarios registrados.
         </div><!-- .card -->
      </div>

      <br>

      <h5>HORARIOS DE ATENCIÓN DISPONIBLES</h5>
      <div class="table-responsive">

         <table class="table table-striped table-hover table-sm"
                v-if="establecimiento.horarios_atencion_profesionales && establecimiento.horarios_atencion_profesionales.length > 0">
            <thead>
            <tr>
               <th>Nombre Establecimiento</th>
               <th>Profesional</th>
               <th>Día</th>
               <th>Hora Inicio</th>
               <th>Hora Término</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="h in establecimiento.horarios_atencion_profesionales">
               <td>@{{ h.establecimiento.nom_establecimiento }}</td>
               <td>@{{ h.profesional.nom_profesional }}</td>
               <td>@{{ h.dia.nom_dia_semana }}</td>
               <td>@{{ h.hora_inicio_profesional || 'Sin definir' }}</td>
               <td>@{{ h.hora_termino_profesional || 'Sin definir' }}</td>
            </tr>
            </tbody>

         </table><!-- .table -->
         <div class="card card-body bg-light" v-else>
            Hasta el momento no existen horarios registrados.
         </div><!-- .card -->
      </div>

   </div>




</div><!-- .row -->
