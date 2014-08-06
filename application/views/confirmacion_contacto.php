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

	<span id="conf_contacto_leyenda">La informaci&oacute;n se guard&oacute; satisfactoriamente.</span>
	<br><br>
	<span class="conf_contacto_campos">Estatus</span>
	<span class="conf_contacto_valores">
		<?= $contacto_estatus; ?>
	</span>
	<br><br>
	<span class="conf_contacto_campos">Tipo de contacto</span>
	<span class="conf_contacto_valores">
		<?= $contacto_tipo; ?>
	</span>
	<br><br>
	<span class="conf_contacto_campos">Nombre</span>
	<span class="conf_contacto_valores">
		<?= $contacto_nombre; ?>
	</span>
	<br><br>
	<span class="conf_contacto_campos">Apellido paterno</span>
	<span class="conf_contacto_valores">
		<?= $contacto_ap_paterno; ?>
	</span>
	<br><br>
	<span class="conf_contacto_campos">Apellido materno</span>
	<span class="conf_contacto_valores">
		<?= $contacto_ap_materno; ?>
	</span>
	<br><br>
	<span class="conf_contacto_campos">Instancia</span>
	<span class="conf_contacto_valores">
		<?= $contacto_instancia_nombre; ?>
	</span>
	<br><br>
	<span class="conf_contacto_campos">&Aacute;rea de adscripci&oacute;n</span>
	<span class="conf_contacto_valores">
		<?= $contacto_adscripcion; ?>
	</span>
	<br><br>
	<span class="conf_contacto_campos">Descripci&oacute;n de funciones</span>
	<span class="conf_contacto_valores">
		<?= $contacto_funciones; ?>
	</span>
	<br><br>
	<span class="conf_contacto_campos">Tel&eacute;fono</span>
	<span class="conf_contacto_valores">
		<?= $contacto_telefono; ?>
	</span>
	<br><br>
	<span class="conf_contacto_campos">Extensi&oacute;n</span>
	<span class="conf_contacto_valores">
		<?= $contacto_extension; ?>
	</span>
	<br><br>
	<span class="conf_contacto_campos">Correo electr&oacute;nico institucional</span>
	<span class="conf_contacto_valores">
		<?= $contacto_correo_inst; ?>
	</span>
	<br><br>
	<span class="conf_contacto_campos">Correo electr&oacute;nico personal</span>
	<span class="conf_contacto_valores">
		<?= $contacto_correo_per; ?>
	</span>
	<br><br>
	<span class="conf_contacto_campos">Avatar</span>
	<span class="conf_contacto_valores">
		<?= $contacto_avatar; ?>
	</span>
	<br><br>
	<span class="conf_contacto_campos">Medio de comunicación preferente</span>
	<span class="conf_contacto_valores">
		<?= $contacto_comunicacion; ?>
	</span>

</div>
<!-- termina contenido -->