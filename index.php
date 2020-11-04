<?php
use App\Http\Controller\DashboardController;
require_once 'vendor/autoload.php';
require_once 'view/includes/header.php'; 
require 'Http/Controller/DashboardController.php';
$obj = new DashboardController();
//$obj->getResultFromApi();
$result = $obj->fetchProperty();
?>

<body>
<div class="container-xl">
	<div class="table-responsive">
		<div class="table-wrapper">
			<div class="table-title">
				<div class="row">
					<div class="col-sm-6">
						<h2>Manage <b>Api Data</b></h2>
					</div>
					<div class="col-sm-6">
						<a href="#addModal"  class="btn btn-success add" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Data</span></a>					
					</div>
				</div>
			</div>
			<table class="table table-striped table-hover" id="userTable">
				<thead>
					<tr>
						<th>No</th>
						<th>county</th>
						<th>country</th>
                        <th>town</th>
                        <th>bedrooms</th>
						<th>bathrooms</th>
                        <th>price</th>
						<th>Title</th>
						<th>Type</th>
						<th>Image</th>
						 <th>Action</th>
					</tr>
				</thead>
				<tbody>
        
				</tbody>
			</table>
		</div>
	</div>        
</div>
<!-- Edit Modal HTML -->
<div id="addModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form  id="uploadData" enctype="multipart/form-data">
				<div class="modal-header">						
					<h4 class="modal-title">Add Details</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<div class="form-group">
						<label>County</label>
						<input type="hidden" class="form-control" name="id" id="id">
						<input type="text" class="form-control" name="County" id="County">
					</div>
					<div class="form-group">
						<label>Country</label>
						<input type="text" class="form-control" name="Country" id="Country">
					</div>
				
					<div class="form-group">
						<label>Town</label>
	             
						<input type="text" class="form-control" name="town" id="town">
					</div>		
					<div class="form-group">
						<label>	Displayable Address </label>
						<input type="text" class="form-control" name="Address" id="Address">
					</div>	
					<div class="form-group">
						<label>	Price </label>
						<input type="text" class="form-control" name="Price" id="Price">
					</div>		
					<div class="form-group">
						<label>	No of bed room</label>
						<select id="bedrooms" name="bedrooms" >
						<option value="">bed room</option>
						<?php for($i=0;$i<=15;$i++) { ?>
						    <option value="<?php echo $i;?>"> <?php echo $i; ?></options>
						<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label>	No of bath rooms</label>
						<select id="bathroom" name="bathroom" >
						<option value="">bath room</option>
						<?php for($i=0;$i<=15;$i++) { ?>
						    <option value="<?php echo $i;?>"> <?php echo $i; ?></options>
						<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label>Property Type</label>
						<select id="Property" name="Property" >
						<option> property</option>
						<?php foreach($result as $res){ ?>
						    <option value="<?php echo $res['id'];?>"> <?php echo $res['title']; ?></options>
						<?php } ?>
						</select>
					</div>
					<div class="form-group">
					      <label for="sale">sale</label><br>
                         <input type="radio" id="sale" name="salerent" value="sale">
					</div>
					<div class="form-group">
					<label for="rent">Rent</label><br>
                          <input type="radio"  id="rent" name="salerent" value="rent">
						  </div>
					<div class="form-group">
						<label></label>Description
						<textarea class="form-control" name="Description" id="Description"></textarea>
					</div>		
					<div class="form-group">
						<label>File</label>
						<input name="media" type="file" multiple/>
					</div>
					<div id="mediaData"></div>	
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<button type="button" id="forSubmit" class="btn btn-success forSubmit" value="Add"> submit</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Delete Modal HTML -->
<div id="deleteModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form>
				<div class="modal-header">						
					<h4 class="modal-title">Delete record</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<p>Are you sure you want to delete these Records?</p>
					<p class="text-warning"><small>This action cannot be undone.</small></p>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-danger" value="Delete" id="delete">
					<input type="hidden" class="btn btn-danger" value="Delete" id="id">
				</div>
			</form>
		</div>
	</div>
</div>
</body>
</html>

