/**
 * Created by root on 08/10/17.
 */

// public/js/angularApp.js

var categoryApp = angular.module('categoryApp', ['mainCtrl', 'categoryService','ngRoute']);
var productApp = angular.module('productApp', ['mainCtrl', 'productService']);


// configure our routes
categoryApp.config(function($routeProvider) {
    $routeProvider

        // route for the home page
        .when('/', {
            templateUrl : 'views/ang_index.php',
            controller  : 'mainController'
        })
});
