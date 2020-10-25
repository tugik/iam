<?php
include("auth.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>DNSDB</title>
		<script src="jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
		<script src="jquery.dataTables.min.js"></script>
		<script src="angular-datatables.min.js"></script>
		<script src="bootstrap.min.js"></script>
		<link rel="stylesheet" href="bootstrap.min.css">
		<link rel="stylesheet" href="datatables.bootstrap.css">
		
		<style>
		.dataTables_filter { margin-top: -1em; padding-right: 10em; }
		.container { width: 100%; }
		body { padding-top: 70px; }
		</style>
	</head>
	<body ng-app="crudApp" ng-controller="crudController">
		

<nav class="navbar navbar-default navbar-fixed-top">
 <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">DNSDB</a>
<!--      <img alt="IPtrulesDB" src="..."> -->
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php">logout</a></li>
        <li class="active"><a href="index_user.php">users <span class="sr-only">(current)</span></a></li>
        <li><a href="index_zone.php">zones</a></li>
        <li><a href="index.php">records</a></li>
    </div>
 </div>
</nav>

		<div class="container" ng-init="fetchData()">
			<div class="alert alert-success alert-dismissible" ng-show="success" >
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{successMessage}}
			</div>
<!--			<div align="right"> -->
<!--				<button type="button" name="add_button" ng-click="addData()" class="btn btn-success">Add User</button> -->

			<div align="right" style="float: right; z-index: 999; position: relative;">
				<button type="button" name="add_button" ng-click="addData()" class="btn btn-success">Add User</button>
			</div>
			<br />

			<div class="table-responsive" style="overflow-x: unset;">
				<table datatable="ng" dt-options="vm.dtOptions" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>username</th>
							<th>fullname</th>
							<th>permission</th>
							<th>state</th>
							<th>add date</th>
							<th>update date</th>
							<th nowrap>change by</th>
							<th>password</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="name in namesData">
							<td width="20%">{{name.username}}</td>
							<td width="40%">{{name.fullname}}</td>
							<td><span class="label" ng-class="{'label-primary': name.permission == 'administrator', 'label-info': name.permission == 'management', 'label-default': name.permission == 'user'}">{{name.permission}}</span></td>
							<td><span class="label" ng-class="{'label-success': name.state == 'enable', 'label-default': name.state == 'disable'}">{{name.state}}</span></td>
							<td>{{name.add_date}}</td>
							<td>{{name.upd_date}}</td>
							<td>{{name.change_by}}</td>
							<td><button type="button" ng-click="fetchPasswordData(name.id)" class="btn btn-warning btn-xs">password</button></td>
							<td><button type="button" ng-click="fetchEditData(name.id)" class="btn btn-warning btn-xs">Edit user</button></td>
							<td><button type="button" ng-click="deleteData(name.id)" class="btn btn-danger btn-xs">Delete</button></td>
						</tr>
					</tbody>
				</table>
			</div>

		</div>
	</body>
</html>


<div class="modal fade" tabindex="-1" role="dialog" id="crudmodal">
	<div class="modal-dialog" role="document" style="width: 20% ">
    	<div class="modal-content">
    		<form method="post" ng-submit="submitForm()">
	      		<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title">{{modalTitle}}</h4>
	      		</div>
	      		<div class="modal-body">
	      			<div class="alert alert-danger alert-dismissible" ng-show="error" >
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						{{errorMessage}}
					</div>
					<div class="form-group">
						<label>UserName</label>
						<input type="text" name="username" ng-model="username" required class="form-control" />
					</div>
					<div class="form-group">
						<label>FullName</label>
						<input type="text" name="fullname" ng-model="fullname" required class="form-control" />
					</div>


					<div class="form-group">
						<label>Password</label>
						<input type="text" name="password" ng-model="password" required class="form-control" />
					</div>



					<div class="form-group">
						<label>Permissions</label>
						<select name="permission" type="text" ng-model="permission" class="form-control">
						<option value="administrator" selected>administrator</option>
						<option value="management">management</option>
						<option value="user">user</option>
						</select>
					</div>
					<div class="form-group">
						<label>State</label>
						<select name="state" type="text" ng-model="state" class="form-control">
						<option value="enable" selected>enable</option>
						<option value="disable">disable</option>
						</select>
					</div>
	      		</div>
	      		<div class="modal-footer">
	      			<input type="hidden" name="hidden_id" value="{{hidden_id}}" />
	      			<input type="submit" name="submit" id="submit" class="btn btn-info" value="{{submit_button}}" />
	        		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        	</div>
	        </form>
    	</div>
  	</div>
</div>








<div class="modal fade" tabindex="-1" role="dialog" id="crudmodaledit">
	<div class="modal-dialog" role="document" style="width: 20% ">
    	<div class="modal-content">
    		<form method="post" ng-submit="submitForm1()">
	      		<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title">{{modalTitle}}</h4>
	      		</div>
	      		<div class="modal-body">
	      			<div class="alert alert-danger alert-dismissible" ng-show="error" >
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						{{errorMessage}}
					</div>
					<div class="form-group">
						<label>UserName</label>
						<input type="text" name="username" ng-model="username" required class="form-control" />
					</div>
					<div class="form-group">
						<label>FullName</label>
						<input type="text" name="fullname" ng-model="fullname" required class="form-control" />
					</div>
					<div class="form-group">
						<label>Permissions</label>
						<select name="permission" type="text" ng-model="permission" class="form-control">
						<option value="administrator" selected>administrator</option>
						<option value="management">management</option>
						<option value="user">user</option>
						</select>
					</div>
					<div class="form-group">
						<label>State</label>
						<select name="state" type="text" ng-model="state" class="form-control">
						<option value="enable" selected>enable</option>
						<option value="disable">disable</option>
						</select>
					</div>
	      		</div>
	      		<div class="modal-footer">
	      			<input type="hidden" name="hidden_id" value="{{hidden_id}}" />
	      			<input type="submit" name="submit" id="submit" class="btn btn-info" value="{{submit_button}}" />
	        		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        	</div>
	        </form>
    	</div>
  	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="crudmodalpass">
	<div class="modal-dialog" role="document" style="width: 20% ">
    	<div class="modal-content">
    		<form method="post" ng-submit="submitForm2()">
	      		<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title">{{modalTitle}}</h4>
	      		</div>
	      		<div class="modal-body">
	      			<div class="alert alert-danger alert-dismissible" ng-show="error" >
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						{{errorMessage}}
					</div>

					<div class="form-group">
						<label>password</label>
						<input type="password" name="password" ng-model="password" required class="form-control" />
					</div>

	      		</div>
	      		<div class="modal-footer">
	      			<input type="hidden" name="hidden_id" value="{{hidden_id}}" />
	      			<input type="submit" name="submit" id="submit" class="btn btn-info" value="{{submit_button}}" />
	        		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        	</div>
	        </form>
    	</div>
  	</div>
</div>






<script>

var app = angular.module('crudApp', ['datatables']);
app.controller('crudController', function($scope, $http){

	$scope.success = false;

	$scope.error = false;

	$scope.fetchData = function(){
		$http.get('fetch_user_data.php').success(function(data){
			$scope.namesData = data;
		});
	};





	$scope.openModal = function(){
		var modal_popup = angular.element('#crudmodal');
		modal_popup.modal('show');
	};

	$scope.closeModal = function(){
		var modal_popup = angular.element('#crudmodal');
		modal_popup.modal('hide');
	};


	$scope.openModalEdit = function(){
		var modal_popup = angular.element('#crudmodaledit');
		modal_popup.modal('show');
	};

	$scope.closeModalEdit = function(){
		var modal_popup = angular.element('#crudmodaledit');
		modal_popup.modal('hide');
	};


	$scope.openModalPass = function(){
		var modal_popup = angular.element('#crudmodalpass');
		modal_popup.modal('show');
	};

	$scope.closeModalPass = function(){
		var modal_popup = angular.element('#crudmodalpass');
		modal_popup.modal('hide');
	};







	$scope.addData = function(){
		$scope.modalTitle = 'Add rule';
		$scope.submit_button = 'Insert';
		$scope.username = '';
		$scope.fullname = '';
		$scope.password = '';
		$scope.permission = '';
		$scope.state = 'enable';
		$scope.openModal();
	};

	$scope.submitForm = function(){
		$http({
			method:"POST",
			url:"insert_user.php",
			data:{'username':$scope.username, 'fullname':$scope.fullname, 'password':$scope.password, 'permission':$scope.permission, 'state':$scope.state, 'change_by':$scope.change_by, 'action':$scope.submit_button, 'id':$scope.hidden_id}
		}).success(function(data){
			if(data.error != '')
			{
				$scope.success = false;
				$scope.error = true;
				$scope.errorMessage = data.error;
			}
			else
			{
				$scope.success = true;
				$scope.error = false;
				$scope.successMessage = data.message;
				$scope.form_data = {};
				$scope.closeModal();
				$scope.fetchData();
			}
		});
	};



	$scope.submitForm1 = function(){
		$http({
			method:"POST",
			url:"insert_user_edit.php",
			data:{'username':$scope.username, 'fullname':$scope.fullname, 'password':$scope.password, 'permission':$scope.permission, 'state':$scope.state, 'change_by':$scope.change_by, 'action':$scope.submit_button, 'id':$scope.hidden_id}
		}).success(function(data){
			if(data.error != '')
			{
				$scope.success = false;
				$scope.error = true;
				$scope.errorMessage = data.error;
			}
			else
			{
				$scope.success = true;
				$scope.error = false;
				$scope.successMessage = data.message;
				$scope.form_data = {};
				$scope.closeModalEdit();
				$scope.fetchData();
			}
		});
	};









	$scope.submitForm2 = function(){
		$http({
			method:"POST",
			url:"insert_user_password.php",
			data:{'username':$scope.username, 'fullname':$scope.fullname, 'password':$scope.password, 'permission':$scope.permission, 'state':$scope.state, 'change_by':$scope.change_by, 'action':$scope.submit_button, 'id':$scope.hidden_id}
		}).success(function(data){
			if(data.error != '')
			{
				$scope.success = false;
				$scope.error = true;
				$scope.errorMessage = data.error;
			}
			else
			{
				$scope.success = true;
				$scope.error = false;
				$scope.successMessage = data.message;
				$scope.form_data = {};
				$scope.closeModalPass();
				$scope.fetchData();
			}
		});
	};















	$scope.fetchSingleData = function(id){
		$http({
			method:"POST",
			url:"insert_user.php",
			data:{'id':id, 'action':'fetch_single_data'}
		}).success(function(data){
			$scope.username = data.username;
			$scope.fullname = data.fullname;
			$scope.password = data.password;
			$scope.permission = data.permission;
			$scope.state = data.state;
			$scope.add_date = data.add_date;
			$scope.upd_date = data.upd_date;
			$scope.change_by = data.change_by;
			$scope.hidden_id = id;
			$scope.modalTitle = 'Edit user';
			$scope.submit_button = 'Edit';
			$scope.openModal();
		});
	};



	$scope.fetchEditData = function(id){
		$http({
			method:"POST",
			url:"insert_user_edit.php",
			data:{'id':id, 'action':'fetch_edit_data'}
		}).success(function(data){
			$scope.username = data.username;
			$scope.fullname = data.fullname;
			$scope.password = data.password;
			$scope.permission = data.permission;
			$scope.state = data.state;
			$scope.add_date = data.add_date;
			$scope.upd_date = data.upd_date;
			$scope.change_by = data.change_by;
			$scope.hidden_id = id;
			$scope.modalTitle = 'Edit user';
			$scope.submit_button = 'Edit';
			$scope.openModalEdit();
		});
	};








	$scope.fetchPasswordData = function(id){
		$http({
			method:"POST",
			url:"insert_user_password.php",
			data:{'id':id, 'action':'fetch_password_data'}
		}).success(function(data){
			$scope.username = data.username;
			$scope.fullname = data.fullname;
			$scope.password = data.password;
			$scope.permission = data.permission;
			$scope.state = data.state;
			$scope.add_date = data.add_date;
			$scope.upd_date = data.upd_date;
			$scope.change_by = data.change_by;
			$scope.hidden_id = id;
			$scope.modalTitle = 'Chage password';
			$scope.submit_button = 'Change';
			$scope.openModalPass();
		});
	};











	$scope.deleteData = function(id){
		if(confirm("Are you sure you want to remove it?"))
		{
			$http({
				method:"POST",
				url:"insert_user.php",
				data:{'id':id, 'action':'Delete'}
			}).success(function(data){
				$scope.success = true;
				$scope.error = false;
				$scope.successMessage = data.message;
				$scope.fetchData();
			});	
		}
	};

});

</script>