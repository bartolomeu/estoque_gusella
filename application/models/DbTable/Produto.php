<?php
/**
 * Description of Produto
 *
 * @author Usuário
 */
class Application_Model_DbTable_Produto extends Zend_Db_Table_Abstract {
    protected $_name = 'produto';
     
    public function showAllJoin() {
        
        $sel = $this->select()->from(
                array('p'=>'produto'), 
                array('id', 'nome', 'preco', 'local_id'))
            ->join(
                array('l'=>'local'), 
                'l.id = p.local_id', 
                array('local_nome'=>'nome'))
            ->setIntegrityCheck(false);
        
        return $this->fetchAll($sel);
    }
}
