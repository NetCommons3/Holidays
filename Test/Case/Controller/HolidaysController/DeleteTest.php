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
 * @package NetCommons\Holidays\Test\Case\Controller\HolidaysController
 */
class HolidaysControllerDeleteTest extends NetCommonsControllerTestCase {

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
 * deleteアクションのGETテスト
 *
 * @param string $role ロール
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderDeleteGet
 * @return void
 */
	public function testDeleteGet($role, $urlOptions, $assert, $exception = null, $return = 'view') {
		//ログイン
		if (isset($role)) {
			TestAuthGeneral::login($this, $role);
		}

		//テスト実施
		$url = Hash::merge(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'delete',
		), $urlOptions);

		$this->_testGetAction($url, $assert, $exception, $return);

		//ログアウト
		if (isset($role)) {
			TestAuthGeneral::logout($this);
		}
	}

/**
 * deleteアクションのGETテスト用DataProvider
 *
 * #### 戻り値
 *  - role: ロール
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderDeleteGet() {
		$results = array();

		$results[0] = array('role' => null,
			'urlOptions' => array('key' => 1),
			'assert' => null, 'exception' => 'ForbiddenException'
		);
		array_push($results, Hash::merge($results[0], array(
			'role' => Role::ROOM_ROLE_KEY_GENERAL_USER,
			'urlOptions' => array('key' => 1,
			'assert' => null, 'exception' => 'ForbiddenException')
		)));

		array_push($results, Hash::merge($results[0], array(
			'role' => Role::ROOM_ROLE_KEY_EDITOR,
			'assert' => null, 'exception' => 'ForbiddenException'
		)));
		array_push($results, Hash::merge($results[0], array(
			'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
			'assert' => null, 'exception' => 'BadRequestException'
		)));
		array_push($results, Hash::merge($results[0], array(
			'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
			'assert' => null, 'exception' => 'BadRequestException', 'return' => 'json'
		)));

		return $results;
	}

/**
 * deleteアクションのPOSTテスト
 *
 * @param array $data POSTデータ
 * @param string $role ロール
 * @param array $urlOptions URLオプション
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderDeletePost
 * @return void
 */
	public function testDeletePost($data, $role, $urlOptions, $exception = null, $return = 'view') {
		//ログイン
		if (isset($role)) {
			TestAuthGeneral::login($this, $role);
		}

		//テスト実施
		$this->_testPostAction('delete', $data, Hash::merge(array('action' => 'delete'), $urlOptions), $exception, $return);

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
 * deleteアクションのPOSTテスト用DataProvider
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
	public function dataProviderDeletePost() {
		return array(
			//ログインなし
			array(
				'data' => null, 'role' => null,
				'urlOptions' => array('key' => 1),
				'exception' => 'ForbiddenException'
			),
			//作成権限のみ
			array(
				'data' => null, 'role' => Role::ROOM_ROLE_KEY_GENERAL_USER,
				'urlOptions' => array('key' => 1),
				'exception' => 'ForbiddenException'
			),
			//編集権限あり
			array(
				'data' => null, 'role' => Role::ROOM_ROLE_KEY_EDITOR,
				'urlOptions' => array('key' => 1),
				'exception' => 'ForbiddenException'
			),
			//公開権限あり（ID指定あり）
			array(
				'data' => null, 'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
				'urlOptions' => array('key' => 1),
			),
			//公開権限あり（ID指定なし）
			array(
				'data' => null, 'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
				'urlOptions' => array('key' => 0),
				'exception' => 'BadRequestException'
			),
			array(
				'data' => null, 'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
				'urlOptions' => array('key' => 0),
				'exception' => 'BadRequestException', 'return' => 'json'
			),
		);
	}

/**
 * deleteアクションのExceptionErrorテスト
 *
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @param array $data POSTデータ
 * @param array $urlOptions URLオプション
 * @param string $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderDeleteExceptionError
 * @return void
 */
	public function testDeleteExceptionError($mockModel, $mockMethod, $data, $urlOptions, $exception = null, $return = 'view') {
		list($mockPlugin, $mockModel) = pluginSplit($mockModel);
		$Mock = $this->getMockForModel($mockPlugin . '.' . $mockModel, array($mockMethod));
		$Mock->expects($this->once())
			->method($mockMethod)
			->will($this->returnValue(false));
		$this->testDeletePost($data, Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR, $urlOptions, $exception, $return);
	}

/**
 * deleteアクションのExceptionErrorテスト用DataProvider
 *
 * #### 戻り値
 *  - mockModel: Mockのモデル
 *  - mockMethod: Mockのメソッド
 *  - data: 登録データ
 *  - urlOptions: URLオプション
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderDeleteExceptionError() {
		return array(
			array(
				'mockModel' => 'Holidays.Holiday', 'mockMethod' => 'deleteHoliday', 'data' => null,
				'urlOptions' => array('key' => 1),
				'exception' => 'BadRequestException'
			),
			array(
				'mockModel' => 'Holidays.Holiday', 'mockMethod' => 'deleteHoliday', 'data' => null,
				'urlOptions' => array('key' => 1),
				'exception' => 'BadRequestException', 'return' => 'json'
			),
		);
	}

}
