<?php
use App\Http\Controller\DashboardController;

require_once 'vendor/autoload.php';

require 'Http/Controller/DashboardController.php';

## Read
$id = $_POST['id'];
$obj = new DashboardController();
$result = $obj->editData($id);
echo json_encode($result);