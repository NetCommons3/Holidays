/**
 * @fileoverview Holidays Javascript
 * @author info@allcreator.net (Allcreator Co.)
 */
/**
 * Holidays Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, $sce)} Controller
 */

NetCommonsApp.controller('Holidays',
    ['$scope', '$location', '$sce', '$timeout', '$log', '$attrs',
      function($scope, $location, $sce, $timeout, $log, $attrs) {

        //$attrsと$evalを使い、ng-initディレクティブの評価をcontrollerの最初に行う.
        $scope.$eval($attrs.ngInit);

        /**
         * Initialize
         *
         * @return {void}
         */
        $scope.initialize = function(targetYear) {
          $scope.targetYear = targetYear.toString(10);
        };
        $scope.changeTargetYear = function() {
          location.href =
              '/holidays/holidays/index/targetYear:' + $scope.targetYear;
        };
     }]
);
NetCommonsApp.controller('Holidays.edit',
    ['$scope', '$sce', '$timeout', '$log', '$attrs',
      function($scope, $sce, $timeout, $log, $attrs) {

        //$attrsと$evalを使い、ng-initディレクティブの評価をcontrollerの最初に行う.
        $scope.$eval($attrs.ngInit);

        /**
         * Initialize
         *
         * @return {void}
         */
        $scope.initialize = function(holidayRrule) {
          $scope.holidayRrule = holidayRrule.holidayRrule;
          $scope.holidayRrule.startYear =
              $scope.holidayRrule.startYear.toString(10);
          $scope.holidayRrule.endYear =
              $scope.holidayRrule.endYear.toString(10);
        };
     }]
);
