<h3>Pedidos</h3>
<table class="table table-hover" style="width: 100%;">
    <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Endereço</th>
            <th>Quantidade</th>
            <th>Id do Produto</th>

        </tr>
    </thead>

    <tbody>
        <?php
        /* @var $pedido Models\Pedido */

        foreach ($data['pedidos'] as $pedido):
            ?>
            <tr>
                <td><?= $pedido->getIdPedido() ?></td>
                <td><?= $pedido->getNome() ?></td>
                <td><?= $pedido->getEndereco() ?></td>
                <td><?= $pedido->getQuantidade() ?></td>
                <td><?= $pedido->getProduto_idProduto() ?></td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>