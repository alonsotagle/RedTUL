<script type="text/javascript" src="<?= base_url('assets/js/jquery-te-1.4.0.js') ?>"></script>
<link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/jquery-te-1.4.0.css')?>" />
<script>
    $(document).ready(function(){

    	$("#menu_mensajeria").addClass("seleccion_menu");

		$("#frm_correo_destinatarios").validationEngine({promptPosition: "centerRight"});
		$("#frm_enviar_correo").validationEngine({promptPosition: "centerRight"});

        $(function() {
	    	$("#tabs").tabs({ active: 0, disabled: [ 1, 2 ] });
		});

		$(document).tooltip();

		$("#nuevo_correo_contenido").jqte();

		$('#nuevo_correo_contenido').jqteVal('<?= $correo_contenido ?>');

		$("#nuevo_correo_plantilla").on("change", function(){
			var valor_lista_plantilla = $(this).val();
			switch (valor_lista_plantilla){
				case "":
					$('#nuevo_correo_asunto').val('');
					$('#nuevo_correo_contenido').jqteVal('');
					break;

				case "generales":

					$.ajax({
						url: "<?= site_url('mensajeria/consulta_detalles_curso') ?>"+"/"+$("#lista_cursos").val(),
						async: false,
						dataType: 'json',
						type: 'post',
						success: function(resultado) {
							if (resultado) {
								var curso_fecha_inicio = resultado['curso_fecha_inicio'].split("-");
								var curso_fecha_fin = resultado['curso_fecha_fin'].split("-");

								$('#nuevo_correo_asunto').val(resultado['curso_titulo']);

								var contenido_generales = "<br>Por este medio se le hace una atenta invitación al curso:";
								contenido_generales += "<br><br>Tema:  "+resultado["curso_titulo"];
								contenido_generales += "<br>Fechas:  "+curso_fecha_inicio[2]+"/"+curso_fecha_inicio[1]+"/"+curso_fecha_inicio[0]+' a '+curso_fecha_fin[2]+"/"+curso_fecha_fin[1]+"/"+curso_fecha_fin[0];
								contenido_generales += "<br>Horario:  "+resultado["curso_hora_inicio"]+" - "+resultado["curso_hora_fin"];
								contenido_generales += "<br>Lugar:  "+resultado["curso_ubicacion"];
								contenido_generales += "<br><a href='<?= site_url('detalle_curso') ?>/"+$("#lista_cursos").val()+"'>Leer más...</a>";
								contenido_generales += "<br><br>Para confirmar sus asistencia le solicitamos que dé clic en el siguiente enlace";
								contenido_generales += "<br><a href='<?= site_url('confirmacion') ?>/"+$("#lista_cursos").val()+"'>Inscribirse a evento</a>";
								contenido_generales += "<br><br>De antemano agradecemos su atención.";
								contenido_generales += "<br><br>Saludos cordiales";
								$("#nuevo_correo_contenido").jqteVal(contenido_generales);
							}
						}
					});

					break;

				case "invitacion":
					$.ajax({
						url: "<?= site_url('mensajeria/plantilla_invitacion') ?>"+"/"+$("#lista_cursos").val(),
						async: false,
						dataType: 'json',
						type: 'post',
						success: function(resultado) {
							if (resultado) {
								var curso_fecha_inicio = resultado['curso_fecha_inicio'].split("-");
								var curso_fecha_fin = resultado['curso_fecha_fin'].split("-");

								$('#nuevo_correo_asunto').val("Invitación a "+resultado['curso_titulo']);

								var contenido_invitacion = "<br>Estimados responsables,";
								contenido_invitacion += "<br><br>El próximo "+curso_fecha_inicio[2]+"/"+curso_fecha_inicio[1]+"/"+curso_fecha_inicio[0]+' a '+curso_fecha_fin[2]+"/"+curso_fecha_fin[1]+"/"+curso_fecha_fin[0];
								contenido_invitacion += " se llevará a cabo "+resultado['curso_titulo']+" para los responsables de sitios web con recursos para la docencia, en un horario de ";
								contenido_invitacion += resultado["curso_hora_inicio"]+" - "+resultado["curso_hora_fin"]+" horas en "+resultado["curso_ubicacion"]+".";
								contenido_invitacion += "<br><br>El evento tiene como propósito "+resultado['curso_objetivos'];
								contenido_invitacion += "<br><br>Cabe mencionar que se envió la invitación a los directores de sus dependencias, la cual anexo al presente. Por favor, es necesario confirmar su asistencia siguiendo los pasos que se indican en el siguiente enlace: ";
								contenido_invitacion += "<a href='<?= site_url('confirmacion') ?>/"+$("#lista_cursos").val()+"'>Inscribirse a evento</a>";
								contenido_invitacion += "<br><br>Agradecemos su participación e interés.";

								$("#nuevo_correo_contenido").jqteVal(contenido_invitacion);
							}
						}
					});
					break;

				case "evaluacion":
					$('#nuevo_correo_asunto').val("Encuesta de evaluación y Material");

					$.ajax({
					url: "<?= site_url('mensajeria/consulta_detalles_curso') ?>"+"/"+$("#lista_cursos").val(),
					async: false,
					dataType: 'json',
					type: 'post',
					success: function(resultado) {
						if (resultado) {
							var curso_fecha_inicio = resultado['curso_fecha_inicio'].split("-");
							var curso_fecha_fin = resultado['curso_fecha_fin'].split("-");

							var contenido_evaluacion = "<br>Estimados miembros de la Red de Responsables Técnicos de la UNAM.";
							contenido_evaluacion += "<br><br>Agradecemos su asistencia a "+resultado['curso_titulo'];
							contenido_evaluacion += " realizada el "+curso_fecha_inicio[2]+"/"+curso_fecha_inicio[1]+"/"+curso_fecha_inicio[0]+' a '+curso_fecha_fin[2]+"/"+curso_fecha_fin[1]+"/"+curso_fecha_fin[0];
							contenido_evaluacion += ", esperamos que los temas presentados hayan sido de su interés.";
							contenido_evaluacion += "<br><br>Con el objetivo de mejorar el desempeño de los eventos y cursos,  les pedimos por favor respondan una breve encuesta sobre su experiencia  en el siguiente en el siguiente enlace [Enlace de la encuesta], ésta permanecerá disponible hasta el próximo [Fecha límite para contestar la encuesta].  Una vez recibida su evaluación, se les enviará por correo electrónico la constancia de asistencia al evento.";
							contenido_evaluacion += "<br><br>Por otra parte, en la siguiente URL podrán descargar el material de los temas presentados [Enlace del material]."
							contenido_evaluacion += "<br><br>Quedo al pendiente de cualquier duda.<br><br>Reciban un cordial saludo."

							$("#nuevo_correo_contenido").jqteVal(contenido_evaluacion);
						}
					}
				});
					break;

				case "constancia":
					$('#nuevo_correo_asunto').val("Constancia de Asistencia al evento");

					$.ajax({
					url: "<?= site_url('mensajeria/consulta_detalles_curso') ?>"+"/"+$("#lista_cursos").val(),
					async: false,
					dataType: 'json',
					type: 'post',
					success: function(resultado) {
						if (resultado) {
							var curso_fecha_inicio = resultado['curso_fecha_inicio'].split("-");
							var curso_fecha_fin = resultado['curso_fecha_fin'].split("-");

							var contenido_constancia = "<br>Estimado [Nombre del contacto],";
							contenido_constancia += "<br><br>Envío la Constancia de asistencia al evento "+resultado['curso_titulo'];
							contenido_constancia += ", realizado el  "+curso_fecha_inicio[2]+"/"+curso_fecha_inicio[1]+"/"+curso_fecha_inicio[0]+' a '+curso_fecha_fin[2]+"/"+curso_fecha_fin[1]+"/"+curso_fecha_fin[0]+".";
							contenido_constancia += "<br><br>Te agradeceré confirmes que tus datos son correctos.";
							contenido_constancia += "<br><br>Quedo al pendiente de cualquier duda.<br><br>Reciban un cordial saludo."

							$("#nuevo_correo_contenido").jqteVal(contenido_constancia);
						}
					}
				});
					break;

				default:
					$.ajax({
						url: "<?= site_url('mensajeria/consulta_plantilla') ?>"+"/"+valor_lista_plantilla,
						dataType: 'json',
						type: 'post',
						success: function(resultado) {
							if (resultado) {
								$('#nuevo_correo_asunto').val(resultado['plantilla_asunto']);
								$('#nuevo_correo_contenido').jqteVal(resultado['plantilla_contenido']);
							}
						}
					});
					break;
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

		$("#btn_correo_obtener_url").click(function(event){
			event.preventDefault();
			if ($("#frm_curso_destinatarios").validationEngine('validate') && $("#lista_cursos").val() != "") {
				valor_contenido_textarea = $("#nuevo_correo_contenido").val();
				valor_contenido_textarea += "<br>Página para incribirse:<br><a href='<?= site_url('confirmacion') ?>/"+$("#lista_cursos").val()+"'>Inscribirse a evento</a>";

				$("#nuevo_correo_contenido").jqteVal(valor_contenido_textarea);
				$("#nuevo_correo_asunto").focus();
			}
		});

		function seleccionar_destinatarios(){
			$.ajax({
				url: "<?= site_url('mensajeria/consulta_destinatarios_correos_editar') ?>"+"/"+"<?= $id_correo ?>",
				dataType: 'json',
				type: 'post',
				success: function(resultado) {
					var id_destinatarios = [];
					$.each(resultado, function(index, value) {
						id_destinatarios.push(value['id_contacto']);
						$('#tabla_buscar_destinatarios tbody input[value='+value['id_contacto']+']').attr('checked', true);
					});
					$("#id_destinatarios").val(id_destinatarios);
				}
			});			
		}

		$.ajax({
			url: "<?= site_url('mensajeria/consulta_contactos') ?>",
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
				}
			},
			complete: function(){
				seleccionar_destinatarios();
			}
		});

		$("#btn_buscar_contacto").click(function(event){
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
							$("#despliega_contactos").find("h2").remove();
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
							$('#despliega_contactos table tbody').find("tr:gt(0)").remove();
							$("#despliega_contactos").find("h2").remove();
							$('#despliega_contactos').append('<h2 class="leyenda_centrada">No hay resultados de búsqueda para los datos especificados<h2>');
						}
					}
				});
			}
		});

		$("#btn_correo_anadir_destinatarios").click(function(event){
			event.preventDefault();

			var ids_contacto = new Array();

			//Individual
			if ($("input[name='curso_invitados[]']:checked").length != 0) {
				$("input[name='curso_invitados[]']:checked").each(function() {
					ids_contacto.push($(this).val());
				});
			}

			//Por tipo
			$("#fieldset_destinatarios_tipo input").each(function(index, value){
				entrada = $(value);
				if (entrada.is(':checked')) {
					$.ajax("<?= site_url('mensajeria/consulta_invitados_tipo') ?>"+"/"+entrada.val(), {
						async: false,
						dataType: 'json',
						type: 'post',
						success: function(resultado){
							if (resultado) {
								$.each(resultado, function(index, value){
									ids_contacto.push(value);
								});
							}
						}
		   			});
				}
			});

			$("#btn_enviar_correo").prop('disabled', true);

			if (ids_contacto.length != 0) {

				ids_contacto = jQuery.unique(ids_contacto);

				$("#id_destinatarios").remove();

				var input_destinatarios = $("<input>")
	               .attr("type", "hidden")
	               .attr("name", "id_destinatarios")
	               .attr("id", "id_destinatarios")
	               .val(ids_contacto);

				$('#frm_enviar_correo').append($(input_destinatarios));

				$("#btn_enviar_correo").prop('disabled', false);
			}

			if ($("#lista_cursos").val() != "") {
				$("#nuevo_correo_plantilla").append('<option value="generales" class="plantillas_curso">Datos generales</option>');
				$("#nuevo_correo_plantilla").append('<option value="invitacion" class="plantillas_curso">Invitación al evento</option>');
				$("#nuevo_correo_plantilla").append('<option value="evaluacion" class="plantillas_curso">Evaluación del evento</option>');
				$("#nuevo_correo_plantilla").append('<option value="constancia" class="plantillas_curso">Envío de constancia</option>');
			}else{
				$(".plantillas_curso").remove();
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
						$('#nuevo_correo_plantilla').append("<option value='"+value['id_plantilla_correo']+"'>"+value['plantilla_asunto']+"</option>");
					});
				}
			}
		});

		$("#programar_correo_hora").change(function(){
			verifica_hora();
		});
		$("#programar_correo_fecha").change(function(){
			verifica_hora();
		});

		function verifica_hora(){
			var hoy = new Date();
			var hora_actual = hoy.getHours();
			var minutos_actual = hoy.getMinutes();

			var tiempo_introducido = $("#programar_correo_hora").val();
			var arreglo_hora = tiempo_introducido.split(":");
			var hora_introducida = arreglo_hora[0];
			var minutos_introducido = arreglo_hora[1];

			if (tiempo_introducido != "") {

				hoy = hoy.getFullYear()+"-"+("0" + (hoy.getMonth() + 1)).slice(-2)+"-"+("0" + hoy.getDate()).slice(-2);

				fecha = $("#programar_correo_fecha").val();

				if(fecha == hoy){

					if (hora_introducida < hora_actual) {
						alert("El sistema no permite ingresar horas anteriores a la actual, cuando se selecciona el día actual");
						$("#programar_correo_hora").val("");
					}else if (hora_introducida == hora_actual && minutos_introducido < minutos_actual) {
						alert("El sistema no permite ingresar horas anteriores a la actual, cuando se selecciona el día actual");
						$("#programar_correo_hora").val("");
					}
				}
			}
		}

		if ("<?= $correo_archivo_adjunto ?>" !="") {
			var url_adjunto = "<?= $correo_archivo_adjunto ?>";
			var arreglo_url = url_adjunto.split( '/' );
			var nombre_archivo = arreglo_url[arreglo_url.length-1];

			$("#archivo_adjunto")
			.attr("href", "<?= base_url('assets/email_archivos_adjuntos')?>"+"/"+nombre_archivo)
			.text("Archivo adjunto");
		}

		$("#btn_cancelar_correo").click(function(event){
			event.preventDefault();
			id = <?= $id_correo; ?>;
			window.location.href = "<?= site_url('mensajeria/cancelar_correo') ?>"+"/"+id;
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
			<li><a href="#tabs-1">Nuevo correo electr&oacute;nico</a></li>
			<li><a href="#tabs-2">Historial de correos electrónicos</a></li>
			<li><a href="#tabs-3">Administrar plantillas</a></li>
		</ul>

		<div id="tabs-1">
			<fieldset class="seccion_envio_correo">
				<legend>Destinatarios
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Se permite seleccionar diferentes grupos de usuarios o bien, de manera individual." class="icon_tooltip">
				</legend>
				<div id="fieldset_destinatarios_curso" class="fieldset_destinatarios">
					<p>Curso
						<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="El sistema permite elegir los contactos invitados a un determinado curso como destinatarios." class="icon_tooltip">
					</p>
					<form id="frm_curso_destinatarios">
						<label for="lista_cursos">T&iacute;tulo de curso</label>
						<select id="lista_cursos" class="validate[required]">
							<option selected value="">- Seleccione una opci&oacute;n -</option>
						</select>
						<input type="submit" id="btn_correo_obtener_url" value="Obtener URL de registro en l&iacute;nea">
					</form>
					<br>
					<div id="invitados_curso">
						<table id="tabla_invitados_curso" class='tables'>
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
				</div>

				<div id="fieldset_destinatarios_tipo" class="fieldset_destinatarios">
					<p>Tipo de Contacto
						<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="El sistema permite elegir destinatarios por tipo de contacto." class="icon_tooltip">
					</p>
					<input type="checkbox" name="tipo_invitado_webmaster" id="tipo_invitado_webmaster" class="checkbox_tipo_invitado_correo" value="1">
					<label for="tipo_invitado_webmaster">Webmaster</label>
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Elegir a todos los contactos de tipo Webmaster.">
					<input type="checkbox" name="tipo_invitado_comunicacion" id="tipo_invitado_comunicacion" class="checkbox_tipo_invitado_correo" value="2">
					<label for="tipo_invitado_comunicacion">Responsable de comunicación</label>
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Elegir a todos los contactos de tipo Responsable de comunicación.">
					<input type="checkbox" name="tipo_invitado_tecnico" id="tipo_invitado_tecnico" class="checkbox_tipo_invitado_correo" value="3">
					<label for="tipo_invitado_tecnico">Responsable Técnico</label>
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Elegir a todos los contactos de tipo Responsable técnico.">
					<input type="checkbox" name="tipo_invitado_otros" id="tipo_invitado_otros" class="checkbox_tipo_invitado_correo" value="4">
					<label for="tipo_invitado_otros">Otros</label>
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Elegir a todos los contactos de tipo Otros.">
				</div>

				<div id="fieldset_destinatarios_contacto" class="fieldset_destinatarios">
					<p>Contacto específico
						<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="El sistema permite realizar la búsqueda de los contactos que desea añadir como destinatarios en el correo electrónico mediante criterios de búsqueda." class="icon_tooltip">
					</p>
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
					<div id="despliega_contactos">
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
					</div>
				</div>
				<input type="submit" id="btn_correo_anadir_destinatarios" value="Añadir destinatarios">
			</fieldset>

			<form id="frm_enviar_correo" action="<?= site_url('mensajeria/guardar_correo') ?>" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="id_correo" value="<?= $id_correo ?>">
				<input type="hidden" name="id_destinatarios" id="id_destinatarios">
				<fieldset class="seccion_envio_correo">
					<legend>Detalle del correo
						<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Cuerpo principal del correo, asunto, archivos y cuerpo del correo." class="icon_tooltip">
					</legend>
					<label class="label_nuevo_correo" for="nuevo_correo_plantilla">Usar plantilla
						<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Se le recomienda revisar la redacción del texto agregado." class="icon_tooltip">
					</label>
					<select id="nuevo_correo_plantilla" class="input_envia_correo">
						<option selected value="">- Seleccione una opci&oacute;n -</option>
					</select>
					<br>
						<label class="label_nuevo_correo" for="nuevo_correo_asunto">Asunto</label>
						<input type="text" class="input_envia_correo validate[required]" id="nuevo_correo_asunto" size="50" name="asunto" value="<?= $correo_asunto ?>">
						<br>
						<label class="label_nuevo_correo">Datos adjuntos</label>
						<input type="file" id="nuevo_correo_archivos_adjuntos" name="userfile">
						<br>
						<a href="#" id="archivo_adjunto" target="_blank"></a>
						<br><br>
						<label class="label_nuevo_correo" for="nuevo_correo_contenido">Contenido del correo
							<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="El texto introducido puede contener etiquetas de HTML." class="icon_tooltip">
						</label>
						<textarea spellcheck="false" id="nuevo_correo_contenido" class="textarea_cuerpo_correo validate[required]" data-prompt-position="topLeft" name="contenido"></textarea>
				</fieldset>
				<fieldset class="seccion_envio_correo">
					<legend>Env&iacute;o
						<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Aquí se puede enviar el correo de inmediato o bien se programa la fecha y hora de su env&iacute;o." class="icon_tooltip">
					</legend>
					<div class="programar_envio_correo">
						<input type="radio" form="frm_enviar_correo" name="envio" id="programar_correo_inmed" class="validate[required] radio" value="0">
						<label for="programar_correo_inmed">Enviar inmediatamente</label>
					</div>
					<div class="programar_envio_correo programar_envio_correo_posterior">
						<input type="radio" form="frm_enviar_correo" name="envio" id="programar_correo_posterior" class="input_envia_correo validate[required] radio" value="1" checked="checked">
						<label for="programar_correo_posterior" class="label_programar_posterior">Programar env&iacute;o</label>
						<br>
						<label class="label_programar_posterior" for="programar_correo_fecha">* Fecha de env&iacute;o</label>
						<input class="input_envia_correo" id="programar_correo_fecha" form="frm_enviar_correo" name="fecha_envio" data-prompt-position="topLeft" value="<?= $correo_fecha_envio ?>">
						<br>
						<label class="label_programar_posterior" for="programar_correo_hora">* Hora de env&iacute;o
							<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Formato horario de 24 horas.">
						</label>
						<input type="time" class="input_envia_correo" id="programar_correo_hora" form="frm_enviar_correo" name="hora_envio" data-prompt-position="topLeft" value="<?= $correo_hora_envio ?>">
						<br>
					</div>
				</fieldset>
				<input type="submit" id="btn_programar_correo" value="Guardar">
				<input type="submit" id="btn_cancelar_correo" value="Cancelar envío de correo">
			</form>
		</div>


		<div id="tabs-2"></div>

		<div id="tabs-3"></div>
</div>
<!-- termina contenido -->