<?php
/**
 * Holiday::saveHoliday()のテスト
 *
 * @property Holiday $Holiday
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsSaveTest', 'NetCommons.TestSuite');

/**
 * Holiday::saveHoliday()のテスト
 *
 * @author Allcreator <info@allcreator.net>
 * @package NetCommons\Holidays\Test\Case\Model\Holiday
 */
class HolidaySaveHolidayTest extends NetCommonsSaveTest {

/**
 * Plugin name
 *
 * @var array
 */
	public $plugin = 'Holidays';

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
	protected $_modelName = 'Holiday';

/**
 * Method name
 *
 * @var array
 */
	protected $_methodName = 'saveHolidays';

/**
 * テストDataの取得
 *
 * @return array
 */
	private function __getData() {
		$data = array(
			'Holiday' => array(
				'holiday_rrule_id' => '1',
				'language_id' => '2',
				'holiday' => '2015-10-31',
				'title' => 'ハロウィン',
				'is_substitute' => 0,
			),
		);
		return $data;
	}

/**
 * SaveのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *
 * @return void
 */
	public function dataProviderSave() {
		$data = $this->__getData();
		return array(
			array($data), //新規
		);
	}

/**
 * SaveのExceptionErrorのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return void
 */
	public function dataProviderSaveOnExceptionError() {
		return array(
			array($this->__getData(), 'Holidays.Holiday', 'save'),
		);
	}

/**
 * SaveのValidationErrorのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *
 * @return void
 */
	public function dataProviderSaveOnValidationError() {
		return array(
			array($this->__getData(), 'Holidays.Holiday'),
		);
	}

/**
 * ValidationErrorのDataProvider
 *
 * ### 戻り値
 *  - field フィールド名
 *  - value セットする値
 *  - message エラーメッセージ
 *  - overwrite 上書きするデータ
 *
 * @return void
 */
	public function dataProviderValidationError() {
		return array(
			array($this->__getData(), 'holiday_rrule_id', '',
				__d('net_commons', 'Invalid request.')),
			array($this->__getData(), 'holiday_rrule_id', null,
				__d('net_commons', 'Invalid request.')),
			array($this->__getData(), 'language_id', '',
				__d('net_commons', 'Invalid request.')),
			array($this->__getData(), 'holiday', '',
				__d('net_commons', 'Invalid request.')),
			array($this->__getData(), 'holiday', 'aaaaa',
				__d('net_commons', 'Invalid request.')),
			array($this->__getData(), 'is_substitute', '',
				__d('net_commons', 'Invalid request.')),
			array($this->__getData(), 'title', '',
				__d('holidays', 'Please input title.')),
		);
	}
}
