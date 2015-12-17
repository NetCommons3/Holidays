<?php
/**
 * holidays edit delete form template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
$langId = Current::read('Language.id');
?>
<div class="nc-danger-zone" ng-init="dangerZone=false;">
	<?php echo $this->NetCommonsForm->create('Holiday', array('type' => 'delete',
			'url' => array('action' => 'delete', $this->request->data['HolidayRrule']['id'])
	)); ?>

	<accordion close-others="false">
		<accordion-group is-open="dangerZone" class="panel-danger">
			<accordion-heading class="clearfix">
				<span style="cursor: pointer">
					<?php echo __d('net_commons', 'Danger Zone'); ?>
				</span>
				<span class="pull-right glyphicon" ng-class="{'glyphicon-chevron-down': dangerZone, 'glyphicon-chevron-right': ! dangerZone}"></span>
			</accordion-heading>

			<div class="pull-left">
				<?php echo sprintf(__d('net_commons', 'Delete all data associated with the %s.'), $this->request->data['Holiday'][$langId]['title']); ?>
			</div>

			<?php echo $this->NetCommonsForm->hidden('Room.id'); ?>
			<?php echo $this->Button->delete(
					__d('net_commons', 'Delete'),
					sprintf(__d('net_commons', 'Deleting the %s. Are you sure to proceed?'), $this->request->data['Holiday'][$langId]['title']),
					array('addClass' => 'pull-right')
				); ?>
		</accordion-group>
	</accordion>

	<?php echo $this->NetCommonsForm->end(); ?>
</div>