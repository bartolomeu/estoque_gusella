<?php

class IndexController extends Zend_Controller_Action {

    public function indexAction() {
    }

    public function readmeAction() {
        // disable layout
        $this->_helper->layout->disableLayout();

        // get readme.html and adjust paths so CSS, images etc are correctly loaded
        $readme = file_get_contents("../readme.html");
        $this->view->readme = str_replace("public/", "/", $readme);
    }

}

