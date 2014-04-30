<script>
    $(document).ready(function(){
        $("#frm_buscar_contacto").validationEngine({promptPosition: "centerRight"});

        $("#menu_contactos").addClass("seleccion_menu");

    }); 
</script>
<!-- inicia contenido -->
<div class="contenido_dinamico">
	<div id="migaDePan">
		<a href="<?= base_url()?>">Inicio</a> > Administrar Contactos
	</div>

	<form id="frm_buscar_contacto" action="<?= base_url()?>" method="POST">
			<label for="nombre_contacto">Nombre</label>
			<input type="text" id="nombre_contacto" name="nombre_contacto" class="buscar_contacto_textInput validate[required]"/>
			<label for="correo_contacto">Correo electr&oacute;nico</label>
			<input type="text" id="correo_contacto" name="correo_contacto" class="buscar_contacto_textInput validate[required]"/>
			<label for="tipo_contacto">Tipo de contacto</label>
			<select name="tipo_contacto" id="tipo_contacto" class="buscar_contacto_textInput validate[required]">
				<option selected disabled>- Elija un tipo -</option>
				<option value="1">Webmaster</option>
				<option value="2">Responsable de comunicación</option>
				<option value="3">Responsable técnico</option>
				<option value="4">Otros</option>
			</select>
			<label for="instancia_contacto">Instancia</label>
			<input type="text" id="instancia_contacto" name="instancia_contacto" class="buscar_contacto_textInput validate[required]"/>
			<input type="submit" id="btn_buscar_contacto" value="Buscar"/>
	</form>

	<table class="tables">
		<tr>
			<td>Nombre completo</td>
			<td>Tipo de contacto</td>
			<td>Estatus</td>
			<td>Instancia</td>
			<td>Correo institucional</td>
			<td>Correo personal</td>
			<td>Editar</td>
			<td>Borrar</td>
		</tr>
	</table>

	<a href="<?= base_url('index.php/contactos/nuevo')?>">
		<input type="button" id="btn_nuevo_contacto" value="Nuevo contacto"/>
	</a>

</div>
<!-- termina contenido -->