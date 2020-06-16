<?php
  //verificar se não está logado
  if ( !isset ( $_SESSION["hqs"]["id"] ) ){
    exit;
  }

  //iniciar as variaveis
  $tipo = "";

  //se nao existe o id
  if ( !isset ( $id ) ) $id = "";

  //verificar se existe um id
  if ( !empty ( $id ) ) {
  	//selecionar os dados do banco
  	$sql = "select * from tipo 
  		where id = ? limit 1";
  	$consulta = $pdo->prepare($sql);
  	$consulta->bindParam(1, $id); 
  	//$id - linha 255 do index.php
  	$consulta->execute();
  	$dados  = $consulta->fetch(PDO::FETCH_OBJ);

  	//separar os dados
  	$id 	= $dados->id;
  	$tipo 	= $dados->tipo;

  } 
?>
<div class="container">
	<h1 class="float-left">Cadastro de Tipo de Quadrinho</h1>
	<div class="float-right">
		<a href="cadastro/tipo" class="btn btn-success">Novo Registro</a>
		<a href="listar/tipo" class="btn btn-info">Listar Registros</a>
	</div>

	<div class="clearfix"></div>

	<form name="formCadastro" method="post" action="salvar/tipo" data-parsley-validate>

		<label for="id">ID</label>
		<input type="text" name="id" id="id"
		class="form-control" readonly
		value="<?=$id;?>">

		<label for="tipo">Tipo de Quadrinho</label>
		<input type="text" name="tipo" id="tipo"
		class="form-control" required
		data-parsley-required-message="Preencha este campo, por favor"
		value="<?=$tipo;?>">

		<button type="submit" class="btn btn-success margin">
			<i class="fas fa-check"></i> Gravar Dados
		</button>

	</form>

</div> <!-- container -->