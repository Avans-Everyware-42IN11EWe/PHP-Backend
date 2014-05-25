/**
 * Created by nanne on 24-05-14.
 */

var glasApp = angular.module('glasApp', ['ngRoute']);

glasApp.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider.
            when('/dashboard', {
                templateUrl: 'views/dashboard.html',
                controller: 'DashboardCtl'
            }).
            otherwise({
                redirectTo: '/dashboard'
            });
    }]);

glasApp.controller('DashboardCtl', function ($scope) {
    $scope.phones = [
        {'name': 'Nexus S',
            'snippet': 'Fast just got faster with Nexus S.',
            'age': 1},
        {'name': 'Motorola XOOM™ with Wi-Fi',
            'snippet': 'The Next, Next Generation tablet.',
            'age': 2},
        {'name': 'MOTOROLA XOOM™',
            'snippet': 'The Next, Next Generation tablet.',
            'age': 3}
    ];

    $scope.orderProp = 'age';
});
