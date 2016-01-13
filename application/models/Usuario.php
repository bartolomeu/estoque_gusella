<?php

class Application_Model_Usuario {
    private $id, $nome, $login, $password;
    
    public function __construct(array $val) {
        $this->id = isset($val['id']) ? $val['id'] : null;
        $this->nome = isset($val['nome'])? $val['nome']:null;
        $this->login = isset($val['login'])? $val['login']:null;
        $this->password = isset($val['password'])? $val['password']:null;
    }
    
    public function __toArray() {
        $val = array();
        $val['id'] = $this->id;
        $val['nome'] = $this->nome;
        $val['login'] = $this->login;
        $val['password'] = $this->password;

        return $val;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function setPassword($password) {
        $this->password = $password;
    }
}
