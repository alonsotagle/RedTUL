<script>
    $(document).ready(function(){
        $("#frm_login").validationEngine({promptPosition: "centerRight"});
    }); 
</script>
<!-- inicia contenido -->
<div id="contenido">
	<div id="login_form">
		<a href="http://132.248.63.219:8082/SIU/login?service=<?= site_url('login/idaut'); ?>">
			Ingreso al sistema a trav&eacute;s de IDU
		</a>
	</div>
<!-- termina contenido -->