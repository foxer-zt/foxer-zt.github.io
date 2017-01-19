angular.module('mooshApp', ['ngRoute']).service('mooshProvider', ['$http', function ($http) {
    return {
        getAll: function() {
            return $http.get('http://irishdash.herokuapp.com/api.php?combined');
        }
    }
}]).config(['$routeProvider', function($routeProvider) {
	$routeProvider
		.when('/play/:moosh/:videoIndex', {controller: 'menuCtrl'})
		.when('/watch/:moosh/:videoIndex', {controller: 'watchCtrl'});
}]);
