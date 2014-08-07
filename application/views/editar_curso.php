<script>
$(document).ready(function(){

    $("#frm_editar_curso").validationEngine({promptPosition: "centerRight"});

    $("#menu_cursos").addClass("seleccion_menu");

	$(function() {
	    $( "#tabs" ).tabs();
	});

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


	$(document).tooltip();

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
				$('#busqueda tbody').find("tr:gt(0)").remove();
				$.each(resultado, function(index, value) {
					$('#busqueda tbody').append('<tr>\
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
			}
		});
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
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="El sistema le permite indicar los tipos de contacto que serán contemplados.">
				</legend>
				<input type="checkbox" name="tipo_invitado_webmaster" id="tipo_invitado_webmaster" class="checkbox_tipo_invitado" value="1">
				<label for="tipo_invitado_webmaster">Webmaster</label>
				<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Elegir a todos los contactos de tipo Webmaster.">
				<input type="checkbox" name="tipo_invitado_comunicacion" id="tipo_invitado_comunicacion" class="checkbox_tipo_invitado" value="2">
				<label for="tipo_invitado_comunicacion">R. de comunicación</label>
				<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Elegir a todos los contactos de tipo Responsable de comunicación.">
				<input type="checkbox" name="tipo_invitado_tecnico" id="tipo_invitado_tecnico" class="checkbox_tipo_invitado" value="3">
				<label for="tipo_invitado_tecnico">R. Técnico</label>
				<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Elegir a todos los contactos de tipo Responsable técnico.">
				<input type="checkbox" name="tipo_invitado_otros" id="tipo_invitado_otros" class="checkbox_tipo_invitado" value="4">
				<label for="tipo_invitado_otros">Otros</label>
				<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Elegir a todos los contactos de tipo Otros.">
			</fieldset>

			<fieldset>
				<legend>Añadir participantes por contacto
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="El sistema le permite realizar la búsqueda de los contactos que serán invitados al curso mediante criterios de búsqueda.">
				</legend>

				<div id='bloque_participantes'>
					<p id="texto_participantes">Participantes</p>
					<table class='tables'>
						<tr>
							<td>Nombre</td>
							<td>Eliminar</td>
						</tr>
					</table>
				</div>

				<form id="frm_buscar_invitados">
					<label for="invitados_curso" class="lbl_invitados_curso">Nombre</label>
					<input type="text" id="invitados_curso" name="invitados_nombre" class="input_invitados_cuso validate[groupRequired[buscar_contacto]]"/>
					<br>
					<label for="invitados_correo" class="lbl_invitados_curso">Correo electr&oacute;nico</label>
					<input type="text" id="invitados_correo" name="invitados_correo" class="input_invitados_cuso validate[groupRequired[buscar_contacto]]"/>
					<br>
					<label for="invitados_instancia" class="lbl_invitados_curso">Instancia</label>
					<input type="text" id="invitados_instancia" name="invitados_instancia" class="input_invitados_cuso validate[groupRequired[buscar_contacto]]"/>
					<br>
					<input type="submit" id="btn_buscar_invitados" value="Buscar">
				</form>

				<table id="busqueda" class='tables'>
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
			<input type="submit" id="btn_invitados_curso" value="Añadir invitados">
		</div>

		<div id="tabs-3">

		</div>
	</div>

</div>
<!-- termina contenido -->