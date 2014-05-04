<script>
    $(document).ready(function(){
        $("#frm_editar_contacto").validationEngine({promptPosition: "centerRight"});

        $("#menu_contactos").addClass("seleccion_menu");

        $.ajax("<?= site_url('contactos/consulta_contacto').'/'.$id_contacto?>", {
			dataType: 'json',
			type: 'post',
			success: function(resultado)
			{
				if (resultado != null) {
					$('#editar_nombre').val(resultado[0]['contacto_nombre']);
					$('#editar_paterno').val(resultado[0]['contacto_ap_paterno']);
					$('#editar_materno').val(resultado[0]['contacto_ap_materno']);
					$('#editar_adscripcion').val(resultado[0]['contacto_adscripcion']);
					$('#editar_funciones').val(resultado[0]['contacto_funciones']);
					$('#editar_correoinst').val(resultado[0]['contacto_correo_inst']);
					$('#editar_correoper').val(resultado[0]['contacto_correo_per']);
					$('#editar_telefono').val(resultado[0]['contacto_telefono']);
					$('#editar_extension').val(resultado[0]['contacto_extension']);
					$('#instanciasgit').val(resultado[0]['instancia_nombre']);
					$('#id_instancia').val(resultado[0]['contacto_instancia']);
					$("input[name=estatus_contacto][value="+resultado[0]['contacto_estatus']+"]").prop('checked', true);
					$("input[name=tipo_contacto][value="+resultado[0]['contacto_tipo']+"]").prop('checked', true);
					$("input[name=instructor_candidato][value="+resultado[0]['contacto_instructor']+"]").prop('checked', true);
					$("input[name=comunicacion_contacto][value="+resultado[0]['contacto_comunicacion']+"]").prop('checked', true);
				}
			}
		});

        $.ajax("<?= site_url('contactos/consulta_instancias')?>", {
			dataType: 'json',
			type: 'post',
			success: function(resultado)
			{
				if (resultado != null) {

					var instancias = [];

					$.each(resultado, function( index, value ) {
						instancias.push({
							label : value['instancia_nombre'],
							value : value['id_instancia']
						});
					});

					$('#instancias').autocomplete({
						source: instancias,
						autoFocus: false,
						change: function(event, ui) {
							if(!ui.item){
								$("#instancias").val("");
							}
						},
						focus: function(event, ui) {
							return false;
						},
						select: function(event, ui) {
							$("#instancias").val( ui.item.label );
							$("#id_instancia").val( ui.item.value );

							return false;
						}
					});
				}
			}
		});

    });
</script>
<!-- inicia contenido -->
<div class="contenido_dinamico">
	<div id="migaDePan">
		<a href="<?= base_url()?>">Inicio</a> > 
		<a href="<?= site_url('contactos')?>">Administrar Contactos</a> > Editar contacto
	</div>

	<form id="frm_editar_contacto" action="<?= site_url('contactos/editar').'/'.$id_contacto?>" method="POST">
			<div class="contenedor_seccion_formulario">
				<label class="etiqueta_frm_nuevo">Estatus</label>
				<input type="radio" name="estatus_contacto" value="1" id="estatus_activo">
				<label for="estatus_activo">Activo</label>
				<input type="radio" name="estatus_contacto" value="0" id="estatus_inactivo">
				<label for="estatus_inactivo">Inactivo</label>
			</div>
			<div id="contenedor_imagen">
				<div id="contacto_imagen"></div>
				<input type="button" id="btn_examinar" value="Examinar">
			</div>
			<div class="contenedor_seccion_formulario">
				<label>* Tipo de contacto</label>
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
			<label class="etiqueta_frm_nuevo">* Nombre</label>
			<input type="text" maxlength="50" id="editar_nombre" name="contacto_nombre" class="validate[required]">
			<br>
			<label class="etiqueta_frm_nuevo">* Apellido paterno</label>
			<input type="text" maxlength="50" id="editar_paterno" name="contacto_apaterno" class="input_frm_nuevo validate[required]">
			<label class="etiqueta_frm_nuevo">* Apellido materno</label>
			<input type="text" maxlength="50" id="editar_materno" name="contacto_amaterno" class="validate[required]">
			<br>
			<p class="encabezado_form_nuevo_contacto">Datos laborales</p>
			<label class="etiqueta_frm_nuevo">* Instancia</label>
			<input type="text" name="contacto_instancia_nombre" id="instancias" class="input_frm_nuevo validate[required]">
			<input type="hidden" name="contacto_instancia" id="id_instancia" class="input_frm_nuevo validate[required]">
			<label class="etiqueta_frm_nuevo">&Aacute;rea de adscripci&oacute;n</label>
			<input type="text" maxlength="255" id="editar_adscripcion" name="contacto_adscripcion">
			<br><br><br>
			<label id="label_funciones">Descripci&oacute;n de funciones</label>
			<textarea name="contacto_funciones" id="editar_funciones" maxlength="255"></textarea>
			<br>
			<p class="encabezado_form_nuevo_contacto">Datos de Contacto</p>

			<div class="contenedor_seccion_formulario">
				<label class="etiqueta_frm_nuevo">* T&eacute;lefono</label>
				<input type="text" id="editar_telefono" name="contacto_telefono" size="10" maxlength="10" class="input_frm_nuevo validate[required,custom[telefono]]">
				<label id="etiqueta_ext">ext.</label>
				<input type="text" id="editar_extension" name="contacto_extension" size="5" maxlength="5" class="validate[custom[telefono]]">
			</div>

			<div id="contenedor_comunicacion">
				<label>* Medio de comunicaci&oacute;n preferente</label>
				<br><br>
				<input type="radio" name="comunicacion_contacto" value="0" id="comunicacion_tel" class="validate[required]">
				<label for="comunicacion_tel">V&iacute;a telef&oacute;nica</label>
				<br>
				<input type="radio" name="comunicacion_contacto" value="1" id="comunicacion_email" class="validate[required]">
				<label for="comunicacion_email">V&iacute;a e-mail</label>
			</div>
			<br>
			<label class="etiqueta_frm_nuevo">Correo institucional</label>
			<input type="text" maxlength="100" id="editar_correoinst" name="contacto_correoinst" class="custom[email], validate[groupRequired[correo]]">
			<br><br>
			<label class="etiqueta_frm_nuevo">Correo personal</label>
			<input type="text" maxlength="100" id="editar_correoper" name="contacto_correopers" class="validate[groupRequired[correo],custom[email]]">
			<br><br><br>
			<div id="botones_envio">
				<input type="submit" id="btn_guardar" value="Guardar">
			</div>
	</form>

</div>
<!-- termina contenido -->