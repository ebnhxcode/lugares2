<div class="card">
   <div class="card-body pro">
      @include('establecimientos.partials.segments.datos_basicos')
   </div>
</div>
<br>
<div class="card">
   <div class="card-body pro">
      @include('establecimientos.partials.segments.datos_ubicacion')
   </div>
</div>
<br>
<div class="card">
   <div class="card-body pro">
      @include('establecimientos.partials.segments.datos_geolocalizacion')
   </div>
</div>
<br>
<div class="card">
   <div class="card-body pro">
      @include('establecimientos.partials.segments.datos_responsable')
   </div>
</div>
<br>
<div class="card">
   <div class="card-body pro">
      @include('establecimientos.partials.segments.datos_contacto')
   </div>
</div>
<br>
<div class="card" v-if="modal_actualizar_activo==true">
   <div class="card-body pro">
      @include('establecimientos.partials.segments.otros_telefonos')
   </div>
</div>
<br>
<div class="card" v-if="modal_actualizar_activo==true">
   <div class="card-body pro">
      @include('establecimientos.partials.segments.horarios_atencion')
   </div>
</div>
<br>
<div class="card" v-if="modal_actualizar_activo==true">
   <div class="card-body pro">
      @include('establecimientos.partials.segments.horarios_visitas')
   </div>
</div>
<br>
<div class="card" v-if="modal_actualizar_activo==true">
   <div class="card-body pro">
      @include('establecimientos.partials.segments.extension_horaria')
   </div>
</div>
<br>


















