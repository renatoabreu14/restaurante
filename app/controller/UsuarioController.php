<?php


namespace controller;

include_once "Conexao.php";
use model\Usuario;

class UsuarioController{

    private static $instance;
    private $conexao;

    private function __construct(){
        $this->conexao = Conexao::getInstance();
    }

    public static function getInstance(){
        if (self::$instance == null){
            self::$instance = new UsuarioController();
        }
        return self::$instance;
    }

    private function inserir(Usuario $usuario){
        $sql = "INSERT INTO usuario (nome, sobrenome, email, password) VALUES 
                (:nome, :sobrenome, :email, :password)";

        $p_sql = $this->conexao->prepare($sql);
        $p_sql->bindValue(":nome", $usuario->getNome());
        $p_sql->bindValue(":sobrenome", $usuario->getSobrenome());
        $p_sql->bindValue(":email", $usuario->getEmail());
        $p_sql->bindValue(":password", $usuario->getPassword());

        return $p_sql->execute();
    }

    public function login(Usuario $usuarioLogin){
        $usuario = new Usuario();
        $sql = "SELECT id, nome, sobrenome, email FROM usuario WHERE email = :email AND password = :password";
        $p_sql = $this->conexao->prepare($sql);
        $p_sql->bindValue(":email", $usuarioLogin->getEmail());
        $p_sql->bindValue(":password", $usuarioLogin->getPassword());
        $p_sql->execute();
        $retornoSQL = $p_sql->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($retornoSQL as $row){
            $usuario = $this->preencherDados($row);
        }
        return $usuario;
    }

    private function preencherDados($row){
        $usuario = new Usuario();
        $usuario->setId($row['id']);
        $usuario->setNome($row['nome']);
        $usuario->setSobrenome($row['sobrenome']);
        $usuario->setEmail($row['email']);
        return $usuario;
    }

    public function gravar(Usuario $usuario){
        if ($usuario->getId() > 0){
            return $this->alterar($usuario);
        }else{
            return $this->inserir($usuario);
        }
    }
}
