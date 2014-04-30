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
		<a href="<?= base_url('index.php/contactos')?>">Administrar Contactos</a> > Nuevo contacto
	</div>

	<form id="frm_nuevo_contacto" action="<?= base_url()?>" method="POST">
			<div class="contenedor_seccion_formulario">
				<label class="etiqueta_frm_nuevo">Estatus</label>
				<input type="radio" name="estatus_contacto" value="1" id="estatus_activo" checked>
				<label for="estatus_activo">Activo</label>
				<input type="radio" name="estatus_contacto" value="0" id="estatus_inactivo">
				<label for="estatus_inactivo">Inactivo</label>
			</div>
			<div id="contenedor_imagen">
				<div id="contacto_imagen"></div>
				<input type="button" id="btn_examinar" value="Examinar">
			</div>
			<div class="contenedor_seccion_formulario">
				<label>Tipo de contacto</label>
				<br>
				<input type="radio" name="tipo_contacto" value="1" id="tipo_web" class="validate[required]">
				<label for="tipo_web">Webmaster</label>
				<br>
				<input type="radio" name="tipo_contacto" value="2" id="tipo_com" class="validate[required]">
				<label for="tipo_com">Responsable de comunicaci&oacute;n</label>
				<br>
				<input type="radio" name="tipo_contacto" value="3" id="tipo_tec" class="validate[required]">
				<label for="tipo_tec">Responsable t&eacute;cnico</label>
				<br>
				<input type="radio" name="tipo_contacto" value="4" id="tipo_otr" class="validate[required]">
				<label for="tipo_otr">Otros</label>
				<br>
			</div>
			
			<label>Instructor candidato</label>
			<input type="radio" name="instructor_candidato" value="1" id="instructor_si">
			<label for="instructor_si">S&iacute;</label>
			<input type="radio" name="instructor_candidato" value="0" id="instructor_no">
			<label for="instructor_no">No</label>
			<br>
			<p class="encabezado_form_nuevo_contacto">Datos Generales</p>
			<label class="etiqueta_frm_nuevo">Nombre</label>
			<input type="text" maxlength="50" name="contacto_nombre" class="validate[required]">
			<br>
			<label class="etiqueta_frm_nuevo">Apellido paterno</label>
			<input type="text" maxlength="50" name="contacto_apaterno" class="input_frm_nuevo validate[required]">
			<label class="etiqueta_frm_nuevo">Apellido materno</label>
			<input type="text" maxlength="50" name="contacto_amaterno" class="validate[required]">
			<br>
			<p class="encabezado_form_nuevo_contacto">Datos laborales</p>
			<label class="etiqueta_frm_nuevo">Instancia</label>
			<input type="text" name="contacto_instancia" class="input_frm_nuevo validate[required]">
			<label class="etiqueta_frm_nuevo">&Aacute;rea de adscripci&oacute;n</label>
			<input type="text" maxlength="255" name="contacto_adscripcion">
			<br><br><br>
			<label id="label_funciones">Descripci&oacute;n de funciones</label>
			<textarea name="contacto_funciones" maxlength="255"></textarea>
			<br>
			<p class="encabezado_form_nuevo_contacto">Datos de Contacto</p>

			<div class="contenedor_seccion_formulario">
				<label class="etiqueta_frm_nuevo">T&eacute;lefono</label>
				<input type="text" name="contacto_telefono" size="10" class="input_frm_nuevo validate[required,custom[telefono]]">
				<label id="etiqueta_ext">ext.</label>
				<input type="text" name="contacto_extension" size="5" class="validate[custom[telefono]]">
			</div>

			<div id="contenedor_comunicacion">
				<label>Medio de comunicaci&oacute;n preferente</label>
				<br><br>
				<input type="radio" name="comunicacion_contacto" value="0" id="comunicacion_tel" class="validate[required]">
				<label for="comunicacion_tel">V&iacute;a telef&oacute;nica</label>
				<br>
				<input type="radio" name="comunicacion_contacto" value="1" id="comunicacion_email" class="validate[required]">
				<label for="comunicacion_email">V&iacute;a e-mail</label>
			</div>
			<br>
			<label class="etiqueta_frm_nuevo">Correo institucional</label>
			<input type="text" maxlength="100" name="contacto_correoinst" class="validate[groupRequired[correo],custom[email]]">
			<br><br>
			<label class="etiqueta_frm_nuevo">Correo personal</label>
			<input type="text" maxlength="100" name="contacto_correopers" class="validate[groupRequired[correo],custom[email]]">
			<br><br><br>
			<div id="botones_envio">
				<input type="submit" id="btn_guardar" value="Guardar">
				<input type="submit" id="btn_guardarynuevo" value="Guardar y nuevo contacto">
			</div>
	</form>

</div>
<!-- termina contenido -->