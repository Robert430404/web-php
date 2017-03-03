<?php $this->loadPartial('header'); ?>

    <div class="home-content">
        <?php foreach ($frontpage as $entry) : ?>
            <article class="newsentry">
                <header class="title">
                    <time datetime="<?php echo $entry['updated_date_obj']->format(DATE_W3C) ?>">
                        <?php echo $entry['updated_date_obj']->format('d M Y') ?>
                    </time>
                    <h2 class="newstitle">
                        <a href="<?php echo $MYSITE; ?><?php echo $entry['striped_link']; ?>"
                           id="<?php echo $entry['parsed_id'] ?>">
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

<?php $this->loadPartial('footer'); ?>