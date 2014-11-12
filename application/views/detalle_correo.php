<script>
    $(document).ready(function(){
        $("#menu_mensajeria").addClass("seleccion_menu");
    });
</script>
<!-- inicia contenido -->
<div class="contenido_dinamico">
	<div id="migaDePan">
		<a href="<?= base_url()?>">Inicio</a> > 
		<a href="<?= site_url('mensajeria')?>"> Env&iacute;o de correos</a> > Detalle de correo
	</div>

	<span class="conf_contacto_campos">Estatus</span>
	<span class="conf_contacto_valores">
		<?= $estatus_correo_descripcion; ?>
	</span>
	<br><br>
	<span class="conf_contacto_campos">Destinatarios</span>
	<span class="conf_contacto_valores">
		<?php
			if($destinatarios){
				foreach ($destinatarios as $key => $value) {
				 	echo $value['contacto_nombre']." ".$value['contacto_ap_paterno']." ".$value['contacto_ap_materno'];
				 	echo "<br>";
				}
			}else{
				echo "-";
			}
		?>
	</span>
	<br><br>
	<span class="conf_contacto_campos">Asunto</span>
	<span class="conf_contacto_valores">
		<?= $correo_asunto; ?>
	</span>
	<br><br>
	<span class="conf_contacto_campos">Contenido del correo</span>
	<br>
	<span class="conf_contacto_valores">
		<?= $correo_contenido; ?>
	</span>
	<br><br>
	<span class="conf_contacto_campos">Fecha de env&iacute;o</span>
	<span class="conf_contacto_valores">
		<?= $correo_fecha_envio; ?>
	</span>
	<br><br>
	<span class="conf_contacto_campos">Hora de env&iacute;o</span>
	<span class="conf_contacto_valores">
		<?= $correo_hora_envio; ?>
	</span>
	<br><br>
	<span class="conf_contacto_campos">Fecha de creaci&oacute;n</span>
	<span class="conf_contacto_valores">
		<?= $correo_fecha_creacion; ?>
	</span>
	<br><br>
	<?php if($correo_archivo_adjunto != "") : ?>
		<span class="conf_contacto_campos">Archivo adjunto</span>
		<span class="conf_contacto_valores">
			<a href="<?= $correo_archivo_adjunto; ?>" target="_blank">Archivo adjunto</a>
		</span>
	<?php endif; ?>
</div>
<!-- termina contenido -->