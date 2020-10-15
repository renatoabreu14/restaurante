<?php


namespace controller;

use model\Mesa;

include_once "Conexao.php";


class MesaController{

    private static $instance;
    private $conexao;

    private function __construct(){
        $this->conexao = Conexao::getInstance();
    }

    public static function getInstance(){
        if (self::$instance == null){
            self::$instance = new MesaController();
        }
        return self::$instance;
    }

    private function inserir(Mesa $mesa){
        $sql = "INSERT INTO mesa (descricao, lugares, posicao) VALUES 
                (:descricao, :lugares, :posicao)";

        $p_sql = $this->conexao->prepare($sql);
        $p_sql->bindValue(":descricao", $mesa->getDescricao());
        $p_sql->bindValue(":lugares", $mesa->getLugares());
        $p_sql->bindValue(":posicao", $mesa->getPosicao());

        return $p_sql->execute();
    }

    private function alterar(Mesa $mesa){
        $sql = "UPDATE mesa SET descricao = :descricao, lugares = :lugares, posicao = :posicao
                WHERE id = :id";

        $p_sql = $this->conexao->prepare($sql);
        $p_sql->bindValue(":descricao", $mesa->getDescricao());
        $p_sql->bindValue(":lugares", $mesa->getLugares());
        $p_sql->bindValue(":posicao", $mesa->getPosicao());
        $p_sql->bindValue(":id", $mesa->getId());

        return $p_sql->execute();
    }

    public function gravar(Mesa $mesa){
        if ($mesa->getId() > 0){
            return $this->alterar($mesa);
        }else{
            return $this->inserir($mesa);
        }
    }

    public function retornaTodos(){
        $lstMesa = array();
        $sql = "SELECT * FROM mesa ORDER BY descricao";
        $p_sql = $this->conexao->query($sql, \PDO::FETCH_ASSOC);
        foreach ($p_sql as $row){
            $mesa = $this->preencherDados($row);
            $lstMesa[] = $mesa;
        }
        return $lstMesa;
    }

    public function buscarMesa($id){
        $mesa = new Mesa();
        $sql = "SELECT * FROM mesa WHERE id = :id";
        $p_sql = $this->conexao->prepare($sql);
        $p_sql->bindValue(":id", $id);
        $p_sql->execute();
        $retornoSQL = $p_sql->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($retornoSQL as $row){
            $mesa = $this->preencherDados($row);
        }
        return $mesa;
    }

    private function preencherDados($row){
        $mesa = new Mesa();
        $mesa->setId($row['id']);
        $mesa->setDescricao($row['descricao']);
        $mesa->setLugares($row['lugares']);
        $mesa->setPosicao($row['posicao']);
        return $mesa;
    }

    public function excluir($id){
        $sql = "DELETE FROM mesa WHERE id = :id";
        $p_sql = $this->conexao->prepare($sql);
        $p_sql->bindValue(":id", $id);
        return $p_sql->execute();
    }

}
