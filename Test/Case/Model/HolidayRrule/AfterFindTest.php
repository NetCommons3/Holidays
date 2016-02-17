<?php
/**
 * HolidayRrule::afterFind()のテスト
 *
 * @property HolidayRrule $HolidayRrule
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');
App::uses('HolidaysComponent', 'Holidays.Controller/Component');

/**
 * HolidayRrule::afterFind()のテスト
 *
 * @author Allcreator <info@allcreator.net>
 * @package NetCommons\Holidays\Test\Case\Model\HolidayRrule
 */
class HolidayRruleAfterFindTest extends NetCommonsModelTestCase {

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
	protected $_methodName = 'afterFind';

/**
 * テストDataの取得
 *
 * @param int $id rrule_id
 * @return array
 */
	private function __getData($id = null) {
		$data = array(
		'0' => array(
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
		)
		);
		return $data;
	}

/**
 * afterFindのテスト
 *
 * @param array $data data
 * @param array $expected 期待値
 * @dataProvider dataProviderAfterFind
 *
 * @return void
 */
	public function testAfterFind($data, $expected) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		//テスト実行
		$result = $this->$model->$method($data);

		//チェック
		$this->assertEquals($result, $expected);
	}

/**
 * afterFindのDataProvider
 *
 * #### 戻り値
 *  - array データ
 *  - array 期待値
 *
 * @return array
 */
	public function dataProviderAfterFind() {
		//idなし
		$data1 = $this->__getData();

		//is_valiableなし
		$data2 = $this->__getData(1);
		$data2[0]['HolidayRrule']['is_variable'] = null;

		//入力用データ項目設定
		$monthDay = '2001-02-11';
		$data3 = $this->__getData(1);
		$data3[0]['HolidayRrule']['month_day'] = $monthDay;
		$expects3 = $data3;
		$expects3[0]['HolidayRrule']['input_month_day']['month'] = date('m', strtotime($monthDay));
		$expects3[0]['HolidayRrule']['input_month_day']['day'] = date('d', strtotime($monthDay));

		return array(
			array($data1, $data1),
			array($data2, $data2),
			array($data3, $expects3),
		);
	}

}
