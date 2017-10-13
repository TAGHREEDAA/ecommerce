/**
 * Created by root on 08/10/17.
 */


// public/js/controllers/mainCtrl.js

angular.module('mainCtrl', [])

// inject the Category service into our controller
    .controller('mainController', function($scope, $http, Category) {
        // object to hold all the data for the new Category form
        $scope.categoryData = {};

        // loading variable to show the spinning loading icon
        $scope.loading = true;

        // get all the categories first and bind it to the $scope.categories object
        // use the function we created in our service
        // GET ALL CATEGORIES ==============
        Category.get()
            .success(function(data) {
                $scope.categories = data;
                $scope.loading = false;
            });

        // function to handle submitting the form
        // SAVE A Category ================
        $scope.submitCategory = function() {
            $scope.loading = true;

            // save the Category. pass in Category data from the form
            // use the function we created in our service
            Category.save($scope.categoryData)
                .success(function(data) {

                    // if successful, we'll need to refresh the category list
                    Category.get()
                        .success(function(getData) {
                            $scope.categories = getData;
                            $scope.loading = false;
                        });

                })
                .error(function(data) {
                    console.log(data);
                });
        };

        // function to handle deleting a category
        // DELETE A CATEGORY ====================================================
        $scope.deleteCategory = function(id) {
            $scope.loading = true;

            // use the function we created in our service
            Category.destroy(id)
                .success(function(data) {

                    // if successful, we'll need to refresh the category list
                    Category.get()
                        .success(function(getData) {
                            $scope.categories = getData;
                            $scope.loading = false;
                        });

                });
        };

    });
