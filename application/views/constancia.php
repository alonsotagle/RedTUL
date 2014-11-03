<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>CONSTANCIA</title>
</head>
<style type="text/css">
body{
	text-align: center;
	font-family: Helvetica;
}

#unam{
	font-weight: bold;
	letter-spacing: 4px;
	font-size: larger;
}

#dgtic{

}

#otorga{
	font-weight: bold;
}

#constancia{
	font-size: 40px;
	font-weight: bold;
	margin: 40px 0px 30px 0px;
	color: #0F1F3D;
}

#a{
	font-weight: bold;
	margin-bottom: 18px;
}

#nombre{
	font-weight: bold;
	font-size: 30px;
	margin-bottom: 25px;
}

#asistencia{

}

#curso{
	font-weight: bold;
	font-size: 20px;
}

#descripcion_curso{

}

#lema{
	margin-top: 40px;
	display: block;
	font-size: 15px;
}

#fecha{
	font-size: 15px;
}

#marcela{
	font-weight: bold;
	display: block;
	margin-top: 80px;
	font-size: 15px;
}

#dcv{
	font-size: 15px;
}
</style>
<body>
	<p id="unam">UNIVERSIDAD NACIONAL AUTÓNOMA DE MÉXICO</p>
	<p id="dgtic">La Dirección General de Cómputo y de Tecnologías de Información y Comunicación</p>
	<p id="otorga">Otorga la presente</p>
	<p id="constancia">CONSTANCIA</p>
	<p id="a">a</p>
	<br>
	<p id="nombre"><?= $nombre_completo ?></p>
	<p id="asistencia">por su asistencia a la</p>
	<p id="curso"><?= $curso['curso_titulo'] ?></p>
	<p id="descripcion_curso">llevada a cabo el <?= $curso['curso_fecha_inicio'] ?> en <?= $curso['curso_ubicacion'] ?>.</p>
	<span id="lema">“POR MI RAZA HABLARÁ EL ESPÍRITU”</span>
	<span id="fecha">Ciudad Universitaria, D.F., <?= $fecha_actual ?></span>
	<span id="marcela">MC. Marcela Peñaloza Báez</span>
	<span id="dcv">Directora de Colaboración y Vinculación DGTIC</span>
</body>
</html>