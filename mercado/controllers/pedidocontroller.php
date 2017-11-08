<?php

namespace Controllers;

use Lib\Controller;
use Models\Pedido;
use Lib\Session;

class PedidoController extends Controller {

    public function index($id) {
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === "POST") {
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING);
            $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_SANITIZE_NUMBER_INT);

            if ($nome == FALSE || $endereco == FALSE || $quantidade == FALSE ) {
                Session::setFlash('Todos os campos são obrigatórios.');
            } else {
                
                $produto_idProduto = $id;

                $pedido = new Pedido(0, $nome, $endereco, $quantidade, $produto_idProduto);
                Pedido::insere($pedido);

                Session::setFlash('Pedido efetuado com sucesso.');
            }
        }
    }
    public function ver($idPedido) {
        $idPedido = filter_var($idPedido, FILTER_SANITIZE_NUMBER_INT);
        if ($idPedido != FALSE) {
            $this->data['pedido'] = Pedido::getPedidoPorId($idPedido);
        }
    }

    public function admin_index() {
        $this->data['pedidos'] = Pedido::getPedido();
    }

}
