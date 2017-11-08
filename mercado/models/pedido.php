<?php

namespace Models;

use Lib\DB;
use Lib\Model;

class Pedido extends Model {

    private $idPedido;
    private $nome;
    private $endereco;
    private $quantidade;
    private $produto_idProduto;

    public static function getPedido() {
        $conn = DB::getConnection();

        $query = 'SELECT `idPedido`, `nome`,`endereco`, `quantidade`, `produto_idProduto` FROM `Pedido`';
        $result = $conn->query($query);
        if ($result === FALSE) {
            throw new \Exception("Falha ao carregar lista de Pedidos. Erro: {$conn->error}");
        }

        $pedido = [];
        while ($row = $result->fetch_assoc()) {
            $pedido[] = new Pedido($row['idPedido'], $row['nome'], $row['endereco'], $row['quantidade'], $row['produto_idProduto']);
        }

        $result->close();

        return $pedido;
    }

    /**
     *
     * @param Pedido $pdd
     * @return type
     * @throws \Exception
     */
    public static function insere($pdd) {
        $conn = DB::getConnection();
        $query = 'INSERT INTO `Pedido` (`nome`, `endereco`, `quantidade`, `produto_idProduto`) VALUES (?, ?, ?, ?)';
        $stmt = $conn->prepare($query);

        if ($stmt === FALSE) {
            throw new \Exception("Falha ao preparar query. Erro: {$conn->error}");
        }

        $nome = $pdd->getNome();
        $endereco = $pdd->getEndereco();
        $quantidade = $pdd->getQuantidade();
        $produto_idProduto = $pdd->getProduto_idProduto();
        if ($stmt->bind_param('ssii', $nome, $endereco, $quantidade, $produto_idProduto) === FALSE) {
            throw new \Exception("Falha ao associar parametros. Erro : {$stmt->error}");
        }

        if ($stmt->execute() === FALSE) {
            throw new \Exception("Falha ao executar query. Erro : {$stmt->error}");
        }

        $stmt->close();
    }

    function getIdPedido() {
        return $this->idPedido;
    }

    function getNome() {
        return $this->nome;
    }

    function getEndereco() {
        return $this->endereco;
    }

    function getQuantidade() {
        return $this->quantidade;
    }

    function getProduto_idProduto() {
        return $this->produto_idProduto;
    }

    function setIdPedido($idPedido) {
        $this->idPedido = $idPedido;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    function setQuantidade($quantidade) {
        $this->quantidade = $quantidade;
    }

    function setProduto_idProduto($produto_idProduto) {
        $this->produto_idProduto = $produto_idProduto;
    }

    function __construct($idPedido, $nome, $endereco, $quantidade, $produto_idProduto) {
        $this->idPedido = $idPedido;
        $this->nome = $nome;
        $this->endereco = $endereco;
        $this->quantidade = $quantidade;
        $this->produto_idProduto = $produto_idProduto;
    }

}
