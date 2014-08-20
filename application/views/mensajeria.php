<script type="text/javascript" src="<?= base_url('assets/js/jquery-te-1.4.0.js') ?>"></script>
<link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/jquery-te-1.4.0.css')?>" />
<script>
    $(document).ready(function(){

    	$("#menu_mensajeria").addClass("seleccion_menu");

        $("#frm_buscar_correo").validationEngine({promptPosition: "centerRight"});
		$("#frm_correo_destinatarios").validationEngine({promptPosition: "centerRight"});
		$("#form_plantilla").validationEngine({promptPosition: "centerRight"});
		$("#frm_enviar_correo").validationEngine({promptPosition: "centerRight"});

        $(function() {
	    	$("#tabs").tabs({ active: <?= $tab ?>});
		});

		$(document).tooltip();

		$("#nuevo_correo_contenido").jqte();

        $("#btn_enviar_correo").prop('disabled', true);

		$.ajax({
			url: "<?= site_url('mensajeria/consulta_correos') ?>",
			dataType: 'json',
			type: 'post',
			success: function(resultado) {
				if (resultado) {
					if (resultado) {
						$.each(resultado, function(index, value) {
							var url_detalle = "<?= site_url('mensajeria/detalle_correo') ?>";
							url_detalle += "/" + value['id_correo'];

							var correo_fecha_creacion = value['correo_fecha_creacion'].split("-");
							var correo_fecha_envio = value['correo_fecha_envio'].split("-");

							if (value['correo_estatus'] == 2) {
								var row_tabla = "<tr class='correo_cancelado'>"
							} else {
								var row_tabla = "<tr>";
							}

							row_tabla += '<td><a href="'+url_detalle+'">'+value['correo_asunto']+'</a></td>\
								<td>'+correo_fecha_creacion[2]+"/"+correo_fecha_creacion[1]+"/"+correo_fecha_creacion[0]+'</td>\
								<td>'+correo_fecha_envio[2]+"/"+correo_fecha_envio[1]+"/"+correo_fecha_envio[0]+'<br>'+value['correo_hora_envio']+'</td>\
								<td>';
							if (value['destinatarios']) {
								$.each(value['destinatarios'], function(index_dest, value_dest) {
									row_tabla += value_dest['contacto_nombre']+" "+value_dest['contacto_ap_paterno']+" "+value_dest['contacto_ap_materno']+"<br>";
								});
							}
							row_tabla += '</td>';
							if (value['correo_estatus'] == 1) {
								row_tabla += '<td>\
									<img id='+value['id_correo']+' class="img_editar_correo"\
									src="'+"<?= base_url('assets/img/icono_editar.png')?>"+'">\
									</td></tr>';
							}else{
								row_tabla += "<td></td></tr>";
							}
							$('#tabla_correos tbody').append(row_tabla);
						});
					}
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
							$("#despliega_correos").find("h2").remove();
							$.each(resultado, function(index, value) {
								var url_detalle = "<?= site_url('mensajeria/detalle_correo') ?>";
								url_detalle += "/" + value['id_correo'];

								if (value['correo_estatus'] == 2) {
									var row_tabla = "<tr class='correo_cancelado'>"
								} else {
									var row_tabla = "<tr>";
								}
								row_tabla += '<td><a href="'+url_detalle+'">'+value['correo_asunto']+'</a></td>\
									<td>'+value['correo_fecha_creacion']+'</td>\
									<td>'+value['correo_fecha_envio']+'<br>'+value['correo_hora_envio']+'</td>\
									<td>';
								if (value['destinatarios']) {
									$.each(value['destinatarios'], function(index_dest, value_dest) {
										row_tabla += value_dest['contacto_nombre']+" "+value_dest['contacto_ap_paterno']+" "+value_dest['contacto_ap_materno']+"<br>";
									});
								}
								row_tabla += '</td>';

								if (value['correo_estatus'] == 1) {
									row_tabla += '<td>\
										<img id='+value['id_correo']+' class="img_editar_correo"\
										src="'+"<?= base_url('assets/img/icono_editar.png')?>"+'">\
										</td></tr>';
								}else{
									row_tabla += "<td></td></tr>";
								}
								$('#tabla_correos tbody').append(row_tabla);
							});
						}else{
							$('#despliega_correos table tbody').find("tr:gt(0)").remove();
							$("#despliega_correos").find("h2").remove();
							$('#despliega_correos').append('<h2 class="leyenda_centrada">No hay resultados de búsqueda para los datos especificados<h2>');
						}
					}
				});
			}
		});

		$("#nuevo_correo_plantilla").on("change", function(){
			var valor_lista_plantilla = $(this).val();
			switch (valor_lista_plantilla){
				case "":
					$('#nuevo_correo_asunto').val('');
					$('#nuevo_correo_contenido').jqteVal('');
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
							$('#nuevo_correo_asunto').val(resultado['plantilla_asunto']);
							$('#nuevo_correo_contenido').jqteVal(resultado['plantilla_contenido']);
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

		$("#btn_correo_obtener_url").click(function(event){
			event.preventDefault();
			if ($("#frm_curso_destinatarios").validationEngine('validate') && $("#lista_cursos").val() != "") {
				valor_contenido_textarea = $("#nuevo_correo_contenido").val();
				valor_contenido_textarea += "<br>Por este medio se le hace una atenta invitación al curso:";

				$.ajax({
					url: "<?= site_url('mensajeria/consulta_detalles_curso') ?>"+"/"+$("#lista_cursos").val(),
					async: false,
					dataType: 'json',
					type: 'post',
					success: function(resultado) {
						if (resultado) {

							var curso_fecha_inicio = resultado['curso_fecha_inicio'].split("-");
							var curso_fecha_fin = resultado['curso_fecha_fin'].split("-");

							valor_contenido_textarea += "<br><br>Tema:  "+resultado["curso_titulo"];
							valor_contenido_textarea += "<br>Fechas:  "+curso_fecha_inicio[2]+"/"+curso_fecha_inicio[1]+"/"+curso_fecha_inicio[0]+' a '+curso_fecha_fin[2]+"/"+curso_fecha_fin[1]+"/"+curso_fecha_fin[0];
							valor_contenido_textarea += "<br>Duración:  "+resultado["curso_hora_inicio"]+" - "+resultado["curso_hora_fin"];
							valor_contenido_textarea += "<br>Lugar:  "+resultado["curso_ubicacion"];
						}
					}
				});

				valor_contenido_textarea += "<br><a href='<?= site_url('detalle_curso') ?>/"+$("#lista_cursos").val()+"'>Leer más...</a>";
				valor_contenido_textarea += "<br><br>Para confirmar sus asistencia le solicitamos que dé clic en el siguiente enlace";
				valor_contenido_textarea += "<br><a href='<?= site_url('confirmacion') ?>/"+$("#lista_cursos").val()+"'>Inscribirse a evento</a>";
				valor_contenido_textarea += "<br><br>De antemano agradecemos su atención.";
				valor_contenido_textarea += "<br><br>Saludos cordiales";

				$("#nuevo_correo_contenido").jqteVal(valor_contenido_textarea);
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

				$("#nuevo_correo_plantilla").append('<option value="invitacion" class="plantillas_curso">Invitación al evento</option>');
				$("#nuevo_correo_plantilla").append('<option value="evaluacion" class="plantillas_curso">Evaluación del evento</option>');
				$("#nuevo_correo_plantilla").append('<option value="constancia" class="plantillas_curso">Envío de constancia</option>');
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

		$("#btn_correo_plantilla").click(function(){
			if ($("#form_plantilla").validationEngine('validate')) {
				if ($('#plantilla_id').val() == "") {
					$('#form_plantilla').attr("action", <?php echo('"'.site_url('mensajeria/registrar_plantilla').'"'); ?> );
				}else{
					$('#form_plantilla').attr("action", <?php echo('"'.site_url('mensajeria/editar_plantilla').'"'); ?> );
				}
			}
		});

		$("#form_plantilla").on( "click", ".img_editar_plantilla", function() {
			$.ajax({
				url: "<?= site_url('mensajeria/consulta_plantilla') ?>"+"/"+$(this).attr('id'),
				dataType: 'json',
				type: 'post',
				success: function(resultado) {
					$('input[name=plantilla_asunto]').val(resultado['plantilla_asunto']);
					$('input[name=plantilla_id]').val(resultado['id_plantilla_correo']);
					$('textarea[name=plantilla_contenido]').val(resultado['plantilla_contenido']);
				}
			});
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

		$("#tabla_correos").on( "click", ".img_editar_correo", function() {
			id = $(this).attr('id');
			window.location.href = "<?= site_url('mensajeria/editar_correo') ?>"+"/"+id;
		});

		$("#btn_enviar_correo").click(function(){
			if ($("#frm_enviar_correo").validationEngine('validate')) {
				$.blockUI({
					message: $('#enviando_correo'),
					css: {
						border: 'none',
						padding: '15px',
						backgroundColor: '#000',
						'-webkit-border-radius': '10px',
						'-moz-border-radius': '10px',
						opacity: .5,
						color: '#fff'
					}
				});
			}
		});

		$.ajax("<?= site_url('mensajeria/consulta_instancias')?>", {
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

					$('#instancia_contacto').autocomplete({
						source: instancias,
						change: function(event, ui) {
							if(!ui.item){
								$("#instancia_contacto").val("");
							}
						},
						focus: function(event, ui) {
							return false;
						},
						select: function(event, ui) {
							$("#instancia_contacto").val( ui.item.label );
							return false;
						}
					});
				}
			}
		});

		$("#lista_cursos").change(function(){
			if ($("#lista_cursos").val() != "") {
				var datos = { 'curso_id' : $("#lista_cursos").val() };
				$.ajax("<?= site_url('mensajeria/consulta_invitados_detalles_curso') ?>", {
					dataType: 'json',
					type: 'post',
					data: datos,
					success: function(resultado){
						if (resultado) {
							$('#tabla_invitados_curso tbody').find("tr:gt(0)").remove();
							$("#invitados_curso").find("h2").remove();
							$.each(resultado, function(index, value) {
								$('#tabla_invitados_curso tbody').append('<tr>\
									<td>'+value['contacto_nombre']+' '+value['contacto_ap_paterno']+' '+value['contacto_ap_materno']+'</td>\
									<td>'+value['contacto_correo_inst']+' '+value['contacto_correo_per']+'</td>\
									<td>'+value['contacto_telefono']+'</td>\
									<td>'+value['tipo_contacto_descripcion']+'</td>\
									<td>'+value['instancia_nombre']+'</td>\
									<td>\
										<input type="checkbox" name="curso_invitados[]" value="'+value['id_contacto']+'" checked>\
									</td>\
								</tr>');
							});
						} else {
							$('#invitados_curso table tbody').find("tr:gt(0)").remove();
							$("#invitados_curso").find("h2").remove();
							$('#invitados_curso').append('<h2 class="leyenda_centrada">No ha elegido invitados para este curso<h2>');
						}
					}
		   		});
			}else{
				$('#tabla_invitados_curso tbody').find("tr:gt(0)").remove();
				$("#invitados_curso").find("h2").remove();
			}
		});
    }); 
</script>
<!-- inicia contenido -->
<div class="contenido_dinamico">
	<div id="migaDePan">
		<a href="<?= base_url()?>">Inicio</a> > Env&iacute;o de correos
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

			<fieldset class="seccion_envio_correo">
				<legend>Detalle del correo
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Cuerpo principal del correo, asunto, archivos y cuerpo del correo." class="icon_tooltip">
				</legend>
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
					<label class="label_nuevo_correo" for="nuevo_correo_contenido">Contenido del correo
						<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="El texto introducido puede contener etiquetas de HTML." class="icon_tooltip">
					</label>
					<textarea spellcheck="false" id="nuevo_correo_contenido" class="textarea_cuerpo_correo validate[required]" data-prompt-position="topLeft" name="contenido"></textarea>
				</form>
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
					<input type="radio" form="frm_enviar_correo" name="envio" id="programar_correo_posterior" class="input_envia_correo validate[required] radio" value="1">
					<label for="programar_correo_posterior" class="label_programar_posterior">Programar env&iacute;o</label>
					<br>
					<label class="label_programar_posterior" for="programar_correo_fecha">* Fecha de env&iacute;o</label>
					<input class="input_envia_correo" id="programar_correo_fecha" form="frm_enviar_correo" name="fecha_envio" data-prompt-position="topLeft">
					<br>
					<label class="label_programar_posterior" for="programar_correo_hora">* Hora de env&iacute;o
						<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Formato horario de 24 horas.">
					</label>
					<input type="time" class="input_envia_correo" id="programar_correo_hora" form="frm_enviar_correo" name="hora_envio" data-prompt-position="topLeft">
					<br>
				</div>
			</fieldset>
			<input type="submit" form="frm_enviar_correo" id="btn_enviar_correo">
		</div>

		<div id="tabs-2">
			<form id="frm_buscar_correo" method="POST">
				<label for="asunto_correo">Asunto
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Resumen del contenido u objetivo del correo electrónico.">
				</label>
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

			<div id="despliega_correos">
				<table id="tabla_correos" class='tables'>
					<tr>
						<td>Asunto</td>
						<td>Fecha de creaci&oacute;n</td>
						<td>Fecha y hora de env&iacute;o</td>
						<td>Destinatarios</td>
						<td>Editar
							<br>
							(S&oacute;lo pendientes)
						</td>
					</tr>
				</table>
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
				<label for="plantilla_asunto">Asunto
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Resumen del contenido u objetivo del correo electrónico.">
				</label>
				<input type="text" maxlength="255" name="plantilla_asunto" id="plantilla_asunto" class="validate[required]" form="form_plantilla"/>
				<input type="hidden" name="plantilla_id" id="plantilla_id" form="form_plantilla">
				<textarea spellcheck="false" class="textarea_cuerpo_correo validate[required]" data-prompt-position="topLeft" name="plantilla_contenido" form="form_plantilla" placeholder="Cuerpo del correo electrónico"></textarea>
				<input type="submit" id="btn_correo_plantilla" value="Guardar plantilla" form="form_plantilla">
			</form>
		</div>
		<div id="enviando_correo" style="display: none;">
			<h3>Enviando correo electrónico</h3>
			<img src="<?= base_url('assets/img/email.gif')?>">
		</div>
</div>
<!-- termina contenido -->