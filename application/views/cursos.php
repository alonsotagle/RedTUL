<script>
    $(document).ready(function(){

    	$("#frm_buscar_curso").validationEngine({promptPosition: "centerRight"});

        $("#menu_cursos").addClass("seleccion_menu");

		cursos_paginacion(10, 1);

        $( "#inicio_curso" ).datepicker({
			changeMonth: true,
			numberOfMonths: 2,
			showOn: "both",
			buttonImage: "<?= base_url('assets/img/calendar.gif')?>",
			buttonImageOnly: true,
			onClose: function( selectedDate ) {
			if (selectedDate != ""){
				$( "#fin_curso" ).datepicker( "option", "minDate", selectedDate );
			}
				$( "#fin_curso" ).datepicker( "option", "defaultDate", selectedDate );
			}
		});

		$( "#fin_curso" ).datepicker({
			changeMonth: true,
			numberOfMonths: 2,
			showOn: "both",
			buttonImage: "<?= base_url('assets/img/calendar.gif')?>",
			buttonImageOnly: true,
			onClose: function( selectedDate ) {
			$( "#inicio_curso" ).datepicker( "option", "maxDate", selectedDate );
			}
		});

		$("#despliega_cursos").on("click", "table tbody tr td .eliminar_curso", function(){
			var eliminar = confirm("¿Está seguro de eliminar el curso?");
			if (eliminar) {
				return true;
			}else{
				return false;
			}
		});

		$("#btn_buscar_curso").click(function(event){
			event.preventDefault();
			if ($("#frm_buscar_curso").validationEngine('validate')) {
				var datos = {
					'nombre_curso' 		: $('#nombre_curso').val(),
					'tipo_curso' 		: $('#tipo_curso').val(),
					'estatus_curso' 	: $('#estatus_curso').val(),
					'inicio_curso'		: $('#inicio_curso').val(),
					'fin_curso'			: $('#fin_curso').val(),
					'instructor_curso'	: $('#instructor_curso').val()
				};

				$.ajax("<?= site_url('cursos/buscar')?>", {
					dataType: 'json',
					data: datos,
					type: 'post',
					success: function(resultado){
						if (resultado) {
							$('#despliega_cursos table tbody').find("tr:gt(0)").remove();
							$("#despliega_cursos").find("h2").remove();
							$.each(resultado, function( index, value ) {
								var url_detalle = "<?= site_url('cursos/detalle_curso') ?>";
								url_detalle += "/" + value['id_curso'];

								var curso_fecha_inicio = value['curso_fecha_inicio'].split("-");
								var curso_fecha_fin = value['curso_fecha_fin'].split("-");

								var datos_curso_renglon ='<tr>\
									<td><a href="'+url_detalle+'" class="link_detalle">'+value['curso_titulo']+'</a></td>\
									<td>'+value['curso_tipo']+'</td>\
									<td>';

								if (value['curso_instructor'] != null) {
									$.each(value['curso_instructor'], function(index, value){
										datos_curso_renglon += value['contacto_nombre']+" "+value['contacto_ap_paterno']+" "+value['contacto_ap_materno']+"<br><br>";
									});
								}else{
									datos_curso_renglon += "¡Instructor eliminado! Asignar instructor";
								}

								datos_curso_renglon += '</td>\
									<td>'+value['estatus_curso_descripcion']+'</td>\
									<td>'+curso_fecha_inicio[2]+"/"+curso_fecha_inicio[1]+"/"+curso_fecha_inicio[0]+' a '+curso_fecha_fin[2]+"/"+curso_fecha_fin[1]+"/"+curso_fecha_fin[0]+'</td>\
									<td>'+value['curso_hora_inicio']+' a '+value['curso_hora_fin']+'</td>\
									<td>'+value['curso_cupo']+'</td>\
									<td>'+value['curso_cupo_disponible']+'</td>\
									<td class="curso_acciones"><a href="'+"<?= site_url('cursos/editar')?>"+"/"+value['id_curso']+'">\
										<img src="'+"<?= base_url('assets/img/icono_editar.png')?>"+'" title="Editar">\
									</a><br>\
									<a href="'+"<?= site_url('cursos/eliminar')?>"+"/"+value['id_curso']+'" class="eliminar_curso" >\
										<img src="'+"<?= base_url('assets/img/icono_borrar.png')?>"+'" title="Eliminar">\
									</a><br>\
									<a href="'+"<?= site_url('cursos/agregar_material')?>"+"/"+value['id_curso']+'">\
										<img src="'+"<?= base_url('assets/img/icono_agregar_material.png')?>"+'" title="Añadir material">\
									</a><br>\
									<a href="'+"<?= site_url('cursos/lista_asistencia')?>"+"/"+value['id_curso']+'">\
										<img src="'+"<?= base_url('assets/img/icono_lista_asistencia.png')?>"+'" title="Generar lista de asistencia">\
									</a></td>\
								</tr>';

								$('#despliega_cursos table tbody').append(datos_curso_renglon);
							});
						}else{
							$('#despliega_cursos table tbody').find("tr:gt(0)").remove();
							$("#despliega_cursos").find("h2").remove();
							$('#despliega_cursos').append('<h2 class="leyenda_centrada">No hay resultados de búsqueda para los datos especificados<h2>');
						}
					}
				});
			}
		});

		$("#paginacion_cursos").pagination({
	        items: <?= $num_cursos ?>,
	        itemsOnPage: 10,
	        onPageClick : function(currentPageNumber, event){
				cursos_paginacion(this.itemsOnPage, currentPageNumber)
			}
	    });

	    function cursos_paginacion(items, pagina){
	    	$.ajax("<?= site_url('cursos/paginacion')?>", {
				dataType: 'json',
				type: 'post',
				data: {
					'num_despliegue' : items,
					'num_pagina': pagina
				},
				success: function(resultado){
					if (resultado) {
						$.each(resultado, function( index, value ) {
							var url_detalle = "<?= site_url('cursos/detalle_curso') ?>";
							url_detalle += "/" + value['id_curso'];

							var curso_fecha_inicio = value['curso_fecha_inicio'].split("-");
							var curso_fecha_fin = value['curso_fecha_fin'].split("-");

							var datos_curso_renglon = "";
							datos_curso_renglon += '<tr>\
								<td><a href="'+url_detalle+'" class="link_detalle">'+value['curso_titulo']+'</a></td>\
								<td>'+value['curso_tipo']+'</td>';

							datos_curso_renglon += '<td>';

							if (value['curso_instructor'] != null) {
								$.each(value['curso_instructor'], function(index, value){
									datos_curso_renglon += value['contacto_nombre']+" "+value['contacto_ap_paterno']+" "+value['contacto_ap_materno']+"<br><br>";
								});
							}else{
								datos_curso_renglon += "¡Instructor eliminado! Asignar instructor";
							}

							datos_curso_renglon += '</td>';

							var etiqueta_material;
							if (value['estatus_curso_descripcion'] == "Finalizado") {
								etiqueta_material = '<a href="'+"<?= site_url('cursos/agregar_material')?>"+"/"+value['id_curso']+'">\
										<img src="'+"<?= base_url('assets/img/icono_agregar_material.png')?>"+'" title="Añadir material">\
									</a>';
							}else{
								etiqueta_material = '<img src="'+"<?= base_url('assets/img/icono_material_no_finalizado.png')?>"+'" title="El curso o evento no ha finalizado.">';
							}

							var etiqueta_lista;
							if (value['curso_tipo'] == "Externo") {
								etiqueta_lista = '<img src="'+"<?= base_url('assets/img/icono_no_lista_asistencia.png')?>"+'" title="No se puede generar lista de asistencia porque el curso o evento es de tipo externo.">';
							}else{
								etiqueta_lista = '<a href="'+"<?= site_url('cursos/lista_asistencia')?>"+"/"+value['id_curso']+'">\
									<img src="'+"<?= base_url('assets/img/icono_lista_asistencia.png')?>"+'" title="Generar lista de asistencia">\
								</a>';
							}

							datos_curso_renglon += '<td>'+value['estatus_curso_descripcion']+'</td>\
								<td>'+curso_fecha_inicio[2]+"/"+curso_fecha_inicio[1]+"/"+curso_fecha_inicio[0]+' a '+curso_fecha_fin[2]+"/"+curso_fecha_fin[1]+"/"+curso_fecha_fin[0]+'</td>\
								<td>'+value['curso_hora_inicio']+' a '+value['curso_hora_fin']+'</td>\
								<td>'+value['curso_cupo']+'</td>\
								<td>'+value['curso_cupo_disponible']+'</td>\
								<td class="curso_acciones"><a href="'+"<?= site_url('cursos/editar')?>"+"/"+value['id_curso']+'">\
									<img src="'+"<?= base_url('assets/img/icono_editar.png')?>"+'" title="Editar">\
								</a><br>\
								<a href="'+"<?= site_url('cursos/eliminar')?>"+"/"+value['id_curso']+'" class="eliminar_curso" >\
									<img src="'+"<?= base_url('assets/img/icono_borrar.png')?>"+'" title="Eliminar">\
								</a><br>'+etiqueta_material+'<br>'+etiqueta_lista+'</td>\
							</tr>';

							$('#despliega_cursos table tbody').append(datos_curso_renglon);
						});
					}else{
						$('#despliega_cursos').html('No hay cursos registrados');
					}
				}
	    	});
    	}
	});
</script>
<!-- inicia contenido -->
<div class="contenido_dinamico">
	<div id="migaDePan">
		<a href="<?= base_url()?>">Inicio</a> > Administrar Cursos
	</div>

	<form id="frm_buscar_curso" method="POST">
		<label for="tipo_curso">Tipo de curso o evento</label>
		<select name="tipo_curso" id="tipo_curso" class="buscar_curso_textInput validate[groupRequired[buscar_curso]]">
			<option selected value="">- Elija un tipo -</option>
			<option value="0">Interno</option>
			<option value="1">Externo</option>
		</select>
		<label for="nombre_curso">Título de curso o evento</label>
		<input type="text" maxlength="100" id="nombre_curso" name="nombre_curso" class="buscar_curso_textInput validate[groupRequired[buscar_curso]]"/>
		<label for="modalidad_curso">Modalidad de curso o evento</label>
		<select name="modalidad_curso" id="modalidad_curso" class="buscar_curso_textInput validate[groupRequired[buscar_curso]]">
			<option selected value="">- Elija un tipo -</option>
			<option value="0">Presencial</option>
			<option value="1">En l&iacute;nea</option>
		</select>
		<label for="instructor_curso">Instructor(es)/Ponentes</label>
		<input type="text" maxlength="100" id="instructor_curso" name="instructor_curso" class="buscar_curso_textInput validate[groupRequired[buscar_curso]]"/>
		<label for="estatus_curso">Estatus de curso o evento</label>
		<select name="estatus_curso" id="estatus_curso" class="buscar_curso_textInput validate[groupRequired[buscar_curso]]">
			<option selected value="">- Elija un tipo -</option>
			<option value="1">Vigente</option>
			<option value="2">Pr&oacute;ximo</option>
			<option value="3">Finalizado</option>
		</select>
		<label for="inicio_curso">Por Fecha</label>
		<input type="text" id="inicio_curso" name="inicio_curso" size="11" class="buscar_curso_fechas validate[condRequired[fin_curso], groupRequired[buscar_curso]] datepicker"/>
		y
		<input type="text" id="fin_curso" name="fin_curso" size="11" class="buscar_curso_fechas validate[condRequired[inicio_curso], groupRequired[buscar_curso]] datepicker"/>
		<br>
		<input type="submit" id="btn_buscar_curso" value="Buscar"/>
	</form>

	<div id="despliega_cursos">
		<table class='tables'>
			<tr>
				<td>T&iacute;tulo</td>
				<td>Tipo</td>
				<td>Instructor asignado</td>
				<td>Estatus</td>
				<td>Vigencia</td>
				<td>Horario</td>
				<td>Cupo total</td>
				<td>Cupo disponible</td>
				<td>Acciones</td>
			</tr>
		</table>
	</div>

	<div id="paginacion_cursos"></div>

	<a href="<?= site_url('cursos/nuevo_evento')?>">
		<input type="button" class="btn_nuevo_curso" value="Nuevo evento"/>
	</a>
	<a href="<?= site_url('cursos/nuevo_curso')?>">
		<input type="button" class="btn_nuevo_curso" value="Nuevo curso"/>
	</a>
</div>
<!-- termina contenido -->