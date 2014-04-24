  <!-- inicia navegacion -->
  
  
<div class="navegacion">
 
	 <div id='cssmenu'>
	<ul>
	   <!-- <li ><a href='index.html'><span>Gestionar Hallazgos</span></a></li>-->
	   <li class='has-sub'><a href='#'><span>Gestionar Hallazgos</span></a>
	      <ul>
	         <li class='has-sub'><a href="<?= base_url('index.php/paginaEsta/redirect/ad_RegistroHallazgo')?>" ><span>Registrar</span></a></li>
	      </ul>
	   </li>   
	   <li class='has-sub'><a href='#'><span>Realizar consulta</span></a>
	      <ul>
	         <li class='has-sub'><a href="<?= base_url('index.php/paginaEsta/redirect/ad_ConsultaProceso')?>" ><span>Por proceso</span></a></li>
			 <li class='has-sub'><a href="<?= base_url('index.php/paginaEsta/redirect/ad_ConsultaColaborador')?>" ><span>Por colaborador</span></a></li>
	         <li class='has-sub'><a href='#'><span>Seguimiento de procesos</span></a>
	            <ul>
                        <li><a href='<?=  base_url('index.php/administrador/consultaHallazgo')?>'><span>Hallazgos</span></a></li>
				    <li><a href="<?= base_url('index.php/paginaEsta/redirect/ad_Acciones')?>" ><span>Acciones</span></a></li>
	               <li><a href="<?= base_url('index.php/paginaEsta/redirect/ad_ConsultaTareas')?>" ><span>Tareas</span></a></li>
                       <li class='last'><a href="<?= base_url('index.php/paginaEsta/redirect/ad_RepoGlobal')?>"><span>Reporte global</span></a></li>
	            </ul>
	         </li>
			 <li class='has-sub'><a href="<?= base_url('index.php/paginaEsta/redirect/ad_IndicadorMejora')?>" ><span>Consultar indicadores</span></a></li>
	      </ul>
	   </li>
	   <li class='has-sub'><a href='#'><span>Gestionar sistema</span></a>
	      <ul>
	         <li class='has-sub'><a href="<?= base_url('index.php/gestion_user_control')?>" ><span>Gestionar usuarios</span></a></li>
			 <li class='has-sub'><a href="<?= base_url('index.php/paginaEsta/redirect/ad_GestionCatalogos')?>" ><span>Gestionar catálogos</span></a></li>
	         <li class='has-sub'><a href="<?= base_url('index.php/paginaEsta/redirect/ad_HistorialCambios')?>" ><span>Gestionar historial de cambios</span></a>
	         </li>
	      </ul>
	   </li>
	   <li class='has-sub' class='last'><a href='#'><span>Usuario</span></a>
	      <ul>
	         <li class='has-sub'><a href="<?= base_url('index.php/login/cambiarpassword')?>" ><span>Cambiar contraseña</span></a></li>
			 <li class='has-sub'><a href="<?= base_url('index.php/login/logout')?>" ><span>Cerrar sesión</span></a></li>
		  </ul>
	</ul>
	</div>
</div>
 
 <!-- termina navegacion -->
 
<div class="topinterna"><img src="<?= base_url('assets/img/titulo.jpg')?>" alt="DGSCA" width="980" height="61" border="0" usemap="#Map2" />
	
</div>
