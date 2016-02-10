<?php
/**
 * HolidayRruleFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * Summary for HolidayRruleFixture
 */
class HolidayRruleFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => 'ID | | | '),
		'is_variable' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => '0:日付固定,1:週曜日指定の可変'),
		'month_day' => array('type' => 'date', 'null' => true, 'default' => null),
		'week' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 2, 'unsigned' => false),
		'day_of_the_week' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 2, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'can_substitute' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => '0:振替なし,1:振替あり'),
		'start_year' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => '繰り返し開始日'),
		'end_year' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => '繰り返し終了日'),
		'rrule' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'rrule rule | 繰返し規則', 'charset' => 'utf8'),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => 'created user | 作成者 | users.id | '),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 | | '),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => 'modified user | 更新者 | users.id | '),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 | | '),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
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
			'is_variable' => 0,
			'month_day' => '2001-02-01',
			'week' => 1,
			'day_of_the_week' => 'SU',
			'can_substitute' => 1,
			'start_year' => '2014-01-01',
			'end_year' => '2032-12-31',
			'rrule' => 'FREQ=YEARLY;INTERVAL=1;BYMONTH=1;UNTIL=20321231',
			'created_user' => 1,
			'created' => '2015-12-15 02:09:33',
			'modified_user' => 1,
			'modified' => '2015-12-15 02:09:33'
		),
		array(
			'id' => 2,
			'is_variable' => 1,
			'month_day' => '2001-02-01',
			'week' => 1,
			'day_of_the_week' => 'SU',
			'can_substitute' => 0,
			'start_year' => '2000-01-10',
			'end_year' => '2033-01-16',
			'rrule' => 'FREQ=YEARLY;INTERVAL=1;BYMONTH=1;BYDAY=2MO;UNTIL=20330110',
			'created_user' => 1,
			'created' => '2015-12-15 02:09:33',
			'modified_user' => 1,
			'modified' => '2015-12-15 02:09:33'
		),
		array(
			'id' => 3,
			'is_variable' => 0,
			'month_day' => '2001-02-01',
			'week' => 1,
			'day_of_the_week' => 'SU',
			'can_substitute' => 1,
			'start_year' => '2001-02-11',
			'end_year' => '2033-10-11',
			'rrule' => 'FREQ=YEARLY;INTERVAL=1;BYMONTH=2;UNTIL=20330211',
			'created_user' => 1,
			'created' => '2015-12-15 02:09:33',
			'modified_user' => 1,
			'modified' => '2015-12-15 02:09:33'
		),
		array(
			'id' => 4,
			'is_variable' => 0,
			'month_day' => '2001-02-01',
			'week' => 1,
			'day_of_the_week' => 'SU',
			'can_substitute' => 1,
			'start_year' => '2015-03-21',
			'end_year' => '2015-03-21',
			'rrule' => '',
			'created_user' => 1,
			'created' => '2015-12-15 02:09:33',
			'modified_user' => 1,
			'modified' => '2015-12-15 02:09:33'
		),
	);

}
