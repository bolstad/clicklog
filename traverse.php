<?php

require __DIR__ . '/vendor/autoload.php';

date_default_timezone_set( 'Europe/Stockholm' );

use MVar\Apache2LogParser\AccessLogParser;
use MVar\Apache2LogParser\LogIterator;

class clickLog {


  private $parser;
  private $lastEntry;
  private $datafile;

  function __construct( $file = '' ) {

    $this->parser = new AccessLogParser( AccessLogParser::FORMAT_COMBINED );

    if ( !file_exists( $file ) ) {
      die( "uhm, $file does not exist\n" );
    }

    $this->datafile = $file;

  }


  function processLastEntry() {

    print_r( $this->lastEntry );
  }

  function run() {
    foreach ( new LogIterator( $this->datafile, $this->parser ) as $line => $data ) {

      try {
        $this->lastEntry = $this->parser->parseLine( $line );
        $this->processLastEntry();

      }
      catch( MVar\Apache2LogParser\Exception\NoMatchesException $noMatch ) {

      }
    }


  }
}


if ( empty( $argv[1] ) ) {
  die( "syntax: php $argv[0] filename\n" );
}

$file = $argv[1];

$clickLog = new clickLog( $file );
$clickLog->run();
