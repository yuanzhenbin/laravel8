<?php
$helpers = [
    'common.php'
];
// 载入
foreach ($helpers as $helperFileName) {
    include __DIR__ . '/' .$helperFileName;
}