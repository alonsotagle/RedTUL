<script>
    $(document).ready(function(){
            $("#frm_buscar_contacto").validationEngine({promptPosition: "centerRight"});
    }); 
</script>
<div class="topinterna">
	<img src="<?= base_url('assets/img/titulo.jpg')?>">
</div>
<!-- inicia contenido -->
<div class="contenido">
	<div id="migaDePan">
		<a href="<?= base_url()?>">Inicio</a> > Administrar Contactos
	</div>

	<form id="frm_buscar_contacto" action="<?= base_url()?>" method="POST">
			<label for="nombre_contacto">Nombre</label>
			<input type="text" id="nombre_contacto" name="nombre_contacto" class="buscar_contacto_textInput validate[required]"/>
			<label for="correo_contacto">Correo electr&oacute;nico</label>
			<input type="text" id="correo_contacto" name="correo_contacto" class="buscar_contacto_textInput validate[required]"/>
			<label for="tipo_contacto">Tipo de contacto</label>
			<select name="tipo_contacto" id="tipo_contacto" class="validate[required]">
				<option selected disabled>- Elija un tipo -</option>
				<option value="1">Webmaster</option>
				<option value="2">Responsable de comunicación</option>
				<option value="3">Responsable técnico</option>
				<option value="4">Otros</option>
			</select>
			<label for="instancia_contacto">Instancia</label>
			<input type="text" id="instancia_contacto" name="instancia_contacto" class="buscar_contacto_textInput validate[required]"/>
			<input type="submit" class="button" value="Buscar"/>
	</form>
</div>
<!-- termina contenido -->