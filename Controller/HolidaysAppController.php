<?php
/**
 * HolidaysApp Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * HolidaysAppController
 *
 * @author Allcreator <info@allcreator.net>
 * @package NetCommons\Holidays\Controller
 */
class HolidaysAppController extends AppController {

/**
 * 祝日設定が取り扱う最小日
 *
 * @var string
 */
	const	HOLIDAYS_DATE_MIN = '2001-01-01 00:00:00';

/**
 * 祝日設定が取り扱う最大日
 *
 * @var string
 */
	const	HOLIDAYS_DATE_MAX = '2033-12-31 23:59:59';

/**
 * 日付固定
 *
 * @var int
 */
	const	HOLIDAYS_FIXED = '0';

/**
 * 週曜日指定
 *
 * @var int
 */
	const	HOLIDAYS_VARIABLE = '1';

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		'Holidays.Holiday',
		'Holidays.HolidayRrule',
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'ControlPanel.ControlPanelLayout',
		//アクセスの権限
		'NetCommons.Permission' => array(
			'type' => PermissionComponent::CHECK_TYEP_SYSTEM_PLUGIN,
			'allow' => array()
		),
		'Security',
	);
}
