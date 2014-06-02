<script>
    $(document).ready(function(){

    	$.ajax("<?= site_url('inicio/consulta_cursos')?>", {
		dataType: 'json',
		type: 'post',
		success: function(resultado)
		{
			if (resultado != null) {
				$('#despliega_cursos').html("<table class='tables'>\
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
					$('#despliega_cursos table tbody').append('<tr>\
						<td>'+value['curso_titulo']+'</td>\
						<td>'+value['curso_tipo']+'</td>\
						<td>'+value['curso_fecha_inicio']+'</td>\
						<td>'+value['curso_hora_inicio']+' a '+value['curso_hora_fin']+'</td>\
						<td></td>\
						<td>'+value['curso_cupo']+'</td>\
					</tr>');
				});
			}else{
				$('#despliega_cursos').html('No hay cursos próximos');
			}
		}
		});

    }); 
</script>
<!-- inicia contenido -->
<div class="contenido_dinamico">
	<div id="migaDePan">Inicio</div>

	<fieldset>
		<legend>Cursos pr&oacute;ximos</legend>
		<div id="despliega_cursos"></div>
	</fieldset>

</div>
<!-- termina contenido -->