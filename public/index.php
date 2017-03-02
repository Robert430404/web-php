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

$releasenews = 0;
$frontpage   = array();

foreach($NEWS_ENTRIES as $entry) {
    $maybe = false;
    foreach($entry["category"] as $category) {
        if ($category["term"] == "releases") {
            if ($releasenews++ > 5) {
                continue 2;
            }
        }
        if ($category["term"] == "frontpage") {
            $maybe = $entry;
        }
    }
    if ($maybe) {
        $frontpage[] = $maybe;
    }
}

// Prepare announcements.
if (is_array($CONF_TEASER)) {
    $conftype = array(
        'conference' => 'Upcoming conferences',
        'cfp'        => 'Conferences calling for papers',
    );
    $announcements = "";
    foreach($CONF_TEASER as $category => $entries) {
        if ($entries) {
            $announcements .= '<div class="panel">';
            $announcements .= '  <a href="/conferences" class="headline" title="' . $conftype[$category] . '">' . $conftype[$category] .'</a>';
            $announcements .= '<div class="body"><ul>';
            foreach (array_slice($entries, 0, 4) as $url => $title) {
                $title = preg_replace("'([A-Za-z0-9])([\s\:\-\,]*?)call for(.*?)$'i", "$1", $title);
                $announcements .= "<li><a href='$url' title='$title'>$title</a></li>";
            }
            $announcements .= '</ul></div>';
            $announcements .= '</div>';
        }
    }
} else {
    $announcements = '';
}

use Services\Templates\Renderer;

$renderer = new Renderer();

$renderer->render('homepage.php', array(
    'NEWS_ENTRIES' => $NEWS_ENTRIES,
    'CONF_TEASER'  => $CONF_TEASER,
    'MYSITE'       => $MYSITE,
    'frontpage'    => $frontpage,
    'announcements' => $announcements,
));
