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
			body { padding-top: 10px; }
		</style>
		
	</head>
	<body ng-app="crudApp" ng-controller="crudController">
		


<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">DNSDB</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php"> logout </a></li>
        <li><a href="index_user.php"> users </a></li>
        <li><a href="index_zone.php"> zones </a></li>
        <li class="active"><a href="index.php"> records <span class="sr-only">(current)</span></a></li>

    </div>
  </div>
</nav>

		<div class="container" ng-init="fetchData()">
			<br />
			<br />
<!--				<h3 align="center">IPtrulesDB</h3> -->
			<br />
			<div class="alert alert-success alert-dismissible" ng-show="success" >
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{successMessage}}
			</div>
			<div align="right" style="float: right; z-index: 999; position: relative;">
				<button type="button" name="add_button" ng-click="addData()" class="btn btn-success">Add Record</button>
			</div>
			<br />
			<div class="table-responsive" style="overflow-x: unset;">
				<table datatable="ng" dt-options="vm.dtOptions" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>name</th>
							<th>ttl</th>
							<th>Class</th>
							<th>Type</th>
							<th>Extra</th>
							<th>Data</th>
							<th>Description</th>
							<th>State</th>
							<th>add date</th>
							<th>update date</th>
							<th>change by</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="name in namesData">
							<td>{{name.name}}.{{name.zone}} </td>
							<td>{{name.ttl}}</td>
							<td>{{name.class}}</td>
							<td>{{name.type}}</td>
							<td>{{name.priority}}  {{name.weight}}  {{name.port}}</td>
							<td>{{name.data}}</td>
							<td>{{name.descr}}</td>
							<td><span class="label" ng-class="{'label-success': name.state == 'enable', 'label-default': name.state == 'disable'}">{{name.state}}</span></td>
							<td>{{name.add_date}}</td>
							<td>{{name.upd_date}}</td>
							<td>{{name.change_by}}</td>
							<td><button type="button" ng-click="fetchSingleData(name.id)" class="btn btn-warning btn-xs">Edit</button></td>
							<td><button type="button" ng-click="deleteData(name.id)" class="btn btn-danger btn-xs">Delete</button></td>
						</tr>
					</tbody>
				</table>
			</div>

		</div>
	</body>
</html>



<div class="modal fade" tabindex="-1" role="dialog" id="crudmodal">
	<div class="modal-dialog" role="document" style="width: 50% ">
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


				<div class="form-group  row">

					<div class="col-md-8">
						<label>Name</label>
						<input type="text" name="name" ng-model="name"  placeholder= "name" required class="form-control" />
					</div>
					<div class="col-md-4">
						<label>zone</label>
						<select name="zone" type="text" ng-model="zone_id"  class="form-control">
						    <option value="{{item.id}}" ng-repeat="item in zoneData">{{item.zone}}</option>
						</select>
					</div>
				</div>

				<div class="form-group  row">

					<div class="col-md-2"> <label>ttl</label>
						<input type="text" name="ttl" ng-model="ttl"  required class="form-control">
					</div>
					<div class="col-md-2"> <label>Class</label>
						<select name="class" type="text" ng-model="class" class="form-control">
						<option value="IN" selected>IN</option>
						<option value="CH">CH</option>
						<option value="HS">HS</option>
						</select>
					</div>
					<div class="col-md-2"> <label>Type</label>
						<select name="type" type="text" ng-model="type" class="form-control">
						<option value="A" selected>A</option>
						<option value="AAAA">AAAA</option>
						<option value="CNAME">CNAME</option>
						<option value="MX">MX</option>
						<option value="NS">NS</option>
						<option value="PTR">PTR</option>
						<option value="CERT">CERT</option>
						<option value="SRV">SRV</option>
						<option value="TXT">TXT</option>
						</select>
					</div>
						<div class="col-md-2"> <label>priority</label>
						<input ng-disabled="!(type == 'MX' || type == 'TXT' || type == 'SRV')" type="text" name="priority" ng-model="priority" class="form-control" />
						</div>
						<div class="col-md-2"> <label>weight</label>
						<input ng-disabled="!((type == 'TXT' || type == 'SRV') && priority)" type="text" name="weight" ng-model="weight" class="form-control" />
						</div>
						<div class="col-md-2"> <label>port</label>
						<input ng-disabled="!((type == 'TXT' || type =='SRV') && weight)" type="text" name="port" ng-model="port" class="form-control" />
						</div>
					</div>

					<div class="form-group">
						<label>Data</label>
						<input type="text" name="data" ng-model="data" placeholder= "ip, name, spf, or text information"  class="form-control" />
					</div>

					<div class="form-group">
						<label>Description</label>
						<input type="text" name="descr" ng-model="descr" placeholder= "Project/owner of IT- from Jira" required class="form-control" />
					</div>
					<div class="form-group">
						<label>State reule</label>
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


<script>

var app = angular.module('crudApp', ['datatables']);
app.controller('crudController', function($scope, $http){

	$scope.success = false;

	$scope.error = false;


		$http.get('fetch_select_data.php').success(function(data){
			$scope.zoneData = data;
		});


	$scope.fetchData = function(){

//		$http.get('fetch_select_data.php').success(function(data){
//			$scope.zoneData = data;
//		});

		$http.get('fetch_data.php').success(function(data){
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

	$scope.addData = function(){
		$scope.modalTitle = 'Add record';
		$scope.submit_button = 'Insert';
		$scope.zone_id = '';
		$scope.name = '';
		$scope.ttl = '7200';
		$scope.class = 'IN';
		$scope.type = 'A';
		$scope.priority = '';
		$scope.weight = '';
		$scope.port = '';
		$scope.data = '';
		$scope.descr = '';
		$scope.state = 'enable';
		$scope.openModal();
	};

	$scope.submitForm = function(){
		$http({
			method:"POST",
			url:"insert.php",
			data:{'zone_id':$scope.zone_id, 'name':$scope.name, 'ttl':$scope.ttl, 'class':$scope.class, 'type':$scope.type, 'priority':$scope.priority, 'weight':$scope.weight, 'port':$scope.port, 'data':$scope.data, 'descr':$scope.descr, 'state':$scope.state, 'change_by':$scope.change_by, 'action':$scope.submit_button, 'id':$scope.hidden_id}
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

	$scope.fetchSingleData = function(id){
		$http({
			method:"POST",
			url:"insert.php",
			data:{'id':id, 'action':'fetch_single_data'}
		}).success(function(data){
			$scope.zone_id = data.zone_id;
			$scope.name = data.name;
			$scope.ttl = data.ttl;
			$scope.class = data.class;
			$scope.type = data.type;
			$scope.priority = data.priority;
			$scope.weight = data.weight;
			$scope.port = data.port;
			$scope.data = data.data;
			$scope.descr = data.descr;
			$scope.state = data.state;
			$scope.add_date = data.add_date;
			$scope.upd_date = data.upd_date;
			$scope.change_by = data.change_by;
			$scope.hidden_id = id;
			$scope.modalTitle = 'Edit record';
			$scope.submit_button = 'Edit';
			$scope.openModal();
		});
	};

	$scope.deleteData = function(id){
		if(confirm("Are you sure you want to remove it?"))
		{
			$http({
				method:"POST",
				url:"insert.php",
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