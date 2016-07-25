<?php
/**
 * Holidays Migration file
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * Holidays Migration
 *
 * @author Allcreator <info@allcreator.net>
 * @package NetCommons\Holidays\Config\Migration
 */
class ModifyIndex extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'modify_index';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'alter_field' => array(
				'holidays' => array(
					'holiday' => array('type' => 'date', 'null' => false, 'default' => null, 'key' => 'index'),
				),
			),
			'drop_field' => array(
				'holidays' => array('indexes' => array('holiday_rrule_id')),
			),
			'create_field' => array(
				'holidays' => array(
					'indexes' => array(
						'holiday' => array('column' => array('holiday', 'language_id'), 'unique' => 0),
					),
				),
			),
		),
		'down' => array(
			'alter_field' => array(
				'holidays' => array(
					'holiday' => array('type' => 'date', 'null' => false, 'default' => null),
				),
			),
			'create_field' => array(
				'holidays' => array(
					'indexes' => array(
						'holiday_rrule_id' => array('column' => 'holiday_rrule_id', 'unique' => 0),
					),
				),
			),
			'drop_field' => array(
				'holidays' => array('indexes' => array('holiday')),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		return true;
	}
}
