<script>
    $(document).ready(function(){

		$.ajax("<?= site_url('contactos/consulta_contactos')?>", {
		dataType: 'json',
		type: 'post',
		success: function(resultado)
		{
			if (resultado != null) {
				$('#despliega_contactos').html("");

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

        $("#menu_contactos").addClass("seleccion_menu");

    }); 
</script>
<!-- inicia contenido -->
<div class="contenido_dinamico">
	<div id="migaDePan">
		<a href="<?= base_url()?>">Inicio</a> > 
		<a href="<?= site_url('contactos')?>">Administrar Contactos</a> > Buscar contactos
	</div>

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
		<?php
		// echo "<pre>";
		// var_dump($resultado);

		foreach ($resultado as $key => $value) {
			echo "<tr>
				<td>".$value['contacto_nombre'].' '.$value['contacto_ap_paterno'].' '.$value['contacto_ap_materno']."</td>
				<td>".$value['tipo_contacto_descripcion']."</td>
				<td>".$value['contacto_estatus']."</td>
				<td>".$value['instancia_nombre']."</td>
				<td>".$value['contacto_correo_inst']."</td>
				<td>".$value['contacto_correo_per']."</td>
				<td>
					<a href=".site_url('contactos/editar')."/".$value['id_contacto'].">
						<img src=".base_url('assets/img/icono_editar.png').">
					</a>
				</td>
				<td>
					<a href=".site_url('contactos/eliminar')."/".$value['id_contacto'].">
						<img src=".base_url('assets/img/icono_borrar.png').">
					</a>
				</td>
			</tr>";
		}
		?>
	</table>

	<div id="despliega_contactos"></div>

</div>
<!-- termina contenido -->