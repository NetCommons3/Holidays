<?php
/**
 * Holidays Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
App::uses('CakeTime', 'Utility');
App::uses('HolidaysAppController', 'Holidays.Controller');

/**
 * Holidays Controller
 *
 * @author Allcreator <info@allcreator.net>
 * @package NetCommons\Holidays\Controller
 */
class HolidaysController extends HolidaysAppController {

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		'Languages.Language'
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'M17n.SwitchLanguage',
		'Holidays.Holidays'
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.NetCommonsTime',
		'NetCommons.Date',
		'NetCommons.Button',
		'NetCommons.NetCommonsHtml',
	);

/**
 * Called before the controller action. You can use this method to configure and customize components
 * or perform logic that needs to happen before each controller action.
 *
 * @return void
 * @link http://book.cakephp.org/2.0/en/controllers.html#request-life-cycle-callbacks
 */
	public function beforeFilter() {
		parent::beforeFilter();
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$targetYear = null;
		// 指定年取り出し
		if (isset($this->params['named']['targetYear'])) {
			$targetYear = $this->params['named']['targetYear'];
		} else {
			$targetYear = CakeTime::format((new NetCommonsTime())->getNowDatetime(), '%Y');
		}
		// 祝日設定リスト取り出し
		$holidays = $this->Holiday->getHolidayInYear($targetYear);
		// View変数設定
		$this->set('holidays', $holidays);
		$this->set('targetYear', $targetYear);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			// 登録処理
			if (! $this->HolidayRrule->saveHolidayRrule($this->request->data)) {
				$this->NetCommons->handleValidationError($this->HolidayRrule->validationErrors);
				return;
			}
			// 登録正常時
			$this->redirect('/holidays/holidays/index/');
			return;
		}
		// デフォルトデータ取り出し
		$data = $this->HolidayRrule->create();
		$holiday = $this->Holiday->create();
		// 新規登録画面表示
		$this->request->data = $data;

		$lang = $this->Language->find('all');
		$langIds = Hash::combine($lang, '{n}.Language.id', '{n}.Language.id');

		foreach ($langIds as $langId) {
			$holiday['Holiday']['language_id'] = $langId;
			$this->request->data['Holiday'][$langId] = $holiday['Holiday'];
		}
	}

/**
 * edit method
 *
 * @param int $rruleId Holiday rule id
 * @return void
 */
	public function edit($rruleId = null) {
		// EditのときはPUTでくる
		if ($this->request->is('put')) {
			// 登録処理
			if (! $this->HolidayRrule->saveHolidayRrule($this->request->data)) {
				$this->NetCommons->handleValidationError($this->HolidayRrule->validationErrors);
				return;
			}
			// 登録正常時
			$this->redirect('/holidays/holidays/index/');
			return;
		}
		// ruleIdの指定がない場合エラー
		// データ取り出し
		$rrule = $this->HolidayRrule->find('first', array(
			'conditions' => array(
				'HolidayRrule.id' => $rruleId),
		));
		// データがない場合エラー FUJI

		$holiday = $this->Holiday->find('all', array(
			'conditions' => array(
				'holiday_rrule_id' => $rruleId,
				'is_substitute' => false, //kuma (振替休日がタイトルに出てしまうため)
			),
		));
		$holiday = Hash::combine($holiday, '{n}.Holiday.language_id', '{n}.Holiday');

		// 編集画面表示
		$this->request->data = $rrule;
		$this->request->data['Holiday'] = $holiday;
	}

/**
 * delete method
 *
 * @param int $rruleId Holiday rule id
 * @throws NotFoundException
 * @return void
 */
	public function delete($rruleId = null) {
		if (! $this->request->is('delete')) { // test
			$this->throwBadRequest();
			return;
		}
		// ruleIdの指定がない場合エラー
		// 削除処理

		if (!$this->Holiday->deleteHoliday($rruleId)) {
			$this->throwBadRequest();
			return;
		}

		// 画面再表示
		// FUJI 削除しましたのFlashメッセージを設定してから
		// 画面再表示
		$this->redirect('/holidays/holidays/index/');
	}
}
