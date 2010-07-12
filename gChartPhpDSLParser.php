<?php
require_once 'gChart.php';
require_once 'SimpleDSLParser.php';

/**
 * @author vglebov
 * @date 2010-07-11
 */

class gChartPhpDSLParser extends SimpleDSLParser
{
	function getUrl() {
		return $this->chart->getUrl();
	}
	function __construct() {
		parent::__construct();
		$this->addPattern("new(\w+):(.*)", array($this, 'newChart'));
		$this->addPattern("addDataSet:(.*)", array($this, 'callChartMethod'), array('addDataSet'));
		$this->addPattern("setLegend:(.*)", array($this, 'callChartMethod'), array('setLegend'));
		$this->addPattern("addLegend:(.*)", array($this, 'callChartMethod'), array('addLegend'));
		$this->addPattern("setLabels:(.*)", array($this, 'callChartMethod'), array('setLabels'));
		$this->addPattern("setColors:(.*)", array($this, 'callChartMethod'), array('setColors'));
		$this->addPattern("addColors:(.*)", array($this, 'callChartMethod'), array('addColors'));
		$this->addPattern("setVisibleAxes:(.*)", array($this, 'callChartMethod'), array('setVisibleAxes'));
		$this->addPattern("setDataRange:(.*)", array($this, 'callChartMethod2'), array('setDataRange'));
		$this->addPattern("addAxisRange:(.*)", array($this, 'callChartMethod2'), array('addAxisRange'));
		$this->addPattern("setGridLines:(.*)", array($this, 'callChartMethod2'), array('setGridLines'));
		$this->addPattern("addBackgroundFill:(.*)", array($this, 'callChartMethod2'), array('addBackgroundFill'));
		$this->addPattern("addLineFill:(.*)", array($this, 'callChartMethod2'), array('addLineFill'));
		$this->addPattern("setTitle:(.*)", array($this, 'callChartMethod2'), array('setTitle'));
		$this->addPattern("addAxisLabel: (\d+), Labels: (.*)", array($this, 'addAxisLabel'));
		$this->addPattern("setStripFill: (\w+), (\d+), Colors: (.*)", array($this, 'setStripFill'));
	}

	public function newChart($class, $data) {
		$values = split(",[ ]*", trim($data));
		$class = 'g'.$class;
		if($values[0] && $values[0]) {
			$this->chart = new $class($values[0], $values[1]);
		} else {
			$this->chart = new $class();
		}
	}
	public function callChartMethod($method, $data) {
		$values = $this->parse_array($data);
		call_user_func(array($this->chart, $method), $values);
	}
	public function callChartMethod2($method, $data) {
		$values = $this->parse_array($data);
		call_user_func_array(array($this->chart, $method), $values);
	}
	public function addAxisLabel($index, $data) {
		$values = $this->parse_array($data);
		$this->chart->addAxisLabel($index, $values);
	}
	public function setStripFill($filltype, $index, $data) {
		$values = $this->parse_array($data);
		$this->chart->setStripFill(trim($filltype), $index, $values);
	}
	private function parse_array($data) {
		return array_map('trim', split(",[ ]*", trim($data)));
	}
}
