<script>
    $(document).ready(function(){

        $("#menu_cursos").addClass("seleccion_menu");

    });
</script>
<!-- inicia contenido -->
<div class="contenido_dinamico">
<div id="migaDePan">
	<a href="<?= base_url()?>">Inicio</a> > 
	<a href="<?= site_url('cursos')?>">Administrar Cursos</a> > Nuevo curso
</div>

	<p id="conf_contacto_leyenda">La informaci&oacute;n se guard&oacute; satisfactoriamente</p>

	<p class="conf_contacto_campos">T&iacute;tulo</p>
	<p class="conf_contacto_valores">
		<?= $curso_titulo; ?>
	</p>
	<p class="conf_contacto_campos">Tipo de curso</p>
	<p class="conf_contacto_valores">
		<?= $curso_tipo; ?>
	</p>
	<p class="conf_contacto_campos">Descripci&oacute;n</p>
	<p class="conf_contacto_valores">
		<?= $curso_descripcion; ?>
	</p>
	<p class="conf_contacto_campos">Objetivos</p>
	<p class="conf_contacto_valores">
		<?= $curso_objetivos; ?>
	</p>
	<p class="conf_contacto_campos">Fecha de inicio</p>
	<p class="conf_contacto_valores">
		<?= $curso_fecha_inicio; ?>
	</p>
	<p class="conf_contacto_campos">Fecha de termino</p>
	<p class="conf_contacto_valores">
		<?= $curso_fecha_fin; ?>
	</p>
	<p class="conf_contacto_campos">Hora de inicio</p>
	<p class="conf_contacto_valores">
		<?= $curso_hora_inicio; ?>
	</p>
	<p class="conf_contacto_campos">Fecha de termino</p>
	<p class="conf_contacto_valores">
		<?= $curso_hora_fin; ?>
	</p>
	<p class="conf_contacto_campos">Cupo</p>
	<p class="conf_contacto_valores">
		<?= $curso_cupo; ?>
	</p>
	<p class="conf_contacto_campos">Ubicaci&oacute;n</p>
	<p class="conf_contacto_valores">
		<?= $curso_ubicacion; ?>
	</p>
	<p class="conf_contacto_campos">URL de mapa de localizaci&oacute;n</p>
	<p class="conf_contacto_valores">
		<?= $curso_mapa_url; ?>
	</p>
	<p class="conf_contacto_campos">Tel&eacute;fono de contacto</p>
	<p class="conf_contacto_valores">
		<?= $curso_telefono; ?>
	</p>
	<p class="conf_contacto_campos">Extensi&oacute;n telef&oacute;nica</p>
	<p class="conf_contacto_valores">
		<?= $curso_telefono_extension; ?>
	</p>

</div>
<!-- termina contenido -->