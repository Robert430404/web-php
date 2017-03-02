<?php // vim: et

require_once __DIR__ . '/../src/autoloader.php';

include_once __DIR__ . '/include/pregen-news.inc';
include_once __DIR__ . '/include/pregen-confs.inc';
include_once __DIR__ . '/include/prepend.inc';
include_once __DIR__ . '/include/branches.inc';
include_once __DIR__ . '/include/version.inc';

// Get the modification date of this PHP file
$timestamps = array(@getlastmod());

/*
   The date of prepend.inc represents the age of ALL
   included files. Please touch it if you modify any
   other include file (and the modification affects
   the display of the index page). The cost of stat'ing
   them all is prohibitive.
*/
$timestamps[] = @filemtime(__DIR__ . "/../../public/include/prepend.inc");

// These are the only dynamic parts of the frontpage
$timestamps[] = @filemtime(__DIR__ . "/../../public/include/pregen-confs.inc");
$timestamps[] = @filemtime(__DIR__ . "/../../public/include/pregen-news.inc");
$timestamps[] = @filemtime(__DIR__ . "/../../public/include/version.inc");
$timestamps[] = @filemtime(__DIR__ . "/../../public/js/common.js");

// The latest of these modification dates is our real Last-Modified date
$timestamp = max($timestamps);

// Note that this is not a RFC 822 date (the tz is always GMT)
$tsstring = gmdate("D, d M Y H:i:s ", $timestamp) . "GMT";

// Check if the client has the same page cached
if (isset($_SERVER["HTTP_IF_MODIFIED_SINCE"]) &&
    ($_SERVER["HTTP_IF_MODIFIED_SINCE"] == $tsstring)) {
    header("HTTP/1.1 304 Not Modified");
    exit();
}
// Inform the user agent what is our last modification date
else {
    header("Last-Modified: " . $tsstring);
}

$_SERVER['BASE_PAGE'] = 'index.php';

mirror_setcookie("LAST_NEWS", $_SERVER["REQUEST_TIME"], 60*60*24*365);

use Services\Mappers\HomepageMappers;
use Services\Templates\Renderer;

$renderer = new Renderer();
$mapper   = new HomepageMappers();

$frontpage     = $mapper->mapNewsEntries($NEWS_ENTRIES);
$announcements = $mapper->mapAnnouncements($CONF_TEASER);

$renderer->render('homepage.php', array(
    'MYSITE'        => $MYSITE,
    'frontpage'     => $frontpage,
    'announcements' => $announcements,
));
