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
App::uses('NetCommonsTime', 'NetCommons.Utility');

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
		'NetCommons.NetCommonsCache',
		//多言語
		'M17n.M17n' => array(
			'keyField' => 'holiday_rrule_id',
			'commonFields' => array('is_substitute')
		),
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
			'className' => 'Holidays.HolidayRrule',
			'foreignKey' => 'holiday_rrule_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Language' => array(
			'className' => 'M17n.Language',
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
		if (!$date) {
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
 * @param string $to 期間終了日‘YYYY-MM-DD’ 形式の文字列
 * @return array期間内のholidayテーブルのデータ配列が返る
 */
	public function getHoliday($from, $to) {
		$holidays = $this->cacheFindQuery('all', array(
			'fields' => array(
				'Holiday.id',
				'Holiday.holiday',
				'Holiday.title'
			),
			'conditions' => array(
				'language_id' => Current::read('Language.id'),
				'holiday >=' => $from,
				'holiday <=' => $to
			),
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
		$holidays = $this->Find('all', array(
			'conditions' => array(
				'language_id' => Current::read('Language.id'),
				'holiday >=' => $from,
				'holiday <=' => $to
			),
			'recursive' => 0,
			'order' => array('holiday')
		));
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
 * saveHolidays 休日設定の保存
 *
 * @param array $data save data
 * @return bool
 * @throws InternalErrorException
 */
	public function saveHolidays($data) {
		//トランザクションBegin
		$this->begin();

		//バリデーション
		$this->set($data);
		if (!$this->validates()) {
			return false;
		}
		try {
			//Holiday登録
			if (!$holiday = $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return $holiday;
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
		$this->validate = ValidateMerge::merge($this->validate, array(
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
					'allowEmpty' => true,
					'required' => false,
				),
			),
		));
		parent::beforeValidate($options);
		return true;
	}

/**
 * AfterFind Callback function
 *
 * @param array $results found data records
 * @param bool $primary indicates whether or not the current model was the model that the query originated on or whether or not this model was queried as an association
 * @return mixed
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function afterFind($results, $primary = false) {
		foreach ($results as &$val) {
			if (isset($val[$this->alias]['is_substitute'])) {
				$val[$this->alias]['is_substitute'] = intval($val[$this->alias]['is_substitute']);
			}
			if (isset($val[$this->alias]['holiday'])) {
				$val[$this->alias]['holiday'] = date('Y-m-d', strtotime($val[$this->alias]['holiday']));
			}
		}
		return $results;
	}

/**
 * delete holidays
 *
 * @param int $rruleId received post data
 * @return bool True if validate operation should continue, false to abort
 * @throws InternalErrorException
 */
	public function deleteHoliday($rruleId) {
		$this->loadModels([
			'Holiday' => 'Holidays.Holiday',
			'HolidayRrule' => 'Holidays.HolidayRrule',
		]);

		//トランザクションBegin
		$this->begin();

		try {
			//HolidayRruleの削除
			if (! $this->HolidayRrule->delete($rruleId, false, true)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//Holidayの削除
			$result = $this->Holiday->deleteAll(array(
				'holiday_rrule_id' => $rruleId
				), false, true);
			if ($result === false) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return true;
	}

}
