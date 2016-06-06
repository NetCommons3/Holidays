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

echo $this->NetCommonsHtml->css(array(
	'/holidays/css/holidays.css',
));
?>

<div ng-controller="Holidays" ng-init="initialize(<?php echo $targetYear; ?>)">
	<?php
		echo $this->MessageFlash->description(
			__d('holidays', 'You can add, edit, and delete the holiday of %s year.', $targetYear)
		);
	?>

	<header class="clearfix">
		<div class="pull-left">
			<?php
				echo $this->element('Holidays.Holidays/year_picker', array(
					'fieldName' => 'targetYear',
					'year' => $targetYear,
					'ngModel' => 'targetYear',
					'options' => array('ng-change' => 'changeTargetYear()')
				));
			?>
		</div>

		<div class="pull-right">
			<?php
				echo $this->Button->addLink(
					'',
					array(
						'controller' => 'holidays',
						'action' => 'add',
					),
					array('tooltip' => __d('holidays', 'Create holiday'))
				);
			?>
		</div>
	</header>

	<?php if ($holidays) : ?>
		<?php echo $this->TableList->startTable(); ?>
			<thead>
				<tr>
					<th><?php echo __d('holidays', 'date'); ?></th>
					<th><?php echo __d('holidays', 'title'); ?></th>
					<th><?php echo __d('holidays', 'holiday specification type'); ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($holidays as $holiday): ?>
					<tr>
						<td>
							<?php
								echo CakeTime::format(
									$this->NetCommonsTime->toUserDatetime($holiday['Holiday']['holiday']), '%m/%d'
								);
							?>
							(
							<?php
								echo __d('holidays', CakeTime::format(
									$this->NetCommonsTime->toUserDatetime($holiday['Holiday']['holiday']), '%a'
								));
							?>
							)
							<?php
								if ($holiday['Holiday']['is_substitute'] !== 1) {
									echo $this->LinkButton->edit(
										'',
										NetCommonsUrl::actionUrl(array(
											'action' => 'edit',
											'key' => $holiday['Holiday']['holiday_rrule_id'])
										),
										array('iconSize' => 'btn-xs')
									);
								}
							?>
						</td>
						<td>
							<?php echo h($holiday['Holiday']['title']); ?>
						</td>
						<td>
							<?php if ($holiday['HolidayRrule']['is_variable']) : ?>
								<?php echo __d('holidays', 'Specified week and day of the week'); ?>
							<?php else : ?>
								<?php echo __d('holidays', 'Date fixed'); ?>
							<?php endif; ?>
						</td>
						<td>
							<?php echo $this->element('Holidays.Holidays/holiday_type', array('holiday' => $holiday)); ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		<?php echo $this->TableList->endTable(); ?>
	<?php else : ?>
		<?php echo __d('holidays', 'No holiday'); ?>
	<?php endif; ?>
</div>