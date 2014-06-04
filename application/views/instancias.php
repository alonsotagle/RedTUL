<script>
    $(document).ready(function(){

    	$.ajax("<?= site_url('instancias/consulta_instancias')?>", {
		dataType: 'json',
		type: 'post',
		success: function(resultado)
		{
			if (resultado != null) {
				$('#despliega_instancias').html("<table class='tables'>\
					<tr>\
						<td>Nombre</td>\
					</tr>\
				</table>");

				// $('#despliega_instancias').html("<table class='tables'>\
				// 	<tr>\
				// 		<td>Nombre</td>\
				// 		<td>Editar</td>\
				// 		<td>Eliminar</td>\
				// 	</tr>\
				// </table>");

				$.each(resultado, function( index, value ) {
					$('#despliega_instancias table tbody').append('<tr>\
						<td>'+value['instancia_nombre']+'</td>\
					</tr>');
				});

				// $.each(resultado, function( index, value ) {
				// 	$('#despliega_instancias table tbody').append('<tr>\
				// 		<td>'+value['instancia_nombre']+'</td>\
				// 		<td><a \
				// 		href="'+"<?= site_url('instancias/editar')?>"+"/"+value['id_instancia']+'">\
				// 			<img \
				// 			src="'+"<?= base_url('assets/img/icono_editar.png')?>"+'">\
				// 		</a></td>\
				// 		<td><a \
				// 		href="'+"<?= site_url('instancias/eliminar')?>"+"/"+value['id_instancia']+'">\
				// 			<img \
				// 			src="'+"<?= base_url('assets/img/icono_borrar.png')?>"+'">\
				// 		</a></td>\
				// 	</tr>');
				// });
			}else{
				$('#despliega_instancias').html('No hay instancias registradas');
			}
		}
		});

        $("#frm_buscar_instancia").validationEngine({promptPosition: "centerRight"});

        $("#menu_instancia").addClass("seleccion_menu");

        $("#btn_buscar_instancia").click(function(event){
			event.preventDefault();
			if ($("#frm_buscar_instancia").validationEngine('validate')) {
				var datos = {
					'instancia_nombre' : $('#nombre_instancia').val()
				};

				$.ajax({
					url: "<?= site_url('instancias/busqueda_instancias') ?>",
					data: datos,
					dataType: 'json',
					type: 'post',
					success: function(resultado) {
						if (resultado) {
							$('#despliega_instancias table tbody').find("tr:gt(0)").remove();
							$.each(resultado, function(index, value) {
								$('#despliega_instancias table tbody').append('<tr>\
									<td>'+value['instancia_nombre']+'</td>\
								</tr>');
							});
							// $.each(resultado, function(index, value) {
							// 	$('#despliega_instancias table tbody').append('<tr>\
							// 		<td>'+value['instancia_nombre']+'</td>\
							// 		<td>\
							// 			<img id='+value['id_instancia']+' class="img_editar_plantilla"\
							// 			src="'+"<?= base_url('assets/img/icono_editar.png')?>"+'">\
							// 		</td>\
							// 		<td><a \
							// 			href="'+"<?= site_url('mensajeria')?>"+"/"+value['id_instancia']+'">\
							// 			<img \
							// 			src="'+"<?= base_url('assets/img/icono_borrar.png')?>"+'">\
							// 		</a></td>\
							// 	</tr>');
							// });
						}else{
							$('#despliega_instancias table tbody').find("tr:gt(0)").remove();
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
		<a href="<?= base_url()?>">Inicio</a> > Cat&aacute;logo de instancias
	</div>

	<div id="bloque_buscar_instancia">
		<form id="frm_buscar_instancia" method="POST">
				<label for="nombre_instancia">Nombre de Instancia</label>
				<input type="text" id="nombre_instancia" name="nombre_instancia" class="buscar_instancia validate[required]"/>
				<br>
				<input type="submit" id="btn_buscar_instancia" value="Buscar"/>
		</form>
	</div>

	<div id="despliega_instancias"></div>

	<!-- <a href="<?= base_url('index.php/cursos/nuevo')?>">
		<input type="button" id="btn_nuevo_curso" value="Nueva instancia"/>
	</a> -->

</div>
<!-- termina contenido -->