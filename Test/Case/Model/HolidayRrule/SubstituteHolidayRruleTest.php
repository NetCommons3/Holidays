<?php
/**
 * HolidayRrule::substitute()のテスト
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
App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * HolidayRrule::substitute()のテスト
 *
 * @author Allcreator <info@allcreator.net>
 * @package NetCommons\Holidays\Test\Case\Model\HolidayRrule
 */
class HolidayRruleSubstituteHolidayRruleTest extends NetCommonsModelTestCase {

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
	protected $_methodName = 'substitute';

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
					'holiday' => '2017-01-01',
					'title' => 'birthday',
				//	'is_substitute' => '0',
				),
			'2' => array(
					'holiday_rrule_id' => $id,
					'language_id' => '2',
					'holiday' => '2017-01-01',
					'title' => '誕生日',
				//	'is_substitute' => '0',
				),
			),
			'HolidayRrule' => array(
				'id' => $id,
				'is_variable' => true,
				'input_month_day' => array(
						'month' => '01',
						'day' => '11',
				),
				'can_substitute' => true,
				'week' => '1',
				'day_of_the_week' => 'SU',
				'start_year' => 2011,
				'end_year' => 2017,
			),
		);
		return $data;
	}

/**
 * substituteのテスト
 *
 * @param array $data
 * @param array $substitute
 * @dataProvider dataProviderSubstitute
 *
 * @return void
 */
	public function testSubstitute($data, $substitute) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		//テスト実行
		$result = $this->$model->$method($data, $substitute);

		//チェック
		$this->assertTrue($result);
	}

/**
 * substituteのDataProvider
 *
 * #### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return void
 */
	public function dataProviderSubstitute() {
		$data1 = $this->__getData(1);
		$substitute1 = $data1['Holiday'];

		$data2 = $this->__getData(1);
		$substitute2 = $data2['Holiday'];
		$substitute2 = array(
				'1' => array(
					'holiday' => '2016-01-01'),
				'2' => array(
					'holiday' => '2016-01-01'),
				);

		return array(
			array($data1, $substitute1), //振替あり（振替日あり）
			array($data2, $substitute2), //振替あり（振替日なし）
		);
	}

/**
 * SaveManyで失敗テスト
 *
 * @param array $data 登録データ
 * @param array $substitute 日
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @dataProvider dataProviderSaveManyError
 * @return void
 */
	public function testSaveManyError($data, $substitute, $mockModel, $mockMethod) {
		$model = $this->_modelName;
		$method = $this->_methodName;
		$this->_mockForReturnFalse($model, $mockModel, $mockMethod);

		$result = $this->$model->$method($data, $substitute);

		//チェック
		$this->assertFalse($result);
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
	public function dataProviderSaveManyError() {
		$substitute1 = array(
			'1' => array(
				'holiday' => '2017-01-01'),
			'2' => array(
				'holiday' => '2017-01-01'),
			);

		return array(
			array($this->__getData(), $substitute1, 'Holidays.Holiday', 'saveMany'),
		);
	}

}
