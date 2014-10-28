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
		<a href="<?= site_url('cursos')?>">Administrar Cursos y Eventos</a> > Nuevo evento
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
				<p>Los datos marcados con asterisco son obligatorios.</p>
				<legend>Nuevo evento</legend>
				<p class="encabezado_form_nuevo_curso">Datos Generales</p>
				<label for="curso_titulo" class="label_nuevo_curso">* T&iacute;tulo del evento
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Nombre alusivo al curso que será impartido.">
				</label>
				<input type="text" maxlength="255" id="curso_titulo" name="curso_titulo" class="validate[required]">
				<br>
				<label for="curso_flyer" class="label_nuevo_curso">Imagen del evento
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Imagen promocional del curso.">
				</label>
				<input type="file" id="curso_flyer" name="curso_flyer" class="validate[checkFileType[jpg|jpeg|gif|JPG|JPEG|GIF]]"/>
				<br><span class="descripcion_archivos">Formatos permitidos .jpg y .gif</span><br>
				<br>
				<label for="curso_modalidad" class="label_nuevo_curso">* Modalidad del evento
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Indica la modalidad en que se llevará a cabo dicho curso.">
				</label>
				<select name="curso_modalidad" id="curso_modalidad" class="validate[required]">
					<option selected disabled>- Elija un tipo -</option>
					<option value="0">Presencial</option>
					<option value="1">En l&iacute;nea</option>
				</select>
				<br>
				<label for="curso_tipo" class="label_nuevo_curso">* Tipo del evento
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Indica la modalidad en que se llevará a cabo dicho curso.">
				</label>
				<select name="curso_tipo" id="curso_tipo" class="validate[required]">
					<option selected disabled>- Elija un tipo -</option>
					<option value="0">Interno</option>
					<option value="1">Externo</option>
				</select>
				<br>
				<label for="curso_descripcion" class="label_nuevo_curso label_nuevo_curso_textarea">* Descripci&oacute;n del evento
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Explicación detallada del contenido del curso así como del público a quien va dirigido.">
				</label>
				<textarea id="curso_descripcion" name="curso_descripcion" cols="40" rows="4" maxlength="500" placeholder="Ingrese una breve descripción de dicho curso." class="validate[required]"></textarea>
				<br>
				<label for="curso_objetivos" class="label_nuevo_curso label_nuevo_curso_textarea">* Objetivos</label>
				<textarea id="curso_objetivos" name="curso_objetivos" cols="40" rows="4" maxlength="250" placeholder="Ingrese el fin al que se desea llegar, la meta que se pretende lograr con la impartición de dicho curso." class="validate[required]"></textarea>
				<br>
				<label for="curso_temario" class="label_nuevo_curso">* Agenda
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Archivo con el listado del contenido a abordar durante el curso.">
				</label>
				<input type="file" id="curso_temario" name="curso_temario" class="validate[required, checkFileType[pdf]]"/>
				<br><span class="descripcion_archivos">Formatos permitidos .pdf</span>
				<br>

				<p class="encabezado_form_nuevo_curso">Datos del evento</p>

				<label for="curso_fecha_inicio" class="label_nuevo_curso">* Inicio del evento
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Periodo de tiempo en el que se impartirá el curso.">
				</label>
				<input type="text" id="curso_fecha_inicio" name="curso_fecha_inicio" class="input_nuevo_curso_centrado validate[required] datepicker"/>
				<br>
				<label for="curso_fecha_fin" class="label_nuevo_curso">* Fin del evento
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Periodo de tiempo en el que se impartirá el curso.">
				</label>
				<input type="text" id="curso_fecha_fin" name="curso_fecha_fin" class="input_nuevo_curso_centrado validate[required] datepicker"/>
				<br>
				<label for="curso_hora_inicio" class="label_nuevo_curso">* Horario de impartición del evento
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Duración de cada sesión del curso.">
				</label>
				<input type="time" id="curso_hora_inicio" name="curso_hora_inicio" maxlength="5" class="validate[required,custom[hora]]"> a
				<input type="time" id="curso_hora_fin" name="curso_hora_fin" maxlength="5" class="validate[required,custom[hora]]">
				<br>
				<label for="curso_cupo" class="label_nuevo_curso">* Cupo total
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Número máximo de participantes en un curso.">
				</label>
				<input type="text" id="curso_cupo" name="curso_cupo" maxlength="3" class="input_nuevo_curso_cupo validate[required, custom[numero]]">
				<br>
				<label for="contacto_instancias" class="label_nuevo_curso_textarea label_nuevo_curso">Instructor(es) a asignar
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Señala el o los instructores que estarán asignados para impartir dicho curso. Presiona la tecla Ctrl+">
				</label>
				<select name="curso_instructor[]" id="curso_instructor" size=10 multiple>
					<option value="" disabled>- Seleccione una o m&aacute;s opciones -</option>
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
				<label for="curso_telefono" class="label_nuevo_curso">* Tel&eacute;fono</label>
				<input type="text" id="curso_telefono" name="curso_telefono" size="10" maxlength="10" class="input_frm_nuevo validate[required, custom[numero]]">
				<label for="curso_telefono_extension">ext.</label>
				<input type="text" id="curso_telefono_extension" name="curso_telefono_extension" size="5" maxlength="5" class="validate[custom[numero]]">
				<br>
				<label for="curso_entidad" class="label_nuevo_curso">* Entidad u organización
				<!-- <img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Indica el lugar exacto en el que se llevará a cabo el curso, por ejemplo entidad, edificio, salón, etc."> -->
				</label>
				<input type="text" maxlength="100" id="curso_entidad" name="curso_entidad"  class="validate[required]">
				<br>
				<label class="label_nuevo_curso">* Costo
				<!-- <img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Indica el lugar exacto en el que se llevará a cabo el curso, por ejemplo entidad, edificio, salón, etc."> -->
				</label>
				<input type="radio" name="curso_costo" value="1" class="validate[required]">Si
				<input type="radio" name="curso_costo" value="0" class="validate[required]">No
				<input type="hidden" name="curso_evento" value="1">
				<br>
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