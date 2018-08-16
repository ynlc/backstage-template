<?php
date_default_timezone_set('PRC');
$params = array_merge(
    require(dirname(__DIR__) . '/params.php'),
    require(dirname(__DIR__) . '/params-local.php')
);
return [

];