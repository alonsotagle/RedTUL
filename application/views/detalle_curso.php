<script>
    $(document).ready(function(){

        $("#menu_cursos").addClass("seleccion_menu");

        $(document).tooltip();

    });
</script>
<!-- inicia contenido -->
<div class="contenido_dinamico">
	<div id="migaDePan">
		<a href="<?= base_url()?>">Inicio</a> > 
		<a href="<?= site_url('cursos')?>">Administrar Cursos</a> > Detalle de curso
	</div>

	<p class="conf_contacto_campos">Estatus</p>
	<p class="conf_contacto_valores">
		<?= $estatus_curso_descripcion; ?>
	</p>

	<p class="conf_contacto_campos">T&iacute;tulo</p>
	<p class="conf_contacto_valores">
		<?= $curso_titulo; ?>
	</p>

	<?php if($curso_flyer != "") : ?>
		<p class="conf_contacto_campos">Flyer</p>
		<p class="conf_contacto_valores">
			<?= $curso_flyer; ?>
		</p>
	<?php endif; ?>

	<p class="conf_contacto_campos">Tipo de curso</p>
	<p class="conf_contacto_valores">
		<?= $curso_tipo; ?>
	</p>

	<p class="conf_contacto_campos">Descripción del curso</p>
	<p class="conf_contacto_valores">
		<?= $curso_descripcion; ?>
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

	<?php if($curso_cupo != "") : ?>
		<p class="conf_contacto_campos">Cupo</p>
		<p class="conf_contacto_valores">
			<?= $curso_cupo; ?>
		</p>
	<?php endif; ?>

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

	<?php if($curso_ubicacion != "") : ?>
		<p class="conf_contacto_campos">Ubicación</p>
		<p class="conf_contacto_valores">
			<?= $curso_ubicacion; ?>
			<?php if($curso_mapa_url != "") : ?>
				<p><?= $curso_mapa_url; ?></p>
			<?php endif; ?>
		</p>
	<?php endif; ?>

	<?php if($curso_telefono != "") : ?>
		<p class="conf_contacto_campos">Tel&eacute;fono</p>
		<p class="conf_contacto_valores">
			<?= $curso_telefono; ?>
			<?php if($curso_telefono_extension != "") : ?>
				<span>ext. <?= $curso_telefono_extension; ?></span>
			<?php endif; ?>
		</p>
	<?php endif; ?>

	<br>
	<br>

	<p class="conf_contacto_campos">Información de los contactos invitados al curso</p>
	<br><br>
	<?php if(!is_null($invitados_tipo)) : ?>
		<p class="conf_contacto_campos"> - Tipo de contacto
			<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Grupo de contactos a quienes se les envió invitación al curso.">
		</p>
		<p class="conf_contacto_valores">
			<?php
				foreach ($invitados_tipo as $key => $value) {
				 	echo $value['tipo_contacto_descripcion'];
				 	echo "<br>";
				 }
			?>
		</p>
	<?php endif; ?>

	<br>

	<?php if(!is_null($invitados_contacto)) : ?>
		<p class="conf_contacto_campos"> - Contactos</p>
		<p class="conf_contacto_valores">
			<?php
				foreach ($invitados_contacto as $key => $value) {
				 	echo $value['contacto_nombre']." ".$value['contacto_ap_paterno']." ".$value['contacto_ap_materno'];
				 	echo "<br>";
				 }
			?>
		</p>
	<?php endif; ?>

	<br>

	<?php if(!is_null($inscritos)) : ?>
		<p class="conf_contacto_campos">Participantes
			<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Grupo de contactos a quienes se les envió invitación al curso.">
		</p>
		<p class="conf_contacto_valores">
			<?php
				foreach ($inscritos as $key => $value) {
				 	echo $value['contacto_nombre']." ".$value['contacto_ap_paterno']." ".$value['contacto_ap_materno'];
				 	echo "<br>";
				 }
			?>
		</p>
	<?php endif; ?>

	<br>

	<?php if(!is_null($cancelados)) : ?>
		<p class="conf_contacto_campos">Contactos cancelados</p>
		<p class="conf_contacto_valores">
			<?php
				foreach ($cancelados as $key => $value) {
				 	echo $value['contacto_nombre']." ".$value['contacto_ap_paterno']." ".$value['contacto_ap_materno'];
				 	echo "<br>";
				 }
			?>
		</p>
	<?php endif; ?>

</div>
<!-- termina contenido -->