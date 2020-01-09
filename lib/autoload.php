<?
$__DIR = str_replace(basename(__FILE__), "", realpath(__FILE__));

$funFile = [
    $__DIR.'helper/helper',
    $__DIR.'App/Model/Builder',
];

foreach ($funFile as $val) {
    include $val.'.php';
}
?>
