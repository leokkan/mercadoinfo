<?php

namespace Controllers;

use Lib\Controller;
use Lib\Session;
use Lib\Router;
use Models\Produto;
use Lib\App;

class ProdutoController extends Controller {

    public function index() {
        $this->data['produtos'] = Produto::getProduto(true);
    }

    public function ver($idProduto) {
        $idProduto = filter_var($idProduto, FILTER_SANITIZE_NUMBER_INT);
        if ($idProduto != FALSE) {
            $this->data['produto'] = Produto::getProdutoPorId($idProduto);
        }
    }

    public function admin_index() {
        $this->data['produtos'] = Produto::getProduto();
    }

    public function admin_novo() {
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
            $valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_STRING);
            $disponivel = filter_input(INPUT_POST, 'disponivel') ? 1 : 0;

            if ($nome == FALSE || $descricao == FALSE || $valor == FALSE) {
                Session::setFlash('Todos os campos são obrigatórios.');
                Router::redirect(App::getRouter()->getUrl('produto', 'novo'));
            }

            //$usuario = Session::get('usuario');
            $produto = new Produto(0, $nome, $descricao, $valor, $disponivel);
            Produto::cadastrar($produto);

            Session::flash('Produto criado com sucesso.');
            Router::redirect(App::getRouter()->getUrl('produto'));
        }
    }

    public function admin_editar($id) {
        $request = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

        if ($request === 'POST') {
            $idProduto = filter_input(INPUT_POST, 'idProduto', FILTER_SANITIZE_NUMBER_INT);
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
            $valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_STRING);
            $disponivel = filter_input(INPUT_POST, 'disponivel') ? 1 : 0;

            if ($idProduto == FALSE || $idProduto <= 0) {
                Session::setFlash('Produto não encontrado.');
                Router::redirect(App::getRouter()->getUrl('produto'));
            } else if ($nome == FALSE || $descricao == FALSE || $valor == FALSE) {
                Session::setFlash('Todos os campos são obrigatórios.');
                Router::redirect(App::getRouter()->getUrl('produto', 'editar', [$idProduto]));
            }

            //$usuario = Session::get('funcionario');
            $produto = new Produto($idProduto, $nome, $descricao, $valor, $disponivel);
            Produto::atualizar($produto);

            Session::flash('Produto atualizado com sucesso.');
            Router::redirect(App::getRouter()->getUrl('produto'));
        } else if ($request === 'GET') {
            $idProduto = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

            if ($idProduto == FALSE || $idProduto < 0) {
                Session::setFlash('Produto não encontrado.');
                Router::redirect(App::getRouter()->getUrl('produto'));
            }

            $this->data['produto'] = Produto::getProdutoPorId($idProduto);
        }
    }

    public function admin_excluir($id) {
        $idProduto = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        if ($idProduto == FALSE || $idProduto < 0) {
            Session::setFlash('Produto não encontrado.');
            Router::redirect(App::getRouter()->getUrl('produto'));
        }

        Produto::excluir($idProduto);
        Session::setFlash('Produto excluído com sucesso.');
        Router::redirect(App::getRouter()->getUrl('produto'));
    }

}
