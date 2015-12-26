<?php
/**
 * Holiday Model
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CakeTime', 'Utility');
App::uses('HolidaysAppModel', 'Holidays.Model');

/**
 * Summary for Holiday Model
 */
class Holiday extends HolidaysAppModel {

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'NetCommons.OriginalKey',
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'HolidayRrule' => array(
			'className' => 'HolidayRrule',
			'foreignKey' => 'holiday_rrule_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Language' => array(
			'className' => 'Language',
			'foreignKey' => 'language_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * isHoliday
 * 指定された日付が祝日かどうかを返す
 *
 * @param string $date 'YYYY-MM-DD' 形式の文字列
 * @return bool true:祝日 false:通常日　振替は祝日扱い
 */
	public function isHoliday($date = null) {
		if (! $date) {
			$date = CakeTime::format((new NetCommonsTime())->getNowDatetime(), '%Y-%m-%d');
		}
		// $dateがnullの場合は本日日付
		if ($this->getHoliday($date, $date)) {
			return true;
		} else {
			return false;
		}
	}

/**
 * getHoliday
 * 指定された期間内の祝日日付を返す
 *
 * @param string $from 期間開始日‘YYYY-MM-DD’ 形式の文字列
 * @param string $to   期間終了日‘YYYY-MM-DD’ 形式の文字列
 * @return array期間内のholidayテーブルのデータ配列が返る
 */
	public function getHoliday($from, $to) {
		$holidays = $this->find('all', array(
			'conditions' => array(
				'language_id' => Current::read('Language.id'),
				'holiday >=' => $from,
				'holiday <=' => $to),
			'recursive' => -1,
			'order' => array('holiday')
		));
		return $holidays;
	}

/**
 * getHolidayInYear
 * 指定された年の祝日日付を返す
 * getHolidayのラッパー関数 YYYYに年始まりの日付と最終日付を付与してgetHolidayを呼び出す
 *
 * @param string $year 指定年（西暦）‘YYYY’ 形式の文字列
 * @return array期間内のholidayテーブルのデータ配列が返る
 */
	public function getHolidayInYear($year = null) {
		// $yearがnullの場合は現在年
		if ($year === null) {
			// 未設定時は現在年
			$year = CakeTime::format((new NetCommonsTime())->getNowDatetime(), '%Y');
		}
		$from = $year . '-01-01';
		$to = $year . '-12-31';
		$holidays = $this->getHoliday($from, $to);
		return $holidays;
	}

/**
 * extractHoliday
 * 指定された日付配列の中から祝日に該当するものだけを抽出して返す
 *
 * @param string $days 指定日付の配列‘YYYY-MM-DD’形式の文字列の配列
 * @return array引数で渡された日付配列のうち、祝日に該当するものだけを抽出した配列
 */
	public function extractHoliday($days) {
		$holidays = array();
		foreach ($days as $day) {
			$ret = $this->isHoliday($day);
			if ($ret) {
				$holidays[] = $day;
			}
		}
		return $holidays;
	}
/**
 * Called during validation operations, before validation. Please note that custom
 * validation rules can be defined in $validate.
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if validate operation should continue, false to abort
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforevalidate
 * @see Model::save()
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
	public function beforeValidate($options = array()) {
		$this->validate = Hash::merge($this->validate, array(
			'holiday_rrule_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					'required' => true,
				),
			),
			'language_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					'required' => true,
				),
			),
			'holiday' => array(
				'date' => array(
					'rule' => 'date',
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					'required' => true,
				),
			),
			'title' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('holidays', 'Please input title.'),
					'allowEmpty' => false,
					'required' => true,
				),
			),
			'is_substitute' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
		));
		parent::beforeValidate($options);
		return true;
	}
}
