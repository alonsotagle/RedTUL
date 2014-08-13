<script>
$(document).ready(function(){

	$("#menu_cursos").addClass("seleccion_menu");

    $("#frm_editar_curso").validationEngine({promptPosition: "centerRight"});
    $("#frm_buscar_invitados").validationEngine({promptPosition: "centerRight"});
    $("#frm_configuracion_linea").validationEngine({promptPosition: "centerRight"});

	$(function() {
	    $( "#tabs" ).tabs();
	});

	$(document).tooltip();

	$.ajax("<?= site_url('cursos/consulta_instructores')?>", {
		dataType: 'json',
		type: 'post',
		success: function(resultado){
			if (resultado != null){
				$.each(resultado, function(index, value ){
					$("#curso_instructor").append("<option value='"+value['id_contacto']+"'>"+value['contacto_nombre']+" "+value['contacto_ap_paterno']+" "+ value['contacto_ap_materno']+"</option>");
				});
			}
		},
		complete: function(){
			seleccionar_invitados();
		}
	});

	$.ajax("<?= site_url('cursos/consulta_curso').'/'.$id_curso?>", {
		dataType: 'json',
		type: 'post',
		success: function(resultado) {
			if (resultado != null) {				
				$('#curso_titulo').val(resultado['curso_titulo']);
				$('#configuracion_titulo_curso').text(resultado['curso_titulo']);
				$("#curso_tipo option[value="+resultado['curso_tipo']+"]").prop('selected', true);
				$('#curso_descripcion').val(resultado['curso_descripcion']);
				$('#curso_objetivos').val(resultado['curso_objetivos']);
				$('#curso_fecha_inicio').val(resultado['curso_fecha_inicio']);
				$('#curso_fecha_fin').val(resultado['curso_fecha_fin']);
				$('#curso_hora_inicio').val(resultado['curso_hora_inicio']);
				$('#curso_hora_fin').val(resultado['curso_hora_fin']);
				$('#curso_cupo').val(resultado['curso_cupo']);
				$('#curso_ubicacion').val(resultado['curso_ubicacion']);
				$('#curso_url_ubicacion').val(resultado['curso_mapa_url']);
				$('#curso_telefono').val(resultado['curso_telefono']);
				$('#curso_telefono_extension').val(resultado['curso_telefono_extension']);
				
				if (resultado['curso_flyer'] != "") {
					$("#flyer_anterior").val(resultado['curso_flyer']);

					var url_flyer = "<?= base_url('assets/flyers_cursos') ?>";
						url_flyer += "/"+resultado['curso_flyer'];

					var a_tag_flyer = $("<a />", {
						href 	: url_flyer,
						id 	: "a_tag_flyer",
						target	: "_blank"
					});

					$("#flyer_anterior").after($(a_tag_flyer));

					var img_flyer = $("<img>")
					.attr("src", url_flyer)
					.attr("id", "img_flyer")
					.attr("width", "150")
					.attr("height", "150")
					.addClass("descripcion_archivos");

					$("#a_tag_flyer").append($(img_flyer));
				}

				$("#temario_anterior").val(resultado['curso_temario']);
				
				var url_temario = "<?= base_url('assets/temarios_cursos') ?>";
					url_temario += "/"+resultado['curso_temario'];
				
				var a_tag_temario = $("<a />", {
					href 	: url_temario,
					text 	: "Ver temario seleccionado",
					target	: "_blank"
				});

				$("#curso_temario_editar").before($(a_tag_temario));
				$("#curso_temario_editar").before($("<br>"));
			}
		}
	});

	function seleccionar_invitados(){
		$.ajax("<?= site_url('cursos/consulta_instructores_curso').'/'.$id_curso?>", {
			dataType: 'json',
			type: 'post',
			success: function(resultado){
				if (resultado != null){
					$.each(resultado, function(index, value){
						$('option[value='+value['instructor_id']+']').attr('selected', true);
					});
				}
			}
		});
	}

	$.ajax("<?= site_url('cursos/consulta_invitado_tipo').'/'.$id_curso?>", {
		dataType: 'json',
		type: 'post',
		success: function(resultado) {
			if (resultado) {
				$.each(resultado, function(index, value) {
					$('input[value='+value['tipo_contacto_id']+'][class="checkbox_tipo_invitado"]').attr('checked', true);
				});
			}
		}
	});

	function consulta_invitado_contacto(){
		$('#bloque_participantes table tbody').find("tr:gt(0)").remove();
		$.ajax("<?= site_url('cursos/consulta_invitado_contacto').'/'.$id_curso?>", {
			dataType: 'json',
			type: 'post',
			success: function(resultado) {
				if (resultado != null) {
					$.each(resultado, function(index, value) {
						$("#bloque_participantes table").append("<tr>\
							<td>"+value['contacto_nombre']+" "+value['contacto_ap_paterno']+" "+value['contacto_ap_materno']+"</td>\
							<td><img src="+"<?= base_url('assets/img/icono_borrar.png')?>"+" class='eliminar_invitado' id='"+value['id_contacto']+"'></td>\
						</tr>");
					});
				}
			}
		});
	}
	consulta_invitado_contacto();

	$("#bloque_participantes").on("click", "table tbody tr td .eliminar_invitado", function(){

		var datos = {
			'curso' 	: <?= $id_curso ?>,
			'contacto' 	: $(this).attr("id")
		};

		$.ajax("<?= site_url('cursos/borrar_invitado_contacto') ?>", {
			dataType: 'json',
			type: 'post',
			data: datos,
			complete: function(){
				consulta_invitado_contacto();
   			}
		});
	});

	$( "#curso_fecha_inicio" ).datepicker({
		changeMonth: true,
		numberOfMonths: 2,
		minDate: 0,
		showOn: "both",
		buttonImage: "<?= base_url('assets/img/calendar.gif')?>",
		buttonImageOnly: true,
		//dateFormat: "dd/mm/yy",
		onClose: function( selectedDate ) {
		if (selectedDate != ""){
			$( "#curso_fecha_fin" ).datepicker( "option", "minDate", selectedDate );
		}
			$( "#curso_fecha_fin" ).datepicker( "option", "defaultDate", selectedDate );
		}
	});

	$( "#curso_fecha_fin" ).datepicker({
		changeMonth: true,
		numberOfMonths: 2,
		minDate: 0,
		showOn: "both",
		buttonImage: "<?= base_url('assets/img/calendar.gif')?>",
		buttonImageOnly: true,
		//dateFormat: "dd/mm/yy",
		onClose: function( selectedDate ) {
		$( "#curso_fecha_inicio" ).datepicker( "option", "maxDate", selectedDate );
		}
	});

	if (<?= $nuevo ?>) {
		$.blockUI({ 
			message: "<h3>Guardado correctamente</h3>",
			css: { 
				backgroundColor: '#54DF0E',
				color: '#fff',
				padding: 3,
				border: 'none'
			} 
		}); 

    	setTimeout($.unblockUI, 2000);
	}

	$("#btn_buscar_invitados").click(function(event){
		event.preventDefault();
		if ($("#frm_buscar_invitados").validationEngine('validate')) {
			var datos = {
				'id_curso' 	: <?= $id_curso ?>,
				'nombre' 	: $('input[name=invitados_nombre]').val(),
				'correo' 	: $('input[name=invitados_correo]').val(),
				'instancia' : $('input[name=invitados_instancia]').val()
			};

			$.ajax({
				url: "<?= site_url('cursos/consulta_contactos') ?>",
				data: datos,
				dataType: 'json',
				type: 'post',
				success: function(resultado) {
					if (resultado) {
						$('#despliega_contactos table tbody').find("tr:gt(0)").remove();
						$("#despliega_contactos").find("h2").remove();
						$.each(resultado, function(index, value) {
							
							if (value['instancia_nombre'].length > 25) {
								instancia_nombre = '<span title="'+value['instancia_nombre']+'">'+value['instancia_nombre'].slice(0,25)+'...</span>';
							}else{
								instancia_nombre = value['instancia_nombre'];
							}

							$('#despliega_contactos table tbody').append('<tr>\
								<td>'+value['contacto_nombre']+' '+value['contacto_ap_paterno']+' '+value['contacto_ap_materno']+'</td>\
								<td>'+value['contacto_correo_inst']+' '+value['contacto_correo_per']+'</td>\
								<td>'+value['contacto_telefono']+'</td>\
								<td>'+value['tipo_contacto_descripcion']+'</td>\
								<td>'+instancia_nombre+'</td>\
								<td>\
									<input type="checkbox" name="curso_invitados[]" value="'+value['id_contacto']+'">\
								</td>\
							</tr>');
						});
					}else{
						$('#despliega_contactos table tbody').find("tr:gt(0)").remove();
						$("#despliega_contactos").find("h2").remove();
						$("#despliega_contactos").append('<h2 class="leyenda_centrada">No hay resultados de búsqueda para los datos especificados<h2>');
					}
				}
			});
		}
	});

	$("#btn_invitados_curso").click(function(event){
		event.preventDefault();
		var datos = {
			'id_curso'		: <?= $id_curso ?>,
			'webmaster' 	: $('input[name=tipo_invitado_webmaster]:checked').val(),
			'comunicacion' 	: $('input[name=tipo_invitado_comunicacion]:checked').val(),
			'tecnico' 		: $('input[name=tipo_invitado_tecnico]:checked').val(),
			'otros' 		: $('input[name=tipo_invitado_otros]:checked').val(),
			'invitados' 	: new Array()
		};

		$("input:checkbox[name='curso_invitados[]']:checked").each(function(){
			datos['invitados'].push($(this).val());
		});

		$.ajax({
			url: "<?= site_url('cursos/agrega_invitados') ?>",
			data: datos,
			type: 'post',
			success: function(resultado) {
				alert("Invitados agregados correctamente.");
				consulta_invitado_contacto();
			}
		});
	});

	$.ajax("<?= site_url('cursos/consulta_instancias')?>", {
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

				$('#invitados_instancia').autocomplete({
					source: instancias,
					change: function(event, ui) {
						if(!ui.item){
							$("#invitados_instancia").val("");
						}
					},
					focus: function(event, ui) {
						return false;
					},
					select: function(event, ui) {
						$("#invitados_instancia").val( ui.item.label );
						return false;
					}
				});
			}
		}
	});

	$( "#configuracion_fecha_inicio" ).datepicker({
		changeMonth: true,
		numberOfMonths: 2,
		minDate: 0,
		showOn: "both",
		buttonImage: "<?= base_url('assets/img/calendar.gif')?>",
		buttonImageOnly: true,
		//dateFormat: "dd/mm/yy",
		onClose: function( selectedDate ) {
		if (selectedDate != ""){
			$( "#configuracion_fecha_fin" ).datepicker( "option", "minDate", selectedDate );
		}
			$( "#configuracion_fecha_fin" ).datepicker( "option", "defaultDate", selectedDate );
		}
	});

	$( "#configuracion_fecha_fin" ).datepicker({
		changeMonth: true,
		numberOfMonths: 2,
		minDate: 0,
		showOn: "both",
		buttonImage: "<?= base_url('assets/img/calendar.gif')?>",
		buttonImageOnly: true,
		//dateFormat: "dd/mm/yy",
		onClose: function( selectedDate ) {
		$( "#configuracion_fecha_inicio" ).datepicker( "option", "maxDate", selectedDate );
		}
	});

	$("#btn_guardar_configuracion").click(function(event){
		event.preventDefault();
		if ($("#frm_configuracion_linea").validationEngine('validate')) {
			var datos = {
				'configuracion_curso_id' 				: <?= $id_curso ?>,
				'configuracion_curso_titulo'			: $('#configuracion_nombre_curso').prop('checked'),
				'configuracion_curso_tipo'				: $('#configuracion_tipo_curso').prop('checked'),
				'configuracion_curso_descripcion'		: $('#configuracion_descripcion_curso').prop('checked'),
				'configuracion_curso_objetivos'			: $('#configuracion_objetivos_curso').prop('checked'),
				'configuracion_curso_temario'			: $('#configuracion_temario_curso').prop('checked'),
				'configuracion_curso_fecha'				: $('#configuracion_fecha_curso').prop('checked'),
				'configuracion_curso_horario'			: $('#configuracion_horario_curso').prop('checked'),
				'configuracion_curso_flyer'				: $('#configuracion_flyer_curso').prop('checked'),
				'configuracion_curso_cupo'				: $('#configuracion_cupo_curso').prop('checked'),
				'configuracion_curso_instructor'		: $('#configuracion_instructor_curso').prop('checked'),
				'configuracion_curso_ubicacion'			: $('#configuracion_ubicacion_curso').prop('checked'),
				'configuracion_curso_mapa'				: $('#configuracion_mapa_curso').prop('checked'),
				'configuracion_curso_telefono'			: $('#configuracion_telefono_curso').prop('checked'),
				'configuracion_fecha_inicio'			: $('#configuracion_fecha_inicio').val(),
				'configuracion_fecha_fin'				: $('#configuracion_fecha_fin').val(),
				'configuracion_ocultar_registro'		: $('#configuracion_ocultar_registro_curso').prop('checked'),
				'configuracion_texto_registro'			: $('#configuracion_texto_registro').val(),
				'configuracion_texto_confirmacion'		: $('#configuracion_texto_confirmacion').val(),
				'configuracion_texto_agradecimientos'	: $('#configuracion_texto_agradecimientos').val()
			};

			$.ajax({
				url: "<?= site_url('cursos/registra_configuracion') ?>",
				data: datos,
				dataType: 'json',
				type: 'post',
				complete: function() {
					$.blockUI({ 
					message: "<h3>La información se guardó satisfactoriamente</h3>",
					css: { 
						backgroundColor: '#54DF0E',
						color: '#fff',
						padding: 3,
						border: 'none'
					} 
				}); 

				setTimeout($.unblockUI, 2000);
				}
			});
		}
	});

	$.ajax("<?= site_url('cursos/consulta_registro_curso').'/'.$id_curso?>", {
		dataType: 'json',
		type: 'post',
		success: function(resultado) {
			if (resultado != null) {				
				$('#configuracion_nombre_curso').attr('checked', resultado['registro_curso_titulo']);
				$('#configuracion_flyer_curso').attr('checked', resultado['registro_curso_flyer']);
				$('#configuracion_tipo_curso').attr('checked', resultado['registro_curso_tipo']);
				$('#configuracion_descripcion_curso').attr('checked', resultado['registro_curso_descripcion']);
				$('#configuracion_objetivos_curso').attr('checked', resultado['registro_curso_objetivos']);
				$('#configuracion_temario_curso').attr('checked', resultado['registro_curso_temario']);
				$('#configuracion_fecha_curso').attr('checked', resultado['registro_curso_fecha']);
				$('#configuracion_horario_curso').attr('checked', resultado['registro_curso_horario']);
				$('#configuracion_cupo_curso').attr('checked', resultado['registro_curso_cupo']);
				$('#configuracion_instructor_curso').attr('checked', resultado['registro_curso_instructor']);
				$('#configuracion_ubicacion_curso').attr('checked', resultado['registro_curso_ubicacion']);
				$('#configuracion_mapa_curso').attr('checked', resultado['registro_curso_mapa_url']);
				$('#configuracion_telefono_curso').attr('checked', resultado['registro_curso_telefono']);
				$('#configuracion_fecha_inicio').val(resultado['registro_vigencia_inicio']);
				$('#configuracion_fecha_fin').val(resultado['registro_vigencia_fin']);
				$('#configuracion_ocultar_registro_curso').attr('checked', resultado['registro_visibilidad']);
				$('#configuracion_texto_registro').val(resultado['registro_texto_registro']);
				$('#configuracion_texto_confirmacion').val(resultado['registro_texto_confirmacion']);
				$('#configuracion_texto_agradecimientos').val(resultado['registro_texto_agradecimientos']);
			}
		}
	});
});

</script>
<!-- inicia contenido -->
<div class="contenido_dinamico">
	<div id="migaDePan">
		<a href="<?= base_url()?>">Inicio</a> > 
		<a href="<?= site_url('cursos')?>">Administrar Cursos</a> > Editar curso
	</div>

	<div id="tabs">
		<ul>
			<li><a href="#tabs-1">Datos Generales</a></li>
			<li><a href="#tabs-2">Administrar Invitados</a></li>
			<li><a href="#tabs-3">Configuración Registro en L&iacute;nea</a></li>
		</ul>
		<div id="tabs-1">
			<form id="frm_editar_curso" action="<?= site_url('cursos/editar').'/'.$id_curso?>" method="POST" enctype="multipart/form-data">
				<fieldset>
				<legend>Editar curso</legend>
				<p class="encabezado_form_nuevo_curso">Datos Generales</p>
				<label for="curso_titulo" class="label_nuevo_curso">* T&iacute;tulo del curso
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Nombre alusivo al curso que será impartido.">
				</label>
				<input type="text" maxlength="255" id="curso_titulo" name="curso_titulo" class="validate[required]">
				<br>
				<label for="curso_flyer" class="label_nuevo_curso">Flyer del curso
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Imagen promocional del curso.">
				</label>
				<input type="file" id="curso_flyer" name="curso_flyer" class="validate[checkFileType[jpg|jpeg|gif|JPG|JPEG|GIF]]"/>
				<br><span class="descripcion_archivos">Formatos permitidos .jpg y .gif</span><br><br>
				<input type="hidden" id="flyer_anterior" name="flyer_anterior">
				<br>
				<label for="curso_tipo" class="label_nuevo_curso">* Tipo de curso
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Indica la modalidad en que se llevará a cabo dicho curso.">
				</label>
				<select name="curso_tipo" id="curso_tipo" class="validate[required]">
					<option selected disabled>- Elija un tipo -</option>
					<option value="0">Presencial</option>
					<option value="1">En l&iacute;nea</option>
				</select>
				<br>
				<label for="curso_descripcion" class="label_nuevo_curso label_nuevo_curso_textarea">* Descripci&oacute;n del curso
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Explicación detallada del contenido del curso así como del público a quien va dirigido.">
				</label>
				<textarea id="curso_descripcion" name="curso_descripcion" cols="40" rows="4" maxlength="500" placeholder="Ingrese una breve descripción de dicho curso." class="validate[required]"></textarea>
				<br>
				<label for="curso_objetivos" class="label_nuevo_curso label_nuevo_curso_textarea">* Objetivos</label>
				<textarea id="curso_objetivos" name="curso_objetivos" cols="40" rows="4" maxlength="250" placeholder="Ingrese el fin al que se desea llegar, la meta que se pretende lograr con la impartición de dicho curso." class="validate[required]"></textarea>
				<br>
				<label for="curso_temario" class="label_nuevo_curso">* Temario
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Archivo con el listado del contenido a abordar durante el curso.">
				</label>
				<input type="file" id="curso_temario_editar" name="curso_temario" class="descripcion_archivos validate[checkFileType[pdf]]"/>
				<br><span class="descripcion_archivos">Formatos permitidos .pdf</span>
				<input type="hidden" id="temario_anterior" name="temario_anterior">
				<br>

				<p class="encabezado_form_nuevo_curso">Datos del curso o evento</p>

				<label for="curso_fecha_inicio" class="label_nuevo_curso">* Inicio de curso
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Periodo de tiempo en el que se impartirá el curso.">
				</label>
				<input type="text" id="curso_fecha_inicio" name="curso_fecha_inicio" class="validate[required] datepicker"/>
				<br>
				<label for="curso_fecha_fin" class="label_nuevo_curso">* Fin de curso
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Periodo de tiempo en el que se impartirá el curso.">
				</label>
				<input type="text" id="curso_fecha_fin" name="curso_fecha_fin" class="validate[required] datepicker"/>
				<br>
				<label for="curso_hora_inicio" class="label_nuevo_curso">* Horario de impartición del curso
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Duración de cada sesión del curso.">
				</label>
				<input type="time" id="curso_hora_inicio" name="curso_hora_inicio" maxlength="5" class="validate[required,custom[hora]]"> a
				<input type="time" id="curso_hora_fin" name="curso_hora_fin" maxlength="5" class="validate[required,custom[hora]]">
				<br>
				<label for="curso_cupo" class="label_nuevo_curso">Cupo total
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Número máximo de participantes en un curso.">
				</label>
				<input type="text" id="curso_cupo" name="curso_cupo" maxlength="3" class="input_nuevo_curso_cupo validate[custom[numero]]">
				<br>
				<label for="contacto_instancias" class="label_nuevo_curso_textarea label_nuevo_curso">* Instructor a asignar
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Señala el o los instructores que estarán asignados para impartir dicho curso.">
				</label>
				<select name="curso_instructor[]" id="curso_instructor" class="validate[required]" size=10 multiple>
					<option value="" disabled>- Seleccione una opción -</option>
				</select>
				<br>
				<label for="curso_ubicacion" class="label_nuevo_curso">Ubicaci&oacute;n
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Indica el lugar exacto en el que se llevará a cabo el curso, por ejemplo entidad, edificio, salón, etc.">
				</label>
				<input type="text" maxlength="250" id="curso_ubicacion" name="curso_ubicacion">
				<br>
				<label for="curso_url_ubicacion" class="label_nuevo_curso">URL de mapa de localizaci&oacute;n
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="URL del mapa de ubicación localización del curso en Google maps.">
				</label>
				<input type="text" id="curso_url_ubicacion" name="curso_url_ubicacion">
				<br>
				<label for="curso_telefono" class="label_nuevo_curso">T&eacute;lefono</label>
				<input type="text" id="curso_telefono" name="curso_telefono" size="10" maxlength="10" class="input_frm_nuevo validate[custom[numero]]">
				<label for="curso_telefono_extension">ext.</label>
				<input type="text" id="curso_telefono_extension" name="curso_telefono_extension" size="5" maxlength="5" class="validate[custom[numero]]">

				<div id="botones_envio">
					<input type="submit" id="btn_guardar" value="Guardar">
					<a href="<?= site_url('cursos') ?>">
						<button type="button">Cancelar</button>
					</a>
				</div>
				</fieldset>
			</form>
		</div>

		<div id="tabs-2">
			<fieldset>
				<legend>Añadir participantes por tipo de contacto
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Se enviará invitación al grupo de contactos seleccionado.">
				</legend>
				<input type="checkbox" name="tipo_invitado_webmaster" id="tipo_invitado_webmaster" class="checkbox_tipo_invitado" value="1">
				<label for="tipo_invitado_webmaster">Webmaster</label>
				<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Elegir a todos los contactos de tipo Webmaster.">
				<input type="checkbox" name="tipo_invitado_comunicacion" id="tipo_invitado_comunicacion" class="checkbox_tipo_invitado" value="2">
				<label for="tipo_invitado_comunicacion">Responsable de comunicación</label>
				<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Elegir a todos los contactos de tipo Responsable de comunicación.">
				<input type="checkbox" name="tipo_invitado_tecnico" id="tipo_invitado_tecnico" class="checkbox_tipo_invitado" value="3">
				<label for="tipo_invitado_tecnico">Responsable Técnico</label>
				<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Elegir a todos los contactos de tipo Responsable técnico.">
				<input type="checkbox" name="tipo_invitado_otros" id="tipo_invitado_otros" class="checkbox_tipo_invitado" value="4">
				<label for="tipo_invitado_otros">Otros</label>
				<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Elegir a todos los contactos de tipo Otros.">
			</fieldset>

			<fieldset>
				<legend>Añadir participantes por contacto
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="El sistema le permite realizar la búsqueda de los contactos que serán invitados al curso mediante criterios de búsqueda.">
				</legend>

				<form id="frm_buscar_invitados">
					<label for="invitados_curso" class="lbl_invitados_curso">Nombre</label>
					<input type="text" id="invitados_curso" name="invitados_nombre" class="validate[groupRequired[buscar_contacto]]" maxlength="100"/>
					<br>
					<label for="invitados_correo" class="lbl_invitados_curso">Correo electr&oacute;nico</label>
					<input type="text" id="invitados_correo" name="invitados_correo" class="validate[groupRequired[buscar_contacto],custom[email]]" maxlength="100"/>
					<br>
					<label for="invitados_instancia" class="lbl_invitados_curso">Instancia</label>
					<input type="text" id="invitados_instancia" name="invitados_instancia" class="validate[groupRequired[buscar_contacto]]" maxlength="100"/>
					<br>
					<input type="submit" id="btn_buscar_invitados" value="Buscar">
				</form>

				<div id="despliega_contactos">
					<table class='tables'>
						<tr>
							<td>Nombre completo</td>
							<td>Correo electr&oacute;nico</td>
							<td>Tel&eacute;fono</td>
							<td>Tipo de contacto</td>
							<td>Instancia</td>
							<td>Añadir</td>
						</tr>
					</table>
				</div>

				<div id='bloque_participantes'>
					<p id="texto_participantes">Participantes
						<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Contactos confirmados.">
					</p>
					<table class='tables'>
						<tr>
							<td>Nombre</td>
							<td>Eliminar</td>
						</tr>
					</table>
				</div>

			</fieldset>
			<input type="submit" id="btn_invitados_curso" value="Añadir invitados">
		</div>

		<div id="tabs-3">
			<form id="frm_configuracion_linea">
				<fieldset>
					<legend>Registro en línea</legend>
					<p class="encabezado_form_nuevo_curso" id="configuracion_titulo_curso"></p>
					<p>Datos que se mostrar&aacute;n en la p&aacute;gina de registro en l&iacute;nea:
						<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Imagen promocional del curso.">
					</p>
					<div id="configuracion_col-izq">
						<input type="checkbox" name="configuracion_nombre_curso" id="configuracion_nombre_curso" value="1">
						<label for="configuracion_nombre_curso">Nombre del curso o evento</label>
						<br>
						<input type="checkbox" name="configuracion_flyer_curso" id="configuracion_flyer_curso" value="1">
						<label for="configuracion_flyer_curso">Flyer</label>
						<br>
						<input type="checkbox" name="configuracion_tipo_curso" id="configuracion_tipo_curso" value="1">
						<label for="configuracion_tipo_curso">Tipo</label>
						<br>
						<input type="checkbox" name="configuracion_descripcion_curso" id="configuracion_descripcion_curso" value="1">
						<label for="configuracion_descripcion_curso">Descripci&oacute;n</label>
						<br>
						<input type="checkbox" name="configuracion_objetivos_curso" id="configuracion_objetivos_curso" value="1">
						<label for="configuracion_objetivos_curso">Objetivos</label>
						<br>
						<input type="checkbox" name="configuracion_temario_curso" id="configuracion_temario_curso" value="1">
						<label for="configuracion_temario_curso">Temario</label>
						<br>
						<input type="checkbox" name="configuracion_fecha_curso" id="configuracion_fecha_curso" value="1">
						<label for="configuracion_fecha_curso">Fecha del curso</label>
						<br>
					</div>
					<div id="configuracion_col-der">
						<input type="checkbox" name="configuracion_horario_curso" id="configuracion_horario_curso" value="1">
						<label for="configuracion_horario_curso">Horario en el que ser&aacute; impartido</label>
						<br>
						<input type="checkbox" name="configuracion_cupo_curso" id="configuracion_cupo_curso" value="1">
						<label for="configuracion_cupo_curso">Cupo total</label>
						<br>
						<input type="checkbox" name="configuracion_instructor_curso" id="configuracion_instructor_curso" value="1">
						<label for="configuracion_instructor_curso">Instructor</label>
						<br>
						<input type="checkbox" name="configuracion_ubicacion_curso" id="configuracion_ubicacion_curso" value="1">
						<label for="configuracion_ubicacion_curso">Ubicaci&oacute;n</label>
						<br>
						<input type="checkbox" name="configuracion_mapa_curso" id="configuracion_mapa_curso" value="1">
						<label for="configuracion_mapa_curso">URL de mapa de localizaci&oacute;n</label>
						<br>
						<input type="checkbox" name="configuracion_telefono_curso" id="configuracion_telefono_curso" value="1">
						<label for="configuracion_telefono_curso">Tel&eacute;fono de contacto</label>
					</div>
					<br>
					<p class="encabezado_form_nuevo_curso" id="configuracion_visibilidad">Visibilidad de registro en l&iacute;nea</p>
					<p>Vigencia del registro
						<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Imagen promocional del curso.">
					</p>
					<label for="configuracion_fecha_inicio" class="etiqueta_frm">* Fecha inicio</label>
					<input type="text" id="configuracion_fecha_inicio" name="configuracion_fecha_inicio" class="input_nuevo_curso_centrado validate[required] datepicker"/>
					<br>
					<label for="configuracion_fecha_fin" class="etiqueta_frm">* Fecha termino</label>
					<input type="text" id="configuracion_fecha_fin" name="configuracion_fecha_fin" class="input_nuevo_curso_centrado validate[required] datepicker"/>
					<br><br>
					<input type="checkbox" name="configuracion_ocultar_registro_curso" id="configuracion_ocultar_registro_curso" value="1">
					<label for="configuracion_ocultar_registro_curso">Ocultar registro en l&iacute;nea</label>
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Imagen promocional del curso.">
					<p class="encabezado_form_nuevo_curso">Configuraci&oacute;n de texto</p>
					<p>* Texto de pantalla de registro</p>
					<textarea rows="4" cols="50" id="configuracion_texto_registro" maxlength="255" placeholder='Por ejemplo. "Complete el siguiente formulario para confirmar su asistencia al curso de..."' class="validate[required]"></textarea>
					<p>* Texto de pantalla de confirmaci&oacute;n</p>
					<textarea rows="4" cols="50" id="configuracion_texto_confirmacion" maxlength="255" placeholder='Por ejemplo. "La información de su registro ha sido enviada a su correo"' class="validate[required]"></textarea>
					<p>Texto de pantalla de agradecimientos</p>
					<textarea rows="4" cols="50" id="configuracion_texto_agradecimientos" maxlength="255" placeholder='Por ejemplo. "Gracias por su apoyo. Su participación es muy importante" ' class="validate[required]"></textarea>
					<input type="submit" id="btn_guardar_configuracion" value="Guardar">
				</fieldset>
			</form>
		</div>
	</div>
</div>
<!-- termina contenido -->