<?php
//include("../auth.php");
session_start();
if(!isset($_SESSION["username"])){
    header("Location: /login.php");
    exit(); }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>IAM</title>
    <script src="/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
    <script src="/jquery.dataTables.min.js"></script>
    <script src="/angular-datatables.min.js"></script>
    <script src="/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/bootstrap.min.css">
    <link rel="stylesheet" href="/datatables.bootstrap.css">

    <style>
        .dataTables_filter { margin-top: -1em; padding-right: 1em; }
        .container { width: 100%; }
        body { padding-top: 60px; }
    </style>
</head>
<body data-ng-app="iamApp" data-ng-controller="iamController"  >


<nav class="navbar navbar-default navbar-fixed-top"  style="background-color:#f5f7fa;"  >
    <div class="container-fluid">
        <div class="navbar-header">
            <span class="icon-bar"></span>
            <img alt="IAM" src="/main-logo.png" width="170" height="50">
            <!--        <a class="navbar-brand" href="#">IAM</a>-->
        </div>
        <p class="navbar-text">Identity and Access Management</p>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/logout.php">logout</a></li>
                <li><a href="/index_user.php">users</a></li>
                <li class="active"><a href="/index_accounts.php">accounts <span class="sr-only">(current)</span></a></li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">list<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/accesslist/index_list2.php">List All Access</a></li>
                        <li><a href="/routes/index_list.php">List All Routes</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/version.php" target="_blank">Version Info</a></li>
                    </ul>
                </li>

        </div>
    </div>
</nav>



<div class="container" data-ng-init="fetchData('accesslist')">
    <div class="alert alert-success alert-dismissible" data-ng-show="success" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{successMessage}}
    </div>
    <!--			<div align="right">
     -->
    <!--				<button type="button" name="add_button" ng-click="addData()" class="btn btn-success">Add Accounts</button>
     -->

<!--    <div align="right" style="float: right; z-index: 999; position: relative;">-->
<!--        <button type="button" name="add_button" ng-click="addData()" class="btn btn-success" style="background-color:#0BB6C1;"  >Create Accounts</button>-->
<!--    </div>-->
<!--    <br />-->
    <h6 align="center" style="color:#4682B4;">All Access List</h6>
    <td class="table-responsive" style="overflow-x: unset;">
        <table datatable="ng" dt-options="vm.dtOptions" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Num</th>
                <th>Account</th>
                <th>Protocol</th>
                <th>Source IP</th>
                <th>Destination IP</th>
                <th>Destination Port</th>
                <th>Description</th>
                <th>State</th>
                <th>Add Date</th>
                <th>Update Date</th>
                <th>Change By</th>
<!--                <th>Action row</th>-->
            </tr>
            </thead>
            <tbody>
            <tr data-ng-repeat="data in namesData">
                <td>{{data.number}}</td>
                <td>{{data.account}}</td>
                <td width="5%">{{data.proto}}</td>
                <td width="10%">{{data.ip}}</td>
                <td width="10%">{{data.dst_ip}}</td>
                <td width="8%">{{data.dst_port}}</td>
                <td>{{data.descr}}</td>
                <td width="5%"><span class="label" ng-class="{'label-success': data.state == 'enable', 'label-default': data.state == 'disable'}">{{data.state}}</span></td>
                <td width="10%">{{data.add_date}}</td>
                <td width="10%">{{data.upd_date}}</td>
                <td width="7%">{{data.change_by}}</td
            </tr>
            </tbody>
        </table>
</div>

</div>
</body>
</html>










<script>

var app = angular.module('iamApp', ['datatables']);
app.controller('iamController', function($scope, $http) {

        $scope.success = false;
        $scope.error = false;

// for modal access
    $scope.formData = {};
    $scope.addAccessData = {};
    $scope.success = false;

    // $scope.getTemplate = function(data){
    //     if (data.id === $scope.formData.id)
    //     {
    //         return 'edit';
    //     }
    //     else
    //     {
    //         return 'display';
    //     }
    // };

    $scope.fetchData = function(data){
        $http.get('select.php').success(function(data){
            $scope.namesData = data;
        });
    };

    // $scope.fetchSingleAccess = function(id,fullname){
    //     $scope.addAccessData.account_id = id;
    //     $http({
    //         method:"POST",
    //         url:"select_single_data.php",
    //         data:{'id':id, 'action':'fetch_single_access'}
    //     }).success(function(data){
    //         //console.log(data)
    //         $scope.modalTitle = 'Access List  - ';
    //         if (fullname !== undefined) {
    //             $scope.modalShowName = fullname;
    //         }
    //         $scope.accesslistData=data;
    //         $scope.openModal('accesslist');
    //     });
    // };
    //
    //  $scope.insertAclData = function(){
    //     $http({
    //         method:"POST",
    //         url:"insert.php",
    //         data:$scope.addAccessData,
    //     }).success(function(data){
    //         $scope.success = true;
    //         $scope.successMessage = data.message;
    //         //$scope.fetchData('accesslist');
    //         $scope.addAccessData = {account_id: $scope.addAccessData.account_id};
    //         $scope.fetchSingleAccess($scope.addAccessData.account_id);
    //     });
    // };
    //
    // $scope.showEdit = function(data) {
    //     $scope.formData = angular.copy(data);
    // };
    //
    //  $scope.editData = function(){
    //     $http({
    //         method:"POST",
    //         url:"edit.php",
    //         data:$scope.formData,
    //     }).success(function(data){
    //         $scope.success = true;
    //         $scope.successMessage = data.message;
    //         //$scope.fetchData('accesslist');
    //         //$scope.fetchSingleAccess();
    //         $scope.fetchSingleAccess($scope.formData.account_id);
    //         $scope.formData = {};
    //     });
    // };
    //
    // $scope.reset = function(){
    //     $scope.formData = {};
    // };
    //
    // $scope.closeMsg = function(){
    //     $scope.success = false;
    // };
    //
    // $scope.deleteData = function(id){
    //     if(confirm("Are you sure you want to remove it?"))
    //     {
    //         $http({
    //             method:"POST",
    //             url:"delete.php",
    //             data:{'id':id}
    //         }).success(function(data){
    //             $scope.success = true;
    //             $scope.successMessage = data.message;
    //             $scope.fetchData('accesslist');
    //         });
    //     }
    // };
    //
    //






});


</script>

