angular.module('app', ['ngRoute', 'ngMaterial', 'carRentalApp']);

angular.module('carRentalApp', ['ngRoute']);

angular.module('app').config(function ($routeProvider) {
    $routeProvider
        .when('/vehicles', {
            templateUrl: 'app/components/vehicle-list/vehicle-list.template.html',
            controller: 'VehicleListController'
        })
        .when('/vehicles/add', {
            templateUrl: 'app/components/vehicle-form/vehicle-form.template.html',
            controller: 'VehicleFormController'
        })
        .when('/vehicles/edit/:id', {
            templateUrl: 'app/components/vehicle-form/vehicle-form.template.html',
            controller: 'VehicleFormController'
        })
        .otherwise({
            redirectTo: '/vehicles'
        });
});
