<?php

namespace controller;

include_once "Conexao.php";

use model\Cliente;

class ClienteController{

    private static $instance;
    private $conexao;

    private function __construct(){
        $this->conexao = Conexao::getInstance();
    }

    public static function getInstance(){
        if (self::$instance == null){
            self::$instance = new ClienteController();
        }
        return self::$instance;
    }

    private function inserir(Cliente $cliente){
        $sql = "INSERT INTO cliente (nome, telefone, email) VALUES 
                (:nome, :telefone, :email)";

        $p_sql = $this->conexao->prepare($sql);
        $p_sql->bindValue(":nome", $cliente->getNome());
        $p_sql->bindValue(":telefone", $cliente->getTelefone());
        $p_sql->bindValue(":email", $cliente->getEmail());

        return $p_sql->execute();
    }

    private function alterar(Cliente $cliente){
        $sql = "UPDATE cliente SET nome = :nome, telefone = :telefone, email = :email
                WHERE id = :id";

        $p_sql = $this->conexao->prepare($sql);
        $p_sql->bindValue(":nome", $cliente->getNome());
        $p_sql->bindValue(":telefone", $cliente->getTelefone());
        $p_sql->bindValue(":email", $cliente->getEmail());
        $p_sql->bindValue(":id", $cliente->getId());

        return $p_sql->execute();
    }

    public function gravar(Cliente $cliente){
        if ($cliente->getId() > 0){
            return $this->alterar($cliente);
        }else{
            return $this->inserir($cliente);
        }
    }

    public function retornaTodos(){
        $lstCliente = array();
        $sql = "SELECT * FROM cliente ORDER BY nome";
        $p_sql = $this->conexao->query($sql, \PDO::FETCH_ASSOC);
        foreach ($p_sql as $row){
            $cliente = $this->preencherDadosCliente($row);
            $lstCliente[] = $cliente;
        }
        return $lstCliente;
    }

    public function buscarCliente($id){
        $cliente = new Cliente();
        $sql = "SELECT * FROM cliente WHERE id = :id";
        $p_sql = $this->conexao->prepare($sql);
        $p_sql->bindValue(":id", $id);
        $p_sql->execute();
        $retornoSQL = $p_sql->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($retornoSQL as $row){
            $cliente = $this->preencherDadosCliente($row);
        }
        return $cliente;
    }

    private function preencherDadosCliente($row){
        $cliente = new Cliente();
        $cliente->setId($row['id']);
        $cliente->setNome($row['nome']);
        $cliente->setTelefone($row['telefone']);
        $cliente->setEmail($row['email']);
        return $cliente;
    }

    public function excluir($id){
        $sql = "DELETE FROM cliente WHERE id = :id";
        $p_sql = $this->conexao->prepare($sql);
        $p_sql->bindValue(":id", $id);
        return $p_sql->execute();
    }

}
