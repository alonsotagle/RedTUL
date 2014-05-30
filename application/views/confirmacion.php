<script>
    $(document).ready(function(){

		$("#confirmar_asistencia").hide();
		$("#cancelar_asistencia").hide();

    	$("#verificar_correo").click(function(){
    		event.preventDefault();
    		if ($("#frm_validar_correo").validationEngine('validate')) {
	    		$("#bloque_ingresar_correo").fadeOut("fast");
	    		$.ajax({
					url: "<?= site_url('confirmacion/verifica_contacto') ?>"+"?verificar_correo="+$("#input_verificar_correo").val(),
					dataType: 'json',
					type: 'post',
					success: function(resultado) {
						if (resultado) {

							var id_contacto = $("<input>")
							.attr("type", "hidden")
							.attr("name", "id_contacto")
							.attr("value", resultado["id_contacto"]);
							$("#frm_confirmar_asistencia").append(id_contacto);

							var informacion_curso = $("<div>")
							.attr("id", "informacion_contacto")
							.attr("class", "bloque_informacion");
							$("#informacion_curso").before(informacion_curso);

							$("#confirmar_asistencia").show();
							$("#cancelar_asistencia").show();

							$("#informacion_contacto").append("<p class='confirmacion_titulos_datos'>Datos de invitado</p>");
							$("#informacion_contacto").append("<p class='confirmacion_titulos_info'>Nombre</p>");
							$("#informacion_contacto").append("<p class='confirmacion_info'>"+resultado["contacto_nombre"]+" "+resultado["contacto_ap_paterno"]+" "+resultado["contacto_ap_materno"]+"</p>");
							$("#informacion_contacto").append("<p class='confirmacion_titulos_info'>Instancia</p>");
							$("#informacion_contacto").append("<p class='confirmacion_info'>"+resultado["instancia_nombre"]+"</p>");
							if (resultado["contacto_adscripcion"] != "") {
								$("#informacion_contacto").append("<p class='confirmacion_titulos_info'>Área de adscrición</p>");
								$("#informacion_contacto").append("<p class='confirmacion_info'>"+resultado["contacto_adscripcion"]+"</p>");
							}
							$("#informacion_contacto").append("<p class='confirmacion_titulos_info'>Estatus de registro</p>");
							$("#informacion_contacto").append("<p class='confirmacion_info'>"+"Invitado"+"</p>");
						} else {
							alert("Verificar correo electrónico");
						}
					}
				});
			}
    	});

    });
</script>
<!-- inicia contenido -->
<div id="contenido_confirmacion">

	<div id="bloque_ingresar_correo">
		<p>Por favor compruebe su identidad, ingresando el correo al que le fue enviada la invitación al curso de <?= $curso_titulo ?>.</p>
		<form id="frm_validar_correo">
			<input type="text" id="input_verificar_correo" class="validate[required]" data-prompt-position="topLeft:355">
			<input type="submit" value="OK" id="verificar_correo">
		</form>
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
		<p class='confirmacion_titulos_info'>Cupo</p>
		<p class='confirmacion_info'><?= $curso_cupo ?></p>
		<br>
		<p class='confirmacion_titulos_info'>Ubicaci&oacute;n</p>
		<p class='confirmacion_info'><?= $curso_ubicacion ?></p>
		<a class='confirmacion_info' href="<?= $curso_mapa_url ?>">Google Maps</a>
		<br><br>
		<p class='confirmacion_titulos_info'>Tel&eacute;fono</p>
		<p class='confirmacion_info'>
			<?php echo $curso_telefono;
				if ($curso_telefono_extension != "") {
					echo " ext. ";
					echo $curso_telefono_extension;
				}
			?>
		</p>
	</div>

	<input id="cancelar_asistencia" type="submit" value="Cancelar Asistencia">
	<form id="frm_confirmar_asistencia" method="post" action="<?= site_url('confirmacion/confirmar_inscripcion')?>">
		<input type="hidden" name="id_curso" value="<?= $id_curso ?>">
		<input id="confirmar_asistencia" type="submit" value="Confirmar Asistencia">
	</form>

<!-- termina contenido -->