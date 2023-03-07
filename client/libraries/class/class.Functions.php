<?php
class Functions {
    private $d;
    
    function __construct($d) {
        $this->d = $d;
    }

    function var_dump($arr) {
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
    }
}
?>