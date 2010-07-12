<?php

if ( !defined( 'MEDIAWIKI' ) ) die();

// credits
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Burn Down Chart',
	'version' => '0.1',
	'author' => 'Vadim Glebov',
	'url' => 'http://www.google.com/profiles/vglebov',
	'description' => 'An extension to use BDC in your wiki.'
);

$wgExtensionFunctions[] = "jfBurnDownChart";

function jfBurnDownChart() {
	global $wgParser;
	$wgParser->setHook( "gChartPhp", "return_gChartPhp" );
}

function return_gChartPhp($code, $args)
{

	require_once "gChartPhpDSLParser.php";
	$parser = new gChartPhpDSLParser();
	$parser->parse($code);

	return "<img src=\"" . $parser->getUrl() . "\"/>";
}

?>