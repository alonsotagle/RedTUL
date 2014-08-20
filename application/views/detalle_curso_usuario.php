<script src="//maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>
<script>
    $(document).ready(function(){

		if ("<?= $curso_mapa_url; ?>" != "") {
			var url = "<?= $curso_mapa_url; ?>";
			var arr_arroba = url.split("@");

			if (arr_arroba.length > 1) {
				var arr_coma = arr_arroba[1].split(",");

				$("#map-canvas").addClass("map-canvas");
				initialize(arr_coma[0], arr_coma[1]);
			}
		}

		function initialize(lat, lng) {
			var map = new google.maps.Map(
				document.getElementById('map-canvas'), {
					center: new google.maps.LatLng(lat, lng),
					zoom: 15,
					mapTypeId: google.maps.MapTypeId.ROADMAP
			});

			var marker = new google.maps.Marker({
				position: new google.maps.LatLng(lat, lng),
				map: map
			});
		}

    });

</script>
<!-- inicia contenido -->
<div id="contenido_confirmacion">

	<div id="informacion_curso" class="bloque_informacion">
		<br>
		<p class='confirmacion_titulos_datos'>Datos de evento</p>
		<br>
		<p class='confirmacion_titulos_info'>T&iacute;tulo</p>
		<p class='confirmacion_info'><?= $curso_titulo ?></p>
		<br>
		<p class='confirmacion_titulos_info'>Descripci&oacute;n</p>
		<p class='confirmacion_info'><?= $curso_descripcion ?></p>
		<br>
		<p class='confirmacion_titulos_info'>Objetivos</p>
		<p class='confirmacion_info'><?= $curso_objetivos ?></p>
		<br>
		<p class='confirmacion_titulos_info'>Fecha</p>
		<p class='confirmacion_info'><?= $curso_fecha_inicio."   a   ".$curso_fecha_fin ?></p>
		<br>
		<p class='confirmacion_titulos_info'>Horario</p>
		<p class='confirmacion_info'><?= $curso_hora_inicio." - ".$curso_hora_fin ?></p>
		<br>
		<?php if($curso_cupo != "") : ?>
			<p class='confirmacion_titulos_info'>Cupo</p>
			<p class='confirmacion_info'><?= $curso_cupo ?></p>
			<br>
		<?php endif; ?>
		<?php if($curso_ubicacion != "") : ?>
			<p class='confirmacion_titulos_info'>Ubicaci&oacute;n</p>
			<p class='confirmacion_info'><?= $curso_ubicacion ?></p>
		<?php endif; ?>
		<?php if($curso_mapa_url != "") : ?>
			<a class='confirmacion_info' href="<?= $curso_mapa_url ?>" target="_blank">URL de la ubicaci&oacute;n</a>
			<br><br>
			<div id="map-canvas"></div>
			<br><br>
		<?php endif; ?>
		<?php if($curso_telefono != "") : ?>
			<p class='confirmacion_titulos_info'>Tel&eacute;fono</p>
			<p class='confirmacion_info'>
				<?php echo $curso_telefono;
					if ($curso_telefono_extension != "") {
						echo " ext. ";
						echo $curso_telefono_extension;
					}
				?>
			</p>
		<?php endif; ?>
	</div>

<!-- termina contenido -->