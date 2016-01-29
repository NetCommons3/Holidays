<?php
/**
 * HolidaysApp Model
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppModel', 'Model');

/**
 * Summary for HolidayApp Model
 */
class HolidaysAppModel extends AppModel {

/**
 * _getWeekDayNum
 *
 * 曜日（数値）を取得
 *
 * @param string $week 曜日（2byte）（Postデータの'day_of_the_week'）
 * @return int 曜日(数値）
 */
	protected function _getWeekDayNum($week) {
		$weekDay = array(
			'SU' => 0,
			'MO' => 1,
			'TU' => 2,
			'WE' => 3,
			'TH' => 4,
			'FR' => 5,
			'SA' => 6,
		);

		return $weekDay[$week];
	}

/**
 * _getDays
 *
 *  指定期間分の日付を取得する
 *
 * @param array $data データ
 * @param int $start 開始年
 * @param int $end 終了年
 * @return array
 */
	protected function _getDays($data, $start, $end) {
		$ret = array();

		for ($i = $start; $i <= $end; $i++) { // kuma mod
			$ret[] = $i . '-' . substr($data['month_day'], 5);
		}
		return $ret;
	}

/**
 * _concatRRule
 *
 * for NetCommons2
 *
 * @param array $rrule Rrule配列データ
 * @param string &$resultStr $rruleデータから組み立てられたRrule文字列
 * @return bool
 */
	protected function _concatRRule($rrule, &$resultStr) {
		$resultStr = '';
		//$result = array();
		//$freqArray = ['NONE', 'YEARLY', 'MONTHLY', 'WEEKLY', 'DAILY'];
		//if (! (isset($rrule['FREQ']) && in_array($rrule['FREQ'], $freqArray))) {
		//	return false;
		//}
		//if ($rrule['FREQ'] != 'NONE') {
		//	$result = array('FREQ=' . $rrule['FREQ']);
		//	$result[] = 'INTERVAL=' . intval($rrule['INTERVAL']);
		//}
		//if (isset($rrule['BYMONTH'])) {
		//	$result[] = 'BYMONTH=' . implode(',', $rrule['BYMONTH']);
		//}
		//if (! empty($rrule['BYDAY'])) {
		//	$result[] = 'BYDAY=' . implode(',', $rrule['BYDAY']);
		//}
		//if (!empty($rrule['BYMONTHDAY'])) {
		//	$result[] = 'BYMONTHDAY=' . implode(',', $rrule['BYMONTHDAY']);
		//}
		//if (isset($rrule['UNTIL'])) {
		//	$result[] = 'UNTIL=' . $rrule['UNTIL'];
		//} elseif (isset($rrule['COUNT'])) {
		//	$result[] = 'COUNT=' . intval($rrule['COUNT']);
		//}
		//$resultStr = implode(';', $result);
		return true;
	}

}
