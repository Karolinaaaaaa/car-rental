angular.module('carRentalApp')
  .controller('VehicleListController', function ($scope, $location, $http) {
    $scope.vehicles = [];
    $scope.hasError = false;
    $scope.errorMessage = '';

    $scope.fetchVehicles = function () {
      $scope.hasError = false;
      $scope.errorMessage = '';
      $http.get('http://localhost:8000/api/vehicles')
        .then(function (response) {
          $scope.vehicles = response.data;
        })
        .catch(function (error) {
          console.error('Błąd podczas pobierania pojazdów:', error);
          $scope.hasError = true;
          $scope.errorMessage = 'Nie udało się załadować listy pojazdów. Spróbuj ponownie.';
        });
    };

    $scope.deleteVehicle = function (id) {
      if (confirm('Czy na pewno chcesz usunąć ten pojazd?')) {
        $http.delete(`http://localhost:8000/api/vehicles/${id}`)
          .then(function () {
            alert('Pojazd został usunięty.');
            $scope.vehicles = $scope.vehicles.filter(vehicle => vehicle.id !== id);
          })
          .catch(function (error) {
            console.error('Błąd podczas usuwania pojazdu:', error);
            $scope.hasError = true;
            $scope.errorMessage = 'Nie udało się usunąć pojazdu. Spróbuj ponownie.';
          });
      }
    };

    $scope.goToAddVehiclePage = function () {
      $location.path('/vehicles/add');
    };

    $scope.goToEditVehiclePage = function (id) {
      $location.path(`/vehicles/edit/${id}`);
    };

    $scope.fetchVehicles();
  });
