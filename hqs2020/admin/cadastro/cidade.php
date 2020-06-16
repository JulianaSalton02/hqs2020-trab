<?php

    //verificar se nao esta logado
    if ( !isset ( $_SESSION["hqs"]["id"] ) ) {
        exit;
    }

    //iniciar as variaveis
    $cidade = $estado = "";

    //se nao existe o id
    if ( !isset ( $id ) ) $id = "";
    
    //verificar se existe um id
    if ( !empty ( $id ) ) {
        //selecionar os dados do banco para poder editar

        $sql = "select * from cidade where id = :id limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":id", $id);
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);

         //separar os dados
        //$id 	    = $dados->id;
        $cidade 	= $dados->cidade;
        $estado 	= $dados->estado;
	  
  }
  //***********************************************
?>
<div class="container">
	<h1 class="float-left">Cadastro de Cidades</h1>
	<div class="float-right">
		<a href="cadastro/cidade" class="btn btn-success">Novo Registro</a>
		<a href="listar/cidade" class="btn btn-info">Listar Registros</a>
	</div>

	<div class="clearfix"></div>

	<form name="formCadastro" method="post" action="salvar/cidade" data-parsley-validate>

		<label for="id">ID</label>
		<input type="text" name="id" id="id"
		class="form-control" readonly
		value="<?=$id;?>">

		<label for="cidade">Nome da Cidade</label>
		<input type="text" name="cidade" id="cidade"
		class="form-control" required
		data-parsley-required-message="Preencha este campo, por favor"
		value="<?=$cidade;?>">

		<label for="estado">Estado</label>
		<input type="text" name="estado" id="estado"
		class="form-control" required
		data-parsley-required-message="Preencha este campo, por favor"
		value="<?=$estado;?>">

		<button type="submit" class="btn btn-success margin">
			<i class="fas fa-check"></i> Gravar Dados
		</button>

	</form>

</div> <!-- container -->