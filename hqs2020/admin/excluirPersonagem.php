<?php
    session_start();

    if ( !isset ( $_SESSION["hqs"]["id"] ) ){
        exit;
    }
    //incluir o arquivo de conexao
    include "config/conexao.php";

    $quadrinho_id = $_GET["quadrinho_id"] ?? "";
    $personagem_id = $_GET["personagem_id"] ?? "";

    if ( (empty($personagem_id) ) or (empty($quadrinho_id) ) ) {
        echo "<script>alert('Erro ao excluir personagem');</script>";
    }

    $sql = "delete from quadrinho_personagem 
    where quadrinho_id :quadrinho_id AND 
    personagem_id = :personagem_id  ";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":personagem_id",$personagem_id);
    $consulta->bindParam(":quadrinho_id",$quadrinho_id);

    if ( !$consulta->execute() )
        echo "<script>alert('Erro ao excluir');</script>";

    echo "<script>location.href='adicionarPersonagem.php?quadrinho_id=$quadrinho_id';</script>";