<?php
include("auth.php");
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
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
	<body data-ng-app="crudApp" data-ng-controller="crudController">
		

<nav class="navbar navbar-default navbar-fixed-top">
 <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">IAM</a>
<!--      <img alt="IAM" src="..."> -->
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php">logout</a></li>
        <li><a href="index_user.php">users</a></li>
        <li class="active"><a href="index_accounts.php">accounts <span class="sr-only">(current)</span></a></li>
    </div>
 </div>
</nav>

		<div class="container" data-ng-init="fetchData()">
			<div class="alert alert-success alert-dismissible" data-ng-show="success" >
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{successMessage}}
			</div>
<!--			<div align="right">
 -->
<!--				<button type="button" name="add_button" ng-click="addData()" class="btn btn-success">Add Accounts</button>
 -->

			<div align="right" style="float: right; z-index: 999; position: relative;">
				<button type="button" name="add_button" ng-click="addData()" class="btn btn-success">Add Accounts</button>
			</div>
			<br />

			<div class="table-responsive" style="overflow-x: unset;">
				<table datatable="ng" dt-options="vm.dtOptions" class="table table-bordered table-striped">
					<thead>
						<tr>
						    <th>account</th>
						    <th>fullname</th>
                            <th>department</th>
						    <th> </th>
						    <th>ip</th>
                            <th>vlan</th>
						    <th>server</th>
						    <th>device</th>

<!--						<th>dns</th>
							<th>net</th>
							<th>subnet</th>
-->
						    <th>description</th>
						    <th>state</th>
						    <th>add date</th>
						    <th>update date</th>
						    <th>change by</th>
						    <th>Edit</th>
						    <th>Delete</th>
						</tr>
					</thead>
				<tbody>
				<tr data-ng-repeat="name in namesData">
				    <td><big style="color:#4B0082">{{name.account}}</big></td>
				    <td>{{name.fullname}}</td>
                    <td>{{name.department}}</td>
				    <td> </td>
				    <td>{{name.ip}}</td>
				    <td>{{name.vlan}}</td>
				    <td>{{name.server}}</td>
				    <td>{{name.device}}</td>

<!--						<td>{{name.dns}}</td>
							<td>{{name.net}}</td>
							<td>{{name.subnet}}</td>
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
	<div class="modal-dialog" role="document" style="width: 40% ">
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
		    <p>add main information</p>
		    <div class="form-group  row">
			<div class="col-md-4"> <label>Name Account</label>
			<input type="text" name="account" ng-model="account" placeholder= "n.lastname" required class="form-control" />
			</div>

			<div class="col-md-4"> <label>Full Name</label>
			<input type="text" name="fullname" ng-model="fullname" placeholder= "Name LastName" required class="form-control" />
			</div>

                    <div class="col-md-4"> <label>Department</label>
                        <input type="text" name="department" ng-model="department" placeholder= "it" required class="form-control" />
                    </div>
                </div>

		    <p> add options</p>
		    <div class="form-group  row">
			<div class="col-md-4"> <label>ip</label>
			<input type="text" name="ip" ng-model="ip" placeholder= "ip" required class="form-control" />
			</div>
			<div class="col-md-2"> <label>vlan</label>
			<input type="text" name="vlan" ng-model="vlan" required class="form-control" />
			</div>
			<div class="col-md-4"> <label>server</label>
			<select type="text" name="server" ng-model="server" required class="form-control" >
			<option value="gw.mlight.io" selected>gw.mlight.io</option>
			<option value="u66fw1">u66fw1</option>
			</select>
			</div>
                <div class="col-md-2"> <label>device</label>
                <select type="text" name="device" ng-model="device" required class="form-control" >
                    <option value="mac" selected>mac</option>
                    <option value="win">win</option>
                </select>
            </div>
            </div>
                <div class="form-group  row">
			<div class="col-md-4"> <label>net</label>
			<input type="text" name="net" ng-model="net"  required class="form-control" />
			</div>
			<div class="col-md-4"> <label>subnet</label>
			<input type="text" name="subnet" ng-model="subnet" required class="form-control" />
			</div>
                    <div class="col-md-4"> <label>dns</label>
                        <select type="text" name="dns" ng-model="dns" required class="form-control" >
                            <option value="10.0.0.53,10.0.0.54" selected>10.0.0.53,10.0.0.54</option>
                            <option value="10.0.0.53">10.0.0.53</option>
                            <option value="10.0.0.54">10.0.0.54</option>
                            <option value="10.14.88.53">10.14.88.53</option>
                        </select>
                    </div>
            </div>
                    <p>add other information</p>
<!--
					<div class="form-group">
						<label>Description</label>
						<input type="text" name="descr" ng-model="descr" placeholder= "Project/owner or IT- from jira" required class="form-control" />
					</div>
-->
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="descr" ng-model="descr" placeholder= "Project/owner or IT- from jira" required class="form-control" ></textarea>
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
		$http.get('fetch_accounts_data.php').success(function(data){
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
		$scope.modalTitle = 'Add Account';
		$scope.submit_button = 'Insert';
		$scope.account = '';
		$scope.fullname = '';
		$scope.department = '';
		$scope.ip = '';
		$scope.vlan = '';
		$scope.server = '';
		$scope.device = '';
		$scope.dns = '';
		$scope.net = '';
		$scope.subnet = '';
		$scope.descr = '';
		$scope.state = 'enable';
		$scope.openModal();
	};

	$scope.submitForm = function(){
		$http({
			method:"POST",
			url:"insert_accounts.php",
			data:{'account':$scope.account,'fullname':$scope.fullname,'department':$scope.department,'ip':$scope.ip,'vlan':$scope.vlan,'server':$scope.server,'device':$scope.device,'dns':$scope.dns,'net':$scope.net,'subnet':$scope.subnet,'descr':$scope.descr,'state':$scope.state,'change_by':$scope.change_by,'action':$scope.submit_button,'id':$scope.hidden_id}
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
			url:"insert_accounts.php",
			data:{'id':id, 'action':'fetch_single_data'}
		}).success(function(data){
			$scope.account = data.account;
			$scope.fullname = data.fullname;
			$scope.department = data.department;
			$scope.ip = data.ip;
			$scope.vlan = data.vlan;
			$scope.server = data.server;
			$scope.device = data.device;
			$scope.dns = data.dns;
			$scope.net = data.net;
			$scope.subnet = data.subnet;
			$scope.descr = data.descr;
			$scope.state = data.state;
			$scope.add_date = data.add_date;
			$scope.upd_date = data.upd_date;
			$scope.change_by = data.change_by;
			$scope.hidden_id = id;
			$scope.modalTitle = 'Edit Account';
			$scope.submit_button = 'Edit';
			$scope.openModal();
		});
	};

	$scope.deleteData = function(id){
		if(confirm("Are you sure you want to remove it?"))
		{
			$http({
				method:"POST",
				url:"insert_accounts.php",
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