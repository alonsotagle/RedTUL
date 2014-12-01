<script>
    $(document).ready(function(){

    	$.ajax("<?= site_url('inicio/consulta_contactos')?>", {
		dataType: 'json',
		type: 'post',
		success: function(resultado)
		{
			if (resultado != null) {
				$('#despliega_usuarios_nuevos').html("<table class='tables'>\
					<tr>\
						<td>Nombre</td>\
						<td>Instancia</td>\
						<td>Correo</td>\
					</tr>\
				</table>");

				$.each(resultado, function( index, value ) {
					var url_detalle = "<?= site_url('contactos/detalle_contacto') ?>";
					url_detalle += "/" + value['id_contacto'];

					if (value['instancia_nombre'].length > 25) {
						instancia_nombre = '<span title="'+value['instancia_nombre']+'">'+value['instancia_nombre'].slice(0,25)+'...</span>';
					}else{
						instancia_nombre = value['instancia_nombre'];
					}

					$('#despliega_usuarios_nuevos table tbody').append('<tr>\
						<td><a href="'+url_detalle+'" class="link_detalle">'+value['contacto_ap_paterno']+' '+value['contacto_ap_materno']+' '+value['contacto_nombre']+'</a></td>\
						<td>'+instancia_nombre+'</td>\
						<td>'+value['contacto_correo_inst']+'<br>'+value['contacto_correo_per']+'</td>\
					</tr>');
				});
			}else{
				$('#despliega_usuarios_nuevos').html('No hay contactos registrado recientemente');
			}
		}
		});

    	$.ajax("<?= site_url('inicio/consulta_cursos')?>", {
		dataType: 'json',
		type: 'post',
		success: function(resultado)
		{
			if (resultado != null) {
				$('#despliega_cursos_inicio').html("<table class='tables'>\
					<tr>\
						<td>Nombre curso</td>\
						<td>Tipo curso</td>\
						<td>Fecha inicio</td>\
						<td>Horario</td>\
						<td>Total asistentes</td>\
						<td>Cupo disponible</td>\
					</tr>\
				</table>");

				$.each(resultado, function( index, value ) {
					$('#despliega_cursos_inicio table tbody').append('<tr>\
						<td>'+value['curso_titulo']+'</td>\
						<td>'+value['curso_tipo']+'</td>\
						<td>'+value['curso_fecha_inicio']+'</td>\
						<td>'+value['curso_hora_inicio']+' a '+value['curso_hora_fin']+'</td>\
						<td>'+value['curso_inscritos']+'</td>\
						<td>'+value['curso_cupo_disponible']+'</td>\
					</tr>');
				});
			}else{
				$('#despliega_cursos_inicio').html('No hay cursos próximos');
			}
		}
		});

    }); 
</script>
<!-- inicia contenido -->
<div class="contenido_dinamico">
	<div id="migaDePan">Inicio</div>

	<fieldset>
		<legend>Actividad</legend>
		<span class="titulo_inicio">Nuevos Usuarios</span>
		<div id="despliega_usuarios_nuevos"></div>
		<br>
		<span class="titulo_inicio">Cursos del Mes</span>
		<div id="despliega_cursos_inicio"></div>
	</fieldset>

</div>
<!-- termina contenido -->