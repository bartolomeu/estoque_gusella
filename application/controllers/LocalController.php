<?php


class LocalController extends Zend_Controller_Action{
    function indexAction(){
        $this->listarAction();
    }
    function listarAction(){
        $local = new Application_Model_DbTable_Local();
        $this->view->locals = $local->fetchAll(null, 'nome asc');
        $this->renderScript('local/listar.phtml');
    }
    function cadastrarAction(){
        
        if ($this->getRequest()->isPost()) {
            $error = array();
            $locModel = new Application_Model_Local($this->getRequest()->getParams());
            
            if(! $locModel->getNome()){
                $error['nome']='Por Favor Insira um nome válido.';
            }
            
            if(count($error) > 0){
                $this->view->msg = "Cadastro não realizado";
                $this->view->errors = $error;
                return;
            }
            
            $locDB = new Application_Model_DbTable_Local();
            $locDB->insert($locModel->__toArray());
            
            $this->view->msg = "Local Cadastrado com sucesso.";
            
            $this->renderScript('local/salvar.phtml');
        }
    }
}
