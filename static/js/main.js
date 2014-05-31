/**
 * Created by nanne on 24-05-14.
 */

var glasApp = angular.module('glasApp', ['ngRoute', 'leaflet-directive']);

glasApp.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider
            .when('/dashboard', {
                templateUrl: 'views/dashboard.html',
                controller: 'DashboardCtl'
            })
            .when('/wijken', {
                templateUrl: 'views/wijken.html',
                controller: 'WijkCtl'
            })
            .otherwise({
                redirectTo: '/dashboard'
            });
    }]);

glasApp.controller('DashboardCtl', function ($scope) {

});

glasApp.controller('WijkCtl', function ($scope) {
    var map = L.mapbox.map('map', 'nanne.i84f0he3');
});
