<?php

$funcionario = $data['funcionario'];
?>

<h3>Cadastrar Usuário</h3>
<form action="" method="POST">
  <input type="hidden" name="idFuncionario" value="<?= $funcionario->getIdFuncionario() ?>"/>
  <input type="text" class="form-control" name="nome" placeholder="Nome do usuário" value="<?= $funcionario->getNome() ?>" /><br />
  <input type="text" class="form-control" name="usuario" placeholder="E-mail" value="<?= $funcionario->getUsuario() ?>" /><br />
  <input type="text" class="form-control" name="senhaAntiga" placeholder="Antiga Senha"  /><br />
  <input type="text" class="form-control" name="senhaNova" placeholder="Nova Senha"  /><br />
  <input type="text" name="cargo" class="form-control" id="cargo" placeholder="Cargo" value="<?= ($funcionario->getCargo() ) ?>"/>
  <button class="btn btn-lg btn-primary btn-block" type="submit">Atualizar</button>
</form>

