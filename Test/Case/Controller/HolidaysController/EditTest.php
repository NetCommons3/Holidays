<?php
/**
 * HolidaysController Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * HolidaysController Test Case
 *
 * @author Allcreator <info@allcreator.net>
 * @package NetCommons\Holidays\Test\Case\Controller
 */
class HolidaysControllerEditTest extends NetCommonsControllerTestCase {

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
 * Plugin name
 *
 * @var array
 */
	public $plugin = 'holidays';

/**
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'holidays';

/**
 * テストDataの取得
 *
 * @param int $int ID
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
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
	}

/**
 * editアクションのGETテスト
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderEditGet
 * @return void
 */
	public function testEditGet($urlOptions, $assert, $exception = null, $return = 'view') {
		//テスト実施
		$url = Hash::merge(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'edit',
		), $urlOptions);

		$this->_testGetAction($url, $assert, $exception, $return);
	}

/**
 * editアクションのGETテスト(ログインなし)用DataProvider
 *
 * #### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderEditGet() {
		//$data = $this->__getData1);
		$results = array();

		//ログインなし
		$results[0] = array(
			'urlOptions' => array(),
			'assert' => null, 'exception' => 'ForbiddenException'
		);
		return $results;
	}

/**
 * editアクションのGETテスト(権限あり)
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderEditGetByAdmin
 * @return void
 */
	public function testEditGetByAdmin($urlOptions, $assert, $exception = null, $return = 'view') {
		//ログイン
		TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR);

		$this->testEditGet($urlOptions, $assert, $exception, $return);

		//ログアウト
		TestAuthGeneral::logout($this);
	}

/**
 * editアクションのGETテスト(権限あり)用DataProvider
 *
 * #### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderEditGetByAdmin() {
		//$data = $this->__getData();
		$results = array();

		//権限あり
		//データなし
		$results[0] = array(
			'urlOptions' => array(-1),
			'assert' => null, 'exception' => 'BadRequestException'
		);
		$results[1] = array(
			'urlOptions' => array(-1),
			'assert' => null, 'exception' => 'BadRequestException', 'return' => 'json'
		);
		$results[2] = array(
			'urlOptions' => array(99),
			'assert' => null, 'exception' => 'BadRequestException'
		);
		$results[3] = array(
			'urlOptions' => array(99),
			'assert' => null, 'exception' => 'BadRequestException', 'return' => 'json'
		);
		$results[4] = array(
			'urlOptions' => array(1),
			'assert' => array('method' => 'assertNotEmpty'),
		);
		$base = 4;
		array_push($results, Hash::merge($results[$base], array(
			'assert' => array('method' => 'assertInput', 'type' => 'input', 'name' => 'data[Holiday][2][title]', 'value' => ''), //ja
		)));
		array_push($results, Hash::merge($results[$base], array(
			'assert' => array('method' => 'assertInput', 'type' => 'button', 'name' => 'save', 'value' => null),
		)));
		array_push($results, Hash::merge($results[$base], array(
			'assert' => array('method' => 'assertInput', 'type' => 'button', 'name' => 'delete', 'value' => null),
		)));

		return $results;
	}

/**
 * editアクションのPUTテスト
 *
 * @param array $data PUTデータ
 * @param string $role ロール
 * @param array $urlOptions URLオプション
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderEditPut
 * @return void
 */
	public function testEditPut($data, $role, $urlOptions, $exception = null, $return = 'view') {
		//ログイン
		if (isset($role)) {
			TestAuthGeneral::login($this, $role);
		}

		//テスト実施
		$this->_testPostAction('put', $data, Hash::merge(array('action' => 'edit'), $urlOptions), $exception, $return);

		//正常の場合、リダイレクト
		if (! $exception) {
			$header = $this->controller->response->header();
			$this->assertNotEmpty($header['Location']);
		}

		//ログアウト
		if (isset($role)) {
			TestAuthGeneral::logout($this);
		}
	}

/**
 * editアクションのPUTテスト用DataProvider
 *
 * #### 戻り値
 *  - data: 登録データ
 *  - role: ロール
 *  - urlOptions: URLオプション
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderEditPut() {
		$data = $this->__getData();

		return array(
			//ログインなし
			array(
				'data' => $data, 'role' => null,
				'urlOptions' => array(),
				'exception' => 'ForbiddenException'
			),
			//システム管理者
			array(
				'data' => $data, 'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
				'urlOptions' => array(),
			),
			//一般
			array(
				'data' => $data, 'role' => Role::ROOM_ROLE_KEY_GENERAL_USER,
				'urlOptions' => array(),
				'exception' => 'ForbiddenException'
			),
			//編集者
			array(
				'data' => $data, 'role' => Role::ROOM_ROLE_KEY_EDITOR,
				'urlOptions' => array(),
				'exception' => 'ForbiddenException'
			),
			//サイト管理者
			array(
				'data' => $data, 'role' => Role::ROOM_ROLE_KEY_CHIEF_EDITOR,
				'urlOptions' => array(),
				'exception' => 'ForbiddenException'
			),
		);
	}

/**
 * editアクションのValidateionErrorテスト
 *
 * @param array $data PUTデータ
 * @param array $urlOptions URLオプション
 * @param string|null $validationError ValidationError
 * @dataProvider dataProviderEditValidationError
 * @return void
 */
	public function testEditValidationError($data, $urlOptions, $validationError = null) {
		//ログイン
		TestAuthGeneral::login($this);

		//テスト実施
		$this->_testActionOnValidationError('put', $data, Hash::merge(array('action' => 'edit'), $urlOptions), $validationError);

		//ログアウト
		TestAuthGeneral::logout($this);
	}

/**
 * editアクションのValidationErrorテスト用DataProvider
 *
 * #### 戻り値
 *  - data: 登録データ
 *  - urlOptions: URLオプション
 *  - validationError: バリデーションエラー
 *
 * @return array
 */
	public function dataProviderEditValidationError() {
		$data = $this->__getData();
		$result = array(
			'data' => $data,
			'urlOptions' => array(),
		);

		return array(
			Hash::merge($result, array(
				'validationError' => array(
					'field' => 'HolidayRrule.week',
					'value' => 'a',
					'message' => __d('net_commons', 'Invalid request.'),
				)
			)),
		);
	}

}
