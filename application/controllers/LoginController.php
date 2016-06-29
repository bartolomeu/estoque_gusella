<?php


class LoginController extends Zend_Controller_Action {

    public function indexAction() {
        $this->_helper->_layout->setLayout('branco');
    }
    public function logarAction(){
        $db = $this->_getParam('db');
        
        if ($this->getRequest()->isPost()) {
            $erro = $this->validaPost();
            
            if(count($erro) > 0){
                $this->view->errors = $erro;
                $this->renderScript('login/index.phtml');
                return $this->indexAction();
            }
 
            $adapter = new Zend_Auth_Adapter_DbTable(
                $db,
                'usuario',
                'login',
                'password',
                'MD5(?)'
                );
            
            $param = $this->getRequest()->getParams();
 
            $adapter->setIdentity($param['login']);
            $adapter->setCredential($param['password']);
 
            $auth   = Zend_Auth::getInstance();
            $result = $auth->authenticate($adapter);
 
            if ($result->isValid()) {
                $this->_helper->FlashMessenger('Login com sucesso.');
                $this->_helper->redirector->gotoSimple('index', 'index');
                return;
            }  else {
                $this->view->alert = array();
                $this->view->alert['titulo'] = "Erro";
                $this->view->alert['msg'] = "Usuário e senha não encontrado";
                $this->renderScript('login/index.phtml');
                return $this->indexAction();
            }
 
        }

    }
    
    protected function validaPost() {
        $error = array();
        $usuModel = new Application_Model_Usuario($this->getRequest()->getParams());

        if (!$usuModel->getLogin()) {
            $error['login'] = 'Por Favor Insira um local válido.';
        }

        if (!$usuModel->getPassword()) {
            $error['password'] = 'Por Favor Insira a senha.';
        }
        return $error;
    }
}
