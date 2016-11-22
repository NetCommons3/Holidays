<?php
/**
 * HolidayFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * Summary for HolidayFixture
 */
class HolidayFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => 'ID'),
		'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'holiday_rrule_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'language_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 6, 'unsigned' => false, 'comment' => '言語ID'),
		'holiday' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => '祝日日付'),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '祝日名称', 'charset' => 'utf8'),
		'is_substitute' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => '0:振替ではない,1:振替休日'),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => '作成者'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '作成日時'),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => '更新者'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '更新日時'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'holiday_rrule_id' => array('column' => 'holiday_rrule_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'key' => 'gantan',
			'holiday_rrule_id' => 1,
			'language_id' => 1,
			'holiday' => '2015-01-01',
			'title' => 'New Years Day',
			'is_substitute' => 0,
			'created_user' => 1,
			'created' => '2015-12-15 02:06:47',
			'modified_user' => 1,
			'modified' => '2015-12-15 02:06:47'
		),
		array(
			'id' => 2,
			'key' => 'gantan',
			'holiday_rrule_id' => 1,
			'language_id' => 2,
			'holiday' => '2015-01-01',
			'title' => '元旦',
			'is_substitute' => 0,
			'created_user' => 1,
			'created' => '2015-12-15 02:06:47',
			'modified_user' => 1,
			'modified' => '2015-12-15 02:06:47'
		),
		array(
			'id' => 3,
			'key' => 'seijin',
			'holiday_rrule_id' => 2,
			'language_id' => 1,
			'holiday' => '2015-01-12',
			'title' => 'Coming-of-Age Day',
			'is_substitute' => 0,
			'created_user' => 1,
			'created' => '2015-12-15 02:06:47',
			'modified_user' => 1,
			'modified' => '2015-12-15 02:06:47'
		),
		array(
			'id' => 4,
			'key' => 'seijin',
			'holiday_rrule_id' => 2,
			'language_id' => 2,
			'holiday' => '2015-01-12',
			'title' => '成人の日',
			'is_substitute' => 0,
			'created_user' => 1,
			'created' => '2015-12-15 02:06:47',
			'modified_user' => 1,
			'modified' => '2015-12-15 02:06:47'
		),
		array(
			'id' => 5,
			'key' => 'kenkokukinen',
			'holiday_rrule_id' => 3,
			'language_id' => 1,
			'holiday' => '2015-02-11',
			'title' => 'National Foundation Day',
			'is_substitute' => 0,
			'created_user' => 1,
			'created' => '2015-12-15 02:06:47',
			'modified_user' => 1,
			'modified' => '2015-12-15 02:06:47'
		),
		array(
			'id' => 6,
			'key' => 'kenkokukinen',
			'holiday_rrule_id' => 3,
			'language_id' => 2,
			'holiday' => '2015-02-11',
			'title' => '建国記念日',
			'is_substitute' => 0,
			'created_user' => 1,
			'created' => '2015-12-15 02:06:47',
			'modified_user' => 1,
			'modified' => '2015-12-15 02:06:47'
		),
		array(
			'id' => 7,
			'key' => 'shunbun',
			'holiday_rrule_id' => 4,
			'language_id' => 1,
			'holiday' => '2015-03-21',
			'title' => 'spring day',
			'is_substitute' => 0,
			'created_user' => 1,
			'created' => '2015-12-15 02:06:47',
			'modified_user' => 1,
			'modified' => '2015-12-15 02:06:47'
		),
		array(
			'id' => 8,
			'key' => 'shunbun',
			'holiday_rrule_id' => 4,
			'language_id' => 2,
			'holiday' => '2015-03-21',
			'title' => '春分の日',
			'is_substitute' => 0,
			'created_user' => 1,
			'created' => '2015-12-15 02:06:47',
			'modified_user' => 1,
			'modified' => '2015-12-15 02:06:47'
		),
	);

}
