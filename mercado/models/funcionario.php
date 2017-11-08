<?php

namespace Models;

use Lib\DB;

class Funcionario {

    private $idFuncionario;
    private $nome;
    private $usuario;
    private $senha;
    private $cargo;

    public static function getByLogin($login) {
        $conn = DB::getConnection();
        $query = 'SELECT `idFuncionario`, `nome`, `usuario`, `senha`, `cargo` FROM `Funcionario` WHERE `usuario` = ?';
        $stmt = $conn->prepare($query);

        if ($stmt === FALSE) {
            throw new \Exception("Falha ao preparar query. Erro: {$conn->error}");
        }

        if ($stmt->bind_param('s', $login) === FALSE) {
            throw new \Exception("Falha ao associar parametros. Erro : {$stmt->error}");
        }

        if ($stmt->execute() === FALSE) {
            throw new \Exception("Falha ao executar query. Erro : {$stmt->error}");
        }

        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $funcionario = new Funcionario($row['idFuncionario'], $row['nome'], $row['usuario'], $row['senha'], $row['cargo']);
        } else {
            $funcionario = NULL;
        }



        $result->close();
        $stmt->close();

        return $funcionario;
    }

    public static function getById($id) {
        $conn = DB::getConnection();

        $query = 'SELECT `idFuncionario`, `nome`,`usuario`, `senha`, `cargo` FROM `Funcionario` WHERE `idFuncionario` = ?';
        $stmt = $conn->prepare($query);

        if ($stmt === FALSE) {
            throw new \Exception("Falha ao preparar query. Erro: {$conn->error}");
        }

        if ($stmt->bind_param('i', $id) === FALSE) {
            throw new \Exception("Falha ao associar parametros. Erro : {$stmt->error}");
        }

        if ($stmt->execute() === FALSE) {
            throw new \Exception("Falha ao executar query. Erro : {$stmt->error}");
        }

        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $funcionario = new Funcionario($row['idFuncionario'], $row['nome'], $row['usuario'], $row['senha'], $row['cargo']);
        } else {
            $funcionario = NULL;
        }
        



        $result->close();
        $stmt->close();

        return $funcionario;
    }
     public static function getFuncionarios() {
      $conn = DB::getConnection();

      $query = 'SELECT idFuncionario, nome, usuario, senha, cargo FROM funcionario';

      $result = $conn->query($query);
      if ($result == FALSE) {
        throw new \Exception("Falha ao carregar lista de usuarios. Erro: {$conn->error}");
      }

      $usuarios = [];
      while ($row = $result->fetch_assoc()) {
        $usuarios[] = new Funcionario($row['idFuncionario'], $row['nome'], $row['usuario'], $row['senha'], $row['cargo']);
      }

      $result->close();

      return $usuarios;
    }

    public static function insere($user) {
      $conn = DB::getConnection();

      $query = 'INSERT INTO Funcionario (nome, usuario, senha, cargo) VALUES (?, ?, ?, ?)';
      $stmt = $conn->prepare($query);
      if ($stmt === FALSE) {
        throw new \Exception("Falha ao preparar query. Erro: {$conn->error}");
      }

      $nome = $user->getNome();
      $usuario = $user->getUsuario();
      $senha = $user->getSenha();
      $cargo = $user->getCargo();
      if ($stmt->bind_param('ssss', $nome, $usuario, $senha, $cargo) === FALSE) {
        throw new \Exception("Falha ao associar parâmetros. Erro: {$stmt->error}");
      }

      if ($stmt->execute() === FALSE) {
        throw new \Exception("Falha ao executar query. Erro: {$stmt->error}");
      }

      $stmt->close();
    }

    public static function altera($user) {
      $conn = DB::getConnection();

      $query = 'UPDATE Funcionario SET nome = ?, usuario = ?, senha = ?, cargo = ? WHERE idFuncionario = ?';
      $stmt = $conn->prepare($query);
      if ($stmt === FALSE) {
        throw new \Exception("Falha ao preparar query. Erro: {$conn->error}");
      }

      $idFuncionario = $user->getIdFuncionario();
      $nome = $user->getNome();
      $usuario = $user->getUsuario();
      $senha = $user->getSenha();
      $cargo = $user->getCargo();
      if ($stmt->bind_param('ssssi', $nome, $usuario, $senha, $cargo, $idFuncionario) === FALSE) {
        throw new \Exception("Falha ao associar parâmetros. Erro: {$stmt->error}");
      }

      if ($stmt->execute() === FALSE) {
        throw new \Exception("Falha ao executar query. Erro: {$stmt->error}");
      }

      $stmt->close();
    }

    public static function exclui($idFuncionario) {
	    $conn = DB::getConnection();

	    $query = 'DELETE FROM Funcionario WHERE idFuncionario = ?';
	    $stmt = $conn->prepare($query);
	    if ($stmt === FALSE) {
	      throw new \Exception("Falha ao preparar query. Erro: {$conn->error}");
	    }

	    if ($stmt->bind_param('i', $idFuncionario) === FALSE) {
	      throw new \Exception("Falha ao associar parametros. Erro: {$stmt->error}");
	    }

	    if ($stmt->execute() === FALSE) {
	      throw new \Exception("Falha ao executar query. Erro: {$stmt->error}");
	    }

	    $stmt->close();
    }


    function getIdFuncionario() {
        return $this->idFuncionario;
    }

    function getNome() {
        return $this->nome;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getSenha() {
        return $this->senha;
    }

    function getCargo() {
        return $this->cargo;
    }

    function setIdFuncionario($idFuncionario) {
        $this->idFuncionario = $idFuncionario;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

    function setCargo($cargo) {
        $this->cargo = $cargo;
    }

    function __construct($idFuncionario, $nome, $usuario, $senha, $cargo) {
        $this->idFuncionario = $idFuncionario;
        $this->nome = $nome;
        $this->usuario = $usuario;
        $this->senha = $senha;
        $this->cargo = $cargo;
    }

}
