<?php
/**
 * Description of Number
 *
 * @author Bartolomeu S. Gusella
 */
class Application_Util_Number {
    static function stringToDecimal($str) {
        return str_replace(',', '.', $str);
    }
    static function decimalTostring($str) {
        return str_replace('.', ',', $str);
    }
}
