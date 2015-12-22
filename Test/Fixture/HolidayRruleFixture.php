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
		'can_substitute' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => '0:振替なし,1:振替あり'),
		'from' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => '繰り返し開始日'),
		'to' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => '繰り返し終了日'),
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
			'is_varidable' => 0,
			'can_substitute' => 1,
			'from' => '2014-12-31 15:00:00',
			'to' => '2033-12-31 15:00:00',
			'rrule' => 'FREQ=YEARLY;INTERVAL=1;BYMONTH=1;UNTIL=20321231T150000',
			'created_user' => 1,
			'created' => '2015-12-15 02:09:33',
			'modified_user' => 1,
			'modified' => '2015-12-15 02:09:33'
		),
		array(
			'id' => 2,
			'is_varidable' => 1,
			'can_substitute' => 0,
			'from' => '2000-01-09 15:00:00',
			'to' => '2033-01-15 15:00:00',
			'rrule' => 'FREQ=YEARLY;INTERVAL=1;BYMONTH=1;BYDAY=2MO;UNTIL=20330109T150000',
			'created_user' => 1,
			'created' => '2015-12-15 02:09:33',
			'modified_user' => 1,
			'modified' => '2015-12-15 02:09:33'
		),
		array(
			'id' => 3,
			'is_varidable' => 0,
			'can_substitute' => 1,
			'from' => '2001-02-10 15:00:00',
			'to' => '2033-10-10 15:00:00',
			'rrule' => 'FREQ=YEARLY;INTERVAL=1;BYMONTH=2;UNTIL=20330210T150000',
			'created_user' => 1,
			'created' => '2015-12-15 02:09:33',
			'modified_user' => 1,
			'modified' => '2015-12-15 02:09:33'
		),
		array(
			'id' => 4,
			'is_varidable' => 0,
			'can_substitute' => 1,
			'from' => '2016-03-20 15:00:00',
			'to' => '2016-03-20 15:00:00',
			'rrule' => '',
			'created_user' => 1,
			'created' => '2015-12-15 02:09:33',
			'modified_user' => 1,
			'modified' => '2015-12-15 02:09:33'
		),
	);

}
