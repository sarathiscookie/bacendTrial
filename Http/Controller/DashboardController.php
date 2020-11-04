<?php

namespace App\Http\Controller;
use App\Model\MySQLiContainer;
use App\Services\Service;
require 'Http/Model/MySQLiContainer.php';
require 'Http/Services/Service.php';

class DashboardController
{

    function __construct() {

        $this->sql = new MySQLiContainer();

    }

    /**
     * Get details from api
     * @return string
     */
    public function getResultFromApi()
    {
        $apiData = new Services();
        $apiData->index();  // Data fetched from API
        return 'Success';
    }
    
     /**
     * fetch edit data details
     * @param string
     * @return array
     */

    public function editData($edit) {
 
        $editData    =  $this->sql->fetchEditData($edit);

        return $editData;

    }

   /**
     * delete record from the database 
     * @param string $delete 
     * @return string $editData 
     */
 
    public function delData($delete) {
 
         $filedetails =    $this->sql->fetchFiledetails($delete);
         if(isset($filedetails[0]['image_full'])) {
             if(file_exists($filedetails[0]['image_full'])) {
                unlink($filedetails[0]['image_full']);
                unlink($filedetails[0]['image_thumbnail']);
             }
         }
        $editData    =  $this->sql->deleteData($delete);

        return $editData;
    }


   /**
     * fetch api from the database 
     * @param array $fetchData 
     * @return array $apiFetchData 
     */

    public function fetchApiData($fetchData) {

         $apiFetchData    =   $this->sql->fetchApiData($fetchData);
         echo $apiFetchData;
        
    }
    
   /**
     * dynamic Insertion of  data 
     * @param string $table_name 
     * @return array $insertData 
     */

    public function insertMsqlData($table_name,$insertData) {
 //print_r($insertData); exit;
       if(!empty($insertData['filename'])) {
        $filename = $_FILES['media']['name'];
        $randomId = date('dmYHis').uniqid().$filename;
        $location = "view/assets/upload/".$randomId;
        $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
        $imageFileType = strtolower($imageFileType);
        $valid_extensions = array("jpg","jpeg","png");
        $response = 0;
        if(in_array(strtolower($imageFileType), $valid_extensions)) {
            $dirname = 'view/assets/upload';
            if(is_dir($dirname)) {
             } else {
                mkdir($dirname, 0777);
             }
           /* Upload file */
               if(move_uploaded_file($_FILES['media']['tmp_name'],$location)){
                $insertData['image_full'] = $location;
                $resize = $this->imageResize($location);
                $insertData['image_thumbnail'] = $resize;
               }
          } else {

            return "invalid file uploaded";
          }
       }
        unset($insertData['filename']);
        $insRes    =  $this->sql->insertData($table_name,$insertData);
        echo $insRes;
    }

     /**
     * fetch property details
     * @return array $insRes 
     */

    public function fetchProperty() {
        $insRes    =  $this->sql->fetchProperty();
        return $insRes;
    }

   /**
     * Resize the image 
     * @return array $insRes 
     */

   public function imageResize($img) {
    if(isset($img)) {
	$image = $img;

	$image_size = getimagesize($image);
	$image_width = $image_size[0];
	$image_height = $image_size[1];

	$new_size = ($image_width + $image_height) / ($image_width * ($image_height / 45));
	$new_width = $image_width * $new_size;
	$new_height = $image_height * $new_size;

	$new_image = imagecreatetruecolor($new_width, $new_height);

	$old_image = imagecreatefromjpeg($image);

	imagecopyresized($new_image, $old_image, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height);

     $resized = imagejpeg($new_image, $image.'.thumb.jpg');
     
      return $image.'.thumb.jpg'; 
     }
   }
}