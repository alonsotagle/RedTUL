<script>
    $(document).ready(function(){

    	$.ajax("<?= site_url('recursos/consulta_recursos')?>", {
		dataType: 'json',
		type: 'post',
		success: function(resultado)
		{
			if (resultado != null) {
				$('#despliega_recursos').html("<table class='tables'>\
					<tr>\
						<td>Nombre</td>\
						<td>Ruta recurso</td>\
						<td>Descripci&oacute;n</td>\
						<td>Editar</td>\
						<td>Eliminar</td>\
					</tr>\
				</table>");

				$.each(resultado, function( index, value ) {
					$('#despliega_recursos table tbody').append('<tr>\
						<td>'+value['recurso_nombre']+'</td>\
						<td><a \
						href="'+"<?= site_url('recursos/editar')?>"+"/"+value['id_recurso']+'">\
							<img \
							src="'+"<?= base_url('assets/img/icono_editar.png')?>"+'">\
						</a></td>\
						<td><a \
						href="'+"<?= site_url('recursos/eliminar')?>"+"/"+value['id_recurso']+'">\
							<img \
							src="'+"<?= base_url('assets/img/icono_borrar.png')?>"+'">\
						</a></td>\
					</tr>');
				});
			}else{
				$('#despliega_recursos').html('No hay recursos registradas');
			}
		}
		});

        $("#frm_buscar_recurso").validationEngine({promptPosition: "centerRight"});

        $("#menu_recursos").addClass("seleccion_menu");

        $("#btn_buscar_recurso").click(function(event){
			event.preventDefault();
			if ($("#frm_buscar_recurso").validationEngine('validate')) {
				var datos = {
					'recurso_nombre' : $('#nombre_recurso').val()
				};

				$.ajax({
					url: "<?= site_url('recursos/busqueda_recursos') ?>",
					data: datos,
					dataType: 'json',
					type: 'post',
					success: function(resultado) {
						if (resultado) {
							$('#despliega_recursos table tbody').find("tr:gt(0)").remove();
							$.each(resultado, function(index, value) {
								$('#despliega_recursos table tbody').append('<tr>\
									<td>'+value['recurso_nombre']+'</td>\
									<td>\
										<img id='+value['id_recurso']+' class="img_editar_plantilla"\
										src="'+"<?= base_url('assets/img/icono_editar.png')?>"+'">\
									</td>\
									<td><a \
										href="'+"<?= site_url('mensajeria')?>"+"/"+value['id_recurso']+'">\
										<img \
										src="'+"<?= base_url('assets/img/icono_borrar.png')?>"+'">\
									</a></td>\
								</tr>');
							});
						}else{
							$('#despliega_recursos table tbody').find("tr:gt(0)").remove();
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
		<a href="<?= base_url()?>">Inicio</a> > Administrar recursos
	</div>

	<div id="bloque_buscar_recurso">
		<form id="frm_buscar_recurso" method="POST">
				<label for="nombre_recurso">Nombre de recurso</label>
				<input type="text" id="nombre_recurso" name="nombre_recurso" class="buscar_recurso validate[required]"/>
				<br>
				<input type="submit" id="btn_buscar_recurso" value="Buscar"/>
		</form>
	</div>

	<div id="despliega_recursos"></div>

	<a href="<?= base_url('index.php/cursos/nuevo')?>">
		<input type="button" id="btn_nuevo_curso" value="Nueva recurso"/>
	</a>

</div>
<!-- termina contenido -->