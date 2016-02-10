<?php
/**
 * HolidayRrule::getEndYearFromPostData()のテスト
 *
 * @property HolidayRrule $HolidayRrule
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsGetTest', 'NetCommons.TestSuite');
App::uses('NetCommonsTime', 'NetCommons.Utility');

/**
 * HolidayRrule::getHolidayRruleFromPostData()のテスト
 *
 * @author Allcreator <info@allcreator.net>
 * @package NetCommons\Holidays\Test\Case\Model\Holiday
 */
class HolidayRruleGetEndYearFromPostDataTest extends NetCommonsGetTest {

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
	protected $_methodName = 'getEndYearFromPostData';

/**
 * Getのテスト
 *
 * @param array $existYear year
 * @param array $expected 期待値（取得したキー情報）
 * @dataProvider dataProviderGet
 *
 * @return void
 */
	public function testGetEndYearFromPostData($existYear, $expected) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		//テスト実行
		$result = $this->$model->$method($existYear);

		//チェック
		$this->assertEquals($result, $expected);
	}

/**
 * getのDataProvider
 *
 * #### 戻り値
 *  - array 取得するキー情報
 *  - array 期待値 （取得したキー情報）
 *
 * @return array
 */
	public function dataProviderGet() {
		$existYear = array(
				'end_year' => '2015');
		$defaultEndYear = '2033';

		return array(
			array($existYear, 2015),
			array(array(), $defaultEndYear),
		);
	}

}
