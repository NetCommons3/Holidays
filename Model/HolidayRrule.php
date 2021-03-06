<?php
/**
 * HolidayRrule Model
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('HolidaysAppModel', 'Holidays.Model');
App::uses('HolidaysAppController', 'Holidays.Controller');
App::uses('HolidaysComponent', 'Holidays.Controller/Component');

/**
 * Holiday Model
 * Summary for HolidayRrule Model
 * @package NetCommons\Holidays\Model
 */
class HolidayRrule extends HolidaysAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Holiday' => array(
			'className' => 'Holidays.Holiday',
			'foreignKey' => 'holiday_rrule_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

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
			// この場合はcount
			if (! isset($val[$this->alias]['id'])) {
				continue;
			}
			// この場合はdelete
			if (! isset($val[$this->alias]['is_variable'])) {
				continue;
			}
			// 入力用データ項目設定
			$monthDay = $val[$this->alias]['month_day'];
			$val[$this->alias]['input_month_day']['month'] = date('m', strtotime($monthDay));
			$val[$this->alias]['input_month_day']['day'] = date('d', strtotime($monthDay));
			$val[$this->alias]['start_year'] = date('Y', strtotime($val[$this->alias]['start_year']));
			$val[$this->alias]['end_year'] = date('Y', strtotime($val[$this->alias]['end_year']));
		}
		return $results;
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
			'is_variable' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'allowEmpty' => false,
					'required' => true,
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'can_substitute' => array(
				'boolean' => array(
					'rule' => array('boolean'),
				),
			),
			'month_day' => array(
				'date' => array(
					'rule' => array('date', 'ymd'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					'required' => true,
				),
			),
			'week' => array(
				'inList' => array(
					'rule' => array('inList', array_keys(HolidaysComponent::getWeekSelectList())),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => true,
					'required' => false,
				),
			),
			'day_of_the_week' => array(
				'inList' => array(
					'rule' => array('inList', array_keys(HolidaysComponent::getWeekdaySelectList())),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => true,
					'required' => false,
				),
			),
			'start_year' => array(
				'date' => array(
					'rule' => array('date'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => true,
				),
				//'comparison' => array(
				//		'rule' => array('comparison', '<', $this->data['HolidayRrule']['end_year']),
				//		'message' => __d('holidays', 'Please input the value is smaller than end year.')
				//),
			),
			'end_year' => array(
				'date' => array(
					'rule' => array('date'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => true,
				),
				'comparison' => array(
						'rule' => array('comparison', '>', $this->data['HolidayRrule']['start_year']),
						'message' => __d('holidays', 'Please input the end year is bigger than start year.')
				),
			),
		));

		parent::beforeValidate($options);

		return true;
	}
/**
 * Called before each save operation, after validation. Return a non-true result
 * to halt the save.
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if the operation should continue, false if it should abort
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforesave
 * @see Model::save()
 */
	public function beforeSave($options = array()) {
		return true;
	}
/**
 * saveHolidayRrule
 *
 * RRULEデータ登録処理
 *
 * @param array $data 登録データ
 * @return bool True on success, false on validation errors
 * @throws InternalErrorException
 */
	public function saveHolidayRrule($data) {
		$this->loadModels([
			'Holiday' => 'Holidays.Holiday',
		]);
		$this->Holiday->Behaviors->disable('M17n.M17n');

		// SetされているPostデータを整える
		// 月日入力はCakeの仕様のため、month, day に分割されてしまっているので
		// DBに入れやすいようにまとめなおす
		if (isset($data[$this->alias]['input_month_day']['day'])) {
			$day = $data[$this->alias]['input_month_day']['day'];
		} else {
			$day = '01';
		}
		$monthDay = $data[$this->alias]['input_month_day']['month'] . '-' . $day;
		$data[$this->alias]['month_day'] = '2001' . '-' . $monthDay;

		//開始年
		$orgStartYear = $this->getStartYearFromPostData($data[$this->alias]);
		$data[$this->alias]['start_year'] = $orgStartYear . '-01-01';

		//終了年
		$orgEndYear = $this->getEndYearFromPostData($data[$this->alias]);
		$data[$this->alias]['end_year'] = $orgEndYear . '-12-31';

		// Rrule文字列(NetCommons3は未設定)
		$data[$this->alias]['rrule'] = '';
		//トランザクションBegin
		$this->begin();
		try {
			$this->set($data[$this->alias]);
			if (! $this->validates()) {
				$this->rollback();
				return false;
			}
			if (!$this->save($data[$this->alias], false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			// 更新したRruleID
			if (! empty($data[$this->alias]['id'])) {
				$rRuleId = $data[$this->alias]['id'];
			} else {
				$rRuleId = $this->getLastInsertID();
			}
			// 以前の祝日データを削除
			$this->Holiday->deleteAll(array('holiday_rrule_id' => $rRuleId), false, true);

			// Rruleから実際の日付配列を取得
			$days = $this->_getDays($data[$this->alias], $orgStartYear, $orgEndYear);
			// 取得した日付の数分Holidayを登録
			$holiday = Hash::remove($data['Holiday'], '{n}.id');
			$holiday = Hash::insert($holiday, '{n}.holiday_rrule_id', $rRuleId);
			foreach ($days as $day) {
				//休日取得（固定休日/可変休日）
				$day = $this->variable($data, $day);
				$holiday = Hash::insert($holiday, '{n}.holiday', $day);
				//キー設定（ 日本語と英語は同じキー）
				//if (empty($data['Holiday'][0]['key'])) {
					$key = OriginalKeyBehavior::generateKey('HolidayRrule', $this->useDbConfig);
					$holiday = Hash::insert($holiday, '{n}.key', $key);
				//}
				//休日登録
				if (!$this->saveHolidayData($data, $holiday)) {
					return false;
				}
			}
			$this->commit();
		} catch (Exception $ex) {
			$this->rollback();
			CakeLog::error($ex);
			return false;
		}

		$this->Holiday->Behaviors->enable('M17n.M17n');
		return true;
	}

/**
 * saveHolidayData
 *
 * save Holiday
 *
 * @param array $data POSTデータ
 * @param array $holiday データ
 * @return bool
 * @throws InternalErrorException
 */
	public function saveHolidayData($data, $holiday) {
		$holiday2 = $holiday;
		$this->Holiday->set($holiday2);
		if (!$this->Holiday->validateMany($holiday2)) { // 引数の配列が乱れる？
			$this->validationErrors = Hash::merge(
				$this->validationErrors, $this->Holiday->validationErrors
			);
			return false;
		}
		//休日登録
		if (! $this->Holiday->saveMany($holiday)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}
		//振替休日(振替に該当した場合、休日登録)
		if (!$this->substitute($data, $holiday)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}
		return true;
	}

/**
 * getDefaultData
 *
 * 新規作成時のデフォルトデータを取り出す
 *
 * @return array
 */
	public function getDefaultData() {
		$data = $this->create();
		$now = strtotime((new NetCommonsTime())->getNowDatetime());
		$data[$this->alias]['input_month_day']['month'] = date('m', $now);
		$data[$this->alias]['input_month_day']['day'] = date('d', $now);
		$data[$this->alias]['start_year'] = HolidaysAppController::HOLIDAYS_YEAR_MIN;
		$data[$this->alias]['end_year'] = HolidaysAppController::HOLIDAYS_YEAR_MAX;
		return $data;
	}
/**
 * getStartYearFromPostData
 *
 * 祝日設定開始年月文字列を取得する
 *
 * @param array $data Postデータ
 * @return int
 */
	public function getStartYearFromPostData($data) {
		if (empty($data['start_year'])) {
			return HolidaysAppController::HOLIDAYS_YEAR_MIN;
		}
		return $data['start_year'];
	}
/**
 * getEndYearFromPostData
 *
 * 祝日設定終了年月文字列を取得する
 *
 * @param array $data Postデータ
 * @return string
 */
	public function getEndYearFromPostData($data) {
		if (empty($data['end_year'])) {
			return HolidaysAppController::HOLIDAYS_YEAR_MAX;
		}
		return $data['end_year'];
	}

/**
 * variable
 *
 * 可変休日(x週のx曜日の日付)
 *
 * @param array $data Postデータ
 * @param string $day 登録するholidayの日
 * @return string
 */
	public function variable($data, $day) {
		if ($data['HolidayRrule']['is_variable'] == false) {
			return $day;
		}

		list($year, $month, $day) = explode('-', $day);
		$timestamp = mktime(0, 0, 0, $data[$this->alias]['input_month_day']['month'], 1, $year);
		$wDayNum = $this->_getWeekDayNum($data[$this->alias]['day_of_the_week']);

		if ($data[$this->alias]['week'] <= 0) { //最終週
			$lastDay = date("t", $timestamp);
			$timestamp = mktime(0, 0, 0, $data[$this->alias]['input_month_day']['month'], $lastDay, $year);
			$wLastDay = date("w", $timestamp);
			$timestamp = mktime(0, 0, 0, $month, $lastDay - $wLastDay + $wDayNum, $year);
		} else {
			$wDay = date("w", $timestamp);
			$wDay = ($wDay <= $wDayNum ? 7 + $wDay : $wDay );
			$newDay = $data[$this->alias]['week'] * 7 + $wDayNum + 1;
			$timestamp = mktime(0, 0, 0, $month, $newDay - $wDay, $year);
		}
		$result = date('Y-m-d', $timestamp);
		return $result;
	}

/**
 * substitute
 *
 * 振替休日を登録する
 *
 * @param array $data POSTデータ
 * @param array $holiday データ
 * @return bool
 */
	public function substitute($data, $holiday) {
		if ($data['HolidayRrule']['can_substitute'] == true) {
			$substitute = array();
			$substitute = $this->_getSubstitute($holiday);
			if ($substitute !== null) { // 振替休日あり
				//$holiday = array_merge_recursive($holiday, $substitute);
				if (! $this->Holiday->saveMany($substitute)) {
					//エラー
					return false;
				}
			}
		}
		return true;
	}
/**
 * _getSubstitute
 *
 * 振替休日を取得する
 *
 * @param array $holiday データ
 * @return string
 */
	protected function _getSubstitute($holiday) {
		$sHoliday = Hash::extract($holiday, '{n}.holiday')[0];

		list($year, $month, $day) = explode('-', $sHoliday);

		$timestamp = mktime(0, 0, 0, $month, $day, $year);
		$wday = date('w', $timestamp);
		$date = $sHoliday;
		$substitute = array();
		if ($wday == 0) { //日曜日
			$substitutes = $holiday;
			$nextDay = strtotime($date . '+1 day');
			foreach ($substitutes as $i => $substitute) {
				if ($i === 2) {
					$title = '(振替休日)'; // タイトル（日本語）
				} else {
					$title = 'substitute holiday'; // タイトル（英語）
				}
				$substitute['title'] = $title; // タイトル
				$substitute['is_substitute'] = true; // 振替休日
				$substitute['holiday'] = strftime('%Y/%m/%d', $nextDay); // +1日(yyyy-mm-dd)

				$substitutes[$i] = $substitute;
			}
			return $substitutes;
		} else {
			return null;
		}
	}

}
