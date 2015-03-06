<?php

require __DIR__ . '/vendor/autoload.php';

date_default_timezone_set( 'Europe/Stockholm' );

use MVar\Apache2LogParser\AccessLogParser;
use MVar\Apache2LogParser\LogIterator;

class clickLog {


  private $parser;
  private $lastEntry;
  private $datafile;
  private $lines;

  function __construct( $file = '' ) {

    $this->parser = new AccessLogParser( AccessLogParser::FORMAT_COMBINED );

    if ( !file_exists( $file ) ) {
      die( "uhm, $file does not exist\n" );
    }

    $this->datafile = $file;

  }


  function processLastEntry() {

    //    print_r( $this->lastEntry );
  }

  /**
   * Count number of lines in a textfile, props 'jack' at Stackoverflow: http://stackoverflow.com/a/20537130/1792591
   *
   * @param string  $file
   * @return int
   */
  function getLines( $file ) {
    $f = fopen( $file, 'rb' );
    $lines = 0;

    while ( !feof( $f ) ) {
      $lines += substr_count( fread( $f, 8192 ), "\n" );
    }

    fclose( $f );

    return $lines;
  }

  function run() {

    $lines = $this->getLines( $this->datafile );
    echo "$lines of lines in this file\n";
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

PHP_Timer::start();

$clickLog = new clickLog( $file );
$clickLog->run();

print PHP_Timer::resourceUsage();
