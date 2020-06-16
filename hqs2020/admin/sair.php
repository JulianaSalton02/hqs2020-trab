<?php
	//iniciar a sessão
	session_start();

	//apagar a sessao
	unset ( $_SESSION["hqs"] );

	//redirecionar para a página inicial
	header("Location: index.php");