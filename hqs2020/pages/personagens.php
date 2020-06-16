<h1>Personagens</h1>
<div class="row">
	<?php
		//selecionar os quadrinhos da editora
		$sql = "select *
			from personagem
			order by nome";
		//executar o sql
		$consulta = $pdo->prepare($sql);
		$consulta->execute();

		while ( $linha = $consulta->fetch(PDO::FETCH_ASSOC) ) {

			//separar os campos
			$id 	= $linha["id"];
			$nome = $linha["nome"];
			$foto	= $linha["foto"]."m.jpg";
			echo "<div class='col-4 mt-3 text-center'>
					<img src='fotos/$foto' class='w-100 '>
					<p>$nome</p>
					<a href='personagem/$id' class='btn btn-danger'>Detalhes</a>
				</div>";
		}

	?>
</div>
