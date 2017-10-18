/**
 * Created by root on 08/10/17.
 */

// public/js/services/categoryService.js

angular.module('categoryService', [])

    .factory('Category', function($http) {

        return {
            // get all the categories
            get : function() {
                console.log('get all categories');
                return $http.get('./api/v1/category');
            },

            // show category details
            show : function(id) {
                console.log('get all categories');
                return $http.get('./api/v1/category/'+id);
            },

            // save a category (pass in category data)
            save : function(categoryData) {
                console.log('indide service save');
                return $http({
                    method: 'POST',
                    url: '/api/v1/category',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(categoryData)
                });
            },

            // destroy a category
            destroy : function(id) {
                console.log('delete');
                return $http.delete('/api/v1/category/' + id);
            }
        }

    });
