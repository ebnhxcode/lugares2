<table class="table table-sm">
   <thead>
   <tr class="text-center">
      <th v-for="c,i in tabla_campos" v-if="c.visibility!=false">
         <a href="#!" class="btn btn-primary" style="width: 100%;height: 100%;" @click.prevent="cambiar_orden_lista(i)">
            <i class="fa fa-sort" aria-hidden="true"></i>&nbsp;
            @{{ tabla_labels[i] }}
         </a>
      </th>
      <th>
         <a href="#!" class="btn btn-primary" style="width: 100%;height: 100%;" @click.prevent="cambiar_orden_lista(`id_${nombre_model}`)">
            <i class="fa fa-sort" aria-hidden="true"></i>&nbsp;
            Acción
         </a>
      </th>
   </tr>
   </thead>
   <tbody>

   <tr class="text-center" v-for="lom in filterBy(lista_objs_model, filtro_head)"
       {{--@dblclick.prevent="editar(lom[`id_${nombre_model}`])"--}}>
      <template v-if="id_en_edicion != lom[`id_${nombre_model}`] || modal_actualizar_activo == true">
         <td v-for="c,i in tabla_campos" v-show="c.visibility!=false" class="text-left">
            {{-- se corre por detras la completitud de relaciones. --}}
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
         <div class="btn-group btn-group-sm" style="margin:0;padding:0;" role="group" aria-label="Basic example">
            {{--
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
            --}}
            <button class="btn"
                    data-placement="top" data-toggle="tooltip" title="Actualizar desde modal"
                    @click.prevent="mostrar_modal_actualizar(lom[`id_${nombre_model}`])"
                    v-show="id_en_edicion == null">
               <i class="fa fa-eye" ></i>
            </button>
            <button class="btn"
                    data-placement="top" data-toggle="tooltip" title="Dejar de editar"
                    @click.prevent="dejar_de_editar()"
                    v-if="id_en_edicion === lom[`id_${nombre_model}`]">
               <i class="fa fa-close"></i>
            </button>
            <button class="btn btn-danger" v-show="id_en_edicion == null"
                    v-if="usuario_auth.usuario_role&&en_array(['Administrador','Jefe de Area','Lider Equipo','Modificador'],usuario_auth.usuario_role.role.nom_role)"
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
<div v-if="typeof spinner_table != 'undefined' && spinner_table == true">
   <spinner></spinner>
</div>