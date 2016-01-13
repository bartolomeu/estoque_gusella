<?php

/**
 * Description of ProdutoController
 *
 * @author Usuário
 */
class ProdutoController extends Zend_Controller_Action {
    
    public function preDispatch() {
        if (! Zend_Auth::getInstance()->hasIdentity()) {
            $this->view->alert = array();
            $this->view->alert['titulo'] = "Alerta";
            $this->view->alert['msg'] = "Você não está logado";
            $this->_helper->redirector->gotoSimple('index', 'login');
        }
    }

    public function cadastrarAction() {
        $local = new Application_Model_DbTable_Local();

        $this->view->locals = $local->fetchAll(null, 'nome asc');

        if ($this->getRequest()->isPost()) {
            $error = $this->validaPost();

            if (count($error) > 0) {
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

    protected function validaPost() {
        $error = array();
        $prodModel = new Application_Model_Produto($this->getRequest()->getParams());

        if (!$prodModel->getLocal_id() || !is_numeric($prodModel->getLocal_id())) {
            $error['local_id'] = 'Por Favor Insira um local válido.';
        }

        if (!$prodModel->getNome()) {
            $error['nome'] = 'Por Favor Insira um nome válido.';
        }
        return $error;
    }

    public function editarAction() {
        $id = $this->getRequest()->getParam('id');
        if (!$id || !is_numeric($id)) {
            $this->view->alert = array(
                'tipo' => 'danger',
                'titulo' => "Alerta",
                'msg' => "ID inválido."
            );
            return $this->indexAction();
        }

        $prodDB = new Application_Model_DbTable_Produto();
        $res = $prodDB->find($id)->toArray();

        if (count($res) != 1) {
            $this->view->alert = array(
                'tipo' => 'danger',
                'titulo' => 'Alerta',
                'msg' => 'Produto não encontrado.'
            );
            return $this->indexAction();
        }
        $this->view->produto = $res[0];
        $local = new Application_Model_DbTable_Local();
        $this->view->locals = $local->fetchAll(null, 'nome asc');
        
        if ($this->getRequest()->isPost()) {
            $error = $this->validaPost();

            if (count($error) > 0) {
                $this->view->msg = "Atualização não realizado";
                $this->view->errors = $error;
            }else{
                $prodDB->update($this->getRequest()->getParams(), array('id=?'=>$id));
                $this->view->msg = "Atualização realizado com sucesso";
                return $this->indexAction();
            }
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
