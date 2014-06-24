<script>
    $(document).ready(function(){

		$("#informacion_contacto").hide();
		$("#botones_asistencia").hide();

    	$("#verificar_correo").click(function(){
    		event.preventDefault();
    		if ($("#frm_validar_correo").validationEngine('validate')) {
	    		$("#bloque_ingresar_correo").fadeOut("fast");

	    		var datos = {
	    						'correo'	: $("#input_verificar_correo").val(),
	    						'id_curso'	: <?= $id_curso ?>};

	    		$.ajax({
					url: "<?= site_url('confirmacion/verifica_contacto') ?>",
					data: datos,
					dataType: 'json',
					type: 'post',
					success: function(resultado) {
						if (resultado) {

							if (resultado["invitado"]) {
								$("#confirmacion_id_contacto").val(resultado["id_contacto"]);
								$("#cancelacion_id_contacto").val(resultado["id_contacto"]);

								$("#invitado_nombre").text(resultado["contacto_nombre"]);
								$("#invitado_ap_paterno").text(resultado["contacto_ap_paterno"]);
								$("#invitado_ap_materno").text(resultado["contacto_ap_materno"]);
								$("#invitado_instancia").text(resultado["instancia_nombre"]);
								$("#id_instancia").val(resultado["id_instancia"]);
								$("#invitado_estatus").text(resultado["contacto_estatus"]);

								if (resultado["contacto_adscripcion"] != "") {
									$("#titulo_adscripcion").text("Área de adscrición");
									$("#invitado_adscripcion").text(resultado["contacto_adscripcion"]);
								}else{
									$("#titulo_adscripcion").remove();
									$("#invitado_adscripcion").remove();
								}

								$("#informacion_contacto").show();
								$("#botones_asistencia").show();
							} else {
								$.blockUI({
									message: "<h3>No está invitado a este curso.</h3>",
									timeout: 4000,
									css: {
										backgroundColor: '#f0ad4e',
										color: '#fff',
										padding: 3,
										border: '1px solid #eea236',
										'-webkit-border-radius': '10px', 
										'-moz-border-radius': '10px'
									}
								});
							}
						} else {
							$.blockUI({
								message: "<h3>Verificar correo electrónico ingresado.</h3>",
								timeout: 2000,
								css: {
									backgroundColor: '#d9534f',
									color: '#fff',
									padding: 3,
									border: '1px solid #d43f3a',
									'-webkit-border-radius': '10px', 
									'-moz-border-radius': '10px'
								}
							});
							$("#bloque_ingresar_correo").fadeIn("fast");
						}
					}
				});
			}
    	});

		$("#datos_correctos").click(function(){
			$("#verificar_datos").fadeOut();
		});

		$("#datos_incorrectos").click(function(){
			$("#verificar_datos").empty().append("<button id='guardar_datos'>Guardar datos</button>");

			var input_nombre = $("<input>")
			.attr("type", "text")
			.attr("id", "invitado_nombre")
			.attr("placeholder", "Nombre")
			.attr("maxlength", "50")
			.attr("value", $("#invitado_nombre").text())
			.addClass("validate[required]");
			$("#invitado_nombre").replaceWith(input_nombre);

			var input_ap_paterno = $("<input>")
			.attr("type", "text")
			.attr("id", "invitado_ap_paterno")
			.attr("placeholder", "Apellido Paterno")
			.attr("maxlength", "50")
			.attr("value", $("#invitado_ap_paterno").text())
			.addClass("validate[required]");
			$("#invitado_ap_paterno").replaceWith(input_ap_paterno);

			var input_ap_materno = $("<input>")
			.attr("type", "text")
			.attr("id", "invitado_ap_materno")
			.attr("placeholder", "Apellido Materno")
			.attr("maxlength", "50")
			.attr("value", $("#invitado_ap_materno").text())
			.addClass("validate[required]");
			$("#invitado_ap_materno").replaceWith(input_ap_materno);

			if($("#invitado_adscripcion").text() != "") {
				var input_adscripcion = $("<input>")
				.attr("type", "text")
				.attr("id", "invitado_adscripcion")
				.attr("placeholder", "Área de Adscripción")
				.attr("maxlength", "255")
				.attr("value", $("#invitado_adscripcion").text());
				$("#invitado_adscripcion").replaceWith(input_adscripcion);
			}

			var input_instancia = $("<input>")
			.attr("type", "search")
			.attr("placeholder", "Instancia")
			.attr("id", "nombre_instancias")
			.attr("value", $("#invitado_instancia").text())
			.addClass("lupa_instancias validate[required]");
			$("#invitado_instancia").replaceWith(input_instancia);

			consulta_instancias();

		});

		function consulta_instancias(){
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

						$('#nombre_instancias').autocomplete({
							source: instancias,
							change: function(event, ui) {
								if(!ui.item){
									$("#nombre_instancias").val("");
								}
							},
							focus: function(event, ui) {
								return false;
							},
							select: function(event, ui) {
								$("#nombre_instancias").val( ui.item.label );
								$("#id_instancia").val( ui.item.value );

								return false;
							}
						});
					}
				}
			});
		}

		$("#verificar_datos").on("click","#guardar_datos",function(){
			var nombre 		= $("#invitado_nombre").validationEngine('validate');
			var paterno 	= $("#invitado_ap_paterno").validationEngine('validate');
			var materno 	= $("#invitado_ap_materno").validationEngine('validate');
			var instancia 	= $("#nombre_instancias").validationEngine('validate');

			if (!nombre && !paterno && !materno && !instancia) {
				var datos = {'id_contacto'			: $("#confirmacion_id_contacto").val(),
	    					'contacto_nombre'		: $("#invitado_nombre").val(),
	    					'contacto_ap_paterno'	: $("#invitado_ap_paterno").val(),
	    					'contacto_ap_materno'	: $("#invitado_ap_materno").val(),
	    					'contacto_instancia'	: $("#id_instancia").val(),
	    					'contacto_adscripcion'	: $("#invitado_adscripcion").val()};

	    		$.ajax({
					url: "<?= site_url('confirmacion/actualizar_contacto') ?>",
					data: datos,
					dataType: 'json',
					type: 'post',
					complete: function(resultado) {
						$.blockUI({
							message: "<h3>Información actualizada</h3>",
							timeout: 2000,
							css: {
								backgroundColor: '#5cb85c',
								color: '#fff',
								padding: 3,
								border: '1px solid #4cae4c',
								'-webkit-border-radius': '10px', 
								'-moz-border-radius': '10px'
							}
						});

						var p_nombre = $("<p>")
						.attr("id", "invitado_nombre")
						.text($("#invitado_nombre").val())
						.addClass("confirmacion_info");
						$("#invitado_nombre").replaceWith(p_nombre);

						var p_ap_paterno = $("<p>")
						.attr("id", "invitado_ap_paterno")
						.text($("#invitado_ap_paterno").val())
						.addClass("confirmacion_info");
						$("#invitado_ap_paterno").replaceWith(p_ap_paterno);

						var p_ap_materno = $("<p>")
						.attr("id", "invitado_ap_materno")
						.text($("#invitado_ap_materno").val())
						.addClass("confirmacion_info");
						$("#invitado_ap_materno").replaceWith(p_ap_materno);

						if($("#invitado_adscripcion").val() != "") {
							var p_adscripcion = $("<p>")
							.attr("id", "invitado_adscripcion")
							.text($("#invitado_adscripcion").val())
							.addClass("confirmacion_info");
							$("#invitado_adscripcion").replaceWith(p_adscripcion);
						}

						var p_instancia = $("<p>")
						.attr("id", "invitado_instancia")
						.text($("#nombre_instancias").val())
						.addClass("confirmacion_info");
						$("#nombre_instancias").replaceWith(p_instancia);

						$("#verificar_datos").hide();
					}
				});
			}
		});

		$("#cancelar_asistencia").click(function(){

			$.blockUI({
				message: $('#form_cancelar')
			});
			$('.blockOverlay').click($.unblockUI);
		});
    });
</script>
<!-- inicia contenido -->
<div id="contenido_confirmacion">

	<div id="bloque_ingresar_correo">
		<p>Por favor compruebe su identidad, ingresando el correo al que le fue enviada la invitación al curso de <strong><?= $curso_titulo ?></strong>.</p>
		<form id="frm_validar_correo">
			<input type="text" id="input_verificar_correo" class="validate[required,custom[email]]" data-prompt-position="topLeft:355">
			<input type="submit" value="OK" id="verificar_correo">
		</form>
	</div>

	<div id="informacion_contacto" class="bloque_informacion">
		<p class='confirmacion_titulos_datos'>Datos de invitado</p>
		<p class='confirmacion_titulos_info'>Nombre</p>
		<p id="invitado_nombre" class='confirmacion_info'></p>
		<p id="invitado_ap_paterno" class='confirmacion_info'></p>
		<p id="invitado_ap_materno" class='confirmacion_info'></p>
		<p class='confirmacion_titulos_info'>Instancia</p>
		<p id="invitado_instancia" class='confirmacion_info'></p>
		<input type="hidden" name="invitado_instancia" id="id_instancia" class="validate[required]">
		<p id="titulo_adscripcion" class='confirmacion_titulos_info'></p>
		<p id='invitado_adscripcion' class='confirmacion_info'></p>

		<p class='confirmacion_titulos_info'>Estatus de registro</p>
		<p id="invitado_estatus" class='confirmacion_info'></p>
		
		<div id="verificar_datos">
			<br><span class=''>¿Son correctos los datos?</span>
			<button id='datos_correctos'>Si</button>
			<button id='datos_incorrectos'>No</button>
		</div>
	</div>

	<div id="informacion_curso" class="bloque_informacion">
		<br>
		<p class='confirmacion_titulos_datos'>Datos de evento</p>
		<br>
		<p class='confirmacion_titulos_info'>T&iacute;tulo</p>
		<p class='confirmacion_info'><?= $curso_titulo ?></p>
		<br>
		<p class='confirmacion_titulos_info'>Descripci&oacute;n</p>
		<p class='confirmacion_info'><?= $curso_descripcion ?></p>
		<br>
		<p class='confirmacion_titulos_info'>Objetivos</p>
		<p class='confirmacion_info'><?= $curso_objetivos ?></p>
		<br>
		<p class='confirmacion_titulos_info'>Fecha</p>
		<p class='confirmacion_info'><?= $curso_fecha_inicio."   a   ".$curso_fecha_fin ?></p>
		<br>
		<p class='confirmacion_titulos_info'>Horario</p>
		<p class='confirmacion_info'><?= $curso_hora_inicio." - ".$curso_hora_fin ?></p>
		<br>
		<?php if($curso_cupo != "") : ?>
			<p class='confirmacion_titulos_info'>Cupo</p>
			<p class='confirmacion_info'><?= $curso_cupo ?></p>
			<br>
		<?php endif; ?>
		<?php if($curso_ubicacion != "") : ?>
			<p class='confirmacion_titulos_info'>Ubicaci&oacute;n</p>
			<p class='confirmacion_info'><?= $curso_ubicacion ?></p>
		<?php endif; ?>
		<?php if($curso_mapa_url != "") : ?>
			<a class='confirmacion_info' href="<?= $curso_mapa_url ?>" target="_blank">URL de la ubicaci&oacute;n</a>
			<br><br>
		<?php endif; ?>
		<?php if($curso_telefono != "") : ?>
			<p class='confirmacion_titulos_info'>Tel&eacute;fono</p>
			<p class='confirmacion_info'>
				<?php echo $curso_telefono;
					if ($curso_telefono_extension != "") {
						echo " ext. ";
						echo $curso_telefono_extension;
					}
				?>
			</p>
		<?php endif; ?>
	</div>

	<div id="botones_asistencia">
		<input id="cancelar_asistencia" type="submit" value="Cancelar Asistencia">
		<form id="frm_confirmar_asistencia" method="post" action="<?= site_url('confirmacion/confirmar_inscripcion')?>">
			<input type="hidden" id="confirmacion_id_contacto" name="id_contacto">
			<input type="hidden" id="confirmacion_id_curso" name="id_curso" value="<?= $id_curso ?>">
			<input id="confirmar_asistencia" type="submit" value="Confirmar Asistencia">
		</form>
	</div>
	<div id="form_cancelar" style="display: none;">
		<form action="<?= site_url('confirmacion/cancelar_inscripcion')?>" method="post">
			<input type="hidden" id="cancelacion_id_contacto" name="id_contacto">
			<input type="hidden" id="cancelacion_id_curso" name="id_curso" value="<?= $id_curso ?>">
			<label>Motivos por el cual cancela su asistencia.</label>
			<textarea id="textarea_motivos"name="motivos" maxlength="250"></textarea>
			<br>
			<input type="submit">
		</form>
	</div>

<!-- termina contenido -->