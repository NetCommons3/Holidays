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

/**
 * Summary for HolidayRrule Model
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
			'className' => 'Holiday',
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
			$val[$this->alias]['input_month_day']['month'] = date('m', strtotime($val[$this->alias]['month_day']));
			$val[$this->alias]['input_month_day']['day'] = date('d', strtotime($val[$this->alias]['month_day']));
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
		$this->validate = Hash::merge($this->validate, array(
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
			),
			'end_year' => array(
				'date' => array(
					'rule' => array('date'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => true,
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
		// start_yearとend_yearは空っぽで来たときは自動的に補足する
		$this->data[$this->alias]['start_year'] = $this->_getStartYearFromPostData($this->data[$this->alias]);
		$this->data[$this->alias]['end_year'] = $this->_getEndYearFromPostData($this->data[$this->alias]);
		return true;
	}
/**
 * saveHolidayRrule
 *
 * RRULEデータ登録処理
 *
 * @param array $data 登録データ
 * @return bool
 * @throws Exception
 */
	public function saveHolidayRrule($data) {
		$this->loadModels([
			'Holiday' => 'Holidays.Holiday',
		]);

		// SetされているPostデータを整える
		// 月日入力はCakeの仕様のため、month, day に分割されてしまっているので
		// DBに入れやすいようにまとめなおす
		$day = isset($data[$this->alias]['input_month_day']['day']) ? $data[$this->alias]['input_month_day']['day'] : '01';
		$monthDay = $data[$this->alias]['input_month_day']['month'] . '-' . $day;
		$data[$this->alias]['month_day'] = '2001' . '-' . $monthDay;

		// Rrule文字列作成 FUJI
		$data[$this->alias]['rrule'] = $this->_makeRrule($data[$this->alias]);

		//トランザクションBegin
		$this->begin();

		try {
			$this->set($data[$this->alias]);
			if (! $this->validates()) {
				$this->rollback();
				return false;
			}
			$this->save($data, false);
			// 更新したRruleID
			if (! empty($data[$this->alias]['id'])) {
				$rRuleId = $data[$this->alias]['id'];
			} else {
				$rRuleId = $this->getLastInsertID();
			}

			// 以前の祝日データを削除
			$this->Holiday->deleteAll(array('holiday_rrule_id' => $rRuleId), false, true);

			// Rruleから実際の日付配列を取得
			// FUJI とりあえずのダミーあとでカレンダーから提供されるRrule展開ツールを使う
			$days = $this->__getDummyDays($data[$this->alias]);

			// 取得した日付の数分Holidayを登録
			foreach ($days as $day) {
				$holiday = Hash::insert($data['Holiday'], '{n}.holiday', $day);
				$holiday = Hash::insert($holiday, '{n}.holiday_rrule_id', $rRuleId);
				if (! $this->Holiday->saveMany($holiday)) {
					$this->validationErrors['Holiday'] = $this->Holiday->validationErrors;
					$this->rollback();
					return false;
				}
			}
			$this->commit();
		} catch (Exception $ex) {
			$this->rollback();
			CakeLog::error($ex);
			throw $ex;
		}
		return true;
	}

/**
 * _makeRrule
 *
 * Postされた変数からRruleを組み立てる
 *
 * @param array $data Postデータ
 * @return string
 */
	protected function _makeRrule($data) {
		$rruleStr = '';
		$endDateTime = $this->_getEndYearFromPostData($data);
		$endDate = date('Ymd', strtotime($endDateTime));
		$endTime = date('His', strtotime($endDateTime));
		$rrule = array(
			'FREQ' => 'YEARLY',
			'INTERVAL' => 1,
			'UNTIL' => $endDate . 'T' . $endTime,
			'BYMONTH' => array(intval(intval($data['input_month_day']['month']))),
		);
		if ($data['is_variable'] == HolidaysAppController::HOLIDAYS_VARIABLE) {
			$week = intval($data['week']);
			$dayOfTheWeek = $data['day_of_the_week'];
			$rrule['BYDAY'] = array($week . $dayOfTheWeek);
		}

		$this->_concatRRule($rrule, $rruleStr);

		return $rruleStr;
	}
/**
 * _concatRRule
 *
 * 文字列にする処理 FUJI もしかしたらこれはカレンダーUtilityの機能の一つではないか あとでここから削除かもしれない
 *
 * @param array $rrule Rrule配列データ
 * @param string $resultStr $rruleデータから組み立てられたRrule文字列
 * @return bool
 */
	protected function _concatRRule($rrule, &$resultStr) {
		$resultStr = '';
		$result = array();
		$freqArray = ['NONE', 'YEARLY', 'MONTHLY', 'WEEKLY', 'DAILY'];
		if (! (isset($rrule['FREQ']) && in_array($rrule['FREQ'], $freqArray))) {
			return false;
		}
		if ($rrule['FREQ'] != 'NONE') {
			$result = array('FREQ=' . $rrule['FREQ']);
			$result[] = 'INTERVAL=' . intval($rrule['INTERVAL']);
		}
		if (isset($rrule['BYMONTH'])) {
			$result[] = 'BYMONTH=' . implode(',', $rrule['BYMONTH']);
		}
		if (! empty($rrule['BYDAY'])) {
			$result[] = 'BYDAY=' . implode(',', $rrule['BYDAY']);
		}
		if (!empty($rrule['BYMONTHDAY'])) {
			$result[] = 'BYMONTHDAY=' . implode(',', $rrule['BYMONTHDAY']);
		}
		if (isset($rrule['UNTIL'])) {
			$result[] = 'UNTIL=' . $rrule['UNTIL'];
		} elseif (isset($rrule['COUNT'])) {
			$result[] = 'COUNT=' . intval($rrule['COUNT']);
		}
		$resultStr = implode(';', $result);
		return true;
	}

/**
 * _getStartYearFromPostData
 *
 * 祝日設定開始年月文字列を取得する
 *
 * @param array $data Postデータ
 * @return string
 */
	protected function _getStartYearFromPostData($data) {
		if (empty($data['start_year'])) {
			return HolidaysAppController::HOLIDAYS_DATE_MIN;
		}
		return $data['start_year'];
	}
/**
 * _getEndYearFromPostData
 *
 * 祝日設定終了年月文字列を取得する
 *
 * @param array $data Postデータ
 * @return string
 */
	protected function _getEndYearFromPostData($data) {
		if (empty($data['end_year'])) {
			return HolidaysAppController::HOLIDAYS_DATE_MAX;
		}
		return $data['end_year'];
	}
/**
 * __getDummyDays
 *
 * カレンダーUtilityができるまでのスタブ関数
 *
 * @param array $data RRULEデータ
 * @return array
 */
	private function __getDummyDays($data) {
		$ret = array();
		for ($i = 2001; $i <= 2033; $i++) {
			$ret[] = $i . '-' . substr($data['month_day'], 5);
		}
		return $ret;
	}
}
