<?php
/**
 * Description of Local
 *
 * @author Usuário
 */
class Application_Model_Local {
    private $id, $nome;
    
    function __construct(array $val) {
        $this->id = isset($val['id']) ? $val['id'] : null;
        $this->nome = isset($val['nome'])? $val['nome']:null;
    }

    function __toArray() {
        $val = array();
        $val['id'] = $this->id;
        $val['nome'] = $this->nome;

        return $val;
    }
    
    
    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }
    
    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }
}
