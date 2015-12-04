<?php

//require_once 'misc/Utils.php';

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initEncoding() {
        mb_internal_encoding("UTF-8");
    }

    protected function _initDoctype() {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }
/*
    protected function _initMenu() {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->placeholder('menu')
                ->setPrefix("<div id=\"menu\">")
                ->setPostfix("</div>");
    }

    protected function _initfFooter() {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->placeholder('footer')
                ->setPrefix("<div id=\"footbox\"><div id=\"foot\">")
                ->setPostfix("</div></div>");
    }
*/
}

