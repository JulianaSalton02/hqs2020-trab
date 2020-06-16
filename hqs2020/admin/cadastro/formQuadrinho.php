<?php
    if ( !isset ( $pagina ) ) exit;
?>
<form name="formPersonagem" action="adicionarPersonagem.php" method="post"
data-parsley-validate="" target="personagens">
    <h3>Adicionar Personagens</h3>
    <input type="hidden" name="quadrinho_id" value="<?=$id;?>">
    <div class="row">
        <div class="col-10 col-md-8">
            <select name="personagem_id" id="personagem_id" class="form-control"
            required data-parsley-required-message="Selecione um personagem">
                <option value="Selecione um Personagem"></option>
                <?php
                    $sql = "select id, nome from personagem order by nome";
                    $consulta = $pdo->prepare($sql);
                    $consulta->execute();

                    while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ){

                        //separar as variaves
                        $idp  = $dados->id;
                        $nome = $dados->nome;

                        echo "<option value='$idp'>$nome</option>";
                    }
                ?>
            </select>
        </div>
        <div class="col-4">
            <button type="submit" class="btn btn-success">OK</button>
            <button type="reset" class="btn btn-danger">Novo</button>
        </div>
    </div>
</form>
<iframe name="personagens" width="100%" height="300px" 
src="adicionarPersonagem.php?quadrinho_id=<?=$id;?>"></iframe>