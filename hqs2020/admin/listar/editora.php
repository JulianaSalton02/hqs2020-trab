<?php
  //verificar se não está logado
  if ( !isset ( $_SESSION["hqs"]["id"] ) ){
    exit;
  }
?>
<div class="container">
	<h1 class="float-left">Listar Editora</h1>
	<div class="float-right">
		<a href="cadastro/editora" class="btn btn-success">Novo Registro</a>
		<a href="listar/editora" class="btn btn-info">Listar Registros</a>
	</div>

	<div class="clearfix"></div>

	<table class="table table-striped table-bordered table-hover" id="tabela">
		<thead>
			<tr>
				<td>ID</td>
				<td>Nome da Editora</td>
				<td>Site da Editora</td>
				<td>Opções</td>
			</tr>
		</thead>
		<tbody>
			<?php
				//buscar as editoras alfabeticamente
				$sql = "select * from editora 
				order by nome";
				$consulta = $pdo->prepare($sql);
				$consulta->execute();

				while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {
					//separar os dados
					$id 	= $dados->id;
					$nome 	= $dados->nome;
					$site 	= $dados->site;
					//mostrar na tela
					echo '<tr>
							<td>'.$id.'</td>
							<td>'.$nome.'</td>
							<td>'.$site.'</td>
							<td>
								<a href="cadastro/editora/'.$id.'" class="btn btn-success btn-sm">
									<i class="fas fa-edit"></i>
								</a>

								<a href="javascript:excluir('.$id.')" class="btn btn-danger btn-sm">
									<i class="fas fa-trash"></i>
								</a>
							</td>
						</tr>';
				}
			?>
		</tbody>
	</table>
</div>
<script>
	//funcao para perguntar se deseja excluir
	//se sim direcionar para o endereco de exclusão
	function excluir(id) {
		//perguntar - função confirm
		if ( confirm( "Deseja mesmo excluir?" ) ) {
			//direcionar para a exclusao
			location.href="excluir/editora/"+id;
		}
	}

	//adicionar o datatable a minha tabela
	$(document).ready(function(){
		$('#tabela').DataTable({
			"language": {
				"lengthMenu": "Mostrando _MENU_ Registros por Pagina",
				"zeroRecords": "Nenhum Registro Encontrado",
				"info": "Mostrando Paginas de  _PAGE_ de _PAGES_",
				"infoEmpty": "No records available",
				"infoFiltered": "(filtered from _MAX_ total records)",
				"search": "buscar"
				
			}
		} );
	})
</script>