<script>
    $(document).ready(function(){

        $("#menu_cursos").addClass("seleccion_menu");

        $(document).tooltip();

        $.ajax("<?= site_url('cursos/usuarios_lista').'/'.$id_curso?>", {
			dataType: 'json',
			type: 'post',
			success: function(resultado)
			{
				if (resultado) {

					$.each(resultado, function( index, value ) {
						$('#tabla_lista tbody').append('<tr>\
							<td class="lista_no_valor">'+(index+1)+'</td>\
							<td>'+value['contacto_ap_paterno']+' '+value['contacto_ap_materno']+' '+value['contacto_nombre']+'<br>('+value['instancia_nombre']+')'+'</td>\
							<td></td>\
							<td></td>\
							<td></td>\
							<td></td>\
							<td></td>\
						</tr>');
					});
				}else{
					alert('No hay contactos inscritos.');
				}
			}
		});
    });
</script>
<!-- inicia contenido -->
<div class="contenido_dinamico">
	<div id="migaDePan">
		<a href="<?= base_url()?>">Inicio</a> > 
		<a href="<?= site_url('cursos')?>">Administrar Cursos</a> > Detalle de curso
	</div>

	<div id="seccion_imprimir">
		<div id="encabezado_lista">
			<img src="<?= base_url('assets/img/logo_unam.png')?>" width="60" height="60" align="left">
			<span id="lista_universidad">Universidad Nacional Autónoma de México</span><br>
			<span id="lista_dgtic">Dirección General de Cómputo y de Tecnologías de Información y Comunicación</span><br>
			<span id="lista_dcv">Dirección de Colaboración y Vinculación</span><br><br>
			<span id="lista_titulo"><?= $curso_titulo; ?></span><br>
		</div>

		<table id="tabla_lista">
			<tr>
				<th class="th_no">No.</th>
				<th class="th_nombre">NOMBRE</th>
				<th colspan="5">FIRMA</th>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td class="lista_dia">____/____/____</td>
				<td class="lista_dia">____/____/____</td>
				<td class="lista_dia">____/____/____</td>
				<td class="lista_dia">____/____/____</td>
				<td class="lista_dia">____/____/____</td>
			</tr>
		</table>

		<div id="datos_curso_lista">
			<span class="">
				<strong>Horario:</strong><br>
				<span><?= $curso_hora_inicio; ?> - <?= $curso_hora_fin; ?></span>
			</span>
			<br><br>

			<span class="conf_contacto_valores">
				<strong>Fechas:</strong><br>
				<span><?= $curso_fecha_inicio; ?> al <?= $curso_fecha_fin; ?></span>
			</span>
		</div>

		<div id="datos_instructores_lista">
		<?php if(!is_null($profesor)) : ?>
			<strong class="">Instructor(es):</strong><br>
			<span class="">
				<?php
					foreach ($profesor as $key => $value) {
					 	echo $value['contacto_nombre']." ".$value['contacto_ap_paterno']." ".$value['contacto_ap_materno'];
					 	echo "<br>";
					 }
				?>
			</span>
			<br><br>
		<?php endif; ?>
		</div>
		<br>
		<div id="cuadro_observaciones">
			<strong id="observaciones_lista">Observaciones:</strong>
		</div>
		<br><br><br>
	</div>

	<div id="wrapper_btn">
		<input type="button" value="Imprimir" onclick="print()">
	</div>

</div>
<!-- termina contenido -->