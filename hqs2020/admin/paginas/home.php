<?php
  //verificar se não está logado
  if ( !isset ( $_SESSION["hqs"]["id"] ) ){
    exit;
  }
?>
<div class="container">
	<h1>Dashboard</h1>

  <p class="text-center">
    <?=$_SESSION["hqs"]["nome"];?>
  </p>
</div>