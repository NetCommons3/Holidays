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
    function($scope, $location, $sce, $timeout, $log, $attrs,
        NetCommonsBase, NetCommonsFlash) {

      //$attrsと$evalを使い、ng-initディレクティブの評価をcontrollerの最初に行う.
      $scope.$eval($attrs.ngInit);

      /**
       * Initialize
       *
       * @return {void}
       */
      $scope.initialize = function(targetYear) {
        $scope.targetYear = targetYear;
      };
      $scope.changeTargetYear = function() {
        location.href =
            '/holidays/holidays/index/targetYear:' + $scope.targetYear;
      };
    }
);
NetCommonsApp.controller('Holidays.edit',
    function($scope, $sce, $timeout, $log, $attrs,
        NetCommonsBase, NetCommonsFlash) {

      //$attrsと$evalを使い、ng-initディレクティブの評価をcontrollerの最初に行う.
      $scope.$eval($attrs.ngInit);

      /**
       * Initialize
       *
       * @return {void}
       */
      $scope.initialize = function(holidayRrule) {
        $scope.holidayRrule = holidayRrule.holidayRrule;
      };
    }
);
