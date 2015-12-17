<?php
/**
 * holidays index no data template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>
<div class="text-right">
	<?php echo $this->Button->addLink(
		'',
		array(
			'controller' => 'holidays',
			'action' => 'add',
		),
		array('tooltip' => __d('holidays', 'Create holiday')));
	?>
</div>