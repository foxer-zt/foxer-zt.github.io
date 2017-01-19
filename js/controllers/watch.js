angular.module('mooshApp').controller('watchCtrl', ['$scope','mooshProvider', '$routeParams' , function ($scope, mooshProvider, $routeParams) {
    mooshProvider.getAll().then(function(response) {
        $scope.mooshs = response.data;
        $scope.playVideo();
    });
    $scope.playVideo = function() {
      console.log(player);
      console.log($routeParams.moosh, $routeParams.videoIndex);
    };
}]);
