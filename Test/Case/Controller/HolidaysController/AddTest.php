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
class HolidaysControllerAddTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.holidays.holiday_rrule',
		'plugin.holidays.holiday',
		'plugin.holidays.plugin4test',
		'plugin.holidays.plugins_role4test',
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
 * addアクションのGETテスト
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderAddGet
 * @return void
 */
	public function testAddGet($urlOptions, $assert, $exception = null, $return = 'view') {
		//テスト実施
		$url = Hash::merge(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'add',
		), $urlOptions);

		$this->_testGetAction($url, $assert, $exception, $return);
	}

/**
 * addアクションのGETテスト(ログインなし)用DataProvider
 *
 * #### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderAddGet() {
		$results = array();

		//ログインなし
		$results[0] = array(
			'urlOptions' => array(),
			'assert' => null, 'exception' => 'ForbiddenException'
		);
		return $results;
	}

/**
 * addアクションのGETテスト(作成権限のみ)
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderAddGetByCreatable
 * @return void
 */
	public function testAddGetByCreatable($urlOptions, $assert, $exception = null, $return = 'view') {
		//ログイン
		TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR);

		$this->testAddGet($urlOptions, $assert, $exception, $return);

		//ログアウト
		TestAuthGeneral::logout($this);
	}

/**
 * addアクションのGETテスト(作成権限あり)用DataProvider
 *
 * #### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderAddGetByCreatable() {
		$results = array();

		//作成権限あり
		$base = 0;
		$results[0] = array(
			'urlOptions' => array(),
			'assert' => array('method' => 'assertNotEmpty'),
		);
		array_push($results, Hash::merge($results[$base], array(
			'assert' => array('method' => 'assertInput', 'type' => 'input', 'name' => 'data[Holiday][2][title]', 'value' => ''),
		)));
		array_push($results, Hash::merge($results[$base], array(
			'assert' => array('method' => 'assertInput', 'type' => 'button', 'name' => 'save', 'value' => null),
		)));

		return $results;
	}

/**
 * addアクションのPOSTテスト
 *
 * @param array $data POSTデータ
 * @param string $role ロール
 * @param array $urlOptions URLオプション
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderAddPost
 * @return void
 */
	public function testAddPost($data, $role, $urlOptions, $exception = null, $return = 'view') {
		//ログイン
		if (isset($role)) {
			TestAuthGeneral::login($this, $role);
		}

		//テスト実施
		$this->_testPostAction('post', $data, Hash::merge(array('action' => 'add'), $urlOptions), $exception, $return);

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
 * addアクションのPOSTテスト用DataProvider
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
	public function dataProviderAddPost() {
		$data = $this->__getData();

		return array(
			//ログインなし
			array(
				'data' => $data, 'role' => null,
				'urlOptions' => array(),
				'exception' => 'ForbiddenException'
			),
			//作成権限あり
			array(
				'data' => $data, 'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
				'urlOptions' => array(),
			),
			//フレームID指定なしテスト
			array(
				'data' => $data, 'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
				'urlOptions' => array(),
			),
		);
	}

/**
 * addアクションのValidateionErrorテスト
 *
 * @param array $data POSTデータ
 * @param array $urlOptions URLオプション
 * @param string|null $validationError ValidationError
 * @dataProvider dataProviderAddValidationError
 * @return void
 */
	public function testAddValidationError($data, $urlOptions, $validationError = null) {
		//ログイン
		TestAuthGeneral::login($this);

		//テスト実施
		$this->_testActionOnValidationError('post', $data, Hash::merge(array('action' => 'add'), $urlOptions), $validationError);

		//ログアウト
		TestAuthGeneral::logout($this);
	}

/**
 * addアクションのValidationErrorテスト用DataProvider
 *
 * #### 戻り値
 *  - data: 登録データ
 *  - urlOptions: URLオプション
 *  - validationError: バリデーションエラー
 *
 * @return array
 */
	public function dataProviderAddValidationError() {
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
