<!--  termina contenido principal -->
 </div>
<!--inicia pie banners y pie derechos-->

<div class="pie-banners">
	<img src="<?= base_url('assets/img/bg-pie.jpg')?>">
</div>

<div class="pie-derechos">

	<div>
		Hecho en México, todos los derechos reservados  2013. Esta página puede ser reproducida con fines no lucrativos, siempre y cuando no se mutile, se cite la fuente completa y su dirección electrónica. De otra forma requiere permiso previo por escrito de la institución. <a id="mostrarCreditos" href="javascript:;">Créditos</a>
	</div>
	<div class="administrado">Sitio web administrado por:<br/>
		Dirección General de Cómputo y Tecnologías de la Información y Comunicación.
	</div>

</div>

<script type="text/javascript">
	
	$(document).ready(function(){
		
		$("#creditos").hide();

		$("#mostrarCreditos").click(function(){
			$("#creditos").fadeIn("slow");
		});

		$("#botonCerrar").click(function(){
			$("#creditos").fadeOut("slow");
		});

	});
</script>

<div id="creditos">
	<a id="botonCerrar" href="javascript:;" title="Cerrar">X</a>
	<p id="tituloCreditos">Créditos</p>
	<div class="columna">

	</div>
	<div class="columna">

	</div>
</div>


<!--termina pie banners y pie derechos-->


</div>

<!--termina contenedor-->

</body>
</html>
