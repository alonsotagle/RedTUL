<script>
    $(document).ready(function(){

        $("#menu_contactos").addClass("seleccion_menu");

    });
</script>
<!-- inicia contenido -->
<div class="contenido_dinamico">
	<div id="migaDePan">
		<a href="<?= base_url()?>">Inicio</a> > 
		<a href="<?= site_url('contactos')?>">Administrar Contactos</a> > Confirmaci&oacute;n contacto
	</div>

	<p id="conf_contacto_leyenda">La informaci&oacute;n se guard&oacute; satisfactoriamente</p>

	<p class="conf_contacto_campos">Estatus</p>
	<p class="conf_contacto_valores">
		<?= $contacto_estatus; ?>
	</p>
	<p class="conf_contacto_campos">Tipo de contacto</p>
	<p class="conf_contacto_valores">
		<?= $contacto_tipo; ?>
	</p>
	<p class="conf_contacto_campos">Nombre</p>
	<p class="conf_contacto_valores">
		<?= $contacto_nombre; ?>
	</p>
	<p class="conf_contacto_campos">Apellido paterno</p>
	<p class="conf_contacto_valores">
		<?= $contacto_ap_paterno; ?>
	</p>
	<p class="conf_contacto_campos">Apellido materno</p>
	<p class="conf_contacto_valores">
		<?= $contacto_ap_materno; ?>
	</p>
	<p class="conf_contacto_campos">Instancia</p>
	<p class="conf_contacto_valores">
		<?= $contacto_instancia_nombre; ?>
	</p>
	<p class="conf_contacto_campos">&Aacute;rea de adscripci&oacute;n</p>
	<p class="conf_contacto_valores">
		<?= $contacto_adscripcion; ?>
	</p>
	<p class="conf_contacto_campos">Descripci&oacute;n de funciones</p>
	<p class="conf_contacto_valores">
		<?= $contacto_funciones; ?>
	</p>
	<p class="conf_contacto_campos">Tel&eacute;fono</p>
	<p class="conf_contacto_valores">
		<?= $contacto_telefono; ?>
	</p>
	<p class="conf_contacto_campos">Extensi&oacute;n</p>
	<p class="conf_contacto_valores">
		<?= $contacto_extension; ?>
	</p>
	<p class="conf_contacto_campos">Correo electr&oacute;nico institucional</p>
	<p class="conf_contacto_valores">
		<?= $contacto_correo_inst; ?>
	</p>
	<p class="conf_contacto_campos">Correo electr&oacute;nico personal</p>
	<p class="conf_contacto_valores">
		<?= $contacto_correo_per; ?>
	</p>
	<p class="conf_contacto_campos">Avatar</p>
	<p class="conf_contacto_valores">
		<?= $contacto_avatar; ?>
	</p>
	<p class="conf_contacto_campos">Medio de comunicación preferente</p>
	<p class="conf_contacto_valores">
		<?= $contacto_comunicacion; ?>
	</p>

</div>
<!-- termina contenido -->