<?php

class LocalController extends Zend_Controller_Action {

    public function preDispatch() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->view->alert = array();
            $this->view->alert['titulo'] = "Alerta";
            $this->view->alert['msg'] = "Você não está logado";
            $this->_helper->redirector->gotoSimple('index', 'login');
        }
    }

    public function indexAction() {
        $this->listarAction();
    }

    public function listarAction() {
        $local = new Application_Model_DbTable_Local();
        $this->view->locals = $local->fetchAll(null, 'nome asc');
        $this->renderScript('local/listar.phtml');
    }

    public function cadastrarAction() {

        if (!$this->getRequest()->isPost()) {
            //@TODO não tem post ?!!
            return;
        }
        try {
            $this->salvar(new Application_Model_Local($this->getRequest()->getParams()));
        } catch (Exception $exc) {
            $error = array();
            switch ($exc->getCode()) {
                case 01:
                    $error['nome'] = 'Por Favor Insira um nome válido.';
                    break;
            }

            $this->view->msg = "Cadastro não realizado";
            $this->view->errors = $error;
            return;
        }

        $this->view->msg = "Local Cadastrado com sucesso.";
        $this->renderScript('local/salvar.phtml');
    }

    /**
     * Valida o model e salva
     * @param Application_Model_Local $locModel
     * @return primary_key
     * @throws Exception da validação dos dados ou exception do BD
     */
    private function salvar(Application_Model_Local $locModel) {

        if (!$locModel->getNome()) {
            throw new Exception("Por Favor Insira um nome válido", 1);
        }

        $locDB = new Application_Model_DbTable_Local();
        return $locDB->insert($locModel->__toArray());
    }

    public function cadastrarjsonAction() {

        $retorno = new stdClass ();
        try {
            $retorno->new_id = $this->salvar(new Application_Model_Local($this->getRequest()->getParams()));

            //busca os locais
            $local = new Application_Model_DbTable_Local();
            $retorno->locals = $local->fetchAll(null, 'nome asc')->toArray();
            //$retorno->locals = $retorno->locals.toArray();

            $retorno->ok = TRUE;
        } catch (Exception $exc) { 
            $retorno->erro = new stdClass();
            $retorno->erro->message = $exc->getMessage();
            $retorno->erro->code = $exc->getCode();
            $retorno->ok = FALSE;
        } finally {
            $this->_helper->json($retorno);
        }
    }

}
