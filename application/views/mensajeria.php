<script>
    $(document).ready(function(){

    	$("#menu_mensajeria").addClass("seleccion_menu");

        $("#frm_buscar_correo").validationEngine({promptPosition: "centerRight"});
		$("#frm_correo_destinatarios").validationEngine({promptPosition: "centerRight"});
		$("#form_plantilla").validationEngine({promptPosition: "centerRight"});
		$("#frm_enviar_correo").validationEngine({promptPosition: "centerRight"});

        $(function() {
	    	$("#tabs").tabs({ active: <?= $tab ?>});
	    	$("#tabs_enviar_correo").tabs();
	    	$("#tabs_correo_cuerpo").tabs();
	    	$("#tabs_correo_plantilla").tabs();
		});

        $("#btn_programar_correo").prop('disabled', true);

		$.ajax({
			url: "<?= site_url('mensajeria/consulta_correos') ?>",
			dataType: 'json',
			type: 'post',
			success: function(resultado) {
				if (resultado) {
					$.each(resultado, function(index, value) {
						$('#tabla_correos tbody').append('<tr>\
							<td>'+value['correo_asunto']+'</td>\
							<td>'+value['correo_fecha_creacion']+'</td>\
							<td>'+value['correo_fecha_envio']+'</td>\
							<td></td>\
							<td>\
							<img id='+value['id_correo']+' class="img_editar_plantilla"\
							src="'+"<?= base_url('assets/img/icono_editar.png')?>"+'">\
							</td>\
							<td><a \
							href="'+"<?= site_url('mensajeria')?>"+'">\
							<img \
							src="'+"<?= base_url('assets/img/icono_borrar.png')?>"+'">\
							</a></td>\
						</tr>');
					});
				}
			}
		});

		$("#btn_buscar_correo").click(function(event){
			event.preventDefault();
			if ($("#frm_buscar_correo").validationEngine('validate')) {
				var datos = {
					'correo_asunto' 		: $('#asunto_correo').val(),
					'correo_fecha_envio' 	: $('#fecha_envio_correo').val(),
					'correo_estatus' 		: $('#estatus_correo').val()
				};

				$.ajax({
					url: "<?= site_url('mensajeria/busqueda_correos') ?>",
					data: datos,
					dataType: 'json',
					type: 'post',
					success: function(resultado) {
						if (resultado) {
							$('#tabla_correos tbody').find("tr:gt(0)").remove();
							$.each(resultado, function(index, value) {
								$('#tabla_correos tbody').append('<tr>\
									<td>'+value['correo_asunto']+'</td>\
									<td>'+value['correo_fecha_creacion']+'</td>\
									<td>'+value['correo_fecha_envio']+'</td>\
									<td></td>\
									<td>\
									<img id='+value['id_correo']+' class="img_editar_plantilla"\
									src="'+"<?= base_url('assets/img/icono_editar.png')?>"+'">\
									</td>\
									<td><a \
									href="'+"<?= site_url('mensajeria')?>"+"/"+value['id_correo']+'">\
									<img \
									src="'+"<?= base_url('assets/img/icono_borrar.png')?>"+'">\
									</a></td>\
								</tr>');
							});
						}else{
							$('#tabla_correos tbody').find("tr:gt(0)").remove();
						}
					}
				});
			}
		});

		$("#nuevo_correo_plantilla").on("change", function(){
			if ($(this).val() == "") {
				$('#nuevo_correo_asunto').val('');
				$('#tab-textoplano textarea').val('');
				$('#tab-html textarea').val('');
				$("#tabs_correo_cuerpo").tabs("enable");
			}else{
				$.ajax({
					url: "<?= site_url('mensajeria/consulta_plantilla') ?>"+"/"+$(this).val(),
					dataType: 'json',
					type: 'post',
					success: function(resultado) {
						$('#tab-textoplano textarea').val('');
						$('#tab-html textarea').val('');
						$("#tabs_correo_cuerpo").tabs("enable");

						$('#nuevo_correo_asunto').val(resultado[0]['plantilla_asunto']);

						if (resultado[0]['plantilla_tipo_contenido'] == 0) {
							$("#tabs_correo_cuerpo").tabs("disable", 1);
							$("#tabs_correo_cuerpo").tabs("option", "active", 0);
							$("#tab-textoplano textarea").val(resultado[0]['plantilla_contenido']);
						}else{
							$("#tabs_correo_cuerpo").tabs("disable", 0);
							$("#tabs_correo_cuerpo").tabs("option", "active", 1);
							$("#tab-html textarea").val(resultado[0]['plantilla_contenido']);
						}
					}
				});
			}
		});

		$("#programar_correo_fecha").datepicker({
			changeMonth: true,
			numberOfMonths: 2,
			minDate: 0,
			showOn: "both",
			buttonImage: "<?= base_url('assets/img/calendar.gif')?>",
			buttonImageOnly: true
		});

		$.ajax({
			url: "<?= site_url('mensajeria/consulta_cursos') ?>",
			dataType: 'json',
			type: 'post',
			success: function(resultado) {
				if (resultado) {
					$.each(resultado, function(index, value) {
						$("#lista_cursos").append("<option value='"+value['id_curso']+"'>"+value['curso_titulo']+"</option>");
					});
				}
			}
		});

		$("#programar_correo_fecha").prop('disabled', true);
		$("#programar_correo_hora").prop('disabled', true);
		$("input[name=envio]").change(function(){
			if ($('input[name=envio]:checked').val() == 1) {
				$("#programar_correo_fecha").prop('disabled', false);
				$("#programar_correo_hora").prop('disabled', false);
				$("#programar_correo_fecha").addClass("validate[required] datepicker");
				$("#programar_correo_hora").addClass("validate[required]");
			}else{
				$("#programar_correo_fecha").prop('disabled', true);
				$("#programar_correo_hora").prop('disabled', true);
				$("#frm_enviar_correo").validationEngine('hide');
				$("#programar_correo_fecha").removeClass("validate[required] datepicker");
				$("#programar_correo_hora").removeClass("validate[required]");
			}
		});

		$("#btn_correo_obtener_url").click(function(){
			event.preventDefault();
			if ($("#frm_curso_destinatarios").validationEngine('validate') && $("#lista_cursos").val() != "") {

				tab_activo_contenido_correo = $("#tabs_correo_cuerpo").tabs("option", "active");
				if (tab_activo_contenido_correo == 0) {
					$("#tabs_correo_cuerpo").tabs("disable", 1);
					$("#tab-html textarea").val("");
					valor_contenido_textarea = $("#tab-textoplano textarea").val();
					valor_contenido_textarea += "\n\nPágina para incribirse:\n<a href='<?= site_url('confirmacion') ?>/"+$("#lista_cursos").val()+"'>Inscribirse a evento</a>";
					$("#tab-textoplano textarea").val(valor_contenido_textarea);
				}else{
					$("#tabs_correo_cuerpo").tabs("disable", 0);
					$("#tab-textoplano textarea").val("");
					valor_contenido_textarea = $("#tab-html textarea").val();
					valor_contenido_textarea += "\n\nPágina para incribirse:\n<a href='<?= site_url('confirmacion') ?>/"+$("#lista_cursos").val()+"'>Inscribirse a evento</a>";
					$("#tab-html textarea").val(valor_contenido_textarea);
				}
				$("#tabs_enviar_correo").tabs("option", "active", 0);
			}
		});

		$("#btn_buscar_contacto").click(function(){
			event.preventDefault();
			if ($("#frm_correo_destinatarios").validationEngine('validate')) {
				var datos = {
					'tipo' 		: $('#tipo_contacto').val(),
					'nombre' 	: $('#nombre_contacto').val(),
					'correo' 	: $('#correo_contacto').val(),
					'instancia' : $('#instancia_contacto').val()
				};

				$.ajax({
					url: "<?= site_url('mensajeria/consulta_contactos') ?>",
					data: datos,
					dataType: 'json',
					type: 'post',
					success: function(resultado) {
						if (resultado) {
							$('#tabla_buscar_destinatarios tbody').find("tr:gt(0)").remove();
							$.each(resultado, function(index, value) {
								$('#tabla_buscar_destinatarios tbody').append('<tr>\
									<td>'+value['contacto_nombre']+' '+value['contacto_ap_paterno']+' '+value['contacto_ap_materno']+'</td>\
									<td>'+value['contacto_correo_inst']+' '+value['contacto_correo_per']+'</td>\
									<td>'+value['contacto_telefono']+'</td>\
									<td>'+value['tipo_contacto_descripcion']+'</td>\
									<td>'+value['instancia_nombre']+'</td>\
									<td>\
										<input type="checkbox" name="curso_invitados[]" value="'+value['id_contacto']+'">\
									</td>\
								</tr>');
							});
						}else{
							$('#tabla_buscar_destinatarios tbody').find("tr:gt(0)").remove();
						}
					}
				});
			}
		});

		$("#btn_correo_anadir_destinatarios").click(function(){
			event.preventDefault();

			if ($("input[name='curso_invitados[]']:checked").length != 0) {

				var ids_contacto = new Array();
				$("input[name='curso_invitados[]']:checked").each(function() {
					ids_contacto.push($(this).val());
				});

				var input = $("<input>")
               .attr("type", "hidden")
               .attr("name", "id_destinatarios").val(ids_contacto);
				$('#frm_enviar_correo').append($(input));

				$("#tabs_enviar_correo").tabs("option", "active", 0);

				$("#btn_programar_correo").prop('disabled', false);
			}
		});

		$.ajax({
			url: "<?= site_url('mensajeria/consulta_plantillas') ?>",
			dataType: 'json',
			type: 'post',
			async: false,
			success: function(resultado) {
				if (resultado) {
					$.each(resultado, function(index, value) {
						$('#tabla_plantillas tbody').append('<tr>\
							<td>'+value['plantilla_asunto']+'</td>\
							<td>\
							<img id='+value['id_plantilla_correo']+' class="img_editar_plantilla"\
							src="'+"<?= base_url('assets/img/icono_editar.png')?>"+'">\
							</td>\
							<td><a \
							href="'+"<?= site_url('mensajeria/plantilla_eliminar')?>"+"/"+value['id_plantilla_correo']+'">\
							<img \
							src="'+"<?= base_url('assets/img/icono_borrar.png')?>"+'">\
							</a></td>\
						</tr>');
						$('#nuevo_correo_plantilla').append("<option value='"+value['id_plantilla_correo']+"'>"+value['plantilla_asunto']+"</option>");
					});
				}
			}
		});

		$('#tab-textoplano textarea').change('input propertychange', function(){
			if ($('#tab-textoplano textarea').val() != "") {
				$("#tabs_correo_cuerpo").tabs("disable", 1);
			}else{
				$("#tabs_correo_cuerpo").tabs("enable");
			}
		});

		$('#tab-html textarea').change('input propertychange', function(){
			if ($('#tab-html textarea').val() != "") {
				$("#tabs_correo_cuerpo").tabs("disable", 0);
			}else{
				$("#tabs_correo_cuerpo").tabs("enable");
			}
		});

		$('textarea[name=plantilla_contenido_plano]').change('input propertychange', function(){
			if ($('textarea[name=plantilla_contenido_plano]').val() != "") {
				$("#tabs_correo_plantilla").tabs("disable", 1);
			}else{
				$("#tabs_correo_plantilla").tabs("enable");
			}
		});

		$('textarea[name=plantilla_contenido_html]').change('input propertychange', function(){
			if ($('textarea[name=plantilla_contenido_html]').val() != "") {
				$("#tabs_correo_plantilla").tabs("disable", 0);
			}else{
				$("#tabs_correo_plantilla").tabs("enable");
			}
		});

		$("#btn_correo_plantilla").click(function(){
			if ($("#form_plantilla").validationEngine('validate')) {
				if ($('#plantilla_id').val() == "") {
					$('#form_plantilla').attr("action", <?php echo('"'.site_url('mensajeria/registrar_plantilla').'"'); ?> );
				}else{
					$('#form_plantilla').attr("action", <?php echo('"'.site_url('mensajeria/editar_plantilla').'"'); ?> );
				}
			}
		});

		$("#tabla_plantillas").on( "click", ".img_editar_plantilla", function() {
			$.ajax({
				url: "<?= site_url('mensajeria/consulta_plantilla') ?>"+"/"+$(this).attr('id'),
				dataType: 'json',
				type: 'post',
				success: function(resultado) {
					$('textarea[name=plantilla_contenido_plano]').val('');
					$('textarea[name=plantilla_contenido_html]').val('');
					$("#tabs_correo_plantilla").tabs("enable");

					$('input[name=plantilla_asunto]').val(resultado[0]['plantilla_asunto']);
					$('input[name=plantilla_id]').val(resultado[0]['id_plantilla_correo']);

					if (resultado[0]['plantilla_tipo_contenido'] == 0) {
						$("#tabs_correo_plantilla").tabs("disable", 1);
						$("#tabs_correo_plantilla").tabs( "option", "active", 0);
						$('textarea[name=plantilla_contenido_plano]').val(resultado[0]['plantilla_contenido']);
					}else{
						$("#tabs_correo_plantilla").tabs("disable", 0);
						$("#tabs_correo_plantilla").tabs( "option", "active", 1);
						$('textarea[name=plantilla_contenido_html]').val(resultado[0]['plantilla_contenido']);
					}
				}
			});
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
			<form id="frm_buscar_correo" method="POST">
				<label for="asunto_correo">Asunto</label>
				<input type="text" id="asunto_correo" maxlength="255" name="asunto_correo" class="input_buscar_correo validate[groupRequired[buscar_correo]]"/>

				<label for="fecha_envio_correo">Fecha de env&iacute;o</label>
				<select name="fecha_envio_correo" id="fecha_envio_correo" class="input_buscar_correo validate[groupRequired[buscar_correo]]" value="">
					<option selected value="">- Elija un tipo -</option>
					<option value="1">El &uacute;ltimo año</option>
					<option value="2">El &uacute;ltimo mes</option>
					<option value="3">La &uacute;ltima semana</option>
					<option value="4">Un d&iacute;a anterior</option>
				</select>

				<label for="estatus_correo">Estatus de env&iacute;o</label>
				<select name="estatus_correo" id="estatus_correo" class="input_buscar_correo validate[groupRequired[buscar_correo]]" value="">
					<option selected value="">- Elija un tipo -</option>
					<option value="1">Pendiente</option>
					<option value="2">Cancelado</option>
					<option value="3">Enviado</option>
				</select>
				<input type="submit" id="btn_buscar_correo" value="Buscar"/>
			</form>

			<table id="tabla_correos" class='tables'>
				<tr>
					<td>Asunto</td>
					<td>Fecha de creaci&oacute;n</td>
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
					<label class="label_nuevo_correo" for="nuevo_correo_plantilla">Usar plantilla</label>
					<select id="nuevo_correo_plantilla" class="input_envia_correo">
						<option selected value="">- Seleccione una opci&oacute;n -</option>
					</select>
					<br>
					<form id="frm_enviar_correo" action="<?= site_url('mensajeria/mandar_correo') ?>" method="POST" enctype="multipart/form-data">
						<label class="label_nuevo_correo" for="nuevo_correo_asunto">Asunto</label>
						<input type="text" class="input_envia_correo validate[required]" id="nuevo_correo_asunto" size="50" name="asunto">
						<br>
						<label class="label_nuevo_correo">Datos adjuntos</label>
						<input type="file" id="nuevo_correo_archivos_adjuntos" name="userfile">
						<br>
						<div id="tabs_correo_cuerpo">
							<ul>
								<li><a href="#tab-textoplano">Texto plano</a></li>
								<li><a href="#tab-html">HTML</a></li>
							</ul>
							<div id="tab-textoplano">
								<textarea spellcheck="false" class="textarea_cuerpo_correo validate[groupRequired[nuevo_correo_contenido]]" data-prompt-position="topLeft" name="contenido_plano"></textarea>
							</div>
							<div id="tab-html">
								<textarea spellcheck="false" class="textarea_cuerpo_correo validate[groupRequired[nuevo_correo_contenido]]" data-prompt-position="topLeft" name="contenido_html"></textarea>
							</div>
						</div>
						<b id="titulo_programar_envio_correo">Env&iacute;o</b>
						<div class="programar_envio_correo">
							<input type="radio" name="envio" id="programar_correo_inmed" class="validate[required] radio" value="0">
							<label for="programar_correo_inmed">Enviar inmediatamente</label>
						</div>
						<div class="programar_envio_correo programar_envio_correo_posterior">
							<input type="radio" name="envio" id="programar_correo_posterior" class="input_envia_correo validate[required] radio" value="1">
							<label for="programar_correo_posterior" class="label_nuevo_correo">Programar env&iacute;o</label>
							<br>
							<label class="label_nuevo_correo" for="programar_correo_fecha">* Fecha de env&iacute;o</label>
							<input class="input_envia_correo" id="programar_correo_fecha" name="fecha_envio" data-prompt-position="topLeft">
							<br>
							<label class="label_nuevo_correo" for="programar_correo_hora">* Hora de env&iacute;o</label>
							<input type="time" class="input_envia_correo" id="programar_correo_hora" name="hora_envio" data-prompt-position="topLeft">
							<br>
						</div>
						<input type="submit" id="btn_programar_correo">
					</form>
				</div>
				<div id="tab-dest">
					<fieldset id="fieldset_destinatarios_curso">
						<legend>Destinatarios(Cursos)
							<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="?" class="icon_tooltip">
						</legend>
						<form id="frm_curso_destinatarios">
							<label for="lista_cursos">T&iacute;tulo de curso</label>
							<select id="lista_cursos" class="validate[required]">
								<option selected value="">- Seleccione una opci&oacute;n -</option>
							</select>
							<input type="submit" id="btn_correo_obtener_url" value="Obtener URL de registro en l&iacute;nea">
						</form>
					</fieldset>
					<fieldset id="fieldset_destinatarios_contacto">
						<legend>Destinatarios(Por contacto)
							<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="?" class="icon_tooltip">
						</legend>
						<form id="frm_correo_destinatarios" method="POST">
							<label for="tipo_contacto">Tipo de contacto</label>
							<select name="tipo_contacto" value="" id="tipo_contacto" class="input_correo_buscar_destinatario validate[groupRequired[buscar_destinatario_contacto]]" form="frm_correo_destinatarios">
								<option selected value="">- Elija un tipo -</option>
								<option value="1">Webmaster</option>
								<option value="2">Responsable de comunicaci&oacute;n</option>
								<option value="3">Responsable técnico</option>
								<option value="4">Otros</option>
							</select>
							<label for="nombre_contacto">Nombre</label>
							<input type="text" id="nombre_contacto" maxlength="100" name="nombre_contacto" class="input_correo_buscar_destinatario validate[groupRequired[buscar_destinatario_contacto]]" form="frm_correo_destinatarios">
							<label for="correo_contacto">Correo electr&oacute;nico</label>
							<input type="text" id="correo_contacto" maxlength="100" name="correo_contacto" class="input_correo_buscar_destinatario validate[groupRequired[buscar_destinatario_contacto]]" form="frm_correo_destinatarios">
							<label for="instancia_contacto">Instancia</label>
							<input type="text" id="instancia_contacto" name="instancia_contacto" class="input_correo_buscar_destinatario validate[groupRequired[buscar_destinatario_contacto]]" form="frm_correo_destinatarios">
							<input type="submit" id="btn_buscar_contacto" value="Buscar" form="frm_correo_destinatarios"/>
						</form>
						<table id="tabla_buscar_destinatarios" class='tables'>
							<tr>
								<td>Nombre completo</td>
								<td>Correo electr&oacute;nico</td>
								<td>Tel&eacute;fono</td>
								<td>Tipo de contacto</td>
								<td>Instancia</td>
								<td>Añadir</td>
							</tr>
						</table>
					</fieldset>
					<input type="submit" id="btn_correo_anadir_destinatarios" value="Añadir destinatarios">
				</div>
			</div>
		</div>
		<div id="tabs-3">

			<table class='tables' id="tabla_plantillas">
				<tr>
					<td>Asunto</td>
					<td>Editar</td>
					<td>Eliminar</td>
				</tr>
			</table>

			<form id="form_plantilla" method="POST">
				<label for="plantilla_asunto">Asunto</label>
				<input type="text" maxlength="255" name="plantilla_asunto" id="plantilla_asunto" class="validate[required]" form="form_plantilla"/>
				<input type="hidden" name="plantilla_id" id="plantilla_id" form="form_plantilla">
				<div id="tabs_correo_plantilla">
					<ul>
						<li><a href="#tab-plantilla_textoplano">Texto plano</a></li>
						<li><a href="#tab-plantilla_html">HTML</a></li>
					</ul>
					<div id="tab-plantilla_textoplano">
						<textarea spellcheck="false" class="textarea_cuerpo_correo validate[groupRequired[plantilla_contenido]]" data-prompt-position="topLeft" name="plantilla_contenido_plano" form="form_plantilla"></textarea>
					</div>
					<div id="tab-plantilla_html">
						<textarea spellcheck="false" class="textarea_cuerpo_correo validate[groupRequired[plantilla_contenido]]" data-prompt-position="topLeft" name="plantilla_contenido_html" form="form_plantilla"></textarea>
					</div>
				</div>
				<input type="submit" id="btn_correo_plantilla" value="Aceptar" form="form_plantilla">
			</form>
		</div>
</div>
<!-- termina contenido -->