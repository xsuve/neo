<?php

// Config
include 'config.php';

// MySQL
include 'functions/mysql.php';

// Session
include 'functions/session.php';

// Session
include 'functions/functions.php';


if(isset($_GET['slug'])) {
  $post_slug = mysqli_real_escape_string($db, $_GET['slug']);

  $post = getPostBySlug($db, $post_slug);
  if($post) {
    $post_user = getPostUser($db, $post['id_user']);
    $user_posts = getUserPosts($db, $post_user['id']);
    $post_likes = getPostLikes($db, $post['id']);
    $liked_post = isPostLikedByUser($db, $post['id'], $_SESSION['user']['id']);

    $other_posts = getOtherPosts($db, $post['id'], 5);
    $bottom_other_posts = getOtherPosts($db, $post['id'], 8);
  } else {
    header('Location: ' . URL . 'index');
  }
} else {
  header('Location: ' . URL . 'index');
}

?>

<!DOCTYPE html>
<html>

  <!-- Head -->
  <?php include 'templates/head.php'; ?>

  <body>

    <!-- Nav -->
    <?php include 'templates/nav.php'; ?>

    <!-- Header -->
    <div class="header post-header" style="background-image: url('<?php echo URL; ?>app/posts/<?php echo $post['image']; ?>');"></div>

    <!-- Post -->
    <div class="section pt-lg-5 pb-lg-5">
      <div class="container-fluid">
        <div class="row mb-lg-5">
          <div class="col-lg-8">
            <div class="section-title mb-lg-3"><?php echo $post['title']; ?></div>
            <div class="post-info">
              <div class="pr-lg-3 mr-lg-3">
                <a href="<?php echo URL; ?>category/<?php echo $post['category']; ?>"><?php echo strtoupper($post['category']); ?></a>
              </div>
              <div class="pr-lg-3 mr-lg-3">DE
                <a href="<?php echo URL; ?>user/<?php echo $post_user['id']; ?>"><?php echo strtoupper($post_user['full_name']); ?></a>
              </div>
              <div class="pr-lg-3 mr-lg-3"><?php echo strtoupper(strftime('%e %B, %Y', strtotime($post['post_date']))); ?></div>
              <div class="total-post-likes"><i class="material-icons mr-lg-2">favorite_border</i><span><?php echo $post_likes; ?> <?php echo ($post_likes > 0 ? ($post_likes > 1 ? 'APRECIERI' : 'APRECIERE') : 'APRECIERI'); ?></span></div>
            </div>
            <div class="section-text mt-lg-5"><?php echo nl2br($post['post_text']); ?></div>
            <?php if(isset($_SESSION['user'])): ?>
              <div class="post-like-btn <?php echo ($liked_post ? 'unlike' : 'like'); ?>-post mt-lg-5 text-center" data-post-id="<?php echo $post['id']; ?>" data-user-id="<?php echo $_SESSION['user']['id']; ?>">
                <i class="material-icons v-m">favorite</i>
              </div>
            <?php endif; ?>
          </div>
          <div class="col-lg-4 text-right">
            <div class="section-right">
              <div class="post-user p-lg-4 text-left">
                <div class="post-user-name mb-lg-3"><?php echo $post_user['full_name']; ?></div>
                <div class="post-user-text mb-lg-1">Membru din <?php echo strftime('%e %B, %Y', strtotime($post_user['signup_date'])); ?></div>
                <div class="post-user-text mb-lg-3"><?php echo count($user_posts); ?> <?php echo (count($user_posts) > 0 ? (count($user_posts) > 1 ? 'articole postate' : 'articol postat') : 'articole postate'); ?></div>
                <div class="post-user-text"><a href="<?php echo URL; ?>user/<?php echo $post_user["id"]; ?>">Vezi profil</a></div>
              </div>
              <?php if(count($other_posts) > 0): ?>
                <div class="other-posts border-none mt-lg-5 text-left">
                  <?php $i = 1; ?>
                  <?php foreach($other_posts as $other_post): ?>
                    <a href="<?php echo URL; ?>post/<?php echo $other_post['slug']; ?>">
                      <div class="other-posts-post mb-lg-3 pb-lg-3 <?php echo ($i == count($other_posts) ? 'last' : ($i == 1 ? 'pt-lg-3' : '')); ?>">
                        <div class="other-post-title mb-lg-2"><?php echo $other_post['title']; ?></div>
                        <div class="other-post-text"><?php echo strftime('%e %B, %Y', strtotime($other_post['post_date'])); ?></div>
                      </div>
                    </a>
                    <?php $i++; ?>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Other Posts -->
        <?php if(count($bottom_other_posts) > 0): ?>
          <div class="row other-posts pt-lg-5">
            <?php $i = 1; ?>
            <?php foreach($bottom_other_posts as $bottom_other_post): ?>
              <div class="col-lg-3 pl-75 pr-75 <?php echo ($i == 1 ? 'pl-lg-0' : ($i == 4 ? 'pr-lg-0' : '')); ?>">
                <a href="<?php echo URL; ?>post/<?php echo $bottom_other_post['slug']; ?>">
                  <div class="box mb-lg-4">
                    <div class="box-image box-image-lg" style="background-image: url('<?php echo URL; ?>app/posts/<?php echo $bottom_other_post['image']; ?>');"></div>
                    <div class="box-title title-lg mt-lg-2 mb-lg-1"><?php echo $bottom_other_post['title']; ?></div>
                    <div class="box-info">
                      <div class="pr-lg-2 mr-lg-2"><?php echo strtoupper($bottom_other_post['category']); ?></div>
                      <div><?php echo strtoupper(strftime('%e %B, %Y', strtotime($bottom_other_post['post_date']))); ?></div>
                    </div>
                  </div>
                </a>
              </div>
              <?php $i = (++$i) % 5; ?>
              <?php if($i == 0) $i++; ?>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Scripts JS -->
    <?php include 'templates/scripts.php'; ?>
  </body>

</html>
