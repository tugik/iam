<?php
//include("../auth.php");
session_start();
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit(); }
?>
<html>
<head>
    <title>Routes List from ALL Accounts</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js"></script>
</head>
<body>
<div class="container">
    <br />
    <h3 align="center">Routes List from ALL Accounts</h3><br />
    <div class="table-responsive" ng-app="liveApp" ng-controller="liveController" ng-init="fetchData()">
        <div class="alert alert-success alert-dismissible" ng-show="success" >
            <a href="#" class="close" data-dismiss="alert" ng-click="closeMsg()" aria-label="close">&times;</a>
            {{successMessage}}
        </div>
        <form name="testform" ng-submit="insertData()">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Account</th>
                    <th>Destination IP</th>
                    <th>Destination Mask</th>
                    <th>Description</th>
                    <th>State</th>
                    <th>Add Date</th>
                    <th>Update Date</th>
                    <th>Change By</th>
<!--                    <th>Action</th> -->
                </tr>
                </thead>
                <tbody>
<!--                <tr>
                    <td><input type="text" ng-model="addData.dst_ip" class="form-control" placeholder="Enter Dst IP" ng-required="true" /></td>
                    <td><input type="text" ng-model="addData.dst_mask" class="form-control" placeholder="Enter Dst Mask" ng-required="true" /></td>
                    <td><input type="text" ng-model="addData.descr" class="form-control" placeholder="Enter Description" ng-required="true" /></td>
                    <td><input type="text" ng-model="addData.add_data" class="form-control" placeholder="auto" ng-required="true" /></td>
                    <td><input type="text" ng-model="addData.upd_date" class="form-control" placeholder="auto" ng-required="true" /></td>
                    <td><input type="text" ng-model="addData.change_by" class="form-control" placeholder="auto" ng-required="true" /></td>
                    <td><button type="submit" class="btn btn-success btn-sm" ng-disabled="testform.$invalid">Add</button></td>
                </tr>
-->
                <tr ng-repeat="data in namesData" ng-include="getTemplate(data)">
                </tr>
                </tbody>
            </table>
        </form>
        <script type="text/ng-template" id="display">
            <td>{{data.account}}</td>
            <td>{{data.dst_ip}}</td>
            <td>{{data.dst_mask}}</td>
            <td>{{data.descr}}</td>
            <td>{{data.state}}</td>
            <td>{{data.add_date}}</td>
            <td>{{data.upd_date}}</td>
            <td>{{data.change_by}}</td>
<!---            <td>
                <button type="button" class="btn btn-primary btn-sm" ng-click="showEdit(data)">Edit</button>
                <button type="button" class="btn btn-danger btn-sm" ng-click="deleteData(data.id)">Delete</button>
            </td>
-->
        </script>
        <script type="text/ng-template" id="edit">
            <td><input type="text" ng-model="formData.account" class="form-control" /></td>
            <td><input type="text" ng-model="formData.dst_ip" class="form-control" /></td>
            <td><input type="text" ng-model="formData.dst_mask" class="form-control" /></td>
            <td><input type="text" ng-model="formData.descr" class="form-control" /></td>
            <td><input type="text" ng-model="formData.state" class="form-control" /></td>
            <td><input type="text" ng-model="formData.add_date" class="form-control" /></td>
            <td><input type="text" ng-model="formData.upd_date" class="form-control" /></td>
            <td><input type="text" ng-model="formData.change_by" class="form-control" /></td>
            <td>
                <input type="hidden" ng-model="formData.data.id" />
                <button type="button" class="btn btn-info btn-sm" ng-click="editData()">Save</button>
                <button type="button" class="btn btn-default btn-sm" ng-click="reset()">Cancel</button>
            </td>
        </script>
    </div>
</div>
</body>
</html>
<script>
    var app = angular.module('liveApp', []);

    app.controller('liveController', function($scope, $http){

        $scope.formData = {};
        $scope.addData = {};
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

        $scope.fetchData = function(){
            $http.get('select.php').success(function(data){
                $scope.namesData = data;
            });
        };

        $scope.insertData = function(){
            $http({
                method:"POST",
                url:"insert.php",
                data:$scope.addData,
            }).success(function(data){
                $scope.success = true;
                $scope.successMessage = data.message;
                $scope.fetchData();
                $scope.addData = {};
            });
        };

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
                    $scope.fetchData();
                });
            }
        };

    });

</script>
