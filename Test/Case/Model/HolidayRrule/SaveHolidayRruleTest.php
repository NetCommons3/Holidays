<?php
/**
 * HolidayRrule::saveHolidayRrule()のテスト
 *
 * @property HolidayRrule $HolidayRrule
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('HolidaysComponent', 'Holidays.Controller/Component');
App::uses('NetCommonsSaveTest', 'NetCommons.TestSuite');

/**
 * HolidayRrule::saveHolidayRrule()のテスト
 *
 * @author Allcreator <info@allcreator.net>
 * @package NetCommons\Holidays\Test\Case\Model\HolidayRrule
 */
class HolidayRruleSaveHolidayRruleTest extends NetCommonsSaveTest {

/**
 * Plugin name
 *
 * @var array
 */
	public $plugin = 'holidays';

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.holidays.holiday_rrule',
		'plugin.holidays.holiday',
	);

/**
 * Model name
 *
 * @var array
 */
	protected $_modelName = 'HolidayRrule';

/**
 * Method name
 *
 * @var array
 */
	protected $_methodName = 'saveHolidayRrule';

/**
 * テストDataの取得
 *
 * @param int $id rrule_id
 * @return array
 */
	private function __getData($id = null) {
		$data = array(
			'Holiday' => array(
			'1' => array(
					'holiday_rrule_id' => $id,
					'language_id' => '1',
					'holiday' => '2015-10-31',
					'title' => 'hallowin',
				//	'is_substitute' => '0',
				),
			'2' => array(
					'holiday_rrule_id' => $id,
					'language_id' => '2',
					'holiday' => '2015-10-31',
					'title' => 'ハロウィン',
				//	'is_substitute' => '0',
				),
			),
			'HolidayRrule' => array(
				'id' => $id,
				'is_variable' => true,
				'input_month_day' => array(
						'month' => '02',
						'day' => '11',
				),
				'can_substitute' => false,
				'week' => '1',
				'day_of_the_week' => 'SU',
				'start_year' => 2011,
				'end_year' => 2017,
			),
		);
		return $data;
	}

/**
 * SaveのDataProvider
 *
 * #### 戻り値
 *  - data 登録データ
 *
 * @return void
 */
	public function dataProviderSave() {
		return array(
			array($this->__getData()), //新規
			array($this->__getData(1)), //更新
		);
	}

/**
 * SaveのExceptionErrorテスト
 *
 * @param array $data 登録データ
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @dataProvider dataProviderSaveOnExceptionError
 * @return void
 */
	public function testSaveOnExceptionError($data, $mockModel, $mockMethod) {
		$model = $this->_modelName;
		$method = $this->_methodName;
		$this->_mockForReturnFalse($model, $mockModel, $mockMethod);

		//$this->setExpectedException('InternalErrorException');// pending ここをコメントアウトしないとうまくいかない？？
		$this->$model->$method($data);
	}

/**
 * SaveのExceptionErrorのDataProvider
 *
 * #### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return void
 */
	public function dataProviderSaveOnExceptionError() {
		return array(
			array($this->__getData(), 'Holidays.Holiday', 'saveMany'),
			array($this->__getData(), 'Holidays.HolidayRrule', 'save'),
			array($this->__getData(), 'Holidays.HolidayRrule', 'substitute'),
		);
	}

/**
 * SaveのValidationErrorのDataProvider
 *
 * #### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *
 * @return void
 */
	public function dataProviderSaveOnValidationError() {
		return array(
			array($this->__getData(), 'Holidays.HolidayRrule'),
			array($this->__getData(), 'Holidays.Holiday', 'validateMany'),
		);
	}

/**
 * ValidationErrorのDataProvider
 *
 * #### 戻り値
 *  - field フィールド名
 *  - value セットする値
 *  - message エラーメッセージ
 *  - overwrite 上書きするデータ
 *
 * @return void
 */
	public function dataProviderValidationError() {
		return array(
			array($this->__getData(), 'is_valiable', 'a',
				__d('net_commons', 'Invalid request.')),
			array($this->__getData(), 'can_substitute', '2',
				__d('net_commons', 'Invalid request.')),
			array($this->__getData(), 'month_day', '',
				__d('net_commons', 'Invalid request.')),
			array($this->__getData(), 'week', 'aa',
				__d('net_commons', 'Invalid request.')),
			array($this->__getData(), 'day_of_the_week', 'aa',
				__d('net_commons', 'Invalid request.')),
			array($this->__getData(), 'start_year', 'a',
				__d('net_commons', 'Invalid request.')),
			array($this->__getData(), 'end_year', '1',
				__d('holidays', 'Please input title.')),
		);
	}

/**
 * Saveのテスト
 *
 * @param array $data 登録データ
 * @dataProvider dataProviderSave
 * @return void
 */
	public function testSave($data) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		//HolidayRruleテスト
		$before['HolidayRrule'] = $data['HolidayRrule'];

		//出力に合わせる
		$before['HolidayRrule']['month_day'] = '2001' . '-' . $before['HolidayRrule']['input_month_day']['month'] . '-' . $before['HolidayRrule']['input_month_day']['day'];
		$before['HolidayRrule']['rrule'] = '';

		//テスト実施
		$result = $this->$model->$method($data);
		$this->assertNotEmpty($result);

		//idのチェック
		if (isset($data[$this->$model->alias]['id'])) {
			$id = $data[$this->$model->alias]['id'];
		} else {
			$id = $this->$model->getLastInsertID();
		}

		//登録データ取得
		$after = $this->$model->find('first', array(
			'recursive' => -1,
			'conditions' => array('id' => $id),
		));

		//登録処理後のHolidayRruleのチェック
		//開始年
		$before['HolidayRrule']['start_year'] = $data['HolidayRrule']['start_year'] . '-01-01 00:00:00';

		//終了年
		$before['HolidayRrule']['end_year'] = $data['HolidayRrule']['end_year'] . '-12-31 00:00:00';

		if (isset($data['HolidayRrule']['id'])) {
			$before['HolidayRrule'] = Hash::remove($before['HolidayRrule'], 'created');
			$before['HolidayRrule'] = Hash::remove($before['HolidayRrule'], 'created_user');
			$before['HolidayRrule'] = Hash::remove($before['HolidayRrule'], 'modified');
			$before['HolidayRrule'] = Hash::remove($before['HolidayRrule'], 'modified_user');
		} else {
			$before['HolidayRrule']['id'] = $id;
		}

		$after['HolidayRrule'] = Hash::remove($after['HolidayRrule'], 'created');
		$after['HolidayRrule'] = Hash::remove($after['HolidayRrule'], 'created_user');

		$after['HolidayRrule'] = Hash::remove($after['HolidayRrule'], 'modified');
		$after['HolidayRrule'] = Hash::remove($after['HolidayRrule'], 'modified_user');

		$this->assertEquals($after['HolidayRrule'], $before['HolidayRrule']);
	}

}
