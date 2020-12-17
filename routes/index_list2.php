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
                        <li><a href="/accesslist/index_list.php">List All Access</a></li>
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

    <form name="testform" ng-submit="insertData()">
<!--    <div align="right" style="float: right; z-index: 999; position: relative;">-->
<!--        <button type="button" name="add_button" ng-click="addData()" class="btn btn-success" style="background-color:#0BB6C1;"  >Create Accounts</button>-->
<!--    </div>-->
<!--    <br />-->

        <h6 align="center" style="color:#4682B4;">All Route List</h6>
    <td class="table-responsive" style="overflow-x: unset;">
        <table datatable="ng" dt-options="vm.dtOptions" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Num</th>
                <th>Account</th>
                <th>Destination IP</th>
                <th>Destination Mask</th>
                <th>Description</th>
                <th>State</th>
                <th>Add Date</th>
                <th>Update Date</th>
                <th>Change By</th>
                <th>Action Row</th>
            </tr>
            </thead>

    <tbody>
    <tr ng-repeat="data in namesData" ng-include="getTemplate(data)">
    </tr>

    <script type="text/ng-template" id="display">
        <td width="5%">{{data.number}}</td>
        <td>{{data.account}}</td>
        <td width="10%"> {{data.dst_ip}}</td>
        <td width="10%">{{data.dst_mask}}</td>
        <td>{{data.descr}}</td>
        <td width="5%"><span class="label" ng-class="{'label-success': data.state == 'enable', 'label-default': data.state == 'disable', 'label-danger': data.state == 'norout'}">{{data.state}}</span></td>
        <td width="10%">{{data.add_date}}</td>
        <td width="10%">{{data.upd_date}}</td>
        <td width="7%">{{data.change_by}}</td>
        <td width="7%">
            <button type="button" class="btn btn-info btn-xs" ng-click="showEdit(data)">Edit</button>
            <button type="button" class="btn btn-warning btn-xs" ng-click="deleteData(data.id)">Delete</button>
        </td>
    </script>
    <script type="text/ng-template" id="edit">
        <td><input type="text" ng-model="formData.number" class="form-control form-control-sm" readonly /></td>
        <td><input type="text" ng-model="formData.account" class="form-control form-control-sm" readonly /></td>
        <td><input type="text" ng-model="formData.dst_ip" class="form-control form-control-sm" /></td>
        <td><input type="text" ng-model="formData.dst_mask" class="form-control form-control-sm" /></td>
        <td><input type="text" ng-model="formData.descr" class="form-control form-control-sm" /></td>
        <td><select type="text" ng-model="formData.state" class="form-control form-control-sm" ><option>enable</option><option>disable</option><option>norout</option></select></td>
        <td><input type="text" ng-model="formData.add_date" class="form-control form-control-sm" readonly /></td>
        <td><input type="text" ng-model="formData.upd_date" class="form-control form-control-sm" readonly /></td>
        <td><input type="text" ng-model="formData.change_by" class="form-control form-control-sm" readonly /></td>

        <td>
            <input type="hidden" ng-model="formData.data.id" />
            <button type="button" class="btn btn-info btn-xs" ng-click="editData()">Save</button>
            <button type="button" class="btn btn-default btn-xs" ng-click="reset()">Cancel</button>
        </td>
    </script>



    </tbody>
    </form>


</div>
</body>
</html>










<script>

var app = angular.module('iamApp', ['datatables']);
app.controller('iamController', function($scope, $http) {


// for modal access
    $scope.formData = {};
    $scope.addAccessData = {};
    $scope.success = false;
    $scope.error = false;

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
    // $scope.insertData = function(){
    //     $http({
    //         method:"POST",
    //         url:"insert.php",
    //         data:$scope.addData,
    //     }).success(function(data){
    //         $scope.success = true;
    //         $scope.successMessage = data.message;
    //         $scope.fetchData();
    //         $scope.addData = {};
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

    $scope.showEdit = function(data) {
        $scope.formData = angular.copy(data);
    };


    $scope.editData = function(){
        $http({
            method:"POST",
            url:"edit.php",
            data:$scope.formData,
        }).success(function(data){
            $scope.success = true;
            $scope.successMessage = data.message;
            $scope.fetchData();
            $scope.formData = {};
        });
    };


     // $scope.editData = function(){
     //    $http({
     //        method:"POST",
     //        url:"edit.php",
     //        data:$scope.formData,
     //    }).success(function(data){
     //        $scope.success = true;
     //        $scope.successMessage = data.message;
     //        //$scope.fetchData('accesslist');
     //        //$scope.fetchSingleAccess();
     //        $scope.fetchSingleAccess($scope.formData.account_id);
     //        $scope.formData = {};
     //    });
     // };


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
                url:"delete.php",
                data:{'id':id}
            }).success(function(data){
                $scope.success = true;
                $scope.successMessage = data.message;
                $scope.fetchData('accesslist');
            });
        }
    };








});


</script>

