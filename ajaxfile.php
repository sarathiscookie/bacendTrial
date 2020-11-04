<?php
use App\Http\Controller\DashboardController;

require_once 'vendor/autoload.php';

require 'Http/Controller/DashboardController.php';

$dataValue = array();
## Read value
$dataValue['draw'] = $_POST['draw'];
$dataValue['row']  = $_POST['start'];
$dataValue['rowperpage'] = $_POST['length']; // Rows display per page
$dataValue['columnIndex']  = $_POST['order'][0]['column']; // Column index
$dataValue['columnName'] = $_POST['columns'][$columnIndex]['data']; // Column name
$dataValue['columnSortOrder'] = $_POST['order'][0]['dir']; // asc or desc
$dataValue['searchValue'] = $_POST['search']['value']; // Search value

$obj = new DashboardController();

echo $result = $obj->fetchApiData($dataValue);