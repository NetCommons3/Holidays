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
class HolidaysControllerIndexTest extends NetCommonsControllerTestCase {

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
 * indexアクションのテスト
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @return void
 */
	public function index($urlOptions, $assert, $exception = null, $return = 'view') {
		//テスト実施
		$url = Hash::merge(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'index',
		), $urlOptions);

		$this->_testGetAction($url, $assert, $exception, $return);
	}

/**
 * indexアクションのテスト
 *
 * @param string $role ロール
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderIndex2
 * @return void
 */
	public function testIndex2($role, $urlOptions, $assert, $exception = null, $return = 'view') {
		//ログイン
		if (isset($role)) {
			TestAuthGeneral::login($this, $role);
		}

		$this->index($urlOptions, $assert, $exception, $return);

		//ログアウト
		if (isset($role)) {
			TestAuthGeneral::logout($this);
		}
	}

/**
 * indexアクションのテスト(編集権限あり)用DataProvider
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
	public function dataProviderIndex2() {
		$results = array();

		//一般
		$results[0] = array(
			'role' => Role::ROOM_ROLE_KEY_GENERAL_USER,
			'urlOptions' => array(),
			'assert' => null,
			'exception' => 'ForbiddenException'
		);
		//編集者
		$results[1] = array(
			'role' => Role::ROOM_ROLE_KEY_EDITOR,
			'urlOptions' => array(),
			'assert' => null,
			'exception' => 'ForbiddenException'
		);
		//サイト管理者
		$results[2] = array(
			'role' => Role::ROOM_ROLE_KEY_CHIEF_EDITOR,
			'urlOptions' => array(),
			'assert' => null,
			//'exception' => 'ForbiddenException'
		);
		//システム管理者
		$results[3] = array(
			'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
			'urlOptions' => array(),
			'assert' => null,
			//'exception' => 'ForbiddenException'
		);
		//ログインなし
		$results[4] = array(
			'role' => null,
			'urlOptions' => array(),
			'assert' => null,
			'exception' => 'ForbiddenException'
		);

		return $results;
	}

/**
 * indexアクションのテスト
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderIndexTargetYear
 * @return void
 */
	public function testIndexTargetYear($urlOptions, $assert, $exception = null, $return = 'view') {
		//ログイン
		TestAuthGeneral::login($this);

		$this->index($urlOptions, $assert, $exception, $return);

		//ログアウト
		TestAuthGeneral::logout($this);
	}

/**
 * indexアクションのテスト(ログインなし)用DataProvider
 *
 * #### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderIndexTargetYear() {
		$results = array();

		//年度指定なし
		$results[0] = array(
			'urlOptions' => array(),
			'assert' => array('method' => 'assertNotEmpty'),
		);
		//年度指定あり(2015年（データあり）)
		$results[1] = array(
			'urlOptions' => array('targetYear' => 2015),
			'assert' => array('method' => 'assertTextContains', 'expected' => '01/01'),
		);
		//年度指定あり(2022年（データなし）)
		$results[2] = array(
			'urlOptions' => array('targetYear' => 2022),
			'assert' => array('method' => 'assertTextContains', 'expected' => __d('holidays', 'No holiday')),
		);

		return $results;
	}

}
