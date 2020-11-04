<?php
use App\Http\Controller\DashboardController;

require_once 'vendor/autoload.php';

require 'Http/Controller/DashboardController.php';

$id = $_POST['id']; 
$obj = new DashboardController();
echo $result = $obj->delData($id);