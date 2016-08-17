angular.module('mooshApp', ['ngRoute']).service('mooshProvider', ['$http', function ($http) {
    return {
        getAll: function() {
            return $http.get('https://foxer-zt.github.io/moosh.json');
        }
    }
}]).config(['$routeProvider', function($routeProvider) {
	$routeProvider.when('/play/:moosh/:videoIndex', {controller: 'menuCtrl'});
}]);
