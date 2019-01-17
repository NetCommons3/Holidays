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
    ['$scope', '$window', '$attrs', 'NC3_URL',
      function($scope, $window, $attrs, NC3_URL) {

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
          $window.location.href =
              NC3_URL + '/holidays/holidays/index/targetYear:' + $scope.targetYear;
        };
     }]
);
NetCommonsApp.controller('Holidays.edit',
    ['$scope', '$attrs',
      function($scope, $attrs) {

        //$attrsと$evalを使い、ng-initディレクティブの評価をcontrollerの最初に行う.
        $scope.$eval($attrs.ngInit);

        /**
         * Initialize
         *
         * @return {void}
         */
        $scope.initialize = function(holidayRrule) {
          if (holidayRrule.holidayRrule.isVariable == true) {
            holidayRrule.holidayRrule.isVariable = '1';
          } else {
            holidayRrule.holidayRrule.isVariable = '0';
          }
          $scope.holidayRrule = holidayRrule.holidayRrule;
          $scope.holidayRrule.startYear =
              $scope.holidayRrule.startYear.toString(10);
          $scope.holidayRrule.endYear =
              $scope.holidayRrule.endYear.toString(10);
        };
     }]
);
