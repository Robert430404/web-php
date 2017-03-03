<?php
/* $Id$ */
$defaults = array(
    "lang"            => myphpnet_language(),
    "current"         => "",
    "meta-navigation" => array(),
    'classes'         => '',
    'layout_span'     => 9,
    "cache"           => false,
    "headsup"         => "",
);

$headerConfig            = array_merge($defaults, $headerConfig);
$headerConfig["headsup"] = get_news_changes();

if (!$headerConfig["headsup"]) {
    $headerConfig["headsup"] = get_near_usergroups();
}

$lang    = language_convert($headerConfig["lang"]);
$curr    = $headerConfig["current"];
$classes = $headerConfig['classes'];

if (isset($_COOKIE["MD"]) || isset($_GET["MD"])) {
    $classes .= "markdown-content";
    $headerConfig["css_overwrite"] = array("/styles/i-love-markdown.css");
}

if (empty($pageTitle)) {
    $pageTitle = "Hypertext Preprocessor";
}

// shorturl; http://wiki.snaplog.com/short_url
if (isset($page) && $shortname = get_shortname($page)) {
    $shorturl = "http://php.net/" . $shortname;
}

$css_files = array(
    '/fonts/Fira/fira.css',
    '/fonts/Font-Awesome/css/fontello.css',
    '/styles/theme-base.css',
    '/styles/theme-medium.css',
);

if (isset($headerConfig['css'])) {
    $css_files = array_merge($css_files, (array) $headerConfig['css']);
}
if (isset($headerConfig["css_overwrite"])) {
    $css_files = $headerConfig["css_overwrite"];
}

foreach($css_files as $filename) {
    // files that do not start with / are assumed to be located in the /styles
    // directory
    if ($filename[0] !== '/') {
        $filename = "/styles/$filename";
    }
    $path = dirname(__DIR__) . $filename;
    $CSS[$filename] = @filemtime($path);
}


if (isset($shortname) && $shortname) {
    header("Link: <$shorturl>; rel=shorturl");
}

if ($headerConfig["cache"]) {
    if (is_numeric($headerConfig["cache"])) {
        $timestamp = $headerConfig["cache"];
    } else {
        $timestamp = filemtime($_SERVER["DOCUMENT_ROOT"] . "/" .$_SERVER["BASE_PAGE"]);
    }
    $tsstring = gmdate("D, d M Y H:i:s ", $timestamp) . "GMT";

    if (isset($_SERVER["HTTP_IF_MODIFIED_SINCE"]) && $_SERVER["HTTP_IF_MODIFIED_SINCE"] == $tsstring) {
        header("HTTP/1.1 304 Not Modified");
        exit;
    }
    header("Last-Modified: " . $tsstring);
}
if (!isset($headerConfig["languages"])) {
    $headerConfig["languages"] = array();
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo $lang?>">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PHP: <?php echo $pageTitle ?></title>

    <link rel="shortcut icon" href="<?php echo $MYSITE ?>favicon.ico">
    <link rel="search" type="application/opensearchdescription+xml" href="http://php.net/phpnetimprovedsearch.src" title="Add PHP.net search">
    <link rel="alternate" type="application/atom+xml" href="<?php echo $MYSITE ?>releases/feed.php" title="PHP Release feed">
    <link rel="alternate" type="application/atom+xml" href="<?php echo $MYSITE ?>feed.atom" title="PHP: Hypertext Preprocessor">

    <?php if (isset($page)) : ?>
        <link rel="canonical" href="http://php.net/<?php echo $page; ?>">
        <?php if ($shortname): ?>
            <link rel="shorturl" href="<?php echo $shorturl ?>">
            <link rel="alternate" href="<?php echo $shorturl ?>" hreflang="x-default">
        <?php endif ?>
    <?php endif ?>

    <?php foreach($headerConfig["meta-navigation"] as $rel => $page): ?>
        <link rel="<?php echo $rel ?>" href="<?php echo $MYSITE ?><?php echo $page ?>">
    <?php endforeach ?>

    <?php foreach($headerConfig["languages"] as $code): ?>
        <link rel="alternate" href="<?php echo $MYSITE ?>manual/<?php echo $code?>/<?php echo $headerConfig["thispage"] ?>" hreflang="<?php echo $code?>">
    <?php endforeach ?>

    <?php foreach($CSS as $filename => $modified): ?>
        <link rel="stylesheet" type="text/css" href="<?php echo $MYSITE ?>cached.php?t=<?php echo $modified?>&amp;f=<?php echo $filename?>" media="screen">
    <?php endforeach ?>

    <!--[if lte IE 7]>
    <link rel="stylesheet" type="text/css" href="<?php echo $MYSITE ?>styles/workarounds.ie7.css" media="screen">
    <![endif]-->

    <!--[if lte IE 8]>
    <script type="text/javascript">
        window.brokenIE = true;
    </script>
    <![endif]-->

    <!--[if lte IE 9]>
    <link rel="stylesheet" type="text/css" href="<?php echo $MYSITE ?>styles/workarounds.ie9.css" media="screen">
    <![endif]-->

    <!--[if IE]>
    <script type="text/javascript" src="<?php echo $MYSITE ?>js/ext/html5.js"></script>
    <![endif]-->

    <?php if (!empty($_SERVER["BASE_HREF"])): ?>
        <base href="<?php echo $_SERVER["BASE_HREF"] ?>">
    <?php endif ?>

</head>
<body class="<?php print $curr; ?> <?php echo $classes; ?>">

<nav id="head-nav" class="navbar navbar-fixed-top">
    <div class="navbar-inner clearfix">
        <a href="/" class="brand"><img src="/images/logos/php-logo.svg" width="48" height="24" alt="php"></a>
        <div id="mainmenu-toggle-overlay"></div>
        <input type="checkbox" id="mainmenu-toggle">
        <ul class="nav">
            <li class="<?php echo $curr == "downloads" ? "active" : ""?>"><a href="/downloads">Downloads</a></li>
            <li class="<?php echo $curr == "docs" ? "active" : ""?>"><a href="/docs.php">Documentation</a></li>
            <li class="<?php echo $curr == "community" ? "active" : ""?>"><a href="/get-involved" >Get Involved</a></li>
            <li class="<?php echo $curr == "help" ? "active" : ""?>"><a href="/support">Help</a></li>
        </ul>
        <form class="navbar-search" id="topsearch" action="/search.php">
            <input type="hidden" name="show" value="quickref">
            <input type="search" name="pattern" class="search-query" placeholder="Search" accesskey="s">
        </form>
    </div>
    <div id="flash-message"></div>
</nav>
<?php if (!empty($headerConfig["headsup"])): ?>
    <div class="headsup"><?php echo $headerConfig["headsup"]?></div>
<?php endif ?>
<nav id="trick"><div><?php doc_toc("en") ?></div></nav>
<div id="goto">
    <div class="search">
        <div class="text"></div>
        <div class="results"><ul></ul></div>
    </div>
</div>

<?php if (!empty($headerConfig['breadcrumbs'])): ?>
    <div id="breadcrumbs" class="clearfix">
        <div id="breadcrumbs-inner">
            <?php if (isset($headerConfig['next'])): ?>
                <div class="next">
                    <a href="<?php echo $headerConfig['next'][0]; ?>">
                        <?php echo $headerConfig['next'][1]; ?> &raquo;
                    </a>
                </div>
            <?php endif; ?>
            <?php if (isset($headerConfig['prev'])): ?>
                <div class="prev">
                    <a href="<?php echo $headerConfig['prev'][0]; ?>">
                        &laquo; <?php echo $headerConfig['prev'][1]; ?>
                    </a>
                </div>
            <?php endif; ?>
            <ul>
                <?php
                $breadcrumbs = $headerConfig['breadcrumbs'];
                $last = array_pop($breadcrumbs);
                foreach ($breadcrumbs as $crumb) {
                    echo "      <li><a href='{$crumb['link']}'>{$crumb['title']}</a></li>";
                }
                echo "      <li><a href='{$last['link']}'>{$last['title']}</a></li>";

                ?>
            </ul>
        </div>
    </div>
<?php endif; ?>


<?php if (isset($headerConfig['intro']) && $headerConfig['intro']):?>
    <div id="intro" class="clearfix">
        <div class="container">
            <?php
                switch ($page) {
                    case 'index.php' :
                        $this->loadPartial('Intros/homepageIntro');
                        break;
                };
            ?>
        </div>
    </div>
<?php endif;?>


<div id="layout" class="clearfix">
    <section id="layout-content">
