<?php

	session_start();

	//mostrar erros
	ini_set('display_errors',1);
	ini_set('display_startup_erros',1);
	error_reporting(E_ALL);

	//criar conexao com banco com PDO
	$servidor = "localhost";
	//em 99% dos casos é localhost

	//usuario de acesso ao banco
	$usuario = "root";
	$senha = "";

	//nome do banco de dados
	$banco = "hqs2020";

	try {
		//criar uma conexao com PDO
		$pdo = new PDO("mysql:host=$servidor;
			dbname=$banco;
			charset=utf8",
			$usuario,
			$senha);

	} catch (PDOException $erro) {

		//mensagem de erro
		$msg = $erro->getMessage();

		echo "<p>Erro ao conectar no banco de dados: $msg </p>";

	}

	//definir a pagina como home
	$pagina = "home";

	//recuperar o parametro
	if ( isset ( $_GET["parametro"] ) )
	{
		$pagina = trim ( $_GET["parametro"]);

		//quebra uma string a partir de um caracter
		$p = explode("/", $pagina); 
		
		//print_r($p);
		// $p[0] - nome da pagina
		// $p[1] - id do registro
		$pagina = $p[0];
	}

	//verificar qual pagina ira carregar
	if ( $pagina == "sobre" )
		$titulo = "Sobre a Hqs";
	else if ( $pagina == "contato" )
		$titulo = "Entre em Contato";
	else if ( $pagina == "personagens" )
		$titulo = "Personagens";
	else if ( $pagina == "editora" ) 
		$titulo = "Editoras";
	else if ( $pagina == "tipo" )
		$titulo = "Tipo de Quadrinhos";
	else
		$titulo = "Página Inicial";

	$porta = $_SERVER["SERVER_PORT"];
?>
<!DOCTYPE html>
<html>
<head>
	<title>HQLandia - <?=$titulo;?></title>
	<meta charset="utf-8">

	<base href="http://<?=$_SERVER['SERVER_NAME']. ":$porta" . $_SERVER['SCRIPT_NAME']?>">

	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="shortcut icon" href="images/icone.png">

	<script type="text/javascript" src="js/jquery-3.1.0.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
	  <a class="navbar-brand" href="index.php"><img src="images/logo.png" alt="HQLandia" title="HQLancia"></a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>

	  <div class="collapse navbar-collapse" id="menu">
	    <ul class="navbar-nav ml-auto">
	      <li class="nav-item">
	        <a class="nav-link" href="home">Home</a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="sobre">Quem somos</a>
	      </li>
	      <li class="nav-item dropdown">
	        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown">Editoras</a>
	        <div class="dropdown-menu">
	        <?php
	        //mostrar as editoras
	        $sql = "select * from editora 
	        	order by nome";
	        //executar
	        $consulta = $pdo->prepare($sql);
			$consulta->execute();
	        //separar os dados por linha
	        while ( $linha = $consulta->fetch(PDO::FETCH_ASSOC) ) {
	        	//separar os dados
	        	$id 	= $linha["id"];
	        	$nome 	= $linha["nome"];
	        	//montar o link
	        	echo "<a href='editora/$id' class='dropdown-item'>$nome</a>";
	        }
	        ?>
	        </div>
	      </li>
	     
	      <li class="nav-item dropdown">
	        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown">Tipo de Quadrinhos</a>
	        <div class="dropdown-menu">
	        <?php
	        //mostrar os tipo de quadrinhos
	        $sql = "select * from tipo 
	        order by tipo";
	        //executar e pegar os resultados
	        $consulta = $pdo->prepare($sql);
			$consulta->execute();
	        //separar as linhas
	        while ( $linha = $consulta->fetch(PDO::FETCH_ASSOC) ) {

	        	//separar as variaveis
	        	$id = $linha["id"];
	        	$tipo = $linha["tipo"];
	        	//montar o link na tela
	        	echo "<a href='tipo/$id' class='dropdown-item'>$tipo</a>";

	        }
	        ?>
	        </div>
	      </li>
	      <li class="nav-item ">
	        <a class="nav-link" href="personagens" >Personagens</a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="contato">Contato</a>
	      </li>
	    </ul>
	  </div>
	</nav>


	<main class='container'>
		<?php


		//configurar a pagina que ira ser incluida
		$pagina = "pages/".$pagina.".php";
		//verificar se a págian existe
		if ( file_exists($pagina) ) {
			include $pagina;
		} else{
			include "erro.php";
		}


		?>
	</main>

	<footer>


	</footer>


</body>
</html>