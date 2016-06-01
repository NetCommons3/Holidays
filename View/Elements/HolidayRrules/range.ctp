<?php
/**
 * holidays edit_form range template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="form-group">
	<label>
		<?php echo __d('holidays', 'Specified target range'); ?>
	</label>
	<div class="form-inline">
		<div class="input-group">
			<?php
				echo $this->NetCommonsForm->input('start_year', array(
					'type' => 'number',
					'label' => false,
					'min' => 1970,
					'max' => 2033,
					'error' => false,
					'div' => false,
				));
			?>

			<span class="input-group-addon">
				<span class="glyphicon glyphicon-minus"></span>
			</span>

			<?php
				echo $this->NetCommonsForm->input('end_year', array(
					'type' => 'number',
					'label' => false,
					'min' => 1970,
					'max' => 2033,
					'error' => false,
					'div' => false,
				));
			?>
		</div>
	</div>

	<?php echo $this->NetCommonsForm->error('end_year'); ?>
</div>
