<script>
    $(document).ready(function(){

    	function consulta_instancias(){
    		$.ajax("<?= site_url('instancias/consulta_instancias')?>", {
			dataType: 'json',
			type: 'post',
			success: function(resultado)
			{
				if (resultado != null) {
					$.each(resultado, function( index, value ) {
						var etiqueta_eliminar;
						if (value['instancia_eliminar']) {
							etiqueta_eliminar = '<a \
							href="'+"<?= site_url('instancias/eliminar')?>"+"/"+value['id_instancia']+'" class="eliminar_instancia" title="Eliminar">\
							<img \
							src="'+"<?= base_url('assets/img/icono_borrar.png')?>"+'">\
							</a>';
						} else{
							etiqueta_eliminar = '<img src="'+"<?= base_url('assets/img/icono_no_eliminar.png')?>"+'" title="La entidad no se puede eliminar porque tiene contactos asociados.">';
						}

						$('#despliega_instancias table tbody').append('<tr>\
							<td class="instancias_nombre" spellcheck="false">'+value['instancia_nombre']+'</td>\
							<td>\
							<div \
							class="editar_instancia" id="'+value['id_instancia']+'"></div>\
							</td>\
							<td>'+etiqueta_eliminar+'</td>\
						</tr>');
					});

					var instancias = [];

					$.each(resultado, function( index, value ){
						instancias.push({
							label : value['instancia_nombre'],
							value : value['id_instancia']
						});
					});

					$('#nombre_instancia').autocomplete({
						source: instancias,
						change: function(event, ui) {
							if(!ui.item){
								$("#nombre_instancia").val("");
							}
						},
						focus: function(event, ui) {
							return false;
						},
						select: function(event, ui) {
							$("#nombre_instancia").val( ui.item.label );
							return false;
						}
					});

				}else{
					$('#despliega_instancias').html('No hay instancias registradas');
				}
			}
			});
		}

		consulta_instancias();

        $("#frm_buscar_instancia").validationEngine({promptPosition: "centerRight"});

        $("#menu_instancia").addClass("seleccion_menu");

        $("#btn_buscar_instancia").click(function(event){
			event.preventDefault();
			if ($("#frm_buscar_instancia").validationEngine('validate')) {
				var datos = {
					'instancia_nombre' : $('#nueva_instancia').val()
				};

				$.ajax({
					url: "<?= site_url('instancias/busqueda_instancias') ?>",
					data: datos,
					dataType: 'json',
					type: 'post',
					success: function(resultado) {
						if (resultado) {
							$('#despliega_instancias table tbody').find("tr:gt(0)").remove();

							$.each(resultado, function(index, value){
								$('#despliega_instancias table tbody').append('<tr>\
									<td class="instancias_nombre" spellcheck="false">'+value['instancia_nombre']+'</td>\
									<td>\
									<div \
									class="editar_instancia" id="'+value['id_instancia']+'"></div>\
									</td>\
									<td><a \
									href="'+"<?= site_url('instancias/eliminar')?>"+"/"+value['id_instancia']+'" class="eliminar_instancia">\
									<img \
									src="'+"<?= base_url('assets/img/icono_borrar.png')?>"+'">\
									</a></td>\
								</tr>');
							});
						}else{
							$('#despliega_instancias table tbody').find("tr:gt(0)").remove();
						}
					}
				});
			}
		});

		$("#despliega_instancias").on("click", "table tbody tr td .eliminar_instancia", function(){
			var eliminar = confirm("¿Está seguro de eliminar la instancia?");
			if (eliminar) {
				return true;
			}else{
				return false;
			}
		});

		$("#despliega_instancias").on("click", "table tbody tr td .editar_instancia", function(event){
			$(".guardar_instancia").parent().prev().attr("contenteditable", false);
			$(".guardar_instancia").addClass("editar_instancia");
			$(".guardar_instancia").removeClass("guardar_instancia");
			$(".fondo_instancia_editable").removeClass("fondo_instancia_editable");

			$(this).parent().prev().attr("contenteditable", true).focus();
			$(this).parent().parent().addClass("fondo_instancia_editable");

			$(this).addClass("guardar_instancia");
			$(this).removeClass("editar_instancia");
		});

		$("#despliega_instancias").on("click", "table tbody tr td .guardar_instancia", function(event){
			var nombre_instancia = $(this).parent().prev();
			var datos = {
				'id_instancia'		: $(this).attr("id"),
				'instancia_nombre'	: nombre_instancia.text()
			};

			$.ajax("<?= site_url('instancias/editar_instancia')?>",{
				data: datos,
				dataType: 'json',
				type: 'post'
			});

			alert("La información se guardó satisfactoriamente.");

			$(this).addClass("editar_instancia");
			$(this).removeClass("guardar_instancia");
			$(this).parent().prev().attr("contenteditable", false);
			$(".fondo_instancia_editable").removeClass("fondo_instancia_editable");
		});

		$("#frm_registrar_instancia").hide();

		$("#btn_nueva_instancia").click(function(){
			$("#frm_registrar_instancia").show();
			$(this).hide();
		});

		$("#btn_registrar_instancia").click(function(event){
			event.preventDefault();
			if ($("#frm_registrar_instancia").validationEngine('validate')) {
				var datos={
					'instancia_nombre'	: $("#nueva_instancia").val()
				};

				$.ajax("<?= site_url('instancias/registrar')?>",{
					data: datos,
					dataType: 'json',
					type: 'post',
					complete: function(){
						$("#frm_registrar_instancia").hide();
						$("#btn_nueva_instancia").show();
						alert("Recuerde que si agrega una instancia debe notificar al Administrador del 'Portal de TUL'");
						$('#despliega_instancias table tbody').find("tr:gt(0)").remove();
						consulta_instancias();
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
				<input type="text" id="nombre_instancia" name="nombre_instancia" class="buscar_instancia validate[required]" maxlength="150"/>
				<br>
				<input type="submit" id="btn_buscar_instancia" value="Buscar"/>
		</form>
	</div>

	<div id="despliega_instancias">
		<table class='tables'>
			<tr>
				<td>Nombre</td>
				<td>Editar</td>
				<td>Eliminar</td>
			</tr>
		</table>
	</div>

	<input type="button" id="btn_nueva_instancia" value="Nueva instancia"/>

	<form id="frm_registrar_instancia">
		<fieldset>
			<label for="nueva_instancia">Nueva instancia</label>
			<br>
			<input type="text" maxlenght="150" id="nueva_instancia" class="validate[required]">
			<input type="submit" id="btn_registrar_instancia" value="Guardar">
		</fieldset>
	</form>

</div>
<!-- termina contenido -->