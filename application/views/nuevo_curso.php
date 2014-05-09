<script>
    $(document).ready(function(){
    	
        $("#frm_nuevo_curso").validationEngine({
        	promptPosition: "centerRight"
        });

        $("#menu_cursos").addClass("seleccion_menu");

        $(document).tooltip();

		$(function() {
		    $( "#tabs" ).tabs({ disabled: [ 1, 2 ] });
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

		$.ajax("<?= site_url('cursos/consulta_instructores')?>", {
			dataType: 'json',
			type: 'post',
			success: function(resultado){
				if (resultado != null)
					$.each(resultado, function(index, value ){
						$("#curso_instructor").append("<option value='"+value['id_contacto']+"'>"+value['contacto_nombre']+" "+value['contacto_ap_paterno']+" "+ value['contacto_ap_materno']+"</option>");
					});
			}
		});

    });
</script>
<!-- inicia contenido -->
<div class="contenido_dinamico">
	<div id="migaDePan">
		<a href="<?= base_url()?>">Inicio</a> > 
		<a href="<?= site_url('cursos')?>">Administrar Cursos</a> > Nuevo curso
	</div>

	<div id="tabs">
		<ul>
			<li><a href="#tabs-1">Datos Generales</a></li>
			<li><a href="#tabs-2">Administrar Invitados</a></li>
			<li><a href="#tabs-3">Configuración Registro en L&iacute;nea</a></li>
		</ul>
		<div id="tabs-1">
			<form id="frm_nuevo_curso" action="<?= site_url('cursos/registrar_curso')?>" method="POST" enctype="multipart/form-data">
				<fieldset>
				<legend>Nuevo curso</legend>
				<p class="encabezado_form_nuevo_curso">Datos Generales</p>
				<label for="curso_titulo" class="label_nuevo_curso">* T&iacute;tulo del curso</label>
				<input type="text" maxlength="255" id="curso_titulo" name="curso_titulo" class="validate[required]">
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
				<label for="curso_descripcion" class="label_nuevo_curso label_nuevo_curso_textarea">* Descripci&oacute;n del curso</label>
				<textarea id="curso_descripcion" name="curso_descripcion" cols="40" rows="4" maxlength="500" placeholder="Ingrese una breve descripción de dicho curso." class="validate[required]"></textarea>
				<br>
				<label for="curso_objetivos" class="label_nuevo_curso label_nuevo_curso_textarea">* Objetivos</label>
				<textarea id="curso_objetivos" name="curso_objetivos" cols="40" rows="4" maxlength="250" placeholder="Ingrese el fin al que se desea llegar, la meta que se pretende lograr con la impartición de dicho curso." class="validate[required]"></textarea>
				<br>
				<label for="curso_temario" class="label_nuevo_curso">* Temario</label>
				<input type="file" id="curso_temario" name="curso_temario" /> <!-- class="validate[required, checkFileType[pdf]]" -->
				<br>

				<p class="encabezado_form_nuevo_curso">Datos del evento</p>

				<label for="curso_fecha_inicio" class="label_nuevo_curso">* Inicio de curso</label>
				<input type="text" id="curso_fecha_inicio" name="curso_fecha_inicio" class="input_nuevo_curso_centrado validate[required] datepicker"/>
				<br>
				<label for="curso_fecha_fin" class="label_nuevo_curso">* Fin de curso</label>
				<input type="text" id="curso_fecha_fin" name="curso_fecha_fin" class="input_nuevo_curso_centrado validate[required] datepicker"/>
				<br>
				<label for="curso_hora_inicio" class="label_nuevo_curso">* Horario</label>
				<input type="text" id="curso_hora_inicio" name="curso_hora_inicio" maxlength="5" class="label_nuevo_curso_hora validate[required,custom[hora]]"> a
				<input type="text" id="curso_hora_fin" name="curso_hora_fin" maxlength="5" class="label_nuevo_curso_hora validate[required,custom[hora]]">
				<br>
				<label for="curso_cupo" class="label_nuevo_curso">Cupo total
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Se determina el número máximo de participantes en un curso, sólo permite valores numéricos.">
				</label>
				<input type="text" id="curso_cupo" name="curso_cupo" maxlength="3" class="input_nuevo_curso_cupo validate[custom[numero]]">
				<br>
				<label for="contacto_instancias" class="label_nuevo_curso">* Profesor
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Señala el o los instructores que estarán asignados para impartir dicho curso.">
				</label>

				<select name="curso_instructor" id="curso_instructor" class="validate[required]">
					<option value="" disabled selected>- Seleccione una opción -</option>
				</select>  
				<!-- <input type="search" name="curso_instructor_nombre" id="curso_instructores" class="validate[required]"> -->
				<!-- <input type="hidden" name="curso_instructor" id="id_instructor" class="validate[required]"> -->
				<br>
				<label for="curso_ubicacion" class="label_nuevo_curso">Ubicaci&oacute;n
				<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Indica el lugar exacto en el que se llevará a cabo el curso, por ejemplo entidad, edificio, salón, etc.">
				</label>
				<input type="text" maxlength="250" id="curso_ubicacion" name="curso_ubicacion">
				<br>
				<label for="curso_url_ubicacion" class="label_nuevo_curso">URL de mapa de localizaci&oacute;n</label>
				<input type="text" id="curso_url_ubicacion" name="curso_url_ubicacion">
				<br>
				<label for="curso_telefono" class="label_nuevo_curso">T&eacute;lefono</label>
				<input type="text" id="curso_telefono" name="curso_telefono" size="10" maxlength="10" class="input_frm_nuevo validate[custom[numero]]">
				<label for="curso_telefono_extension">ext.</label>
				<input type="text" id="curso_telefono_extension" name="curso_telefono_extension" size="5" maxlength="5" class="validate[custom[numero]]">
				<div id="botones_envio">
					<input type="submit" id="btn_guardar" value="Guardar">
				</div>
				</fieldset>
			</form>
		</div>
		<div id="tabs-2">

		</div>
		<div id="tabs-3">
		
		</div>
	</div>

</div>
<!-- termina contenido -->