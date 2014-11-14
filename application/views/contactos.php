<script type="text/javascript">
$(document).ready(function(){

	$("#frm_buscar_contacto").validationEngine({promptPosition: "centerRight", scroll: false});

    $("#menu_contactos").addClass("seleccion_menu");

	$.ajax("<?= site_url('contactos/consulta_instancias')?>", {
		dataType: 'json',
		type: 'post',
		success: function(resultado)
		{
			if (resultado) {

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

	$.ajax("<?= site_url('contactos/consulta_contactos')?>", {
	dataType: 'json',
	type: 'post',
	success: function(resultado)
	{
		if (resultado) {

			$.each(resultado, function( index, value ) {
				var url_detalle = "<?= site_url('contactos/detalle_contacto') ?>";
				url_detalle += "/" + value['id_contacto'];

				if (value['instancia_nombre'].length > 25) {
					instancia_nombre = '<span title="'+value['instancia_nombre']+'">'+value['instancia_nombre'].slice(0,25)+'...</span>';
				}else{
					instancia_nombre = value['instancia_nombre'];
				}

				$('#despliega_contactos table tbody').append('<tr>\
					<td>'+value['contacto_IDU']+'</td>\
					<td><a href="'+url_detalle+'" class="link_detalle">'+value['contacto_ap_paterno']+' '+value['contacto_ap_materno']+' '+value['contacto_nombre']+'</a></td>\
					<td>'+value['rol_contacto_descripcion']+'</td>\
					<td>'+value['tipo_contacto_descripcion']+'</td>\
					<td>'+value['contacto_estatus']+'</td>\
					<td>'+instancia_nombre+'</td>\
					<td>'+value['contacto_correo_inst']+'</td>\
					<td>'+value['contacto_correo_per']+'</td>\
					<td class="contacto_acciones"><a \
					href="'+"<?= site_url('contactos/editar')?>"+"/"+value['id_contacto']+'">\
					<img \
					src="'+"<?= base_url('assets/img/icono_editar.png')?>"+'" title="Editar">\
					</a><br>\
					<a href="'+"<?= site_url('contactos/eliminar')?>"+"/"+value['id_contacto']+'" class="eliminar_contacto">\
					<img src="'+"<?= base_url('assets/img/icono_borrar.png')?>"+'" title="Eliminar">\
					</a></td>\
				</tr>');
			});
		}else{
			$('#despliega_contactos').html('No hay contactos registrados.');
		}
	}
	});

	$("#despliega_contactos").on("click", "table tbody tr td .eliminar_contacto", function(){
		var eliminar = confirm("¿Está seguro de eliminar el contacto?");
		if (eliminar) {
			return true;
		}else{
			return false;
		}
	});

    $("#btn_buscar_contacto").click(function(event){
		event.preventDefault();
		if ($("#frm_buscar_contacto").validationEngine('validate')) {
			var datos = {
				'nombre_contacto' 	: $('#nombre_contacto').val(),
				'correo_contacto' 	: $('#correo_contacto').val(),
				'tipo_contacto' 	: $('#tipo_contacto').val(),
				'instancia_contacto': $('#instancia_contacto').val(),
				'instructor_contacto': $('#instructor_contacto').val()
			};

			$.ajax({
				url: "<?= site_url('contactos/buscar') ?>",
				data: datos,
				dataType: 'json',
				type: 'post',
				success: function(resultado) {
					if (resultado) {
						$('#despliega_contactos table tbody').find("tr:gt(0)").remove();
						$("#despliega_contactos").find("h2").remove();
						$.each(resultado, function(index, value) {
							var url_detalle = "<?= site_url('contactos/detalle_contacto') ?>";
							url_detalle += "/" + value['id_contacto'];

							if (value['instancia_nombre'].length > 25) {
								instancia_nombre = '<span title="'+value['instancia_nombre']+'">'+value['instancia_nombre'].slice(0,25)+'...</span>';
							}else{
								instancia_nombre = value['instancia_nombre'];
							}

						$('#despliega_contactos table tbody').append('<tr>\
							<td>'+value['contacto_IDU']+'</td>\
							<td><a href="'+url_detalle+'" class="link_detalle">'+value['contacto_ap_paterno']+' '+value['contacto_ap_materno']+' '+value['contacto_nombre']+'</a></td>\
							<td>'+value['rol_contacto_descripcion']+'</td>\
							<td>'+value['tipo_contacto_descripcion']+'</td>\
							<td>'+value['contacto_estatus']+'</td>\
							<td>'+instancia_nombre+'</td>\
							<td>'+value['contacto_correo_inst']+'</td>\
							<td>'+value['contacto_correo_per']+'</td>\
							<td class="contacto_acciones"><a \
							href="'+"<?= site_url('contactos/editar')?>"+"/"+value['id_contacto']+'">\
							<img \
							src="'+"<?= base_url('assets/img/icono_editar.png')?>"+'" title="Editar">\
							</a><br>\
							<a href="'+"<?= site_url('contactos/eliminar')?>"+"/"+value['id_contacto']+'" class="eliminar_contacto">\
							<img src="'+"<?= base_url('assets/img/icono_borrar.png')?>"+'" title="Eliminar">\
							</a></td>\
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
});
</script>
<!-- inicia contenido -->
<div class="contenido_dinamico">
	<div id="migaDePan">
		<a href="<?= base_url()?>">Inicio</a> > Administrar Contactos
	</div>

	<form id="frm_buscar_contacto" method="POST">
		<label for="nombre_contacto">Nombre</label>
		<input type="text" id="nombre_contacto" maxlength="50" name="nombre_contacto" class="buscar_contacto_textInput validate[groupRequired[buscar_contacto]]"/>
		<label for="correo_contacto">Correo electr&oacute;nico</label>
		<input type="text" id="correo_contacto" maxlength="100" name="correo_contacto" class="buscar_contacto_textInput validate[groupRequired[buscar_contacto]]"/>
		<label for="tipo_contacto">Tipo de usuario</label>
		<select name="tipo_contacto" id="tipo_contacto" class="buscar_contacto_textInput validate[groupRequired[buscar_contacto]]">
			<option selected value="">- Elija un tipo -</option>
			<option value="0">Responsable técnico</option>
			<option value="1">Responsable de comunicación</option>
		</select>
		<label for="instancia_contacto">Instancia</label>
		<input type="text" id="instancia_contacto" name="instancia_contacto" class="buscar_contacto_textInput validate[groupRequired[buscar_contacto]"/>
		<label for="instructor_contacto">Instructores postulados</label>
		<select name="instructor_contacto" id="instructor_contacto" class="buscar_contacto_textInput validate[groupRequired[buscar_contacto]]">
			<option selected value="">- Elija un tipo -</option>
			<option value="1">Sí</option>
			<option value="0">No</option>
		</select>
		<input type="submit" id="btn_buscar_contacto" value="Buscar"/>
	</form>

	<div id="despliega_contactos">
		<table class='tables'>
			<tr>
				<td>Identificador Universitario (IDU)</td>
				<td>Nombre completo</td>
				<td>Rol</td>
				<td>Tipo de usuario</td>
				<td>Estatus</td>
				<td>Instancia</td>
				<td>Correo institucional</td>
				<td>Correo personal</td>
				<td>Acciones</td>
			</tr>
		</table>
	</div>

	<a href="<?= site_url('contactos/nuevo')?>">
		<input type="button" id="btn_nuevo_contacto" value="Nuevo contacto"/>
	</a>

</div>
<!-- termina contenido -->