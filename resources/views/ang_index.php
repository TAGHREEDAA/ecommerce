<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 08/10/17
 * Time: 12:29 ص
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel and Angular Categories Page</title>

    <!-- CSS -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
    <style>
        body        { padding-top:30px; }
        form        { padding-bottom:20px; }
        .category    { padding-bottom:20px; }
    </style>

    <!-- JS -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.8/angular.min.js"></script>
    <script src="http://code.angularjs.org/1.2.3/angular-route.js"></script>

    <!-- ANGULAR -->
    <!-- all angular resources will be loaded from the /public folder -->
        <script src="js/controllers/mainCtrl.js"></script>
        <script src="js/services/categoryService.js"></script>
        <script src="js/angularApp.js"></script>

</head>
<body class="container" ng-app="categoryApp" ng-controller="mainController"> <div class="col-md-8 col-md-offset-2">

    <div class="page-header">
        <h2>Laravel and Angular Single Page Application</h2>
        <h4>Category System</h4>
        {{test}}
    </div>

    <form ng-submit="submitCategory()"> <!-- ng-submit will disable the default form action and use our function -->

        <div class="form-group">
            <input type="text" class="form-control input-sm" name="name" ng-model="categoryData.name" placeholder="Name">
        </div>

        <div class="form-group">
            <input type="text" class="form-control input-lg" name="description" ng-model="categoryData.description" placeholder="Description">
        </div>

        <div class="form-group text-right">
            <button type="submit" class="btn btn-primary btn-lg">Submit</button>
        </div>
    </form>

    <!-- LOADING ICON =============================================== -->
    <!-- show loading icon if the loading variable is set to true -->
    <p class="text-center" ng-show="loading"><span class="fa fa-meh-o fa-5x fa-spin"></span></p>

    <!-- THE CATEGORIES =============================================== -->
    <!-- hide these categories if the loading variable is true -->
    <div class="category" ng-hide="loading" ng-repeat="category in categories">
        <h3>Category #{{ category.id }} <small> {{ category.name }}</h3>
        <p>{{ category.description }}</p>

        <p><a href="#" ng-click="deleteCategory(category.id)" class="text-muted">Delete</a></p>
    </div>

</div>
</body>
</html>