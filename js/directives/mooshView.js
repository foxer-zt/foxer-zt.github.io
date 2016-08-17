angular.module('mooshApp').directive('mooshView', function() {
    return {
        restrict: 'EA',
        templateUrl: 'js/templates/moosh.html',
        scope: {
            'moosh': '=moosh',
            'updater': '&',
            'selected': '=selected',
            'index': '@'
        }
    };
});
