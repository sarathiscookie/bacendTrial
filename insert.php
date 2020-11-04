<?php
use App\Http\Controller\DashboardController;

require_once 'vendor/autoload.php';

require 'Http/Controller/DashboardController.php';

$dataValue = array();

if(isset($_POST['id'])) {
$dataValue['id'] = $_POST['id'];
}
$dataValue['county'] = $_POST['County'];
$dataValue['country']  = $_POST['Country'];
$dataValue['town'] = $_POST['town']; 
$dataValue['address']  = $_POST['Address'];
$dataValue['price'] = $_POST['Price'];
$dataValue['num_bedrooms'] = $_POST['bedrooms'];
$dataValue['num_bathrooms'] = $_POST['bathroom'];
$dataValue['property_type_id'] = $_POST['Property'];
$dataValue['type'] = $_POST['sale_rent'];
$dataValue['description'] = $_POST['Description'];
$dataValue['filename'] = $_FILES;
$table_name ='details';
$obj = new DashboardController();

echo $result = $obj->insertMsqlData($table_name,$dataValue);
