angular.module('carRentalApp').component('addressComponent', {
  bindings: {
    address: '='
  },
  template: `
    <div class="address">
      <md-input-container class="md-block">
        <label>Ulica</label>
        <input type="text" ng-model="$ctrl.address.street" required>
      </md-input-container>
      <md-input-container class="md-block">
        <label>Miasto</label>
        <input type="text" ng-model="$ctrl.address.city" required>
      </md-input-container>
      <md-input-container class="md-block">
        <label>Kod pocztowy</label>
        <input type="text" ng-model="$ctrl.address.postalCode" required>
      </md-input-container>
      <md-input-container class="md-block">
        <label>Kraj</label>
        <input type="text" ng-model="$ctrl.address.country" required>
      </md-input-container>
    </div>
  `,
  controller: function () {
    this.$onInit = function () {
      if (!this.address) {
        this.address = {
          street: '',
          city: '',
          postalCode: '',
          country: 'Polska'
        };
      }
    };
  }
});
