<script>
    $(document).ready(function(){

		$.ajax("<?= site_url('contactos/consulta_contactos')?>", {
		dataType: 'json',
		type: 'post',
		success: function(resultado)
		{
			if (resultado != null) {
				$('#despliega_contactos').html("<table class='tables'>\
					<tr>\
						<td>Nombre completo</td>\
						<td>Tipo de contacto</td>\
						<td>Estatus</td>\
						<td>Instancia</td>\
						<td>Correo institucional</td>\
						<td>Correo personal</td>\
						<td>Editar</td>\
						<td>Borrar</td>\
					</tr>\
				</table>");

				$.each(resultado, function( index, value ) {
					$('#despliega_contactos table tbody').append('<tr>\
						<td>'+value['contacto_nombre']+' '+value['contacto_ap_paterno']+' '+value['contacto_ap_materno']+'</td>\
						<td>'+value['tipo_contacto_descripcion']+'</td>\
						<td>'+value['contacto_estatus']+'</td>\
						<td>'+value['instancia_nombre']+'</td>\
						<td>'+value['contacto_correo_inst']+'</td>\
						<td>'+value['contacto_correo_per']+'</td>\
						<td><a \
						href="'+"<?= site_url('contactos/editar')?>"+"/"+value['id_contacto']+'">\
						<img \
						src="'+"<?= base_url('assets/img/icono_editar.png')?>"+'">\
						</a></td>\
						<td><a \
						href="'+"<?= site_url('contactos/eliminar')?>"+"/"+value['id_contacto']+'">\
						<img \
						src="'+"<?= base_url('assets/img/icono_borrar.png')?>"+'">\
						</a></td>\
					</tr>');
				});
			}else{
				$('#despliega_contactos').html('No hay contactos registrados');
			}
		}
		});

        $("#frm_buscar_contacto").validationEngine({promptPosition: "centerRight", scroll: false});

        $("#menu_contactos").addClass("seleccion_menu");

    }); 
</script>
<!-- inicia contenido -->
<div class="contenido_dinamico">
	<div id="migaDePan">
		<a href="<?= base_url()?>">Inicio</a> > Administrar Contactos
	</div>

	<form id="frm_buscar_contacto" action="<?= site_url('contactos/buscar')?>" method="POST">
			<label for="nombre_contacto">Nombre</label>
			<input type="text" id="nombre_contacto" maxlength="50" name="nombre_contacto" class="buscar_contacto_textInput validate[groupRequired[buscar_contacto]]"/>
			<label for="correo_contacto">Correo electr&oacute;nico</label>
			<input type="text" id="correo_contacto" maxlength="100" name="correo_contacto" class="buscar_contacto_textInput validate[groupRequired[buscar_contacto]]"/>
			<label for="tipo_contacto">Tipo de contacto</label>
			<select name="tipo_contacto" id="tipo_contacto" class="buscar_contacto_textInput validate[groupRequired[buscar_contacto]]">
				<option selected disabled>- Elija un tipo -</option>
				<option value="1">Webmaster</option>
				<option value="2">Responsable de comunicación</option>
				<option value="3">Responsable técnico</option>
				<option value="4">Otros</option>
			</select>
			<label for="instancia_contacto">Instancia</label>
			<input type="text" id="instancia_contacto" name="instancia_contacto" class="buscar_contacto_textInput validate[groupRequired[buscar_contacto]"/>
			<input type="submit" id="btn_buscar_contacto" value="Buscar"/>
	</form>

	<div id="despliega_contactos"></div>

	<a href="<?= site_url('contactos/nuevo')?>">
		<input type="button" id="btn_nuevo_contacto" value="Nuevo contacto"/>
	</a>

</div>
<!-- termina contenido -->