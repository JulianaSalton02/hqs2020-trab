<?php
  //verificar se não está logado
  if ( !isset ( $pagina ) ){
    exit;
  }

  $msg = NULL;

  //verificar se foi dado um POST
  if ( $_POST ) {
    //iniciar as variaveis
    $login = $senha = "";
    //recuperar o login e a senha digitados
    if ( isset ( $_POST["login"] ) )
      $login = trim ( $_POST["login"] );
    
    if ( isset ( $_POST["senha"] ) )
      $senha = trim ( $_POST["senha"] );

    //verificar se os campos estao em branco
    if ( empty ( $login ) )
      $msg = '<p class="alert alert-danger">Preencha o campo Login</p>';
    else if ( empty ( $senha ) ) 
      $msg = '<p class="alert alert-danger">Preencha o campo Senha</p>';
    else {
      //verificar se o login existe
      $sql = "select id, nome, login, senha, foto from usuario where login = ? limit 1";
      //apontar a conexao com o banco
      //preparar o sql para execução
      $consulta = $pdo->prepare($sql);
      //passar o parametro para o sql
      $consulta->bindParam(1, $login);
      //executar o sql
      $consulta->execute();
      //puxar os dados do resultado
      $dados = $consulta->fetch(PDO::FETCH_OBJ);

      //verificar se existe usuario
      if ( empty ( $dados->id ) ) 
        $msg = '<p class="alert alert-danger">O usuário não existe!</p>';
      //verificar se a senha esta correta
      else if ( !password_verify($senha, $dados->senha) )
        $msg = '<p class="alert alert-danger">Senha incorreta</p>';
      //se deu tudo certo
      else {
        //registrar este usuário na sessao
        $_SESSION["hqs"] = 
          array("id"  => $dados->id,
                "nome"=> $dados->nome,
                "foto"=> $dados->foto);
        //redirecionar para o home
        $msg = 'Deu certo!';
        //javascript para redirecionar
        echo '<script>location.href="paginas/home";</script>';
        exit;

      }


    }
  }
?>
<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image">
              </div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Bem-vindo ao Sistema</h1>
                  </div>
                  <?=$msg;?>
                  <form class="user" name="login" method="post" data-parsley-validate>
                    <div class="form-group">
                      <input type="text" 
                      name="login" 
                      class="form-control form-control-user" id="login" placeholder="Digite o seu login" required
                      data-parsley-required-message="Preencha o Login">
                    </div>
                    <div class="form-group">
                      <input type="password"
                      name="senha" 
                      class="form-control form-control-user" id="senha" placeholder="Digite sua senha" required
                      data-parsley-required-message="Preencha a senha">
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="lembrar">
                        <label class="custom-control-label" for="lembrar">Lembrar meu login</label>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Login
                    </button>
                  </form>
                 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>