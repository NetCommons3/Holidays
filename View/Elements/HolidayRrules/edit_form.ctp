<?php
/**
 * holiday rrules edit form template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->NetCommonsHtml->css('/holidays/css/holidays.css');
?>
<?php echo $this->NetCommonsForm->create('HolidayRrule'); ?>
	<?php echo $this->NetCommonsForm->hidden('id'); ?>

	<div class="panel-body">
		<?php echo $this->SwitchLanguage->tablist('holidays-'); ?>

		<div class="tab-content">
			<?php echo $this->element('Holidays.HolidayRrules/title'); ?>

			<?php echo $this->element('Holidays.HolidayRrules/is_variable'); ?>

			<?php echo $this->element('Holidays.HolidayRrules/range'); ?>
		</div>
	</div>


	<div class="panel-footer text-center">
		<?php echo $this->Button->cancelAndSave(
				__d('net_commons', 'Cancel'),
				__d('net_commons', 'OK'),
				'/holidays/holidays/index'
			); ?>
	</div>

<?php echo $this->NetCommonsForm->end();