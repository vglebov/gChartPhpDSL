<?php
/**
 * @author vglebov
 * @date 2010-03-29
 */
class SimpleDSLParser
{
	function __construct() {
		$this->actions = array();
		$this->addPattern("^\#", null); // comment
		$this->addPattern("^\//", null); // comment
		$this->addPattern("^\s*$", null); // blank line
	}
	/**
	 * @param String $pattern regex
	 * @param function $function callback
	 * @param array $params params for calback
	 */
	public function addPattern($pattern, $function, $params = array()) {
		$this->actions[] = array('pattern' => $pattern, 'function' => $function, 'params' => $params);
	}
	/**
	 * @param string $text
	 */
	public function parse($text) {
		$lines = split("[\n|\r]", $text);
		foreach($lines as $line) {
			$action = $this->_recognize($line);
			if (empty($action)) {
				throw new Exception("Can't recognize line [$line]");
			}
			if (isset($action['function'])) {
				call_user_func_array($action['function'], $action['params']);
			}
		}
	}
	/**
	 * @param text $line command text
	 * @return array prepared callback
	 */
	private function _recognize($line) {
		$matches = array();
		foreach($this->actions as $action) {
			$pattern = "#{$action['pattern']}#i";
			if (preg_match($pattern, $line, $matches)) {
				array_shift($matches);
				$params = array_merge($action['params'], $matches);
				return array('function' => $action['function'], 'params' => $params);
			}
		}
		return null;
	}
}
