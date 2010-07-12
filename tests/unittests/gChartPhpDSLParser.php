<?php
require_once "gChartPhpDSLParser.php";
class UnitTests_gChartPhpDSLParser extends UnitTestCase {

	function test_PieChart() {
		$piChart = new gPieChart();
		$piChart->setTitle("A Title");
		$piChart->addDataSet(array(112,315,66,40));
		$piChart->setLegend(array("first", "second", "third","fourth"));
		$piChart->setLabels(array("first", "second", "third","fourth"));
		$piChart->setColors(array("ff3344", "11ff11", "22aacc", "3333aa"));

		$text = <<< END
newPieChart:
setTitle: A Title
addDataSet: 112,315,66,40
setLegend: first, second, third, fourth
setLabels: first, second, third, fourth
setColors: ff3344, 11ff11, 22aacc, 3333aa
END;

		$parser = new gChartPhpDSLParser();
		$parser->parse($text);

		$this->assertEqual($piChart->getUrl(), $parser->getUrl());
	}

	function test_3DPieChart() {
		$pie3dChart = new gPie3DChart();
		$pie3dChart->addDataSet(array(112,315,66,40));
		$pie3dChart->setLegend(array("first", "second", "third","fourth"));
		$pie3dChart->setLabels(array("first", "second", "third","fourth"));
		$pie3dChart->setColors(array("ff3344", "11ff11", "22aacc", "3333aa"));

		$text = <<< END
newPie3DChart:
addDataSet: 112,315,66,40
setLegend: first, second, third, fourth
setLabels: first, second, third, fourth
setColors: ff3344, 11ff11, 22aacc, 3333aa
END;

		$parser = new gChartPhpDSLParser();
		$parser->parse($text);

		$this->assertEqual($pie3dChart->getUrl(), $parser->getUrl());
	}

	function test_ConcentricPieChart() {
		$CPChart = new gConcentricPieChart();
		$CPChart->addDataSet(array(112,315,66,40));
		$CPChart->addDataSet(array(100,235,346,50));
		$CPChart->addColors(array("008800", "880000"));
		$CPChart->addColors(array("000088", "888800"));
		$CPChart->addLegend(array('1', '2', '3', '4'));
		$CPChart->addLegend(array('1a', '2a', '3a', '4a'));
		$text = <<< END
newConcentricPieChart:
addDataSet: 112,315,66,40
addDataSet: 100,235,346,50
addColors: 008800, 880000
addColors: 000088, 888800
addLegend: 1, 2, 3, 4
addLegend: 1a, 2a, 3a, 4a
END;

		$parser = new gChartPhpDSLParser();
		$parser->parse($text);

		$this->assertEqual($CPChart->getUrl(), $parser->getUrl());
	}

	function test_LineChart() {
		$lineChart = new gLineChart(300,300);
		$lineChart->addDataSet(array(112,315,66,40));
		$lineChart->addDataSet(array(212,115,366,140));
		$lineChart->addDataSet(array(112,95,116,140));
		$lineChart->setLegend(array("first", "second", "third","fourth"));
		$lineChart->setColors(array("ff3344", "11ff11", "22aacc", "3333aa"));
		$lineChart->setVisibleAxes(array('x','y'));
		$lineChart->setDataRange(30,400);
		$lineChart->addAxisRange(0, 1, 4, 1);
		$lineChart->addAxisRange(1, 30, 400);
		$lineChart->addBackgroundFill('bg', 'EFEFEF');
		$lineChart->addBackgroundFill('c', '000000');

		$text = <<< END
newLineChart: 300,300
addDataSet: 112,315,66,40
addDataSet: 212,115,366,140
addDataSet: 112,95,116,140
setLegend: first, second, third, fourth
setColors: ff3344, 11ff11, 22aacc, 3333aa
setVisibleAxes: x, y
setDataRange: 30, 400
addAxisRange: 0, 1, 4, 1
addAxisRange: 1, 30, 400
addBackgroundFill: bg, EFEFEF
addBackgroundFill: c, 000000
END;

		$parser = new gChartPhpDSLParser();
		$parser->parse($text);

		$this->assertEqual($lineChart->getUrl(), $parser->getUrl());
	}

	function test_LineChart_StripFill() {
		$lineChart = new gLineChart(300,300);
		$lineChart->addDataSet(array(112,315,66,40));
		$lineChart->addDataSet(array(212,115,366,140));
		$lineChart->addDataSet(array(112,95,116,140));
		$lineChart->setLegend(array("first", "second", "third","fourth"));
		$lineChart->setColors(array("ff3344", "11ff11", "22aacc", "3333aa"));
		$lineChart->setVisibleAxes(array('x','y'));
		$lineChart->setDataRange(30,400);
		$lineChart->addAxisLabel(0, array("This", "axis", "has", "labels!"));
		$lineChart->addAxisRange(1, 30, 400);
		$lineChart->setStripFill('bg',0,array('CCCCCC',0.15,'FFFFFF',0.1));

		$text = <<< END
newLineChart: 300,300
addDataSet: 112,315,66,40
addDataSet: 212,115,366,140
addDataSet: 112,95,116,140
setLegend: first, second, third, fourth
setColors: ff3344, 11ff11, 22aacc, 3333aa
setVisibleAxes: x, y
setDataRange: 30, 400
addAxisLabel: 0, Labels: This, axis, has, labels!
addAxisRange: 1, 30, 400
setStripFill: bg, 0, Colors: CCCCCC, 0.15, FFFFFF ,0.1

END;

		$parser = new gChartPhpDSLParser();
		$parser->parse($text);

		$this->assertEqual($lineChart->getUrl(), $parser->getUrl());

	}

	function test_LineChart_LineFill() {
		$lineChart = new gLineChart(300,300);
		$lineChart->addDataSet(array(112,125,66,40));
		$lineChart->setLegend(array("first"));
		$lineChart->setColors(array("ff3344"));
		$lineChart->setVisibleAxes(array('x','y'));
		$lineChart->setDataRange(30,130);
		$lineChart->addAxisRange(0, 1, 4, 1);
		$lineChart->addAxisRange(1, 30, 130);
		$lineChart->addLineFill('B','76A4FB',0,0);

		$text = <<< END
newLineChart: 300,300
addDataSet: 112,125,66,40
setLegend: first
setColors: ff3344
setVisibleAxes: x, y
setDataRange: 30, 130
addAxisRange: 0, 1, 4, 1
addAxisRange: 1, 30, 130
addLineFill: B,76A4FB,0,0

END;

		$parser = new gChartPhpDSLParser();
		$parser->parse($text);

		$this->assertEqual($lineChart->getUrl(), $parser->getUrl());

	}

	function test_LineChart_GridLines() {
		$lineChart = new gLineChart(300,300);
		$lineChart->addDataSet(array(112,315,66,40));
		$lineChart->addDataSet(array(212,115,366,140));
		$lineChart->addDataSet(array(112,95,116,140));
		$lineChart->setLegend(array("first", "second", "third","fourth"));
		$lineChart->setColors(array("ff3344", "11ff11", "22aacc", "3333aa"));
		$lineChart->setVisibleAxes(array('x','y'));
		$lineChart->setDataRange(0,400);
		$lineChart->addAxisRange(0, 1, 4, 1);
		$lineChart->addAxisRange(1, 0, 400);
		$lineChart->setGridLines(33,10);

		$text = <<< END
newLineChart: 300,300
addDataSet: 112,315,66,40
addDataSet: 212,115,366,140
addDataSet: 112,95,116,140
setLegend: first, second, third, fourth
setColors: ff3344, 11ff11, 22aacc, 3333aa
setVisibleAxes: x, y
setDataRange: 0, 400
addAxisRange: 0, 1, 4, 1
addAxisRange: 1, 0, 400
setGridLines: 33,10

END;

		$parser = new gChartPhpDSLParser();
		$parser->parse($text);

		$this->assertEqual($lineChart->getUrl(), $parser->getUrl());
	}
	/** TODO:
	 * Grouped Bar Chart
	 * Horizontal Grouped Bar Chart
	 * Stacked Bar Chart
	 * Horizontal Stacked Bar Chart
	 * Venn Diagram
	 * Latex Formula
	 * QR Code
	 * Google-o-Meter
	 * Map Chart
	 * Scatter Chart
	 * Grouped Bar Chart
	 * Candlestick Chart
	 */
}
