<script>
    $(document).ready(function(){

        $("#frm_buscar_correo").validationEngine({promptPosition: "centerRight"});

        $("#menu_mensajeria").addClass("seleccion_menu");

        $(function() {
	    	$( "#tabs" ).tabs();
	    	$( "#tabs_enviar_correo" ).tabs();
	    	$( "#tabs_correo_cuerpo" ).tabs();
		});


    }); 
</script>
<!-- inicia contenido -->
<div class="contenido_dinamico">
	<div id="migaDePan">
		<a href="<?= base_url()?>">Inicio</a> > Servicio de mensajer&iacute;a
	</div>

<div id="tabs">
		<ul>
			<li><a href="#tabs-1">Bandeja de entrada</a></li>
			<li><a href="#tabs-2">Nuevo correo electr&oacute;nico</a></li>
			<li><a href="#tabs-3">Administrar plantillas</a></li>
		</ul>
		<div id="tabs-1">
			<form id="frm_buscar_correo" action="<?= site_url('contactos/buscar')?>" method="POST">
				<label for="asunto_correo">Asunto</label>
				<input type="text" id="asunto_correo" maxlength="255" name="asunto_correo" class="input_buscar_correo validate[groupRequired[buscar_correo]]"/>

				<label for="fecha_envio_correo">Fecha de env&iacute;o</label>
				<select name="fecha_envio_correo" id="fecha_envio_correo" class="input_buscar_correo validate[groupRequired[buscar_correo]]">
					<option selected disabled>- Elija un tipo -</option>
					<option value="1">El &uacute;ltimo año</option>
					<option value="2">El &uacute;ltimo mes</option>
					<option value="3">La &uacute;ltima semana</option>
					<option value="4">Un d&iacute;a anterior</option>
				</select>

				<label for="tipo_contacto">Estatus de env&iacute;o</label>
				<select name="tipo_contacto" id="tipo_contacto" class="input_buscar_correo validate[groupRequired[buscar_correo]]">
					<option selected disabled>- Elija un tipo -</option>
					<option value="1">Pendiente</option>
					<option value="2">Cancelado</option>
					<option value="3">Enviado</option>
				</select>
				<input type="submit" id="btn_buscar_contacto" value="Buscar"/>
			</form>

			<table class='tables'>
				<tr>
					<td>Asunto</td>
					<td>Fecha de creación</td>
					<td>Fecha de env&iacute;o</td>
					<td>Destinatarios</td>
					<td>Editar</td>
					<td>Eliminar</td>
				</tr>
			</table>

		</div>


		<div id="tabs-2">
			<div id="tabs_enviar_correo">
				<ul>
					<li><a href="#tab-contenido">Contenido correo electr&oacute;nico</a></li>
					<li><a href="#tab-dest">Destinatarios</a></li>
				</ul>
				<div id="tab-contenido">
					<label class="label_nuevo_correo">Usar plantilla</label>
					<input type="text">
					<br>
					<label class="label_nuevo_correo">Asunto</label>
					<input type="text">
					<br>
					<label class="label_nuevo_correo">Datos adjuntos</label>
					<input type="file">
					<br>
					<div id="tabs_correo_cuerpo">
						<ul>
							<li><a href="#tab-textoplano">Texto plano</a></li>
							<li><a href="#tab-html">HTML</a></li>
						</ul>
						<div id="tab-textoplano">
							<textarea class="textarea_cuerpo_correo"></textarea>
						</div>
						<div id="tab-html">
							<textarea class="textarea_cuerpo_correo"></textarea>
						</div>
					</div>

				</div>
				<div id="tab-dest"></div>
			</div>
		</div>
		<div id="tabs-3"></div>

</div>
<!-- termina contenido -->