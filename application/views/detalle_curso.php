<script>
    $(document).ready(function(){

        $("#menu_cursos").addClass("seleccion_menu");

        $(document).tooltip();

        if (<?= count($registro); ?> > 0) {
        	$("#info_registro").show();
        }else{
        	$("#info_registro").hide();
        }

    });
</script>
<!-- inicia contenido -->
<div class="contenido_dinamico">
	<div id="migaDePan">
		<a href="<?= base_url()?>">Inicio</a> > 
		<a href="<?= site_url('cursos')?>">Administrar Cursos</a> > Detalle de curso
	</div>

	<p class="encabezado_detalle_curso">Datos generales</p>
	<p class="conf_contacto_campos">Estatus</p>
	<p class="conf_contacto_valores">
		<?= $estatus_curso_descripcion; ?>
	</p>

	<p class="conf_contacto_campos">T&iacute;tulo</p>
	<p class="conf_contacto_valores">
		<?= $curso_titulo; ?>
	</p>

	<p class="conf_contacto_campos">Flyer</p>
	<p class="conf_contacto_valores">
		<?= $curso_flyer; ?>
	</p>

	<p class="conf_contacto_campos">Tipo de curso</p>
	<p class="conf_contacto_valores">
		<?= $curso_tipo; ?>
	</p>

	<p class="conf_contacto_campos">Descripción del curso</p>
	<p class="conf_contacto_valores">
		<?= $curso_descripcion; ?>
	</p>

	<p class="conf_contacto_campos">Objetivo</p>
	<p class="conf_contacto_valores">
		<?= $curso_objetivos; ?>
	</p>

	<p class="conf_contacto_campos">Temario</p>
	<p class="conf_contacto_valores">
		<?= $curso_temario; ?>
	</p>

	<p class="conf_contacto_campos">Vigencia del curso</p>
	<p class="conf_contacto_valores">
		<span>Fecha de inicio: <?= $curso_fecha_inicio; ?></span>
		<span>Fecha de fin: <?= $curso_fecha_fin; ?></span>
	</p>

	<p class="conf_contacto_campos">Horario</p>
	<p class="conf_contacto_valores">
		<span>Hora de inicio: <?= $curso_hora_inicio; ?></span>
		<span>Hora de fin: <?= $curso_hora_fin; ?></span>
	</p>

	<p class="conf_contacto_campos">Cupo</p>
	<p class="conf_contacto_valores">
		<?= $curso_cupo; ?>
	</p>

	<?php if(!is_null($profesor)) : ?>
		<p class="conf_contacto_campos">Profesor</p>
		<p class="conf_contacto_valores">
			<?php
				foreach ($profesor as $key => $value) {
				 	echo $value['contacto_nombre']." ".$value['contacto_ap_paterno']." ".$value['contacto_ap_materno'];
				 	echo "<br>";
				 }
			?>
		</p>
	<?php endif; ?>

	<p class="conf_contacto_campos">Ubicación</p>
	<p class="conf_contacto_valores">
		<?= $curso_ubicacion; ?>
		<?php if($curso_mapa_url != "-") : ?>
			<p><?= $curso_mapa_url; ?></p>
		<?php endif; ?>
	</p>

	<p class="conf_contacto_campos">Tel&eacute;fono</p>
	<p class="conf_contacto_valores">
		<?= $curso_telefono; ?>
		<?php if($curso_telefono_extension != "-") : ?>
			<span>ext. <?= $curso_telefono_extension; ?></span>
		<?php endif; ?>
	</p>

	<br>
	<br>

	<p class="encabezado_detalle_curso">Información de los contactos invitados al curso</p>
	<p class="conf_contacto_campos"> - Tipo de contacto
		<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Grupo de contactos a quienes se les envió invitación al curso.">
	</p>
	<p class="conf_contacto_valores">
	<?php
		if($invitados_tipo != "-"){
			foreach ($invitados_tipo as $key => $value) {
				echo $value['tipo_contacto_descripcion'];
				echo "<br>";
			}
		}else{
			echo $invitados_tipo;
		}
	?>
	</p>

	<br>

	<p class="conf_contacto_campos"> - Contactos</p>
	<p class="conf_contacto_valores">
	<?php
		if($invitados_contacto != "-"){
			foreach ($invitados_contacto as $key => $value) {
				echo $value['contacto_nombre']." ".$value['contacto_ap_paterno']." ".$value['contacto_ap_materno'];
				echo "<br>";
			}
		}else{
			echo $invitados_contacto;
		}
	?>
	</p>

	<br>

	<p class="conf_contacto_campos">Participantes
		<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Contactos confirmados.">
	</p>
	<p class="conf_contacto_valores">
	<?php
		if($inscritos != "-"){
			foreach ($inscritos as $key => $value) {
				echo $value['contacto_nombre']." ".$value['contacto_ap_paterno']." ".$value['contacto_ap_materno'];
				echo "<br>";
			}
		}else{
			echo $inscritos;
		}
	?>
	</p>

	<br>

	<p class="conf_contacto_campos">Contactos cancelados</p>
	<p class="conf_contacto_valores">
	<?php
		if($cancelados != "-"){
			foreach ($cancelados as $key => $value) {
				echo $value['contacto_nombre']." ".$value['contacto_ap_paterno']." ".$value['contacto_ap_materno'];
				echo "<br>";
			}
		}else{
			echo $cancelados;
		}
	?>
	</p>
	<br>

	<div id="info_registro">
		<p class="encabezado_detalle_curso">Configuraci&oacute;n del registro en l&iacute;nea</p>


		<p class="conf_contacto_campos">T&iacute;tulo del curso</p>
		<p class="conf_contacto_valores">
			<?= $registro['registro_curso_titulo']; ?>
		</p>

		<p class="conf_contacto_campos">Flyer</p>
		<p class="conf_contacto_valores">
			<?= $registro['registro_curso_flyer']; ?>
		</p>

		<p class="conf_contacto_campos">Tipo de evento o curso</p>
		<p class="conf_contacto_valores">
			<?= $registro['registro_curso_tipo']; ?>
		</p>

		<p class="conf_contacto_campos">Descripci&oacute;n</p>
		<p class="conf_contacto_valores">
			<?= $registro['registro_curso_descripcion']; ?>
		</p>

		<p class="conf_contacto_campos">Objetivos</p>
		<p class="conf_contacto_valores">
			<?= $registro['registro_curso_objetivos']; ?>
		</p>

		<p class="conf_contacto_campos">Temario</p>
		<p class="conf_contacto_valores">
			<?= $registro['registro_curso_temario']; ?>
		</p>

		<p class="conf_contacto_campos">Vigencia</p>
		<p class="conf_contacto_valores">
			<?= $registro['registro_curso_fecha']; ?>
		</p>

		<p class="conf_contacto_campos">Horario</p>
		<p class="conf_contacto_valores">
			<?= $registro['registro_curso_horario']; ?>
		</p>

		<p class="conf_contacto_campos">Cupo total</p>
		<p class="conf_contacto_valores">
			<?= $registro['registro_curso_cupo']; ?>
		</p>

		<p class="conf_contacto_campos">Instructor</p>
		<p class="conf_contacto_valores">
			<?= $registro['registro_curso_instructor']; ?>
		</p>

		<p class="conf_contacto_campos">Ubicaci&oacute;n</p>
		<p class="conf_contacto_valores">
			<?= $registro['registro_curso_ubicacion']; ?>
		</p>

		<p class="conf_contacto_campos">URL de mapa de localizaci&oacute;n</p>
		<p class="conf_contacto_valores">
			<?= $registro['registro_curso_mapa_url']; ?>
		</p>

		<p class="conf_contacto_campos">Tel&eacute;fono de contacto</p>
		<p class="conf_contacto_valores">
			<?= $registro['registro_curso_telefono']; ?>
		</p>

		<p class="conf_contacto_campos">Extensi&oacute;n telef&oacute;nica</p>
		<p class="conf_contacto_valores">
			<?= $registro['registro_curso_telefono_extension']; ?>
		</p>
	</div>

</div>
<!-- termina contenido -->