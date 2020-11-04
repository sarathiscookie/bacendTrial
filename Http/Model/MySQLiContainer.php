<?php
namespace App\Model;
use SplObjectStorage, mysqli;
header("Content-type: text/html; charset=utf-8");
require_once "config/database.php";

class MySQLiContainer extends SplObjectStorage
{

    function __construct() {

        $this->conn = $this->newConnection(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE,DB_PORT);

    }

    /**
     * mysqli connection
     * @param string $MYSQL_SERVER
     *  @param string $MYSQL_SERVER_USERNAME
     * @param string $MYSQL_SERVER_PASSWORD
     * @param string $MYSQL_SERVER_DATA_BASE
     * @param string $MYSQL_SERVER_PORT
     * @return object mysqli
     */

    public function newConnection($MYSQL_SERVER, $MYSQL_SERVER_USERNAME, $MYSQL_SERVER_PASSWORD, $MYSQL_SERVER_DATA_BASE, $MYSQL_SERVER_PORT)
    {
      
        $mysqli = new mysqli($MYSQL_SERVER, $MYSQL_SERVER_USERNAME, $MYSQL_SERVER_PASSWORD, $MYSQL_SERVER_DATA_BASE, $MYSQL_SERVER_PORT);
        if (!$mysqli->set_charset('utf8')) {
            printf("Error loading character set utf8: %s\n", $mysqli->error);
        }
        $this->attach($mysqli);
        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
        return $mysqli;
   }

    /**
     * Insert data 
     * @param string $table_name
     * @param array $data
     * @return string
     */

   public function insertData($table_name,$data){

     if(!empty($data['id'])) {
         $id = $data['id'];
         unset($data['id']);
        $sql = "UPDATE $table_name SET";
        $data["address"] = str_replace("."," ",$data["address"]);
        $comma = " ";
        foreach($data as $key => $val) {
            if( ! empty($val)) {
                $sql .= $comma . $key . " = '" .(trim($val)) . "'";
                $comma = ", ";
            }
        }
        $sql .= "where id =". $id;
       
        
        if ($this->conn->query($sql) === TRUE) {
            return "New record updated successfully";
        } else {
          return "Error: " . $sql . "<br>" . $this->conn->error;
        }
        $this->conn->close();
        
     } else {
    unset($data['id']);
    $key = array_keys($data);  //get key( column name)
    $value = array_values($data);  //get values (values to be inserted)
     $sql ="INSERT INTO $table_name ( ". implode(',' , $key) .") VALUES('". implode("','" , $value) ."')";
     if ($this->conn->query($sql) === TRUE) {
        return "New record created successfully";
    } else {
      return "Error: " . $sql . "<br>" . $this->conn->error;
    }
    $this->conn->close();
     }
  

     }


    /**
     * fetch File details
     * @param string $id
     * @return array $allResult
     */

     public function fetchFiledetails($id) {
        $sql ="SELECT id,image_full,image_thumbnail FROM details where id =" . $id;
 
        $result = mysqli_query($this->conn, $sql) or die("Mysql Error in getting : get products1");
     
        if ($result->num_rows > 0) {
            $allResult = $result->fetch_all(MYSQLI_ASSOC);
        }
      
         return $allResult;

     }


    /**
     * delete Data from details 
     * @param string $data
     * @return string 
     */

     public function deleteData($data){
        if(isset($data)) {
           $sql = "delete from details where id  = ".$data;
           $a = fopen('/tmp/testerror1.txt', 'w');
           fwrite($a,$data);
           fclose($a);
           if ($this->conn->query($sql) === TRUE) {
               return "record deleted successfully";
           } else {
             return "Error: " . $sql . "<br>" . $this->conn->error;
           }
           $this->conn->close();
     }
    }
     
   /**
     * fetch Property details
     * @return string $allResult
     */

     public function fetchProperty(){

        $sql ="SELECT id,title FROM property";
        $result = mysqli_query($this->conn, $sql) or die("Mysql Error in getting : get products1");

        if ($result->num_rows > 0) {
            $allResult = $result->fetch_all(MYSQLI_ASSOC);
        }
         return $allResult;
     }


    /**
     * fetch Edit Details
     * @param string $edit
     * @return array $resData
     */

     public function fetchEditData($edit) {
        
        $sql ="SELECT details.id as id,type,details.description,address,property_type_id,county,country,town,image_thumbnail,latitude,longitude,num_bedrooms,num_bathrooms,price FROM details inner join property on details.property_type_id = property.id where details.id='$edit'";
        $query = mysqli_query($this->conn, $sql) or die("Mysql Error in getting : get products1");
        $resData = array();

      
        while ($row = mysqli_fetch_array($query)) {  // preparing an array
            $resData['id'] = $row["id"];
            $resData['county'] = $row["county"];
            $resData['country'] = $row["country"];
            $resData['town'] = $row["town"];
            $resData['bedrooms'] = $row["num_bedrooms"];
            $resData['bathrooms'] = $row["num_bathrooms"];
            $resData['address'] = $row["address"];
            $resData['description'] = $row["description"];
            $resData['price'] = $row["price"];
            $resData['thumbnail'] = $row["image_thumbnail"]; 	
            $resData['Property'] = $row["property_type_id"];
            $resData['type'] = $row["type"];
        } 

           return $resData;
     }

   /**
     * fetch api informations
     * @param array $newData
     * @return string $json_data
     */

     public function fetchApiData($newData){
        $draw = $newData['draw'];
        $row = $newData['row'];
        $rowperpage = $newData['rowperpage']; 
        $columnIndex = $newData['columnIndex']; 
        $columnName = $newData['columnName']; 
        $columnName = 'county';
        $columnSortOrder = $newData['columnSortOrder']; 
        $searchValue = $newData['searchValue']; 

$sql ="SELECT details.id as id,type,title,county,country,town,image_thumbnail,latitude,longitude,num_bedrooms,num_bathrooms,price FROM details inner join property on details.property_type_id = property.id";
$query = mysqli_query($this->conn, $sql) or die("Mysql Error");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData; 
$sql ="SELECT details.id as id,type,title,county,country,town,image_thumbnail,latitude,longitude,num_bedrooms,num_bathrooms,price FROM details inner join property on details.property_type_id = property.id";

if (!empty($searchValue)) {  
    $sql .= " AND ( title LIKE '%" .$searchValue. "%' ";
    $sql .= " OR num_bedrooms = '" .$searchValue. "' ";
    $sql .= " OR price LIKE '" .$searchValue. "%' ";
    $sql .= " OR type LIKE '%" .$searchValue. "%' )";
}
$query = mysqli_query($this->conn, $sql) or die("Mysql Error ");
$totalFiltered = mysqli_num_rows($query); 
$sql .= " ORDER BY " . $columnName . " " . $columnSortOrder . "   LIMIT " . $row . " ," . $rowperpage . "   ";
$query = mysqli_query($this->conn, $sql) or die("Mysql Error in getting : get products3");

$data = array();
$nestedData = array();
$rownew = 0;
while ($row = mysqli_fetch_array($query)) {  

    $nestedData['No'] = ++$rownew;
    $nestedData['id'] = $row["id"];
    $nestedData['title'] = $row["title"];
    $nestedData['county'] = $row["county"];
    $nestedData['country'] = $row["country"];
    $nestedData['town'] = $row["town"];
    $nestedData['bedrooms'] = $row["num_bedrooms"];
    $nestedData['bathrooms'] = $row["num_bathrooms"];
    $nestedData['price'] = $row["price"];
    $nestedData['type'] = $row["type"];
    $nestedData['thumbnail'] = $row["image_thumbnail"];
    $data[]=$nestedData;
} 

$json_data = array(
    "draw" => intval($draw),  
    "recordsTotal" => intval($totalData),  
    "recordsFiltered" => intval($totalFiltered), 
    "data" =>$data 
);

echo  json_encode($json_data);  

    }



}

?>