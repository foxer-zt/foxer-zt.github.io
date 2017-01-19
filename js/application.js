angular.module('mooshApp', ['ngRoute']).service('mooshProvider', ['$http', function ($http) {
    return {
        getAll: function() {
            return $http.get('https://irishdash.herokuapp.com/api.php?combined');
        }
    }
}]).config(['$routeProvider', function($routeProvider) {
	$routeProvider.when('/play/:moosh/:videoIndex', {controller: 'menuCtrl'});
}]);
