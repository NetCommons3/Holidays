<?php
/**
 * Holiday::getHolidayInYear()のテスト
 *
 * @property Holiday $Holiday
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsGetTest', 'NetCommons.TestSuite');

/**
 * Holiday::getHolidayInYear()のテスト
 *
 * @author Allcreator <info@allcreator.net>
 * @package NetCommons\Holidays\Test\Case\Model\Holiday
 */
class HolidayGetHolidayInYearTest extends NetCommonsGetTest {

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
		'plugin.net_commons.site_setting',
		'plugin.holidays.holiday',
	);

/**
 * Model name
 *
 * @var array
 */
	protected $_modelName = 'Holiday';

/**
 * Method name
 *
 * @var array
 */
	protected $_methodName = 'getHolidayInYear';

/**
 * Getのテスト
 *
 * @param array $existYear year
 * @param array $expected 期待値（取得したキー情報）
 * @dataProvider dataProviderGet
 *
 * @return void
 */
	public function testGetHolidayInYear($existYear, $expected) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		//テスト実行
		$result = $this->$model->$method($existYear);

		//チェック
		if (empty($result)) {
			$this->assertEquals($expected['id'], '0');
		} else {
			foreach ($expected as $key => $val) {
				$this->assertEquals($result[$key][$model]['id'], $val);
			}
		}
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
		$existYear = '2015';
		$notExistYear = '2020';

		return array(
			array($existYear, array('2', '4', '6', '8')), // this is 'id' value! 存在する
			array($notExistYear, array('id' => '0')), // 存在しない
		);
	}

}
