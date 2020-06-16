<?php
  //verificar se não está logado
  if ( !isset ( $_SESSION["hqs"]["id"] ) ){
    exit;
  }
?>
<div class="container">
	<h1 class="float-left">Listar Clientes</h1>
	<div class="float-right">
		<a href="cadastro/cliente" class="btn btn-success">Novo Registro</a>
		<a href="listar/cliente" class="btn btn-info">Listar Registros</a>
	</div>

	<div class="clearfix"></div>

	<table class="table table-striped table-bordered table-hover" id="tabela">
		<thead>
			<tr>
        <td>ID</td>
        <td>Foto</td>
        <td>Nome</td>
			  <td>Nascimento</td>
        <td>Id Cidade</td>
        <td>Email</td>
        <td>Celular</td>
        <td>Opções</td> 
			</tr>
		</thead>
		<tbody>
			<?php
          $sql = " SELECT id, nome, cpf, date_format(datanascimento, '%d/%m/%Y') datanascimento, email, cidade_id, foto, celular FROM cliente order by nome";
          $consulta = $pdo->prepare($sql);
          $consulta->execute();
          while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {
            //separar os dados
          $id 	            = $dados->id;
          $foto           	= $dados->foto;
					$nome 	          = $dados->nome;
          $datanascimento 	= $dados->datanascimento;
          $cidade_id 	        = $dados->cidade_id;
          $email 	          = $dados->email;
          $celular 	        = $dados->celular;
          //mostrar na tela 
          //print_r($_POST);
          //print_r($_FILES);
            echo '<tr>
                    <td>'.$id.'</td>
                    <td><img src="../fotos/'.$foto.'p.jpg" alt="'.$nome.'" width="70px"></td>
                    <td>'.$nome.'</td>
                    <td>'.$datanascimento.'</td>
                    <td>'.$cidade_id.'</td>
                    <td>'.$email.'</td>
                    <td>'.$celular.'</td>
                    <td>
							        <a href="cadastro/cliente/'.$id.'" class="btn btn-success btn-sm">
								        <i class="fas fa-pencil-alt"></i>
						        	</a>
							        <a href="javascript:excluir('.$id.')" class="btn btn-outline-danger btn-sm">
								        <i class="fas fa-trash"></i>
							        </a>
						        </td>
                  </tr>
                ';
          }
      ?>
    </tbody>
  </table>
</div>
<script type="text/javascript">
  function excluir(id){
    if ( confirm("deseja realmente excluir este registro?") ){
      location.href='excluir/cliente/'+id;
    }
  }
//adicionar o dataTable 
$(document).ready(function(){
	$('#tabela').DataTable({
		"language": {
			"lengthMenu": "Mostrando _MENU_ Registros por Pagina",
			"zeroRecords": "Nenhum Registro Encontrado",
			"info": "Mostrando Paginas de  _PAGE_ de _PAGES_",
			"infoEmpty": "No records available",
			"infoFiltered": "(filtered from _MAX_ total records)",
			"search": "buscar",
      "paginate": {
                "first":      "Primeiro",
                "last":       "Último",
                "next":       "Próximo",
                "previous":   "Anterior"
      }
		}
	} );
})
</script>