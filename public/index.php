<?php // vim: et

require_once __DIR__ . '/../src/autoloader.php';

include_once __DIR__ . '/include/pregen-news.inc';
include_once __DIR__ . '/include/pregen-confs.inc';
include_once __DIR__ . '/include/prepend.inc';
include_once __DIR__ . '/include/branches.inc';
include_once __DIR__ . '/include/version.inc';

use Services\Mappers\HomepageMappers;
use Services\Templates\Renderer;

$renderer = new Renderer();
$mapper   = new HomepageMappers();

$frontpage     = $mapper->mapNewsEntries($NEWS_ENTRIES);
$announcements = $mapper->mapAnnouncements($CONF_TEASER);
$tsstring      = $mapper->getTimestampString();

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

$renderer->render('homepage.php', array(
    'MYSITE'        => $MYSITE,
    'frontpage'     => $frontpage,
    'announcements' => $announcements
));
