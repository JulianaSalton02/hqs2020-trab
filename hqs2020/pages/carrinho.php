<?php

	$op = $produto = "";
	if ( isset ( $p[1] ) ) $op = trim ( $p[1] );
	if ( isset ( $p[2] ) ) $produto = trim ( $p[2] );

	if ( $op == "add" ) {

		$sql = "select id, titulo, valor from quadrinho where id = ? limit 1";
		$consulta = $pdo->prepare($sql);
		$consulta->bindParam(1, $produto, PDO::PARAM_INT);
		$consulta->execute();
		$linha 		= $consulta->fetch(PDO::FETCH_OBJ);

		if ( isset ( $linha->id ) ) { 
			$id 	= 	$linha->id;
			$titulo =	$linha->titulo;
			$valor  =	$linha->valor;

			$_SESSION["carrinho"][$id] = array("id"=>$id, "titulo"=>$titulo, "valor"=>$valor, "quantidade"=>1);
		}

	} else if ( $op == "quantidade" ) {

		$quantidade = 1;
		if ( isset ( $p[3] ) ) $quantidade = trim ( $p[3] );
		$_SESSION["carrinho"][$produto]["quantidade"] = $quantidade;

	} else if ( $op == "del" ) {

		unset ( $_SESSION["carrinho"][$produto] );

	} else if ( $op == "limpar" ) {

		unset ( $_SESSION["carrinho"] );

	}

?>
<h1>Carrinho de Compras:</h1>
<?php
	if ( isset ( $_SESSION["carrinho"] ) ) {
		?>
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<td>Nome do Produto</td>
					<td>Valor Unitário</td>
					<td>Quantidade</td>
					<td>Total</td>
					<td>Excluir</td>
				</tr>
			</thead>

		<?php

		$geral = 0;

		foreach ( $_SESSION["carrinho"] as $c ) {
			
			$id 		= 	$c["id"];
			$titulo 	=	$c["titulo"];
			$valor  	=	$c["valor"];
			$quantidade =	$c["quantidade"];

			$total = $valor * $quantidade;

			$geral = $total + $geral;

			$valor = number_format($valor,2,",",".");
			$total = number_format($total,2,",",".");

			echo "<tr>
				<td>$titulo</td>
				<td>$valor</td>
				<td>
					<input type='text' value='$quantidade' onblur='adicionaQuantidade($id, this.value)' class='form-control'>
				</td>
				<td>$total</td>
				<td><a href='carrinho/del/$id' class='btn btn-danger'>Excluir</a></td>
			</tr>";
		}
		$geral = number_format($geral,2,",",".");
		?>
			<tfoot>
				<tr>
					<td colspan="3">TOTAL:</td>
					<td colspan="2">R$ <?=$geral;?></td>
				</tr>
			</tfoot>
		</table>
		<form method="post" target="pagseguro"  action="https://pagseguro.uol.com.br/v2/checkout/payment.html" target="_blank">  
			<!-- Campos obrigatórios -->  
	        <input name="receiverEmail" type="hidden" value="suporte@lojamodelo.com.br">  
	        <input name="currency" type="hidden" value="BRL"> 

	        <?php

	        	$i = 1;

	        	foreach ( $_SESSION["carrinho"] as $c ) {
			
					$id 		= 	$c["id"];
					$titulo 	=	$c["titulo"];
					$valor  	=	$c["valor"];
					$quantidade =	$c["quantidade"];

					$total = $valor * $quantidade;

					$valor = number_format($valor,2,".","");

					?>

					<input name="itemId<?=$i;?>" type="hidden" value="<?=$id;?>">  
			        <input name="itemDescription<?=$i;?>" type="hidden" value="<?=$titulo;?>">  
			        <input name="itemAmount<?=$i;?>" type="hidden" value="<?=$valor;?>">  
			        <input name="itemQuantity<?=$i;?>" type="hidden" value="<?=$quantidade;?>">  
			        <input name="itemWeight<?=$i;?>" type="hidden" value="1000">  
 

					<?php

					$i++;
				}


	        ?>
	        <a href="carrinho/limpar" class="btn btn-danger">Limpar Carrinho</a>
	        <button type="submit" class="btn btn-success">Realizar Pagamento</button>
		</form>
		<script type="text/javascript">
			function adicionaQuantidade(produto, quantidade) {
				location.href = 'carrinho/quantidade/'+produto+"/"+quantidade;
			}
		</script>
		<?php
	} else {
		echo "<p class=\"alert alert-danger\">Não existem produtos no carrinho</p>";
	}

?>
