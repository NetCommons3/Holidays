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
		$day = isset($data[$this->alias]['input_month_day']['day']) ? $data[$this->alias]['input_month_day']['day'] : '01';
		$monthDay = $data[$this->alias]['input_month_day']['month'] . '-' . $day;
		$data[$this->alias]['month_day'] = '2001' . '-' . $monthDay;

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

			// Rrule文字列作成
			// FUJI

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
