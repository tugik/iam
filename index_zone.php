<?php
include("auth.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>IAM</title>
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
      <a class="navbar-brand" href="#">IAM</a>
<!--      <img alt="DNSDB" src="..."> -->
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php">logout</a></li>
        <li><a href="index_user.php">users</a></li>
        <li class="active"><a href="index_zones.php">zones <span class="sr-only">(current)</span></a></li>
        <li><a href="index.php">records</a></li>
    </div>
 </div>
</nav>

		<div class="container" ng-init="fetchData()">
			<div class="alert alert-success alert-dismissible" ng-show="success" >
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{successMessage}}
			</div>
<!--			<div align="right">
 -->
<!--				<button type="button" name="add_button" ng-click="addData()" class="btn btn-success">Add Zone</button>
 -->

			<div align="right" style="float: right; z-index: 999; position: relative;">
				<button type="button" name="add_button" ng-click="addData()" class="btn btn-success">Add Zone</button>
			</div>
			<br />

			<div class="table-responsive" style="overflow-x: unset;">
				<table datatable="ng" dt-options="vm.dtOptions" class="table table-bordered table-striped">
					<thead>
						<tr>
						    <th>zone</th>
						    <th>type zone</th>
						    <th> </th>
						    <th>Host Label</th>
			    			    <th>TTL</th>
						    <th>Class</th>
						    <th>Type</th>
			    			    <th>Data</th>

<!--							<th>Primary Name Server</th>
							<th>Hostmaster Email</th>
							<th>Serial Numbers</th>
							<th>Refresh</th>
							<th>Retry</th>
							<th>Expire</th>
							<th>Minimum</th> 
-->

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
				    <td><big style="color:#4B0082">{{name.zone}}</big></td>
				    <td>{{name.type_zone}}</td>
				    <td> </td>
				    <td>{{name.name}}</td>
				    <td>{{name.ttl}}</td>
				    <td>{{name.class}}</td>
				    <td>{{name.type}}</td>
				    <td>{{name.primary_ns}}  {{name.resp_person}}  <b style="color:#FF4500"> {{name.serial}} </b> {{name.refresh}}  {{name.retry}}  {{name.expire}}  {{name.minimum}}</td>

<!--							<td>{{name.resp_person}}</td>
							<td>{{name.serial}}</td>
							<td>{{name.refresh}}</td>
							<td>{{name.retry}} {{name.expire}}</td>
							<td>{{name.expire}}</td>
							<td>{{name.minimum}}</td> 
-->

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
	<div class="modal-dialog" role="document" style="width: 70% ">
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
		    <p>add main parameters and options</p>
		    <div class="form-group  row">
			<div class="col-md-5"> <label>Zone Name</label>
			<input type="text" name="zone" ng-model="zone" placeholder= "example.com" required class="form-control" />
			</div>
			<div class="col-md-2"> <label>type</label>
			<select name="type_zone" type="text" ng-model="type_zone" class="form-control">
			<option value="master" selected>master</option>
			<option value="slave">slave</option>
			<option value="primary">primary</option>
			<option value="secondary">secondary</option>
			<option value="forward">forward</option>
			<option value="redirect">redirect</option>
			<option value="mirror">mirror</option>
			<option value="hint">hint</option>
			<option value="stub">stub</option>
			<option value="static-stub">static-stub</option>
			</select>
			</div>
			<div class="col-md-5"> <label>file</label>
			<input type="text" name="file" ng-model="file" placeholder= "/path/bind/example.com" required class="form-control" />
			</div>
		    </div>
		    <div class="form-group  row">
			<div class="col-md-3"> <label>masters</label>
			<input ng-disabled="type_zone == 'master'" type="text" name="masters" ng-model="masters" placeholder= "ip master;" class="form-control" />
			</div>
			<div class="col-md-3"> <label>forwarders</label>
			<input ng-disabled="type_zone == 'master'" type="text" name="forwarders" ng-model="forwarders" placeholder= "ip forwarder;" class="form-control" />
			</div>
			<div class="col-md-3"> <label>notify</label>
			<select ng-disabled="type_zone == 'master'" type="text" name="notify" ng-model="notify" placeholder= "yes or no" class="form-control" >
			<option value="yes" selected>yes</option>
			<option value="no">no</option>
			</select>
			</div>
		    </div>
		    <div class="form-group  row">
			<div class="col-md-3"> <label>allow_query</label>
			<input ng-disabled="type_zone == 'master'" type="text" name="allow_query" ng-model="allow_query" placeholder= "ip list or any;" class="form-control" />
			</div>

			<div class="col-md-3"> <label>allow_transfer</label>
			<input ng-disabled="type_zone == 'master'" type="text" name="allow_transfer" ng-model="allow_transfer" placeholder= "none; or ip secondary;" class="form-control" />
			</div>

			<div class="col-md-3"> <label>allow_update</label>
			<input ng-disabled="type_zone == 'master'" type="text" name="allow_update" ng-model="allow_update" placeholder= "none; or ip list;" class="form-control" />
			</div>

			<div class="col-md-3"> <label>allow_notify</label>
			<input ng-disabled="type_zone == 'master'" type="text" name="allow_notify" ng-model="allow_notify" placeholder= "none; or ip list;" class="form-control" />
			</div>
		    </div>
		    <p> add main records</p>
		    <div class="form-group  row">
			<div class="col-md-4"> <label>name</label>
			<input type="text" name="name" ng-model="name" placeholder= "name" required class="form-control" />
			</div>
			<div class="col-md-2"> <label>ttl</label>
			<input type="text" name="ttl" ng-model="ttl" required class="form-control" />
			</div>
			<div class="col-md-1"> <label>class</label>
			<select type="text" name="class" ng-model="class" required class="form-control" />
			<option value="IN" selected>IN</option>
			<option value="CH">CH</option>
			<option value="HS">HS</option>
			</select>
			</div>
			<div class="col-md-1"> <label>type</label>
			<input ng-disabled="type" type="text" name="type" ng-model="type" required class="form-control" />
			</div>
			<div class="col-md-2"> <label>primary_ns</label>
			<input type="text" name="primary_ns" ng-model="primary_ns" placeholder= "ns.example.com" required class="form-control" />
			</div>
			<div class="col-md-2"> <label>resp_person</label>
			<input type="text" name="resp_person" ng-model="resp_person"  placeholder= "admin@example.com" required class="form-control" />
			</div>
		    </div>
		    <div class="form-group  row">
			<div class="col-md-4"> <label>serial</label>
			<input ng-disabled="type == 'SOA'" type="text" name="serial" ng-model="serial" placeholder= "auto generate from time" class="form-control" />
			</div>
			<div class="col-md-2"> <label>refresh</label>
			<input type="text" name="refresh" ng-model="refresh" required class="form-control" />
			</div>
			<div class="col-md-2"> <label>retry</label>
			<input type="text" name="retry" ng-model="retry" required class="form-control" />
			</div>
			<div class="col-md-2"> <label>expire</label>
			<input type="text" name="expire" ng-model="expire" required class="form-control" />
			</div>
			<div class="col-md-2"> <label>minimum</label>
			<input type="text" name="minimum" ng-model="minimum" required class="form-control" />
			</div>
		    </div>
<p>add other information</p>

					<div class="form-group">
						<label>Description</label>
						<input type="text" name="descr" ng-model="descr" placeholder= "Project/owner or IT- from jira" required class="form-control" />
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


<script>

var app = angular.module('crudApp', ['datatables']);
app.controller('crudController', function($scope, $http){

	$scope.success = false;

	$scope.error = false;

	$scope.fetchData = function(){
		$http.get('fetch_zone_data.php').success(function(data){
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
		$scope.modalTitle = 'Add zone';
		$scope.submit_button = 'Insert';
		$scope.zone = '';
		$scope.type_zone = 'master';
		$scope.file = '';
		$scope.masters = '';
		$scope.forwarders = '';
		$scope.notify = 'no';
		$scope.allow_query = 'any;';
		$scope.allow_transfer = '';
		$scope.allow_update = '';
		$scope.allow_notify = '';
		$scope.name = '';
		$scope.ttl = '7200';
		$scope.class = 'IN';
		$scope.type = 'SOA';
		$scope.primary_ns = '';
		$scope.resp_person = '';
		$scope.serial = '';
		$scope.refresh = '3600';
		$scope.retry = '900';
		$scope.expire = '3600000';
		$scope.minimum = '3600';
		$scope.descr = '';
		$scope.state = 'enable';
		$scope.openModal();
	};

	$scope.submitForm = function(){
		$http({
			method:"POST",
			url:"insert_zone.php",
			data:{'zone':$scope.zone,'type_zone':$scope.type_zone,'file':$scope.file,'masters':$scope.masters,'forwarders':$scope.forwarders,'notify':$scope.notify,'allow_query':$scope.allow_query,'allow_transfer':$scope.allow_transfer,'allow_update':$scope.allow_update,'allow_notify':$scope.allow_notify,'name':$scope.name,'ttl':$scope.ttl,'class':$scope.class,'type':$scope.type,'primary_ns':$scope.primary_ns,'resp_person':$scope.resp_person,'serial':$scope.serial,'refresh':$scope.refresh,'retry':$scope.retry,'expire':$scope.expire,'minimum':$scope.minimum,'descr':$scope.descr, 'state':$scope.state, 'change_by':$scope.change_by, 'action':$scope.submit_button, 'id':$scope.hidden_id}
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
			url:"insert_zone.php",
			data:{'id':id, 'action':'fetch_single_data'}
		}).success(function(data){
			$scope.zone = data.zone;
			$scope.type_zone = data.type_zone;
			$scope.file = data.file;
			$scope.masters = data.masters;
			$scope.forwarders = data.forwarders;
			$scope.notify = data.notify;
			$scope.allow_query = data.allow_query;
			$scope.allow_transfer = data.allow_transfer;
			$scope.allow_update = data.allow_update;
			$scope.allow_notify = data.allow_notify;
			$scope.name = data.name;
			$scope.ttl = data.ttl;
			$scope.class = data.class;
			$scope.type = data.type;
			$scope.primary_ns = data.primary_ns;
			$scope.resp_person = data.resp_person;
			$scope.serial = data.serial;
			$scope.refresh = data.refresh;
			$scope.retry = data.retry;
			$scope.expire = data.expire;
			$scope.minimum = data.minimum;
			$scope.descr = data.descr;
			$scope.state = data.state;
			$scope.add_date = data.add_date;
			$scope.upd_date = data.upd_date;
			$scope.change_by = data.change_by;
			$scope.hidden_id = id;
			$scope.modalTitle = 'Edit Rule';
			$scope.submit_button = 'Edit';
			$scope.openModal();
		});
	};

	$scope.deleteData = function(id){
		if(confirm("Are you sure you want to remove it?"))
		{
			$http({
				method:"POST",
				url:"insert_zone.php",
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