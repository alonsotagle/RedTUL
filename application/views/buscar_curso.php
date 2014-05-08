<script>
    $(document).ready(function(){

        $("#menu_cursos").addClass("seleccion_menu");

    }); 
</script>
<!-- inicia contenido -->
<div class="contenido_dinamico">
	<div id="migaDePan">
		<a href="<?= base_url()?>">Inicio</a> > 
		<a href="<?= site_url('cursos')?>">Administrar Cursos</a> > Buscar cursos
	</div>

	<table class='tables'>
		<tr>
			<td>Nombre</td>
			<td>Tipo</td>
			<td>Instructor asignado</td>
			<td>Estatus</td>
			<td>Vigencia</td>
			<td>Horario</td>
			<td>Cupo disponible</td>
			<td>Editar</td>
			<td>Eliminar</td>
		</tr>
		<?php

		if (!is_null($resultado)) {

			foreach ($resultado as $key => $value) {
				echo "<tr>
						<td>".$value['curso_titulo']."</td>
						<td>".$value['curso_tipo']."</td>
						<td>".$value['curso_instructor']."</td>
						<td>".$value['estatus_curso_descripcion']."</td>
						<td>".$value['curso_fecha_inicio']." a ".$value['curso_fecha_fin']."</td>
						<td>".$value['curso_hora_inicio']." a ".$value['curso_hora_fin']."</td>
						<td>".$value['curso_cupo']."</td>
						<td><a href=".site_url('cursos/editar')."/".$value['id_curso'].">
						<img src=".base_url('assets/img/icono_editar.png').">
						</a></td>
						<td><a href=".site_url('cursos/eliminar')."/".$value['id_curso'].">
						<img src=".base_url('assets/img/icono_borrar.png').">
						</a></td>
					</tr>";
			}
		}
		?>
	</table>

</div>
<!-- termina contenido -->