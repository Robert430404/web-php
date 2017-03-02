<?php

$intro = '
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
        $version = $release['version'];
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

return $intro;