<?php
class usuario
{
    private $pdo;
    public $msgErro = "";

    public function conectar($nome, $host, $usuario, $senha)
    {
        try
        {
            $this->pdo = new PDO("mysql:dbname=".$nome.";host=".$host, $usuario, $senha);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e)
        {
            $this->msgErro = $e->getMessage();
        }
    }

    public function cadastrar($nome, $senha)
    {
        $sql = $this->pdo->prepare("SELECT id FROM usuarios WHERE nome = :n");
        $sql->bindValue(":n", $nome);
        $sql->execute();

        if ($sql->rowCount() > 0)
        {
            return false;
        }
        else
        {
            $sql = $this->pdo->prepare("INSERT INTO usuarios (nome, senha) VALUES (:n, :s)");
            $sql->bindValue(":n", $nome);
            $sql->bindValue(":s", md5($senha));
            $sql->execute();

            return true;
        }
    }

    public function logar($nome, $senha)
    {
        $senhaMD5 = md5($senha);

        $sql = $this->pdo->prepare("SELECT id FROM usuarios WHERE nome = :n AND senha = :s");
        $sql->bindValue(":n", $nome);
        $sql->bindValue(":s", $senhaMD5);
        $sql->execute();

        if ($sql->rowCount() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
?>
