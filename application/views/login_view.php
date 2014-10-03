<script>
    $(document).ready(function(){
            $("#frm_login").validationEngine({promptPosition: "centerRight"});
    }); 
</script>
<!-- inicia contenido -->
<div id="contenido">
	<div id="login_form">
		<form id="frm_login" action="<?=  base_url('index.php/login/autenticacion')?>" method="POST">
				<label for="usuario">Usuario</label>
				<br>
				<input type="text" id="usr_nombre" name="usr_nombre" class="input validate[required]" spellcheck="false"/>
				<br><br>
				<label for="contrase">Contraseña</label>
				<br>
				<input type="password" id="usr_password" name="usr_password" class="input validate[required]"/>
				<input type="hidden" name="token" value="<?=$token?>">
				<p class="error"><?=$this->session->flashdata('usuario_incorrecto')?></p>     
				<br>
				<input type="submit"  class="button" value="Ingresar" />
				<?php
				if($this->session->flashdata('usuario_incorrecto')){
				}
				?>
				<!-- <a class="recuperar" href="<?=  base_url('login/recuperarpassword')?>">Recuperar contrase&ntilde;a</a> -->
		</form>
	</div>
<!-- termina contenido -->