<script>
    $(document).ready(function(){
        $("#frm_nuevo_contacto").validationEngine({promptPosition: "centerRight"});

        $("#menu_contactos").addClass("seleccion_menu");

    });
</script>
<!-- inicia contenido -->
<div class="contenido_dinamico">
	<div id="migaDePan">
		<a href="<?= base_url()?>">Inicio</a> > 
		<a href="<?= base_url('index.php/contacto')?>">Administrar Contactos</a> > Nuevo contacto
	</div>

	<form id="frm_nuevo_contacto" action="<?= base_url()?>" method="POST">
			<label for="">Estatus</label>
			<input type="radio" name="estatus_contacto" value="" class=" validate[required]"/>Activo
			<input type="radio" name="estatus_contacto" value="" class=" validate[required]"/>Inactivo
			<br>
			<label for="">Tipo de contacto</label>
			<br>
			<input type="radio" name="tipo_contacto" value="" class=" validate[required]"/>Webmaster
			<br>
			<input type="radio" name="tipo_contacto" value="" class=" validate[required]"/>Responsable de comunicaci&oacute;n
			<br>
			<input type="radio" name="tipo_contacto" value="" class=" validate[required]"/>Responsable t&eacute;cnico
			<br>
			<input type="radio" name="tipo_contacto" value="" class=" validate[required]"/>Otros
			<br>
			<label for="">Instructor candidato</label>
			<input type="radio" name="instructor_candidato" value="" class=" validate[required]"/>S&iacute;
			<input type="radio" name="instructor_candidato" value="" class=" validate[required]"/>No
			<br>
			<p class="encabezado_form_nuevo_contacto">Datos Generales</p>
			<label>Nombre</label>
			<input type="text">
			<br>
			<label>Apellido paterno</label>
			<input type="text">
			<label>Apellido materno</label>
			<input type="text">
			<br>
			<p class="encabezado_form_nuevo_contacto">Datos laborales</p>
			<label>Instancia</label>
			<input type="text">
			<label>&Aacute;rea de adscripci&oacute;n</label>
			<input type="text">
			<br>
			<label>Descripci&oacute;n de funciones</label>
			<textarea></textarea>
			<br>
			<p class="encabezado_form_nuevo_contacto">Datos de Contacto</p>
			<label>T&eacute;lefono</label>
			<input type="text">
			<label>ext.</label>
			<input type="text">
			<label>Medio de comunicaci&oacute;n preferente</label>
			<input type="radio" name="comunicacion_contacto" value="" class=" validate[required]"/>V&iacute;a telef&oacute;nica
			<input type="radio" name="comunicacion_contacto" value="" class=" validate[required]"/>V&iacute;a e-mail
			<label>Correo institucional</label>
			<input type="text">
			<label>Correo personal</label>
			<input type="text">

			<input type="submit" id="" value="Guardar"/>
			<input type="submit" id="" value="Guardar y nuevo contacto"/>
	</form>

</div>
<!-- termina contenido -->