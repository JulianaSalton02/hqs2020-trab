<?php

	$id = "";
	//verificar se esta sendo enviado id
	if ( isset ( $p[1]) ) {
		//id receber o parametro na posiçao 1
		$id = trim ( $p[1] );
	}

	//comando sql para selecionar o personagem
	$sql = "select * from personagem 
		where id = ? limit 1";
	//executar o sql e guardar o resultado
	$consulta = $pdo->prepare($sql);
	$consulta->bindParam(1, $id, PDO::PARAM_INT);
	$consulta->execute();
	$linha = $consulta->fetch(PDO::FETCH_ASSOC);

	//separar os dados do personagem
	$nome 		= $linha["nome"];
	$nomecivil 	= $linha["nomecivil"];
	$foto		= $linha["foto"]."m.jpg";
	$resumo		= $linha["resumo"];
?>
<h1><?=$nome;?></h1>
<div class="row">
	<div class="col-4">
		<img src="fotos/<?=$foto;?>" class="w-100">
	</div>
	<div class="col-8">
		<p><strong>Nome civil:</strong> <?=$nomecivil;?></p>
		<p><strong>Resumo:</strong> <?=$resumo;?>
	</p>
</div>