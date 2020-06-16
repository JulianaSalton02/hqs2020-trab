<?php
  //verificar se não está logado
  if ( !isset ( $_SESSION["hqs"]["id"] ) ){
    exit;
  }

  if ( !isset ( $id ) ) $id = "";
  $nome = $cpf = $datanascimento = $email = $senha = $cep = $endereco = $complemento = $bairro = $cidade_id = 
  $foto = $telefone = $celular = $nome_cidade = $estado = "";

  if ( !empty ( $id ) ) {
	  //selecionar os dados do cliente
	  $sql =  "select c.*, date_format(c.datanascimento,'%d/%m/%Y') datanascimento,
	  ci.cidade, ci.estado from cliente c 
	  inner join cidade ci on ( ci.id = c.cidade_id ) where c.id = :id limit 1";
	  $consulta = $pdo->prepare( $sql);
	  $consulta->bindParam(":id", $id);
	  $consulta->execute();

	  $dados = $consulta->fetch(PDO::FETCH_OBJ);

	  if ( empty ( $dados->id ) ) {
		  echo "<p class='alert alert-danger'>Cliente Não Existente</p>";
	  }

	  $id             = $dados->id;
	  $nome           = $dados->nome;
	  $datanascimento = $dados->datanascimento;
	  $endereco       = $dados->endereco;
	  $bairro         = $dados->bairro;
	  $cidade_id      = $dados->cidade_id;
	  $nome_cidade    = $dados->cidade;
	  $estado         = $dados->estado;
	  $cpf            = $dados->cpf;
	  $email          = $dados->email;
	  $cep            = $dados->cep;
	  $complemento    = $dados->complemento;
	  $foto           = $dados->foto;
	  $telefone       = $dados->telefone;
	  $celular        = $dados->celular;


  }
?>
<div class="container">
	<h1 class="float-left">Cadastro de Clientes</h1>
	<div class="float-right">
		<a href="cadastro/cliente" class="btn btn-success">Novo Registro</a>
		<a href="listar/cliente" class="btn btn-info">Listar Registros</a>
	</div>

	<div class="clearfix"></div>

	<form name="formCadastro" method="post"
	action="salvar/cliente" data-parsley-validate enctype="multipart/form-data">

		<div class="row">
			<div class="col-12 col-md-2">
				<label for="id">ID:</label>
				<input type="text" name="id" id="id" class="form-control" readonly value="<?=$id;?>">
			</div>
			<div class="col-12 col-md-10">
				<label for="nome">Nome:</label>
				<input type="text" name="nome" id="nome" class="form-control" required data-parsley-required-message="Preencha o nome" 
				value="<?=$nome;?>" placeholder="Digite seu nome completo">
			</div>

			<div class="col-12 col-md-4">
				<label for="cpf">CPF:</label>
				<input type="text" name="cpf" id="cpf" class="form-control" required data-parsley-required-message="Preencha o cpf" 
				value="<?=$cpf;?>" 
				onblur="verificarCpf(this.value)">
			</div>
			<div class="col-12 col-md-4">
				<label for="datanascimento">Data de Nascimento:</label>
				<input type="text" name="datanascimento" id="datanascimento" class="form-control" required data-parsley-required-message="Preencha a data de nascimento" 
				placeholder="Digite a data 11/12/1990" value="<?=$datanascimento;?>">
			</div>
			<div class="col-12 col-md-4">
				<label for="foto">Foto (JPG)</label>
				<input type="file" name="foto" id="foto" class="form-control">
				<input type="hidden" name="foto" value="<?=$foto?>" class="form-control">
                <?php  
                     
                if( !empty($foto)){
                    $foto = "<img src='../fotos/".$foto."p.jpg' alt='".$nome."' width='150px'>";
                } else{
                    $foto = "";
                }?>
                <div><?php echo $foto ;?></div>
			</div>

			<div class="col-12 col-md-6">
				<label for="telefone">Telefone:</label>
				<input type="text" name="telefone" id="telefone" class="form-control" placeholder="Telefone com DDD"
				value="<?=$telefone;?>">
			</div>
			<div class="col-12 col-md-6">
				<label for="celular">Celular:</label>
				<input type="text" name="celular" id="celular" class="form-control" placeholder="Celular com DDD"
				value="<?=$celular;?>" required data-parsley-required-message="Preencha o celular">
			</div>

			<div class="col-12">
				<label for="email">E-mail:</label>
				<input type="email" name="email" id="email" class="form-control"required data-parsley-required-message="Preencha o e-mail" 
				data-parsley-type-message="Digite um e-mail válido"
				value="<?=$email;?>">
			</div>

			<div class="col12 col-md-6">
				<label for="senha">Senha:</label>
				<input type="password" name="senha" id="senha" class="form-control" value="<?=$senha?>">
			</div>
			<div class="col12 col-md-6">
				<label for="senha2">Redigite a Senha:</label>
				<input type="password" name="senha2" id="senha2" class="form-control"  data-parsley-equalto="#senha" data-parsley-trigger="keyup" data-parsley-error-message="Senha não confere" value="<?=$senha?>">
			</div>

			<div class="col-12 col-md-3">
				<label for="cep">CEP:</label>
				<input type="text" name="cep" id="cep" class="form-control" required data-parsley-required-message="Preencha o CEP"
				 value="<?=$cep;?>">
			</div>
			<div class="col-12 col-md-2">
				<label for="cidade_id">ID Cidade</label>
				<input type="text" name="cidade_id" id="cidade_id" class="form-control" required data-parsley-required-message="Preencha a Cidade" readonly value="<?=$cidade_id;?>">
			</div>
			<div class="col-12 col-md-5">
				<label for="nome_cidade">Nome da Cidade:</label>
				<input type="text" id="nome_cidade" class="form-control"
				value="<?=$nome_cidade;?>">
			</div>
			<div class="col-12 col-md-2">
				<label for="estado">Estado:</label>
				<input type="text" id="estado" class="form-control"
				value="<?=$estado;?>">
			</div>

			<div class="col-12 col-md-8">
				<label for="endereco">Endereço</label>
				<input type="text" name="endereco" id="endereco" class="form-control"
				value="<?=$endereco;?>">
			</div>
			<div class="col-12 col-md-4">
				<label for="bairro">Bairro</label>
				<input type="text" name="bairro" id="bairro" class="form-control"
				value="<?=$bairro;?>">
			</div>
		</div>
		<button type="submit" class="btn btn-success margin">
			<i class="fas fa-check"></i> Gravar Dados
		</button>
	</form>
	<?php
		//verificar se o id é vazio
		if ( empty ( $id ) ) $id = 0;
	?>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#datanascimento").inputmask("99/99/9999");
			$("#cpf").inputmask("999.999.999-99");
			$("#telefone").inputmask("(99) 9999-9999");
			$("#celular").inputmask("(99) 99999-9999");
			$("#cep").inputmask("99.999-999");
		});
		function verificarCpf(cpf) {
			//funcao ajax para verificar o cpf
			$.get("verificacpf.php",
				{cpf:cpf,id:<?=$id;?>},
				function(dados){

					if ( dados != "" ) {
						//mostrar o erro retornado
						alert(dados);
						//zerar o cpf
						$("#cpf").val("");

					}
			})
		}
		function confirmarEmail(email){
               $.get("verificaEmail.php", {email:email,id:<?=$id;?>}, function(dados){
                   if(dados != ""){
                       alert(dados);
                       $("#email").val("");
                   }
               }) 
            }
			
		$("#cep").blur(function(){
			//pegar o cep
			cep = $("#cep").val();
			cep = cep.replace(/\D/g, '');

			//verificar se esta em branco
			if ( cep == "" ) {
				alert("Preencha o CEP");
			} else {

				//Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                	$("#nome_cidade").val(dados.localidade);
                	$("#estado").val(dados.uf);
                	$("#endereco").val(dados.logradouro);
                	$("#bairro").val(dados.bairro);
					
					//buscar o id da cidade
					$.get("buscarCidade.php",{cidade:dados.localidade, estado:dados.uf},
					function(dados){
						
						if ( dados != "Erro" ) {
							$("#cidade_id").val(dados);
						}else {
							alert(dados);
						}
					})

					//focar no campo endereço
					$("#endereco").focus();
                })

			}


		})
	</script>
</div>