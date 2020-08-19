<?php
require "vendor/autoload.php";
use \Application\UserTableWrapper;
try {
    $userTable = new UserTableWrapper();
    $userTable->insert([1, 'Totoshka', 'Rastotoshka', 'ararara@gmail.com']);
    var_dump($userTable->update(1, [4, 'Totoshka', 'Rastotoshka', 'ararara@gmail.com']));

} catch (Exception $e) {
    echo $e->getMessage();
}
