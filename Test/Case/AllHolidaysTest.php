<?php
/**
 * Holidays All Test Suite
 *
 * @author AllCreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
App::uses('NetCommonsTestSuite', 'NetCommons.TestSuite');

/**
 * Holidays All Test Suite
 *
 * @author AllCreator <info@allcreator.net>
 * @package NetCommons\Holidays\Test\Case
 * @codeCoverageIgnore
 */
class AllHolidaysTest extends NetCommonsTestSuite {

/**
 * All test suite
 *
 * @return CakeTestSuite
 */
	public static function suite() {
		$plugin = preg_replace('/^All([\w]+)Test$/', '$1', __CLASS__);
		$suite = new NetCommonsTestSuite(sprintf('All %s Plugin tests', $plugin));
		$suite->addTestDirectoryRecursive(CakePlugin::path($plugin) . 'Test' . DS . 'Case');
		return $suite;
	}
}
