angular.module('mooshApp', ['ngRoute']).service('mooshProvider', ['$http', function ($http) {
    return {
        getAll: function() {
            return $http.get('https://foxer-zt.github.io/moosh.json');
        }
    }
}]).config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
	$routeProvider.when('/play/:moosh/:videoIndex', {controller: 'menuCtrl'});
	$locationProvider.html5Mode(true);
}]);
