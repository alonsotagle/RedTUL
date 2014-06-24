<script>
    $(document).ready(function(){

        $("#menu_mensajeria").addClass("seleccion_menu");

    });
</script>
<!-- inicia contenido -->
<div class="contenido_dinamico">
	<div id="migaDePan">
		<a href="<?= base_url()?>">Inicio</a> > 
		<a href="<?= site_url('mensajeria')?>">Servicio de mensajer&iacute;a</a> > Detalle de correo
	</div>

	<p class="conf_contacto_campos">Estatus</p>
	<p class="conf_contacto_valores">
		<?= $estatus_correo_descripcion; ?>
	</p>

	<p class="conf_contacto_campos">Destinatarios</p>
	<p class="conf_contacto_valores">
		<?php
			foreach ($destinatarios as $key => $value) {
			 	echo $value['contacto_nombre']." ".$value['contacto_ap_paterno']." ".$value['contacto_ap_materno'];
			 	echo "<br>";
			 }
		?>
	</p>

	<p class="conf_contacto_campos">Asunto</p>
	<p class="conf_contacto_valores">
		<?= $correo_asunto; ?>
	</p>
	<p class="conf_contacto_campos">Contenido del correo</p>
	<p class="conf_contacto_valores">
		<?= $correo_contenido; ?>
	</p>
	<p class="conf_contacto_campos">Fecha de env&iacute;o</p>
	<p class="conf_contacto_valores">
		<?= $correo_fecha_envio; ?>
	</p>
	<p class="conf_contacto_campos">Hora de env&iacute;o</p>
	<p class="conf_contacto_valores">
		<?= $correo_hora_envio; ?>
	</p>
	<p class="conf_contacto_campos">Fecha de creaci&oacute;n</p>
	<p class="conf_contacto_valores">
		<?= $correo_fecha_creacion; ?>
	</p>
	<?php if($correo_archivo_adjunto != "") : ?>
		<p class="conf_contacto_campos">Archivo adjunto</p>
		<p class="conf_contacto_valores">
			<a href="<?= $correo_archivo_adjunto; ?>" target="_blank">Archivo adjunto</a>
		</p>
	<?php endif; ?>

</div>
<!-- termina contenido -->