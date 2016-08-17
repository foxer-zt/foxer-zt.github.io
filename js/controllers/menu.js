angular.module('mooshApp').controller('menuCtrl', ['$scope','mooshProvider', '$routeParams' , function ($scope, mooshProvider, $routeParams) {
    var init = function(mooshs, player) {
    	if ($routeParams.moosh) {
			for (var mooshIndex in mooshs) {
				if(mooshs[mooshIndex].name == $routeParams.moosh) {
					if ($routeParams.videoIndex) {
						player.loadVideoById(mooshs[mooshIndex].videos[videoIndex]);
					} else {
						player.loadVideoById(mooshs[mooshIndex].videos[0])
					}
				}
			} 
		player.playVideo();
    	}
	}
    mooshProvider.getAll().then(function(response) {
        $scope.mooshs = response.data;
        $scope.selected = 0;
        $scope.select = function(index) {
            $scope.selected = index;
        };
        $scope.selectedVideo = '';
		init($scope.mooshs, player);
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
