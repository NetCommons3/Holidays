<?php
/**
 * Holiday::extractHoliday()のテスト
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
 * Holiday::extractHoliday()のテスト
 *
 * @author Allcreator <info@allcreator.net>
 * @package NetCommons\Holidays\Test\Case\Model\Holiday
 */
class HolidayExtractHolidayTest extends NetCommonsGetTest {

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
	protected $_methodName = 'extractHoliday';

/**
 * Getのテスト
 *
 * @param array $existDays days
 * @param array $expected 期待値（取得したキー情報）
 * @dataProvider dataProviderExtractHoliday
 *
 * @return void
 */
	public function testExtractHoliday($existDays, $expected) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		//テスト実行
		$result = $this->$model->$method($existDays);

		//チェック
		if (empty($result)) {
			$this->assertEquals($expected['id'], '0');
		} else {
			$this->assertEquals($result, $expected);
		}
	}

/**
 * getのDataProvider
 *
 * #### 戻り値
 *  - array 対象日付配列
 *  - array 期待値 （取得した日付配列）
 *
 * @return array
 */
	public function dataProviderExtractHoliday() {
		$existDays = array('2016-03-20 15:00:00', '2016-01-01 00:00:00', '2016-02-10 15:00:00', '2016-10-30 15:00:00');
		$notExistDays = array();

		return array(
			array($existDays, array('2016-03-20 15:00:00', '2016-02-10 15:00:00')), // this is 'id' value! 存在する
			array($notExistDays, array('id' => '0')), // 存在しない
		);
	}

}