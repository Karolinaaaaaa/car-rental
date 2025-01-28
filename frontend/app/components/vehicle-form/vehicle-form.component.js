angular.module('carRentalApp')
    .controller('VehicleFormController', function ($scope, $http, $location, $routeParams) {
        $scope.vehicle = {
            brand: '',
            registrationNumber: '',
            vin: '',
            email: '',
            address: {
              street: '',
              city: '',
              postalCode: '',
              country: 'Polska'
           },
            currentLocation: 'Lublin',
            isRented: false
        };

        $scope.hasError = false;
        $scope.errorMessage = '';

        const vehicleId = $routeParams.id;
        if (vehicleId) {
            $http.get(`http://localhost:8000/api/vehicles/${vehicleId}`)
                .then(function (response) {
                    $scope.vehicle = response.data;
                })
                .catch(function (error) {
                    console.error('Błąd podczas ładowania pojazdu:', error);
                    $scope.hasError = true;
                    $scope.errorMessage = 'Nie udało się załadować danych pojazdu. Spróbuj ponownie.';
                });
        }

        $scope.saveVehicle = function () {
            const apiUrl = vehicleId
                ? `http://localhost:8000/api/vehicles/${vehicleId}`
                : 'http://localhost:8000/api/vehicles';

            const httpMethod = vehicleId ? 'put' : 'post';

            $http[httpMethod](apiUrl, $scope.vehicle)
                .then(function () {
                    alert('Pojazd został zapisany.');
                    $location.path('/vehicles');
                })
                .catch(function (error) {
                    console.error('Błąd podczas zapisywania pojazdu:', error);
                    $scope.hasError = true;
                    $scope.errorMessage = 'Nie udało się zapisać pojazdu. Spróbuj ponownie.';
                });
        };

        $scope.cancel = function () {
            $location.path('/vehicles');
        };

        $scope.retrySaveVehicle = function () {
          $scope.hasError = false;
          $scope.saveVehicle();
      };
      
    });
