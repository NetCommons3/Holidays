<?php
/**
 * Holiday::isHoliday()のテスト
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
 * Holiday::isHoliday()のテスト
 *
 * @author Allcreator <info@allcreator.net>
 * @package NetCommons\Holidays\Test\Case\Model\Holiday
 */
class HolidayIsHolidayTest extends NetCommonsGetTest {

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
	protected $_methodName = 'isHoliday';

/**
 * isHolidayのテスト
 *
 * @param string $exist 判定対象の日付
 * @param bool $expected 期待値
 * @dataProvider dataProviderIsHoliday
 *
 * @return void
 */
	public function testIsHoliday($exist, $expected) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		//テスト実行
		$result = $this->$model->$method($exist);

		//チェック
		$this->assertEquals($expected, $result);
	}

/**
 * isHolidayのDataProvider
 *
 * #### 戻り値
 *  - array チェックする日付文字列
 *  - array 期待値
 *
 * @return array
 */
	public function dataProviderIsHoliday() {
		$existData = date('Y-m-d H:i:s', strtotime('2016-02-11 00:00:00 GMT+09:00')); // 祝日
		$notExistData = date('Y-m-d H:i:s', strtotime('1999-06-06 00:00:00 GMT+09:00')); // 祝日でない

		return array(
			array($existData, true), // 存在する
			array($notExistData, false), // 存在しない
		);
	}

}
