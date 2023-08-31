<?php 
require_once 'usuarios.php'; 
$u = new usuario;
require_once 'evento/conexao.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cadastro.css">
    <title>Cadastrar</title>
</head>
<body>
    
<div class="container" >
    <a class="links" id="paracadastro"></a>

    
    <div class="content">      
  
      <!--FORMULÁRIO DE CADASTRO--> 
      <div id="cadastro">
        <form method="post" action=""> 
          <h1>Cadastro</h1> 
          
          <p> 
            <label for="nome_cad">Seu nome</label>
            <input id="nome_cad" name="nome_cad" required="required" type="text" placeholder="Darruiz DLC" />
          </p>
          
          <p> 
            <label for="senha_cad">Sua senha</label>
            <input id="senha_cad" name="senha_cad" required="required" type="password" placeholder="Sua senha BB"/>
          </p> 

          <p> 
            <label for="senha_con">Confirmar senha</label>
            <input id="senha_con" name="senha_con" required="required" type="password" placeholder="Confirme sua senha BB"/>
          </p>
          
          <p> 
            <input type="submit" value="Cadastrar"/> 
          </p>
          
          <p class="link">  
            Já tem conta?
            <a href="login.php"> Ir para Login </a>
          </p>
        </form>
      </div>
      
    </div>
    <footer>&copy; Darruiz 2023</footer>
  </div> 
  <?php
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $nome = addslashes($_POST['nome_cad']);
    $senha = md5(addslashes($_POST['senha_cad']));
    $confisenha = addslashes($_POST['senha_con']);  

    if(!empty($nome) && !empty($senha) && !empty($confisenha)) 
    {
        $database = new Database();
        $connection = $database->conectar(); 

        $u->conectar("dzcl", "localhost", "root", ""); 

        if ($u->msgErro == "") 
        {
            if($senha == md5($confisenha)) 
            {
                if ($u->cadastrar($nome, $senha)) 
                {   
                    ?>
                    <div id="msg-sucesso">
                    Cadastrado com sucesso! Volte para fazer o login!
                    </div>
                    <?php
                } 
                else 
                {
                    ?>
                    <div class="msg-erro">
                    Erro ao cadastrar no sistema!
                    </div>
                    <?php
                }
            } 
            else 
            { 
                ?>
                <div class="msg-erro">
                Senha e Confirmar senha não correspondem!
                </div>
                <?php
            }

            header("location: index.php");
        }
        else 
        { 
            echo "Erro: ".$u->msgErro;
        }

        $connection = null; 
    }  
    else 
    { 
        ?>
        <div class="msg-erro">
        Preencha todos os campos!
        </div>
        <?php
    }
}
?>
</body>
</html>
