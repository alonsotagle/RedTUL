<script>
    $(document).ready(function(){

    	$.ajax("<?= site_url('cursos/consulta_cursos')?>", {
		dataType: 'json',
		type: 'post',
		success: function(resultado)
		{
			if (resultado != null) {
				$('#despliega_cursos').html("<table class='tables'>\
					<tr>\
						<td>Nombre</td>\
						<td>Tipo</td>\
						<td>Instructor asignado</td>\
						<td>Estatus</td>\
						<td>Vigencia</td>\
						<td>Horario</td>\
						<td>Cupo total</td>\
						<td>Cupo disponible</td>\
						<td>Editar</td>\
						<td>Eliminar</td>\
					</tr>\
				</table>");

				$.each(resultado, function( index, value ) {
					var url_detalle = "<?= site_url('cursos/detalle_curso') ?>";
					url_detalle += "/" + value['id_curso'];

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

					datos_curso_renglon += '<td>'+value['estatus_curso_descripcion']+'</td>\
						<td>'+value['curso_fecha_inicio']+' a '+value['curso_fecha_fin']+'</td>\
						<td>'+value['curso_hora_inicio']+' a '+value['curso_hora_fin']+'</td>\
						<td>'+value['curso_cupo']+'</td>\
						<td>'+value['curso_cupo_disponible']+'</td>\
						<td><a \
						href="'+"<?= site_url('cursos/editar')?>"+"/"+value['id_curso']+'">\
						<img \
						src="'+"<?= base_url('assets/img/icono_editar.png')?>"+'">\
						</a></td>\
						<td><a \
						href="'+"<?= site_url('cursos/eliminar')?>"+"/"+value['id_curso']+'" class="eliminar_curso">\
						<img \
						src="'+"<?= base_url('assets/img/icono_borrar.png')?>"+'">\
						</a></td>\
					</tr>';

					$('#despliega_cursos table tbody').append(datos_curso_renglon);
				});
			}else{
				$('#despliega_cursos').html('No hay cursos registrados');
			}
		}
		});

        $("#frm_buscar_curso").validationEngine({promptPosition: "centerRight"});

        $("#menu_cursos").addClass("seleccion_menu");

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

    }); 
</script>
<!-- inicia contenido -->
<div class="contenido_dinamico">
	<div id="migaDePan">
		<a href="<?= base_url()?>">Inicio</a> > Administrar Cursos
	</div>

	<form id="frm_buscar_curso" action="<?= site_url('cursos/buscar')?>" method="POST">
			<label for="nombre_curso">Nombre curso</label>
			<input type="text" maxlength="100" id="nombre_curso" name="nombre_curso" class="buscar_curso_textInput validate[groupRequired[buscar_curso]]"/>
			<label for="tipo_curso">Tipo de curso</label>
			<select name="tipo_curso" id="tipo_curso" class="buscar_curso_textInput validate[groupRequired[buscar_curso]]">
				<option selected value="">- Elija un tipo -</option>
				<option value="0">Presencial</option>
				<option value="1">En l&iacute;nea</option>
			</select>
			<label for="instructor_curso">Instructor asignado</label>
			<input type="text" maxlength="100" id="instructor_curso" name="instructor_curso" class="buscar_curso_textInput validate[groupRequired[buscar_curso]]"/>
			<label for="estatus_curso">Estatus</label>
			<select name="estatus_curso" id="estatus_curso" class="buscar_curso_textInput validate[groupRequired[buscar_curso]]">
				<option selected value="">- Elija un tipo -</option>
				<option value="1">Vigente</option>
				<option value="2">Pr&oacute;ximo</option>
				<option value="3">Finalizado</option>
			</select>
			<label for="inicio_curso">Cursos impartidos entre</label>
			<input type="text" id="inicio_curso" name="inicio_curso" size="11" class="buscar_curso_fechas validate[condRequired[fin_curso], groupRequired[buscar_curso]] datepicker"/>
			y
			<input type="text" id="fin_curso" name="fin_curso" size="11" class="buscar_curso_fechas validate[condRequired[inicio_curso], groupRequired[buscar_curso]] datepicker"/>

			<input type="submit" id="btn_buscar_contacto" value="Buscar"/>
	</form>

	<div id="despliega_cursos"></div>

	<a href="<?= base_url('index.php/cursos/nuevo')?>">
		<input type="button" id="btn_nuevo_curso" value="Nuevo curso"/>
	</a>

</div>
<!-- termina contenido -->