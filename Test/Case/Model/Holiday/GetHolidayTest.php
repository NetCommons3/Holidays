<?php
/**
 * Holiday::getHoliday()のテスト
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
 * Holiday::getHoliday()のテスト
 *
 * @author Allcreator <info@allcreator.net>
 * @package NetCommons\Holidays\Test\Case\Model\Holiday
 */
class HolidayGetHolidayTest extends NetCommonsGetTest {

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
	protected $_methodName = 'getHoliday';

/**
 * Getのテスト
 *
 * @param array $existFrom from
 * @param array $existTo to
 * @param array $expected 期待値（取得したキー情報）
 * @dataProvider dataProviderGet
 *
 * @return void
 */
	public function testGetHoliday($existFrom, $existTo, $expected) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		//テスト実行
		$result = $this->$model->$method($existFrom, $existTo);

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
		$existFrom = '2015-01-01';
		$existTo = '2015-01-31';
		$notExistFrom = '2017-01-01';
		$notExistTo = '2017-01-31';

		return array(
			array($existFrom, $existTo, array('2', '4')), // this is 'id' value! 存在する
			array($notExistFrom, $notExistTo, array('id' => '0')), // 存在しない
		);
	}

}
