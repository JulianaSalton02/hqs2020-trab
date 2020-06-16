<h1 class="text-center">HQs em Destaque</h1>
<div class="row">
<?php
	//selecionar 4 quadrinhos aleatorios
	$sql = "select id, titulo, capa, valor 
		from quadrinho 
		order by rand() 
		limit 4";
	$consulta = $pdo->prepare($sql);
	$consulta->execute();

	while ( $linha = $consulta->fetch(PDO::FETCH_ASSOC) ) {

		//recuperar as variaveis
		$id 	= $linha["id"];
		$titulo = $linha["titulo"];
		$capa	= $linha["capa"]."m.jpg";
		$valor	= $linha["valor"];

		//formatar o valor
		$valor = number_format($valor, 2, ",", ".");
		//var,casas decimais,sep decimal,sep milhares

		echo "<div class='col-3 text-center'>
			<img src='fotos/$capa' class='w-100'>
			<p>$titulo</p>
			<p class='valor'>R$ $valor</p>
			<a href='quadrinho/$id'
			class='btn btn-danger'>Detalhes</a>
		</div>";

	}