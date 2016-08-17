angular.module('mooshApp', []).service('mooshProvider', ['$http', function ($http) {
    return {
        getAll: function() {
            return $http.get('https://foxer-zt.github.io/moosh.json');
        }
    }
}]);
