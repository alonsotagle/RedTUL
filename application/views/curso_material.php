<!-- inicia contenido -->

<div class="contenido_dinamico">
	<div id="migaDePan">
		<a href="<?= base_url()?>">Inicio</a> > 
		<a href="<?= site_url('cursos')?>">Administrar Cursos</a> > Añadir material
	</div>
	<?= form_open_multipart('cursos/guardar_material', '', array('id_curso' => $id_curso)); ?>
	<h2>Material</h2>
	<label for="material_url">URL</label>
	<input type="text" id="material_url" name="material_url" maxlength="300">

	<input type="submit" value="Cargar material">
</div>
<!-- termina contenido -->