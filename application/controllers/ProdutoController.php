<?php

/**
 * Description of ProdutoController
 *
 * @author Usuário
 */
class ProdutoController extends Zend_Controller_Action {

    public function cadastrarAction() {
        $local = new Application_Model_DbTable_Local();
        
        $this->view->locals = $local->fetchAll(null, 'nome asc');
        
        if ($this->getRequest()->isPost()) {
            $error = array();
            $prodModel = new Application_Model_Produto($this->getRequest()->getParams());
            
            if(! $prodModel->getLocal_id()){
                $error['local_id']='Por Favor Insira um local válido.';
            }
            
            if(! $prodModel->getNome()){
                $error['nome']='Por Favor Insira um nome válido.';
            }
            
            if(count($error) > 0){
                $this->view->msg = "Cadastro não realizado";
                $this->view->errors = $error;
                return;
            }
            
            $proDB = new Application_Model_DbTable_Produto();
            $proDB->insert($prodModel->__toArray());
            
            $this->view->msg = "Produto Cadastrado com sucesso.";
            $this->renderScript('produto/salvar.phtml');
        }
    }
    
    function editarAction(){
        if(! $this->getRequest()->getParam('id')){
            throw new Exception('erro1');
            return ; // @TODO quebrou tratar erro !!
        }
        
        $prodDB = new Application_Model_DbTable_Produto();
        $prodDB->select()->where('id = ?', $this->getRequest()->getParam('id'));
        
        $this->view->produto = $prodDB->fetchAll();
        
        if(count($this->view->produto) != 1){
            throw new Exception('erro2');
            return; // @TODO quebrou tratar erro !!
        }
        $this->renderScript('produto/cadastrar.phtml');
    }
    
    function listarAction() {
        $produtos = new Application_Model_DbTable_Produto();
        $this->view->produtos = $produtos->fetchAll(null, 'nome asc');
        $this->renderScript('produto/listar.phtml'); // estou tornando explícito o listar pq ele tb será usado no indexAction
    }
    
    /**
     * Index age como listar !!
     */
    function indexAction() {
        $this->listarAction();
    }

}
