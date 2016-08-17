angular.module('mooshApp').controller('menuCtrl', ['$scope','mooshProvider', function ($scope, mooshProvider) {
    mooshProvider.getAll().then(function(response) {
        $scope.mooshs = response.data;
        $scope.selected = 0;
        $scope.select = function(index) {
            $scope.selected = index;
        };
        $scope.selectedVideo = '';
        $scope.updateVideo = function(videoId) {
            $scope.selectedVideo = videoId;
            if(player) {
                player.loadVideoById(videoId);
                player.playVideo();
            } else {
                console.log('Player is not defined');
            }
        };
        $scope.executeFirst = function(moosh) {
            if(player && moosh.videos.length === 1) {
                player.loadVideoById(moosh.videos[0]);
                player.playVideo();
            } else {
                console.log('Player is not defined');
            }
        };
    });
}]);
