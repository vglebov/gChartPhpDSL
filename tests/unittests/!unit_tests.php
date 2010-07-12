<?php
$unittests_dir = realpath(dirname(__FILE__));
$site_dir = realpath(dirname(__FILE__). '/../..');

chdir($site_dir);

set_include_path(implode(PATH_SEPARATOR, array(
	realpath($site_dir),
	realpath($site_dir . '/library'),
	get_include_path(),
)));

chdir($unittests_dir);

require_once($unittests_dir . '/simpletest/autorun.php');
require_once($unittests_dir . '/simpletest/unit_tester.php');
require_once($unittests_dir . '/simpletest/shell_tester.php');
require_once($unittests_dir . '/simpletest/mock_objects.php');
require_once($unittests_dir . '/simpletest/web_tester.php');
require_once($unittests_dir . '/simpletest/extensions/pear_test_case.php');
require_once($unittests_dir . '/simpletest/extensions/phpunit_test_case.php');

class UnitTests extends TestSuite {
	function UnitTests() {
		$this->TestSuite('Unit tests');
		$path = dirname(__FILE__);
		$this->addFile($path . '/gChartPhpDSLParser.php');
	}
}
?>
