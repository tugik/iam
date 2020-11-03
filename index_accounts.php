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
	<body data-ng-app="iamApp" data-ng-controller="iamController">
		

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

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">list<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="./accesslist/index.php">All Access List</a></li>
                    <li><a href="./routes/index.php">All Routes</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="version.php">Version Info</a></li>
                </ul>
            </li>

    </div>
 </div>
</nav>

		<div class="container" data-ng-init="fetchData('accounts')">
			<div class="alert alert-success alert-dismissible" data-ng-show="success" >
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{successMessage}}
			</div>
<!--			<div align="right">
 -->
<!--				<button type="button" name="add_button" ng-click="addData()" class="btn btn-success">Add Accounts</button>
 -->

			<div align="right" style="float: right; z-index: 999; position: relative;">
				<button type="button" name="add_button" ng-click="addData()" class="btn btn-success">Create Accounts</button>
			</div>
			<br />

			<div class="table-responsive" style="overflow-x: unset;">
				<table datatable="ng" dt-options="vm.dtOptions" class="table table-bordered table-striped">
					<thead>
						<tr>
						    <th>Account</th>
						    <th>Full Name</th>
                            <th>Department</th>
						    <th> </th>
						    <th>IP</th>
                            <th>Vlan</th>
						    <th>Server</th>
						    <th>Device</th>

<!--						<th>dns</th>
							<th>net</th>
							<th>subnet</th>
-->
						    <th>Description</th>
						    <th>State</th>
						    <th>Add Date</th>
						    <th>Update Date</th>
						    <th>Change By</th>
                            <th>Routes</th>
						    <th>Access List</th>
                            <th>Edit</th>
						    <th>Delete</th>
						</tr>
					</thead>
				<tbody>
				<tr data-ng-repeat="name in namesData">
				    <td><b>{{name.account}}</b></td>
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
				    <td><button type="button" ng-click="fetchSingleRoutes(name.id,name.fullname)" class="btn btn-info btn-xs">Routes</button></td>
                    <td><button type="button" ng-click="fetchSingleAccess(name.id,name.fullname)" class="btn btn-primary btn-xs">Access List</button></td>
                    <td><button type="button" ng-click="fetchSingleData(name.id)" class="btn btn-warning btn-xs">Edit</button></td>
				    <td><button type="button" ng-click="deleteData(name.id)" class="btn btn-danger btn-xs">Delete</button></td>
                </tr>
                </tbody>
				</table>
			</div>

		</div>
	</body>
</html>

<div class="modal fade" tabindex="-1" role="dialog" id="accountmodal">
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






 <div class="modal fade" tabindex="-1" role="dialog" id="accesslist">
    <div class="modal-dialog" role="document" style="width: 90% ">
        <div class="modal-content">
            <form method="post" ng-submit="insertAclData()">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{modalTitle}} <b>{{modalShowName}}</b></h4>
                </div>

                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible" ng-show="error" >
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{errorMessage}}
                    </div>




                    <form name="testform" ng-submit="insertData()">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Protocol</th>
                                <th>Source IP</th>
                                <th>Destination IP</th>
                                <th>Destination Port</th>
                                <th>Description</th>
                                <th>State</th>
                                <th>Add Date</th>
                                <th>Update Date</th>
                                <th>Change By</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <select ng-model="addAccessData.proto" class="form-control" ng-required="true">
                                        <option selected>tcp</option>
                                        <option>all</option>
                                        <option>udp</option>
                                    </select>
                                </td>
                                <td><input type="text" ng-model="addAccessData.ip" class="form-control" placeholder="Account IP" ng-required="true" readonly /></td>
                                <td><input type="text" ng-model="addAccessData.dst_ip" class="form-control" placeholder="Enter Dst IP" ng-required="true" /></td>
                                <td><input type="text" ng-model="addAccessData.dst_port" class="form-control" placeholder="Enter any, 443, etc..." ng-required="true" /></td>
                                <td><input type="text" ng-model="addAccessData.descr" class="form-control" placeholder="Enter Description" ng-required="true" /></td>
                                <td><select type="text" ng-model="addAccessData.state" class="form-control" ng-required="true"><option selected>enable</option><option>disable</option></select></td>
                                <td><input type="text" ng-model="addAccessData.add_data" class="form-control" placeholder="auto" ng-required="true" readonly /></td>
                                <td><input type="text" ng-model="addAccessData.upd_date" class="form-control" placeholder="auto" ng-required="true" readonly /></td>
                                <td><input type="text" ng-model="addAccessData.change_by" class="form-control" placeholder="auto" ng-required="true" readonly /></td>
                                <td><button type="submit" class="btn btn-sm btn-success " ng-disabled="testform.$invalid"> Add  IP  rule</button></td>
                            </tr>
                            <tr ng-repeat="data in accesslistData" ng-include="getTemplate(data)">
                            </tr>

                            </tbody>
                        </table>
                    </form>
                    <script type="text/ng-template" id="display">
                        <td>{{data.proto}}</td>
                        <td>{{data.ip}}</td>
                        <td>{{data.dst_ip}}</td>
                        <td>{{data.dst_port}}</td>
                        <td>{{data.descr}}</td>
<!--                        <td>{{data.state}}</td> -->
                        <td><span class="label" ng-class="{'label-success': data.state == 'enable', 'label-default': data.state == 'disable'}">{{data.state}}</span></td>
                        <td>{{data.add_date}}</td>
                        <td>{{data.upd_date}}</td>
                        <td>{{data.change_by}}</td>
                        <td nowrap>
                            <button type="button" class="btn  btn-xs btn-primary btn-sm" ng-click="showEdit(data)">Edit</button>
                            <button type="button" class="btn btn-xs btn-danger btn-sm" ng-click="deleteData(data.id)">Delete</button>
                        </td>
                    </script>
                    <script type="text/ng-template" id="edit">
                        <td><select type="text" ng-model="formData.proto" class="form-control form-control-sm"><option>tcp</option><option>all</option>><option>udp</option></select></td>
                        <td><input type="text" ng-model="formData.ip" class="form-control form-control-sm" readonly /></td>
                        <td><input type="text" ng-model="formData.dst_ip" class="form-control form-control-sm" /></td>
                        <td><input type="text" ng-model="formData.dst_port" class="form-control form-control-sm" /></td>
                        <td><input type="text" ng-model="formData.descr" class="form-control form-control-sm" /></td>
                        <td><select type="text" ng-model="formData.state" class="form-control form-control-sm" ><option>enable</option><option>disable</option></select></td>
                        <td><input type="text" ng-model="formData.add_date" class="form-control form-control-sm" readonly /></td>
                        <td><input type="text" ng-model="formData.upd_date" class="form-control form-control-sm" readonly /></td>
                        <td><input type="text" ng-model="formData.change_by" class="form-control form-control-sm" readonly /></td>
                        <td nowrap>
                            <input type="hidden" ng-model="formData.data.id" />
                            <button type="button" class="btn btn-info btn-sm" ng-click="editData()">Save</button>
                            <button type="button" class="btn btn-default btn-sm" ng-click="reset()">Cancel</button>
                        </td>
                    </script>





                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" value="{{hidden_id}}" />
<!--                    <input type="submit" name="submit" id="submit" class="btn btn-info" value="{{submit_button}}" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
-->
                </div>
            </form>
        </div>
    </div>
</div>








<div class="modal fade" tabindex="-1" role="dialog" id="routes">
    <div class="modal-dialog" role="document" style="width: 70% ">
        <div class="modal-content">
            <form method="post" ng-submit="insertRoutesData()">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{modalTitle}} <b>{{modalShowName}}</b></h4>
                </div>

                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible" ng-show="error" >
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{errorMessage}}
                    </div>




                    <form name="testform" ng-submit="insertRoutesData()">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Destination IP</th>
                                <th>Destination Mask</th>
                                <th>Description</th>
                                <th>State</th>
                                <th>Add Date</th>
                                <th>Update Date</th>
                                <th>Change By</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><input type="text" ng-model="addRoutesData.dst_ip" class="form-control" placeholder="Enter Dst IP" ng-required="true" /></td>
                                <td><input type="text" ng-model="addRoutesData.dst_mask" class="form-control" placeholder="Enter Dst Mask" ng-required="true" /></td>
                                <td><input type="text" ng-model="addRoutesData.descr" class="form-control" placeholder="Enter Description" ng-required="true" /></td>
                                <td><select type="text" ng-model="addRoutesData.state" class="form-control" ng-required="true"><option selected>enable</option><option>disable</option></select></td>
                                <td><input type="text" ng-model="addRoutesData.add_data" class="form-control" placeholder="auto" ng-required="true" readonly /></td>
                                <td><input type="text" ng-model="addRoutesData.upd_date" class="form-control" placeholder="auto" ng-required="true" readonly /></td>
                                <td><input type="text" ng-model="addRoutesData.change_by" class="form-control" placeholder="auto" ng-required="true" readonly /></td>
                                <td><button type="submit" class="btn btn-sm btn-success " ng-disabled="testform.$invalid"> Add Routs</button></td>
                            </tr>
                            <tr ng-repeat="data in routesListData" ng-include="getTemplateRoutes(data)">
                            </tr>

                            </tbody>
                        </table>
                    </form>
                    <script type="text/ng-template" id="displayRoutes">
                        <td>{{data.dst_ip}}</td>
                        <td>{{data.dst_mask}}</td>
                        <td>{{data.descr}}</td>
                        <!--                        <td>{{data.state}}</td> -->
                        <td><span class="label" ng-class="{'label-success': data.state == 'enable', 'label-default': data.state == 'disable'}">{{data.state}}</span></td>
                        <td>{{data.add_date}}</td>
                        <td>{{data.upd_date}}</td>
                        <td>{{data.change_by}}</td>
                        <td nowrap>
                            <button type="button" class="btn  btn-xs btn-primary btn-sm" ng-click="showRoutesEdit(data)">Edit</button>
                            <button type="button" class="btn btn-xs btn-danger btn-sm" ng-click="deleteRoutesData(data.id)">Delete</button>
                        </td>
                    </script>
                    <script type="text/ng-template" id="editRoutes">
                        <td><input type="text" ng-model="formRoutesData.dst_ip" class="form-control" /></td>
                        <td><input type="text" ng-model="formRoutesData.dst_mask" class="form-control" /></td>
                        <td><input type="text" ng-model="formRoutesData.descr" class="form-control" /></td>
                        <td><select type="text" ng-model="formRoutesData.state" class="form-control" ><option>enable</option><option>disable</option></select></td>
                        <td><input type="text" ng-model="formRoutesData.add_date" class="form-control" readonly /></td>
                        <td><input type="text" ng-model="formRoutesData.upd_date" class="form-control" readonly /></td>
                        <td><input type="text" ng-model="formRoutesData.change_by" class="form-control" readonly /></td>
                        <td nowrap>
                            <input type="hidden" ng-model="formRoutesData.data.id" />
                            <button type="button" class="btn btn-info btn-sm" ng-click="editRoutesData()">Save</button>
                            <button type="button" class="btn btn-default btn-sm" ng-click="resetRoutes()">Cancel</button>
                        </td>
                    </script>


                </div>
        </div>
        <div class="modal-footer">
            <input type="hidden" name="hidden_id" value="{{hidden_id}}" />
            <!--                    <input type="submit" name="submit" id="submit" class="btn btn-info" value="{{submit_button}}" />
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            -->
        </div>
        </form>
    </div>
</div>
</div>



















<script>

var app = angular.module('iamApp', ['datatables']);
app.controller('iamController', function($scope, $http) {

        $scope.success = false;
        $scope.error = false;

        $scope.fetchData = function (type) {
            $http.get('fetch_' + type + '_data.php').success(function (data) {
                $scope.namesData = data;
            });
        };

        $scope.openModal = function (modal) {
            var modal_popup = angular.element('#' + modal);
            modal_popup.modal('show');
        };

        $scope.closeModal = function (modal) {
            var modal_popup = angular.element('#' + modal);
            modal_popup.modal('hide');
        };


        $scope.addData = function () {
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
            $scope.openModal('accountmodal');
        };

        $scope.submitForm = function () {
            $http({
                method: "POST",
                url: "insert_accounts.php",
                data: {
                    'account': $scope.account,
                    'fullname': $scope.fullname,
                    'department': $scope.department,
                    'ip': $scope.ip,
                    'vlan': $scope.vlan,
                    'server': $scope.server,
                    'device': $scope.device,
                    'dns': $scope.dns,
                    'net': $scope.net,
                    'subnet': $scope.subnet,
                    'descr': $scope.descr,
                    'state': $scope.state,
                    'change_by': $scope.change_by,
                    'action': $scope.submit_button,
                    'id': $scope.hidden_id
                }
            }).success(function (data) {
                if (data.error != '') {
                    $scope.success = false;
                    $scope.error = true;
                    $scope.errorMessage = data.error;
                } else {
                    $scope.success = true;
                    $scope.error = false;
                    $scope.successMessage = data.message;
                    $scope.form_data = {};
                    $scope.closeModal('accountmodal');
                    $scope.fetchData('accounts');
                }
            });
        };

        $scope.fetchSingleData = function (id) {

            $http({
                method: "POST",
                url: "insert_accounts.php",
                data: {'id': id, 'action': 'fetch_single_data'}
            }).success(function (data) {
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
                $scope.openModal('accountmodal');
            });
        };

        $scope.deleteData = function (id) {
            if (confirm("Are you sure you want to remove it?")) {
                $http({
                    method: "POST",
                    url: "insert_accounts.php",
                    data: {'id': id, 'action': 'Delete'}
                }).success(function (data) {
                    $scope.success = true;
                    $scope.error = false;
                    $scope.successMessage = data.message;
                    $scope.fetchData('accounts');
                });
            }
        };




// for modal access
    $scope.formData = {};
    $scope.addAccessData = {};
    $scope.success = false;

    $scope.getTemplate = function(data){
        if (data.id === $scope.formData.id)
        {
            return 'edit';
        }
        else
        {
            return 'display';
        }
    };

    $scope.fetchSingleAccess = function(id,fullname){
        $scope.addAccessData.account_id = id;
        $http({
            method:"POST",
            url:"/accesslist/select_single_data.php",
            data:{'id':id, 'action':'fetch_single_access'}
        }).success(function(data){
            //console.log(data)
            $scope.modalTitle = 'Access List  - ';
            if (fullname !== undefined) {
                $scope.modalShowName = fullname;
            }
            $scope.accesslistData=data;
            $scope.openModal('accesslist');
        });
    };

    $scope.insertAclData = function(){
        $http({
            method:"POST",
            url:"/accesslist/insert.php",
            data:$scope.addAccessData,
        }).success(function(data){
            $scope.success = true;
            $scope.successMessage = data.message;
            //$scope.fetchData('accesslist');
            $scope.addAccessData = {account_id: $scope.addAccessData.account_id};
            $scope.fetchSingleAccess($scope.addAccessData.account_id);
        });
    };

    $scope.showEdit = function(data) {
        $scope.formData = angular.copy(data);
    };

    $scope.editData = function(){
        $http({
            method:"POST",
            url:"/accesslist/edit.php",
            data:$scope.formData,
        }).success(function(data){
            $scope.success = true;
            $scope.successMessage = data.message;
            //$scope.fetchData('accesslist');
            //$scope.fetchSingleAccess();
            $scope.fetchSingleAccess($scope.formData.account_id);
            $scope.formData = {};
        });
    };

    $scope.reset = function(){
        $scope.formData = {};
    };

    $scope.closeMsg = function(){
        $scope.success = false;
    };

    $scope.deleteData = function(id){
        if(confirm("Are you sure you want to remove it?"))
        {
            $http({
                method:"POST",
                url:"/accesslist/delete.php",
                data:{'id':id}
            }).success(function(data){
                $scope.success = true;
                $scope.successMessage = data.message;
                $scope.fetchData('accesslist');
            });
        }
    };





    // for modal routes
     $scope.formRoutesData = {};
     $scope.addRoutesData = {};
     $scope.success = false;

    $scope.getTemplateRoutes = function(data){
        if (data.id === $scope.formRoutesData.id)
        {
            return 'editRoutes';
        }
        else
        {
            return 'displayRoutes';
        }
    };

    $scope.fetchSingleRoutes = function(id,fullname){
        $scope.addRoutesData.account_id = id;
        $http({
            method:"POST",
            url:"/routes/select_single_data.php",
            data:{'id':id, 'action':'fetch_single_routes'}
        }).success(function(data){
            //console.log(data)
            $scope.modalTitle = 'Routes List  - ';
            if (fullname !== undefined) {
                $scope.modalShowName = fullname;
            }
            $scope.routesListData=data;
            $scope.openModal('routes');
        });
    };

    $scope.insertRoutesData = function(){
        $http({
            method:"POST",
            url:"/routes/insert.php",
            data:$scope.addRoutesData,
        }).success(function(data){
            $scope.success = true;
            $scope.successMessage = data.message;
            //$scope.fetchData('accesslist');
            $scope.addRoutesData = {account_id: $scope.addRoutesData.account_id};
            $scope.fetchSingleRoutes($scope.addRoutesData.account_id);
        });
    };

    $scope.showRoutesEdit = function(data) {
        $scope.formRoutesData = angular.copy(data);
    };

    $scope.editRoutesData = function(){
        $http({
            method:"POST",
            url:"/routes/edit.php",
            data:$scope.formRoutesData,
        }).success(function(data){
            $scope.success = true;
            $scope.successMessage = data.message;
            //$scope.fetchData('accesslist');
            //$scope.fetchSingleAccess();
            $scope.fetchSingleRoutes($scope.formRoutesData.account_id);
            $scope.formRoutesData = {};
        });
    };

    $scope.resetRoutes = function(){
        $scope.formRoutesData = {};
    };

    $scope.closeMsg = function(){
        $scope.success = false;
    };

    $scope.deleteRoutesData = function(id){
        if(confirm("Are you sure you want to remove it?"))
        {
            $http({
                method:"POST",
                url:"/routes/delete.php",
                data:{'id':id}
            }).success(function(data){
                $scope.success = true;
                $scope.successMessage = data.message;
                $scope.fetchRoutesData('routes');
            });
        }
    };




});


</script>

