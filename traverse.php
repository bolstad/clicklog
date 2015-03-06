<?php

require __DIR__ . '/vendor/autoload.php';

date_default_timezone_set( 'Europe/Stockholm' );

use MVar\Apache2LogParser\AccessLogParser;
use MVar\Apache2LogParser\LogIterator;

$parser = new AccessLogParser( AccessLogParser::FORMAT_COMBINED );

if ( empty( $argv[1] ) ) {
  die( "syntax: php $argv[0] filename\n" );
}

$file = $argv[1];
if ( !file_exists( $file ) ) {
  die( "uhm, $file does not exist\n" );
}


foreach ( new LogIterator( $file, $parser ) as $line => $data ) {
  try {

    $data = $parser->parseLine( $line );
    print_r( $data );

  }

  catch( MVar\Apache2LogParser\Exception\NoMatchesException $noMatch ) {

  }




}
