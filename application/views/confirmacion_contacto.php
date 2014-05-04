<script>
    $(document).ready(function(){

        $("#menu_contactos").addClass("seleccion_menu");

    });
</script>
<!-- inicia contenido -->
<div class="contenido_dinamico">
	<div id="migaDePan">
		<a href="<?= base_url()?>">Inicio</a> > 
		<a href="<?= site_url('contactos')?>">Administrar Contactos</a> > Confirmaci&oacute;n de nuevo contacto
	</div>

	<p id="conf_contacto_leyenda">La informaci&oacute;n se guard&oacute; satisfactoriamente</p>

	<p class="conf_contacto_campos">Estatus</p>
	<p class="conf_contacto_valores">
		<?= $estatus; ?>
	</p>
	<p class="conf_contacto_campos">Tipo de contacto</p>
	<p class="conf_contacto_valores">
		<?= $tipo; ?>
	</p>
	<p class="conf_contacto_campos">Nombre</p>
	<p class="conf_contacto_valores">
		<?= $nombre; ?>
	</p>
	<p class="conf_contacto_campos">Apellido paterno</p>
	<p class="conf_contacto_valores">
		<?= $paterno; ?>
	</p>
	<p class="conf_contacto_campos">Apellido materno</p>
	<p class="conf_contacto_valores">
		<?= $materno; ?>
	</p>
	<p class="conf_contacto_campos">Instancia</p>
	<p class="conf_contacto_valores">
		<?= $instancia; ?>
	</p>
	<p class="conf_contacto_campos">&Aacute;rea de adscripci&oacute;n</p>
	<p class="conf_contacto_valores">
		<?= $adscripcion; ?>
	</p>
	<p class="conf_contacto_campos">Descripci&oacute;n de funciones</p>
	<p class="conf_contacto_valores">
		<?= $funciones; ?>
	</p>
	<p class="conf_contacto_campos">Tel&eacute;fono</p>
	<p class="conf_contacto_valores">
		<?= $telefono; ?>
	</p>
	<p class="conf_contacto_campos">Correo electr&oacute;nico institucional</p>
	<p class="conf_contacto_valores">
		<?= $correoinst; ?>
	</p>
	<p class="conf_contacto_campos">Correo electr&oacute;nico personal</p>
	<p class="conf_contacto_valores">
		<?= $correopers; ?>
	</p>
	<p class="conf_contacto_campos">Avatar</p>
	<p class="conf_contacto_valores">
		/
	</p>
	<p class="conf_contacto_campos">Medio de comunicación preferente</p>
	<p class="conf_contacto_valores">
		<?= $comunicacion; ?>
	</p>

</div>
<!-- termina contenido -->