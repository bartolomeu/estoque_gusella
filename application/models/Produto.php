<?php

/**
 * Description of Produto
 *
 * @author Usuário
 */
class Application_Model_Produto {

    protected $id, $local_id, $nome, $preco;

    function __construct(array $val) {
        $this->id = isset($val['id']) ? $val['id'] : null;
        $this->local_id = isset($val['local_id'])? $val['local_id']:null;
        $this->nome = isset($val['nome'])? $val['nome']:null;
        $this->preco = isset($val['preco'])? $val['preco']:null;
    }

    function __toArray() {
        $val = array();
        $val['id'] = $this->id;
        $val['local_id'] = $this->local_id;
        $val['nome'] = $this->nome;
        $val['preco'] = Application_Util_Number::stringToDecimal($this->preco);

        return $val;
    }

    function getId() {
        return $this->id;
    }

    function getLocal_id() {
        return $this->local_id;
    }

    function getNome() {
        return $this->nome;
    }

    function getPreco() {
        return $this->preco;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setLocal_id($local_id) {
        $this->local_id = $local_id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setPreco($preco) {
        $this->preco = $preco;
    }

}
