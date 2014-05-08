<script>
    $(document).ready(function(){

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

		if (!is_null($resultado)) {

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
		}
		?>
	</table>

</div>
<!-- termina contenido -->