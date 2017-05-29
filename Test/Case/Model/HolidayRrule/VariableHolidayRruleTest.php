<?php
/**
 * HolidayRrule::variable()のテスト
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
 * HolidayRrule::variable()のテスト
 *
 * @author Allcreator <info@allcreator.net>
 * @package NetCommons\Holidays\Test\Case\Model\HolidayRrule
 */
class HolidayRruleVariableHolidayRruleTest extends NetCommonsModelTestCase {

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
	protected $_methodName = 'variable';

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
						'month' => '01',
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
 * Variableのテスト
 *
 * @param array $data
 * @param array $day
 * @param array $expected 期待値（取得したキー情報）
 * @dataProvider dataProviderVariable
 *
 * @return void
 */
	public function testVariable($data, $day, $expected) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		//テスト実行
		$result = $this->$model->$method($data, $day);

		//チェック
		$this->assertEquals($result, $expected);
	}

/**
 * variableのDataProvider
 *
 * #### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return void
 */
	public function dataProviderVariable() {
		$data1 = $this->__getData();
		$data1['HolidayRrule']['is_variable'] = false;

		$data2 = $this->__getData();
		$data2['HolidayRrule']['week'] = 2; //第2週

		$data3 = $this->__getData();
		$data3['HolidayRrule']['week'] = -1; //最終週

		return array(
			array($data1, '2017-01-01', '2017-01-01'), //固定
			array($data2, '2017-01-01', '2017-01-08'), //可変、最終週ではない（2017年1月第2週の日曜日）
			array($data3, '2017-01-01', '2017-01-29'), //可変、最終週
		);
	}

}
