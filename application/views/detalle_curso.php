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
	<span class="conf_contacto_campos">Estatus</span>
	<span class="conf_contacto_valores">
		<?= $estatus_curso_descripcion; ?>
	</span>
	<br><br>

	<span class="conf_contacto_campos">T&iacute;tulo</span>
	<span class="conf_contacto_valores">
		<?= $curso_titulo; ?>
	</span>
	<span class="conf_registro_linea">
		<?= $registro['registro_curso_titulo']; ?>
	</span>
	<br><br>

	<span class="conf_contacto_campos">Imagen</span>
	<span class="conf_contacto_valores">
		<?= $curso_flyer; ?>
	</span>
	<span class="conf_registro_linea">
		<?= $registro['registro_curso_flyer']; ?>
	</span>
	<br><br>

	<span class="conf_contacto_campos">Tipo</span>
	<span class="conf_contacto_valores">
		<?= $curso_tipo; ?>
	</span>
	<span class="conf_registro_linea">
		<?= $registro['registro_curso_tipo']; ?>
	</span>
	<br><br>

	<span class="conf_contacto_campos">Modalidad</span>
	<span class="conf_contacto_valores">
		<?= $curso_modalidad; ?>
	</span>
	<span class="conf_registro_linea">
		<?= $registro['registro_curso_modalidad']; ?>
	</span>
	<br><br>

	<span class="conf_contacto_campos">Descripción</span>
	<span class="conf_contacto_valores">
		<?= $curso_descripcion; ?>
	</span>
	<span class="conf_registro_linea">
		<?= $registro['registro_curso_descripcion']; ?>
	</span>
	<br><br>

	<span class="conf_contacto_campos">Objetivo</span>
	<span class="conf_contacto_valores">
		<?= $curso_objetivos; ?>
	</span>
	<span class="conf_registro_linea">
		<?= $registro['registro_curso_objetivos']; ?>
	</span>	
	<br><br>

	<span class="conf_contacto_campos">Temario</span>
	<span class="conf_contacto_valores">
		<?= $curso_temario; ?>
	</span>
	<span class="conf_registro_linea">
		<?= $registro['registro_curso_temario']; ?>
	</span>
	<br><br>

	<span class="conf_contacto_campos">Vigencia</span>
	<span class="conf_contacto_valores">
		<span>Fecha de inicio: <?= $curso_fecha_inicio; ?></span><br>
		<span>Fecha de fin: <?= $curso_fecha_fin; ?></span>
	</span>
	<span class="conf_registro_linea">
		<?= $registro['registro_curso_fecha']; ?>
	</span>
	<br><br>

	<span class="conf_contacto_campos">Horario</span>
	<span class="conf_contacto_valores">
		<span>Hora de inicio:<?= $curso_hora_inicio; ?></span><br>
		<span>Hora de fin:<?= $curso_hora_fin; ?></span>
	</span>
	<span class="conf_registro_linea">
		<?= $registro['registro_curso_horario']; ?>
	</span>
	<br><br>

	<span class="conf_contacto_campos">Cupo</span>
	<span class="conf_contacto_valores">
		<?= $curso_cupo; ?>
	</span>
	<span class="conf_registro_linea">
		<?= $registro['registro_curso_cupo']; ?>
	</span>
	<br><br>

	<span class="conf_contacto_campos">Profesor</span>
	<span class="conf_contacto_valores">
	<?php
		if($profesor != "-"){
			foreach ($profesor as $key => $value) {
				echo $value['contacto_nombre']." ".$value['contacto_ap_paterno']." ".$value['contacto_ap_materno'];
				echo "<br>";
			}
		}else{
			echo $profesor;
		}
	?>
	</span>
	<span class="conf_registro_linea">
		<?= $registro['registro_curso_instructor']; ?>
	</span>
	<br><br>

	<span class="conf_contacto_campos">Ubicación</span>
	<span class="conf_contacto_valores">
		<?= $curso_ubicacion; ?>
	</span>
	<span class="conf_registro_linea">
		<?= $registro['registro_curso_ubicacion']; ?>
	</span>
	<br><br>

	<span class="conf_contacto_campos">URL de mapa de localización</span>
	<span class="conf_contacto_valores">
		<?= $curso_mapa_url; ?>
	</span>
	<span class="conf_registro_linea">
		<?= $registro['registro_curso_mapa_url']; ?>
	</span>
	<br><br>

	<span class="conf_contacto_campos">Tel&eacute;fono</span>
	<span class="conf_contacto_valores">
		<?= $curso_telefono; ?>
	</span>
	<span class="conf_registro_linea">
		<?= $registro['registro_curso_telefono']; ?>
	</span>
	<br><br>

	<span class="conf_contacto_campos">Extensi&oacute;n</span>
	<span class="conf_contacto_valores">
		<?= $curso_telefono_extension; ?>
	</span>
	<span class="conf_registro_linea">
		<?= $registro['registro_curso_telefono_extension']; ?>
	</span>
	<br><br>

	<span class="conf_contacto_campos">Entidad u organización.</span>
	<span class="conf_contacto_valores">
		<?= $curso_entidad; ?>
	</span>
	<span class="conf_registro_linea">
		<?= $registro['registro_curso_entidad']; ?>
	</span>
	<br><br>

	<span class="conf_contacto_campos">Costo</span>
	<span class="conf_contacto_valores">
		<?= $curso_costo; ?>
	</span>
	<span class="conf_registro_linea">
		<?= $registro['registro_curso_costo']; ?>
	</span>
	<br><br>

	<p class="encabezado_detalle_curso">Información de los contactos invitados al curso</p>
	<span class="conf_contacto_campos"> - Tipo de contacto
		<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Grupo de contactos a quienes se les envió invitación al curso.">
	</span>
	<span class="conf_contacto_valores">
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
	</span>

	<br><br>

	<span class="conf_contacto_campos"> - Contactos</span>
	<span class="conf_contacto_valores">
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
	</span>
	<br><br>

	<span class="conf_contacto_campos">Participantes
		<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Contactos confirmados.">
	</span>
	<span class="conf_contacto_valores">
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
	</span>
	<br><br>

	<span class="conf_contacto_campos">Contactos cancelados</span>
	<span class="conf_contacto_valores">
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
	</span>
	<br><br>
	<br>

</div>
<!-- termina contenido -->