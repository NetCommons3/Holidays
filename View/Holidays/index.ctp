<?php
/**
 * holidays index template
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
?>
<div ng-controller="Holidays" ng-init="initialize(<?php echo $targetYear; ?>)">
	<div class="pull-left">
		<?php echo $this->element('Holidays.Holidays/year_select'); ?>
	</div>

	<?php echo $this->element('Holidays.Holidays/add_button'); ?>

	<table class="table table-condensed">
		<thead>
			<tr>
				<th><?php echo __d('holidays', 'date'); ?></th>
				<th><?php echo __d('holidays', 'title'); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php if (count($holidays) === 0) :?>
			<tr><td colspan=2><?php echo __d('holidays', 'No holiday'); ?></td></tr>
		<?php else: ?>
			<?php foreach ($holidays as $holiday): ?>
				<tr class="grid_row">
					<td class="grid_holiday holiday_grid_date">
						<?php echo
							CakeTime::format($this->NetCommonsTime->toUserDatetime($holiday['Holiday']['holiday']), '%m/%d');
						?>
					</td>
					<td class="grid_summary holiday_grid_summary">
						<?php if ($holiday['Holiday']['is_substitute'] === 1) :?>
							<?php echo $holiday['Holiday']['title']; ?>
						<?php else: ?>
							<?php echo $this->NetCommonsHtml->link(
								$holiday['Holiday']['title'],
								NetCommonsUrl::actionUrl(array(
									'action' => 'edit',
									'key' => $holiday['Holiday']['holiday_rrule_id']))
							); ?>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
		</tbody>
	</table>
</div>