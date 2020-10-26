<?php

// Config
include 'config.php';

// MySQL
include 'functions/mysql.php';

// Funcions
include 'functions/functions.php';

?>

<!DOCTYPE html>
<html>

  <!-- Head -->
  <?php include 'templates/head.php'; ?>

  <body>

    <!-- Nav -->
    <?php include 'templates/nav.php'; ?>

    <!-- Header -->
    <?php
      $highlight = getHighlight($db);
      if($highlight != '') {
        $highlight_likes = getPostLikes($db, $highlight['id']);
        $highlight_user = getPostUser($db, $highlight['id_user']);
        include 'templates/header.php';
      }
    ?>

    <!-- Popular -->
    <?php $popular_posts = getPopularPosts($db); ?>
    <?php if(count($popular_posts) >= 4): ?>
      <div class="section pt-lg-5 pb-lg-5">
        <div class="container-fluid">
          <div class="row mb-lg-4">
            <div class="col-lg-9">
              <div class="v-m">
                <div class="section-title">Cele mai populare</div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6 pr-75">
              <a href="<?php echo URL; ?>post/<?php echo $popular_posts[0]['slug']; ?>">
                <div class="box">
                  <div class="box-image" style="background-image: url('<?php echo URL; ?>app/posts/<?php echo $popular_posts[0]['image']; ?>');"></div>
                  <div class="box-title title-lg mt-lg-2 mb-lg-1"><?php echo $popular_posts[0]['title']; ?></div>
                  <div class="box-info">
                    <div class="pr-lg-2 mr-lg-2"><?php echo strtoupper($popular_posts[0]['category']); ?></div>
                    <div><?php echo strtoupper(strftime('%e %B, %Y', strtotime($popular_posts[0]['post_date']))); ?></div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-lg-6">
              <div class="row">
                <div class="col-lg-4 pl-75 pr-75">
                  <a href="<?php echo URL; ?>post/<?php echo $popular_posts[1]['slug']; ?>">
                    <div class="box">
                      <div class="box-image" style="background-image: url('<?php echo URL; ?>app/posts/<?php echo $popular_posts[1]['image']; ?>');"></div>
                      <div class="box-title mt-lg-2 mb-lg-1"><?php echo $popular_posts[1]['title']; ?></div>
                      <div class="box-info">
                        <div class="pr-lg-2 mr-lg-2"><?php echo strtoupper($popular_posts[1]['category']); ?></div>
                        <div><?php echo strtoupper(strftime('%e %B, %Y', strtotime($popular_posts[1]['post_date']))); ?></div>
                      </div>
                    </div>
                  </a>
                </div>
                <div class="col-lg-4 pl-75 pr-75">
                  <a href="<?php echo URL; ?>post/<?php echo $popular_posts[2]['slug']; ?>">
                    <div class="box">
                      <div class="box-image" style="background-image: url('<?php echo URL; ?>app/posts/<?php echo $popular_posts[2]['image']; ?>');"></div>
                      <div class="box-title mt-lg-2 mb-lg-1"><?php echo $popular_posts[2]['title']; ?></div>
                      <div class="box-info">
                        <div class="pr-lg-2 mr-lg-2"><?php echo strtoupper($popular_posts[2]['category']); ?></div>
                        <div><?php echo strtoupper(strftime('%e %B, %Y', strtotime($popular_posts[2]['post_date']))); ?></div>
                      </div>
                    </div>
                  </a>
                </div>
                <div class="col-lg-4 pl-75">
                  <a href="<?php echo URL; ?>post/<?php echo $popular_posts[3]['slug']; ?>">
                    <div class="box">
                      <div class="box-image" style="background-image: url('<?php echo URL; ?>app/posts/<?php echo $popular_posts[3]['image']; ?>');"></div>
                      <div class="box-title mt-lg-2 mb-lg-1"><?php echo $popular_posts[3]['title']; ?></div>
                      <div class="box-info">
                        <div class="pr-lg-2 mr-lg-2"><?php echo strtoupper($popular_posts[3]['category']); ?></div>
                        <div><?php echo strtoupper(strftime('%e %B, %Y', strtotime($popular_posts[3]['post_date']))); ?></div>
                      </div>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    <?php endif; ?>

    <!-- Latest -->
    <?php $latest_posts = getLatestPosts($db, array(($highlight['id'] ? $highlight['id'] : null), $popular_posts[0]['id'], $popular_posts[1]['id'], $popular_posts[2]['id'], $popular_posts[3]['id'])); ?>
    <?php if(count($latest_posts) > 0): ?>
      <div class="section pt-lg-5 pb-lg-5">
        <div class="container-fluid">
          <div class="row mb-lg-4">
            <div class="col-lg-9">
              <div class="v-m">
                <div class="section-title">Ultimele noutati</div>
              </div>
            </div>
          </div>
          <div class="row">
            <?php $i = 1; ?>
            <?php foreach($latest_posts as $latest_post): ?>
              <div class="col-lg-3 pl-75 pr-75 <?php echo ($i == 1 ? 'pl-lg-3' : ($i == 4 ? 'pr-lg-3' : '')); ?>">
                <a href="<?php echo URL; ?>post/<?php echo $latest_post['slug']; ?>">
                  <div class="box mb-lg-4">
                    <div class="box-image box-image-lg" style="background-image: url('<?php echo URL; ?>app/posts/<?php echo $latest_post['image']; ?>');"></div>
                    <div class="box-title title-lg mt-lg-2 mb-lg-1"><?php echo $latest_post['title']; ?></div>
                    <div class="box-info">
                      <div class="pr-lg-2 mr-lg-2"><?php echo strtoupper($latest_post['category']); ?></div>
                      <div><?php echo strtoupper(strftime('%e %B, %Y', strtotime($latest_post['post_date']))); ?></div>
                    </div>
                  </div>
                </a>
              </div>
              <?php $i = (++$i) % 5; ?>
              <?php if($i == 0) $i++; ?>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    <?php endif; ?>

  </body>

</html>
