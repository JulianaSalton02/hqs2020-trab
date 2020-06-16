<?php
    session_start();
    //verificar se nao esta logado
    if ( !isset ( $_SESSION["hqs"]["id"] ) ){
        exit;
    }

    $cidade = $_GET["cidade"] ?? "";
    $estado = $_GET["estado"] ?? "";

    if ( ( empty ($cidade) ) or ( empty ($estado) ) ) {
        echo "Erro";
    }

    include "config/conexao.php";
    //coloquei : no estado
    $sql = "select id from cidade where cidade = :cidade and estado = :estado limit 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":cidade", $cidade);
    $consulta->bindParam(":estado", $estado);
    $consulta->execute();

    $d = $consulta->fetch(PDO::FETCH_OBJ);

    if (empty ( $d->id ) ) echo "Erro";
    else echo $d->id;