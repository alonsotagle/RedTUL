<script>
    $(document).ready(function(){
        $("#frm_buscar_curso").validationEngine({promptPosition: "centerRight"});

        $("#menu_cursos").addClass("seleccion_menu");

        $( "#inicio_curso" ).datepicker({
			changeMonth: true,
			numberOfMonths: 2,
			minDate: 0,
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
			minDate: 0,
			showOn: "both",
			buttonImage: "<?= base_url('assets/img/calendar.gif')?>",
			buttonImageOnly: true,
			onClose: function( selectedDate ) {
				$( "#inicio_curso" ).datepicker( "option", "maxDate", selectedDate );
			}
		});

    }); 
</script>
<!-- inicia contenido -->
<div class="contenido_dinamico">
	<div id="migaDePan">
		<a href="<?= base_url()?>">Inicio</a> > Administrar Cursos
	</div>

	<form id="frm_buscar_curso" action="<?= base_url()?>" method="POST">
			<label for="nombre_curso">Nombre curso</label>
			<input type="text" id="nombre_curso" name="nombre_curso" class="buscar_curso_textInput validate[required]"/>
			<label for="tipo_curso">Tipo de curso</label>
			<select name="tipo_curso" id="tipo_curso" class="buscar_curso_textInput validate[required]">
				<option selected disabled>- Elija un tipo -</option>
				<option value="0">Presencial</option>
				<option value="1">En l&iacute;nea</option>
			</select>
			<label for="instructor_curso">Instructor asignado</label>
			<input type="text" id="instructor_curso" name="instructor_curso" class="buscar_curso_textInput validate[required]"/>
			<label for="estatus_curso">Estatus</label>
			<select name="estatus_curso" id="estatus_curso" class="buscar_curso_textInput validate[required]">
				<option selected disabled>- Elija un tipo -</option>
				<option value="1">Vigente</option>
				<option value="2">Pr&oacute;ximo</option>
				<option value="3">Finalizado</option>
			</select>
			<label for="inicio_curso">Inicio de curso</label>
			<input type="text" id="inicio_curso" name="inicio_curso" class="buscar_curso_fechas validate[required]"/>
			<label for="fin_curso">Fin de curso</label>
			<input type="text" id="fin_curso" name="fin_curso" class="buscar_curso_fechas validate[required]"/>

			<input type="submit" id="btn_buscar_contacto" value="Buscar"/>
	</form>

	<table class="tables">
		<tr>
			<td>Nombre</td>
			<td>Tipo</td>
			<td>Instructor asignado</td>
			<td>Estatus</td>
			<td>Fecha inicio</td>
			<td>Fecha termino</td>
			<td>Horario</td>
			<td>Total invitados</td>
			<td>Cupo disponible</td>
		</tr>
	</table>

	<a href="<?= base_url('index.php/cursos/nuevo')?>">
		<input type="button" id="btn_nuevo_curso" value="Nuevo curso"/>
	</a>

</div>
<!-- termina contenido -->