<?php
$intro ='
  <div class="row clearfix">
    <div class="blurb">
      <p>PHP is a popular general-purpose scripting language that is especially suited to web development.</p>
      <p>Fast, flexible and pragmatic, PHP powers everything from your blog to the most popular websites in the world.</p>
    </div>
    <div class="download">
      <h3>Download</h3>
      <ul>';
        foreach (get_active_branches() as $major => $releases) :
          foreach ((array)$releases as $release) :
            $version                 = $release['version'];
            list($major, $minor, $_) = explode('.', $version);

            $intro .= "
              <li>
                <a class='download-link' href='/downloads.php#v$version'>
                  $version
                </a>
                <span class='dot'>&middot;</span>
                <a class='notes' href='/ChangeLog-$major.php#$version'>
                  Release Notes
                </a>
                <span class='dot'>&middot;</span>
                <a class='notes' href='/migration$major$minor'>
                  Upgrading
                </a>
              </li>";
          endforeach;
        endforeach;
$intro .= '
      </ul>
    </div>
  </div>';

include_once __DIR__ . '/Partials/header.php';
?>

<div class="home-content">
<?php foreach($frontpage as $entry) : ?>
  <article class="newsentry">
    <header class="title">
      <time datetime="<?php echo $entry['updated_date_obj']->format(DATE_W3C) ?>">
        <?php echo $entry['updated_date_obj']->format('d M Y') ?>
      </time>
      <h2 class="newstitle">
        <a href="<?php echo $MYSITE; ?><?php echo $entry['striped_link']; ?>" id="<?php echo $entry['parsed_id'] ?>">
          <?php echo $entry["title"] ?>
        </a>
      </h2>
    </header>
    <div class="newscontent">
      <?php echo $entry["content"] ?>
    </div>
  </article>
<?php endforeach; ?>
  <p class="archive"><a href="/archive/">Older News Entries</a></p>
</div>
<?php

$SIDEBAR = "
  $announcements
  <p class='panel'><a href='/cal.php'>User Group Events</a></p>
  <p class='panel'><a href='/thanks.php'>Special Thanks</a></p>
  <p class='panel social-media'>
    <span class='headline'>Social media</span>
    <div class='body'>
      <ul>
        <li>
          <a href='https://twitter.com/official_php'>
            <i class='icon-twitter'></i>
            @official_php
          </a>
        </li>
      </ul>
    </div>
  </p>";

require_once __DIR__ . '/Partials/footer.php';