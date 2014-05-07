<script>
    $(document).ready(function(){
        $("#frm_nuevo_curso").validationEngine({promptPosition: "centerRight"});

        $("#menu_cursos").addClass("seleccion_menu");

        $(document).tooltip();

		$(function() {
		    $( "#tabs" ).tabs();
		});

		$( "#curso_fecha_inicio" ).datepicker({
			changeMonth: true,
			numberOfMonths: 2,
			minDate: 0,
			showOn: "both",
			buttonImage: "<?= base_url('assets/img/calendar.gif')?>",
			buttonImageOnly: true,
			dateFormat: "dd/mm/yy",
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
			dateFormat: "dd/mm/yy",
			onClose: function( selectedDate ) {
			$( "#curso_fecha_inicio" ).datepicker( "option", "maxDate", selectedDate );
			}
		});

    });
</script>
<!-- inicia contenido -->
<div class="contenido_dinamico">
	<div id="migaDePan">
		<a href="<?= base_url()?>">Inicio</a> > 
		<a href="<?= site_url('contactos')?>">Administrar Contactos</a> > Nuevo contacto
	</div>

	<div id="tabs">
		<ul>
			<li><a href="#tabs-1">Datos Generales</a></li>
			<li><a href="#tabs-2">Administrar Invitados</a></li>
			<li><a href="#tabs-3">Configuración Registro en L&iacute;nea</a></li>
		</ul>
		<div id="tabs-1">
			<form id="frm_nuevo_curso">
				<p class="encabezado_form_nuevo_curso">Datos Generales</p>
				<label for="curso_titulo" class="label_nuevo_curso">* T&iacute;tulo del curso</label>
				<input type="text" maxlength="255" id="curso_titulo" name="curso_titulo" class="validate[required]">
				<br>
				<label for="curso_tipo" class="label_nuevo_curso">* Tipo de contacto
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Indica la modalidad en que se llevará a cabo dicho curso.">
				</label>
				<select name="curso_tipo" id="curso_tipo" class="validate[required]">
					<option selected disabled>- Elija un tipo -</option>
					<option value="1">Presencial</option>
					<option value="2">En l&iacute;nea</option>
				</select>
				<br>
				<label for="curso_descripcion" class="label_nuevo_curso">* Descripci&oacute;n del curso</label>
				<textarea id="curso_descripcion" name="curso_descripcion" cols="40" rows="4" maxlength="255" placeholder="Ingrese una breve descripción de dicho curso." class="validate[required]"></textarea>
				<br>
				<label for="curso_objetivos" class="label_nuevo_curso">* Objetivos</label>
				<textarea id="curso_objetivos" name="curso_objetivos" cols="40" rows="4" maxlength="255" placeholder="Ingrese el fin al que se desea llegar, la meta que se pretende lograr con la impartición de dicho curso." class="validate[required]"></textarea>
				<br>
				<label for="curso_temario" class="label_nuevo_curso">* Temario</label>
				<textarea id="curso_temario" name="curso_temario" cols="40" rows="4" maxlength="255" placeholder="Ingrese el conjunto de temas que se proponen para su estudio en el curso." class="validate[required]"></textarea>
				<br>

				<p class="encabezado_form_nuevo_curso">Datos del evento</p>

				<label for="curso_fecha_inicio" class="label_nuevo_curso">* Inicio de curso</label>
				<input type="text" id="curso_fecha_inicio" name="curso_fecha_inicio" class="validate[required]"/>
				<br>
				<label for="curso_fecha_fin" class="label_nuevo_curso">* Fin de curso</label>
				<input type="text" id="curso_fecha_fin" name="curso_fecha_fin" class="validate[required]"/>
				<br>
				<label for="curso_hora_inicio" class="label_nuevo_curso">* Horario</label>
				<input type="text" id="curso_hora_inicio" name="curso_hora_inicio" class="validate[required]"> a
				<input type="text" id="curso_hora_fin" name="curso_hora_fin" class="validate[required]">
				<br>
				<label for="curso_cupo" class="label_nuevo_curso">Cupo total
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Se determina el número máximo de participantes en un curso, sólo permite valores numéricos.">
				</label>
				<input type="text" id="curso_cupo" name="curso_cupo" class="validate[custom[numero]]">
				<br>
				<label for="contacto_instancias" class="label_nuevo_curso">* Profesor
					<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Señala el o los instructores que estarán asignados para impartir dicho curso.">
				</label>
				<input type="search" name="contacto_instancia_nombre" id="contacto_instancias" class="input_frm_nuevo validate[required]">
				<input type="hidden" name="contacto_instancia" id="id_instancia" class="input_frm_nuevo validate[required]">
				<br>
				<label for="curso_ubicacion" class="label_nuevo_curso">Ubicaci&oacute;n
				<img src="<?= base_url('assets/img/icono_tooltip.gif')?>" title="Indica el lugar exacto en el que se llevará a cabo el curso, por ejemplo entidad, edificio, salón, etc.">
				</label>
				<input type="text" maxlength="250" id="curso_ubicacion" name="curso_ubicacion">
				<br>
				<label for="curso_url_ubicacion" class="label_nuevo_curso">URL de mapa de localizaci&oacute;n</label>
				<input type="text" maxlength="250" id="curso_url_ubicacion" name="curso_url_ubicacion">
				<br>
				<label for="curso_telefono" class="label_nuevo_curso">T&eacute;lefono</label>
				<input type="text" id="curso_telefono" name="curso_telefono" size="10" maxlength="10" class="input_frm_nuevo validate[custom[numero]]">
				<label for="curso_extension">ext.</label>
				<input type="text" id="curso_extension" name="curso_extension" size="5" maxlength="5" class="validate[custom[numero]]">

				<br>
				

				<div id="botones_envio">
					<input type="submit" id="btn_guardar" value="Guardar">
				</div>
			</form>
		</div>
		<div id="tabs-2">
			<p>Morbi tincidunt, dui sit amet facilisis feugiat, odio metus gravida ante, ut pharetra massa metus id nunc. Duis scelerisque molestie turpis. Sed fringilla, massa eget luctus malesuada, metus eros molestie lectus, ut tempus eros massa ut dolor. Aenean aliquet fringilla sem. Suspendisse sed ligula in ligula suscipit aliquam. Praesent in eros vestibulum mi adipiscing adipiscing. Morbi facilisis. Curabitur ornare consequat nunc. Aenean vel metus. Ut posuere viverra nulla. Aliquam erat volutpat. Pellentesque convallis. Maecenas feugiat, tellus pellentesque pretium posuere, felis lorem euismod felis, eu ornare leo nisi vel felis. Mauris consectetur tortor et purus.</p>
		</div>
		<div id="tabs-3">
			<p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>
			<p>Duis cursus. Maecenas ligula eros, blandit nec, pharetra at, semper at, magna. Nullam ac lacus. Nulla facilisi. Praesent viverra justo vitae neque. Praesent blandit adipiscing velit. Suspendisse potenti. Donec mattis, pede vel pharetra blandit, magna ligula faucibus eros, id euismod lacus dolor eget odio. Nam scelerisque. Donec non libero sed nulla mattis commodo. Ut sagittis. Donec nisi lectus, feugiat porttitor, tempor ac, tempor vitae, pede. Aenean vehicula velit eu tellus interdum rutrum. Maecenas commodo. Pellentesque nec elit. Fusce in lacus. Vivamus a libero vitae lectus hendrerit hendrerit.</p>
		</div>
	</div>

</div>
<!-- termina contenido -->