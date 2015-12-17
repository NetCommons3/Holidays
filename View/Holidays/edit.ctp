<?php
/**
 * holidays edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->NetCommonsHtml->script(array(
	'/holidays/js/holidays.js',
));
$jsHolidayRrule = NetCommonsAppController::camelizeKeyRecursive($this->data);
?>
<div class="panel panel-default" ng-controller="Holidays.edit" ng-init="initialize(<?php echo h(json_encode($jsHolidayRrule)); ?>)">

    <?php echo $this->element('Holidays.HolidayRrules/edit_form'); ?>

</div>

<?php echo $this->element('Holidays.HolidayRrules/delete_form');

