<?php 


require __DIR__ . '/vendor/autoload.php';

date_default_timezone_set('Europe/Stockholm');

use MVar\Apache2LogParser\AccessLogParser;

// Format can be any of predefined `AccessLogParser::FORMAT_*` constants or custom string
$parser = new AccessLogParser(AccessLogParser::FORMAT_COMBINED);

// String which you want to parse
$line = '66.249.78.230 - - [29/Dec/2013:16:07:58 +0200] "GET /my-page/ HTTP/1.1" 200 2490 "-" ' .
    '"Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)"';

$line = '94.234.170.146 - - [11/Feb/2015:11:58:50 +0100] "GET /_img/bg-menu-hover-right-4x24.png HTTP/1.1" 200 649 "http://www.glesys.se/vps.php?gclid=CO394Jne2cMCFaLUcgod-FkAPg" "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_2) AppleWebKit/600.3.18 (KHTML, like Gecko) Version/8.0.3 Safari/600.3.18"';
var_export($parser->parseLine($line));
