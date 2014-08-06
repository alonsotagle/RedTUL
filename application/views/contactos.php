<script>
    $(document).ready(function(){

    	$( document ).tooltip();

    	$.ajax("<?= site_url('contactos/consulta_instancias')?>", {
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

		$.ajax("<?= site_url('contactos/consulta_contactos')?>", {
		dataType: 'json',
		type: 'post',
		success: function(resultado)
		{
			if (resultado != null) {

				$.each(resultado, function( index, value ) {
					var url_detalle = "<?= site_url('contactos/detalle_contacto') ?>";
					url_detalle += "/" + value['id_contacto'];

					if (value['instancia_nombre'].length > 25) {
						instancia_nombre = '<span title="'+value['instancia_nombre']+'">'+value['instancia_nombre'].slice(0,25)+'...</span>';
					}else{
						instancia_nombre = value['instancia_nombre'];
					}

					$('#despliega_contactos table tbody').append('<tr>\
						<td><a href="'+url_detalle+'" class="link_detalle">'+value['contacto_nombre']+' '+value['contacto_ap_paterno']+' '+value['contacto_ap_materno']+'</a></td>\
						<td>'+value['tipo_contacto_descripcion']+'</td>\
						<td>'+value['contacto_estatus']+'</td>\
						<td>'+instancia_nombre+'</td>\
						<td>'+value['contacto_correo_inst']+'</td>\
						<td>'+value['contacto_correo_per']+'</td>\
						<td><a \
						href="'+"<?= site_url('contactos/editar')?>"+"/"+value['id_contacto']+'">\
						<img \
						src="'+"<?= base_url('assets/img/icono_editar.png')?>"+'">\
						</a></td>\
						<td><a \
						href="'+"<?= site_url('contactos/eliminar')?>"+"/"+value['id_contacto']+'" class="eliminar_contacto">\
						<img \
						src="'+"<?= base_url('assets/img/icono_borrar.png')?>"+'">\
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

        $("#frm_buscar_contacto").validationEngine({promptPosition: "centerRight", scroll: false});

        $("#menu_contactos").addClass("seleccion_menu");

        $("#btn_buscar_contacto").click(function(event){
			event.preventDefault();
			if ($("#frm_buscar_contacto").validationEngine('validate')) {
				var datos = {
					'nombre_contacto' 	: $('#nombre_contacto').val(),
					'correo_contacto' 	: $('#correo_contacto').val(),
					'tipo_contacto' 	: $('#tipo_contacto').val(),
					'instancia_contacto': $('#instancia_contacto').val()
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
									<td><a href="'+url_detalle+'" class="link_detalle">'+value['contacto_nombre']+' '+value['contacto_ap_paterno']+' '+value['contacto_ap_materno']+'</a></td>\
									<td>'+value['tipo_contacto_descripcion']+'</td>\
									<td>'+value['contacto_estatus']+'</td>\
									<td>'+instancia_nombre+'</td>\
									<td>'+value['contacto_correo_inst']+'</td>\
									<td>'+value['contacto_correo_per']+'</td>\
									<td><a \
									href="'+"<?= site_url('contactos/editar')?>"+"/"+value['id_contacto']+'">\
									<img \
									src="'+"<?= base_url('assets/img/icono_editar.png')?>"+'">\
									</a></td>\
									<td><a \
									href="'+"<?= site_url('contactos/eliminar')?>"+"/"+value['id_contacto']+'" class="eliminar_contacto">\
									<img \
									src="'+"<?= base_url('assets/img/icono_borrar.png')?>"+'">\
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
		<label for="tipo_contacto">Tipo de contacto</label>
		<select name="tipo_contacto" id="tipo_contacto" class="buscar_contacto_textInput validate[groupRequired[buscar_contacto]]">
			<option selected value="">- Elija un tipo -</option>
			<option value="1">Webmaster</option>
			<option value="2">Responsable de comunicación</option>
			<option value="3">Responsable técnico</option>
			<option value="4">Otros</option>
		</select>
		<label for="instancia_contacto">Instancia</label>
		<input type="text" id="instancia_contacto" name="instancia_contacto" class="buscar_contacto_textInput validate[groupRequired[buscar_contacto]"/>
		<input type="submit" id="btn_buscar_contacto" value="Buscar"/>
	</form>

	<div id="despliega_contactos">
		<table class='tables'>
			<tr>
				<td>Nombre completo</td>
				<td>Tipo de contacto</td>
				<td>Estatus</td>
				<td>Instancia</td>
				<td>Correo institucional</td>
				<td>Correo personal</td>
				<td>Editar</td>
				<td>Borrar</td>
			</tr>
		</table>
	</div>

	<a href="<?= site_url('contactos/nuevo')?>">
		<input type="button" id="btn_nuevo_contacto" value="Nuevo contacto"/>
	</a>

</div>
<!-- termina contenido -->