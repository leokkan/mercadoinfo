<?php
/* @var $pagina Models\Produto */
$produto = $data['produto'];
?>
<h2><?= $produto->getNome() ?></h2>
<p><?= nl2br($produto->getDescricao()) ?></p>
<a href="<?= Lib\App::getRouter()->getUrl('pedido', 'index', [$produto->getIdProduto()]) ?>">Comprar</a><br />