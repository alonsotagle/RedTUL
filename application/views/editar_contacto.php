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
					$('#contacto_nombre').val(resultado[0]['contacto_nombre']);
					$('#contacto_paterno').val(resultado[0]['contacto_ap_paterno']);
					$('#contacto_materno').val(resultado[0]['contacto_ap_materno']);
					$('#contacto_adscripcion').val(resultado[0]['contacto_adscripcion']);
					$('#contacto_funciones').val(resultado[0]['contacto_funciones']);
					$('#contacto_correoinst').val(resultado[0]['contacto_correo_inst']);
					$('#contacto_correopers').val(resultado[0]['contacto_correo_per']);
					$('#contacto_telefono').val(resultado[0]['contacto_telefono']);
					$('#contacto_ext').val(resultado[0]['contacto_extension']);
					$('#contacto_instancias').val(resultado[0]['instancia_nombre']);
					$('#id_instancia').val(resultado[0]['contacto_instancia']);
					$("input[name=estatus_contacto][value="+resultado[0]['contacto_estatus']+"]").prop('checked', true);
					$("input[name=tipo_contacto][value="+resultado[0]['contacto_tipo']+"]").prop('checked', true);
					$("input[name=instructor_candidato][value="+resultado[0]['contacto_instructor']+"]").prop('checked', true);
					$("input[name=comunicacion_contacto][value="+resultado[0]['contacto_comunicacion']+"]").prop('checked', true);

					$('#contacto_avatar_old').val(resultado[0]['contacto_avatar']);

					if (resultado[0]['contacto_avatar'] != "") {
						url = "<?= base_url('assets/img_avatar') ?>";
						url += "/"+resultado[0]['contacto_avatar'];
						$('#contacto_imagen').attr('src', url);
					}
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

		$(document).tooltip();

    });
</script>
<!-- inicia contenido -->
<div class="contenido_dinamico">
	<div id="migaDePan">
		<a href="<?= base_url()?>">Inicio</a> > 
		<a href="<?= site_url('contactos')?>">Administrar Contactos</a> > Editar contacto
	</div>

	<form id="frm_editar_contacto" action="<?= site_url('contactos/editar').'/'.$id_contacto?>" method="POST" enctype="multipart/form-data">
			<div class="contenedor_seccion_formulario">
				<label>Estatus</label>
				<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Indica el estado en el que se encuentra la cuenta del usuario." class="icon_tooltip">
				<input type="radio" name="estatus_contacto" value="1" id="estatus_activo">
				<label for="estatus_activo">Activo</label>
				<input type="radio" name="estatus_contacto" value="0" id="estatus_inactivo">
				<label for="estatus_inactivo">Inactivo</label>
			</div>
			<div id="contenedor_imagen">
				<img src="<?= base_url('assets/img/avatar.png') ?>" id="contacto_imagen">
				<input type="file" id="contacto_avatar" name="contacto_avatar">
				<input type="hidden" id="contacto_avatar_old" name="contacto_avatar_old">
			</div>
			<div class="contenedor_seccion_formulario">
				<label>* Tipo de contacto</label>
				<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Indica el rol que tiene el contacto dentro de la instancia a la que pertenece.">
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
			<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Indica si un contacto ha sido o se ha postulado como instructor de un determinado curso." class="icon_tooltip">
			<input type="radio" name="instructor_candidato" value="1" id="instructor_si">
			<label for="instructor_si">S&iacute;</label>
			<input type="radio" name="instructor_candidato" value="0" id="instructor_no">
			<label for="instructor_no">No</label>
			<br>
			<p class="encabezado_form_nuevo_contacto">Datos Generales</p>
			<label class="etiqueta_frm" for="contacto_nombre">* Nombre</label>
			<input type="text" maxlength="50" id="contacto_nombre" name="contacto_nombre" class="validate[required]">
			<br>
			<label class="etiqueta_frm" for="contacto_paterno">* Apellido paterno</label>
			<input type="text" maxlength="50" id="contacto_paterno" name="contacto_apaterno" class="input_frm_nuevo validate[required]">
			<label for="contacto_materno">* Apellido materno</label>
			<input type="text" maxlength="50" id="contacto_materno" name="contacto_amaterno" class="validate[required]">
			<br>
			<p class="encabezado_form_nuevo_contacto">Datos laborales</p>
			<label for="contacto_instancias">* Instancia</label>
			<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Se refiere a la entidad o dependencia a la que pertenece el contacto.">
			<input type="search" name="contacto_instancia_nombre" id="contacto_instancias" class="input_frm_nuevo validate[required]">
			<input type="hidden" name="contacto_instancia" id="id_instancia" class="input_frm_nuevo validate[required]">
			<label for="contacto_adscripcion">&Aacute;rea de adscripci&oacute;n</label>
			<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Indica el área de la instancia a la que pertenece.">
			<input type="text" maxlength="255" id="contacto_adscripcion" name="contacto_adscripcion">
			<br><br><br>
			<label for="contacto_funciones" class="label_funciones">Descripci&oacute;n de funciones</label>
			<textarea id="contacto_funciones" name="contacto_funciones" cols="50" rows="4" maxlength="255" placeholder="Ingrese una breve descripción de los roles que desempeña el contacto."></textarea>
			<br>
			<p class="encabezado_form_nuevo_contacto">Datos de Contacto</p>

			<div class="contenedor_seccion_formulario">
				<label for="contacto_telefono">* T&eacute;lefono</label>
				<input type="text" id="contacto_telefono" name="contacto_telefono" size="10" maxlength="10" class="input_frm_nuevo validate[required,custom[telefono]]">
				<label for="contacto_ext" id="etiqueta_ext">ext.</label>
				<input type="text" id="contacto_ext" name="contacto_extension" size="5" maxlength="5" class="validate[custom[telefono]]">
			</div>

			<div id="contenedor_comunicacion">
				<label>* Medio de comunicaci&oacute;n preferente</label>
				<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Se refiere al medio de comunicación que el contacto prefiere.">
				<br><br>
				<input type="radio" name="comunicacion_contacto" value="0" id="comunicacion_tel" class="validate[required]">
				<label for="comunicacion_tel">V&iacute;a telef&oacute;nica</label>
				<br>
				<input type="radio" name="comunicacion_contacto" value="1" id="comunicacion_email" class="validate[required]">
				<label for="comunicacion_email">V&iacute;a e-mail</label>
			</div>
			<br>
			<label for="contacto_correoinst">Correo institucional</label>
			<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Correo electrónico institucional con la que cuenta el usuario.">
			<input type="text" maxlength="100" id="contacto_correoinst" name="contacto_correoinst" class="custom[email], validate[groupRequired[correo]]">
			<br><br>
			<label for="contacto_correopers">Correo personal</label>
			<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Es un correo electrónico alterno al institucional.">
			<input type="text" maxlength="100" id="contacto_correopers" name="contacto_correopers" class="validate[groupRequired[correo],custom[email]]">
			<br><br><br>
			<div id="botones_envio">
				<input type="submit" id="btn_guardar" value="Guardar">
			</div>
	</form>

</div>
<!-- termina contenido -->