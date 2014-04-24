<script>
    $(document).ready(function(){
            $("#frm_login").validationEngine({promptPosition: "centerRight"});
    }); 
</script>
<div class="topinterna"><img src="<?=  base_url('assets/img/titulo.jpg')?>" alt="DGTIC" style="width:980; heigh:61; border:0" /></div>
<!-- inicia contenido -->
<div class="contenido">
	<form id="frm_login" action="<?=  base_url('index.php/login/autenticacion')?>" method="POST">
		<div id="align_izq">
			<h1>Bienvenido</h1>
			<h3>Red Toda la UNAM enLínea</h3>
		</div>
		<div id="align_der">
			<img src="<?=  base_url('assets/img/avatar_sesion.png')?>" alt="avatar">
			<label for="usuario"></label>
			<input type="text" id="usr_nombre" name="usr_nombre" class="input validate[required]" spellcheck="false" placeholder="Nombre de Usuario"/>
			<label for="contrase"></label>
			<input type="password" id="usr_password" name="usr_password" class="input validate[required]" placeholder="Contrase&ntilde;a"/>
			<input type="hidden" name="token" value="<?=$token?>">
			<select name="usr_rol" id="usr_rol" class="select validate[required]" >
				<option  disabled>- Elija un rol -</option>
				<option>Administrador</option>
				<option>Colaborador</option>
				<option>Auditor</option>
			</select>
			<p class="error"><?=$this->session->flashdata('usuario_incorrecto')?></p>     
			<input type="submit"  class="button" value="Ingresar" />
			<?php
			if($this->session->flashdata('usuario_incorrecto')){
			}
			?>
			<a class="recuperar" href="<?=  base_url('login/recuperarpassword')?>">Recuperar contrase&ntilde;a</a>
		</div>
	</form>
</div>
<!-- termina contenido -->