<?php

class IndexController extends Zend_Controller_Action {
    
    public function preDispatch() {
        if (! Zend_Auth::getInstance()->hasIdentity()) {
            $this->view->alert = array();
            $this->view->alert['titulo'] = "Alerta";
            $this->view->alert['msg'] = "Você não está logado";
            $this->_helper->redirector->gotoSimple('index', 'login');
        }
    }

    public function indexAction() {
    }

}

