<?php

require 'AresReader.php';

$ares = new AresReader('87344416');
echo '<pre>' . print_r($ares->print(), 1) . '</pre>';

?>