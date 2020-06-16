<?php

	$id = "";
	if ( isset ( $p[1]) ) {
		$id = trim ( $p[1] );
	}

	//selecionar o quadrinho
	$sql 		= "select *, date_format(data,'%d/%m/%Y') data
					from quadrinho 
					where id = ? limit 1";
	$consulta = $pdo->prepare($sql);
	$consulta->bindParam(1, $id, PDO::PARAM_INT);
	$consulta->execute();
	$linha 		= $consulta->fetch(PDO::FETCH_ASSOC);

	$id 	= $linha["id"];
	$titulo = $linha["titulo"];
	$numero	= $linha["numero"];
	$capa	= $linha["capa"]."m.jpg";
	$resumo = $linha["resumo"];
	$valor 	= $linha["valor"];
	$valor = number_format($valor,2,",",".");
	$data 	= $linha["data"];
?>
<h1><?=$titulo;?></h1>
<div class="row">
	<div class="col-4">
		<img src="fotos/<?=$capa;?>" class="w-100">
		<p class="valor">R$ <?=$valor;?>
	</div>
	<div class="col-8">
		<p><strong>Data:</strong> <?=$data;?></p>
		<p><strong>Número do quadrinho:</strong> <?=$numero;?></p>
		<p><strong>Resumo:</strong> <?=$resumo;?></p>
		<p class="text-center">
			<a href="carrinho/add/<?=$id;?>" class="btn btn-danger btn-lg">
				Adicionar ao Carrinho
			</a>
		</p>
	</div>
</div>