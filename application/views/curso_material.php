<script>
$(document).ready(function(){
	$("#menu_cursos").addClass("seleccion_menu");
	$("#frm_material").validationEngine({promptPosition: "centerRight"});

	$("#material_file").change(function(){
		if ($(this).val() == "") {
			$("#material_url").prop('disabled', false);
			$("#material_url").val("");
		}else{
			$("#material_url").prop('disabled', true);
		}
	});

	$("#material_url").change(function(){
		if ($(this).val() == "") {
			$("#material_file").prop('disabled', false);
		}else{
			$("#material_file").prop('disabled', true);
		}
	});
});
</script>
<!-- inicia contenido -->
<div class="contenido_dinamico">
	<div id="migaDePan">
		<a href="<?= base_url()?>">Inicio</a> > 
		<a href="<?= site_url('cursos')?>">Administrar Cursos</a> > Añadir material
	</div>
	<?= form_open_multipart('cursos/guardar_material', array("id" => "frm_material"), array('id_curso' => $id_curso)); ?>
	<h2>Material</h2>
	<br>
	<input type="file" id="material_file" name="material_file" class="validate[checkFileType[pdf], groupRequired[material]]"/>
	<br>
	<span>Formatos permitidos .pdf</span>
	<br><br>
	<label for="material_url">URL</label>
	<br>
	<input type="text" id="material_url" name="material_url" maxlength="300" class="validate[groupRequired[material], custom[url]]">
	<br><br>
	<input type="submit" value="Cargar material">

</div>
<!-- termina contenido -->