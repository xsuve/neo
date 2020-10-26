<?php

// Config
include 'config.php';

// MySQL
include 'functions/mysql.php';

// Session
include 'functions/session.php';

// Session
include 'functions/functions.php';


if(isset($_GET['category'])) {
  $post_category = mysqli_real_escape_string($db, $_GET['category']);

  $posts = getCategoryPosts($db, $post_category);
  if(count($posts) == 0) {
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

    <!-- Category Posts -->
    <div class="section pt-lg-5 pb-lg-5">
      <div class="container-fluid">
        <div class="row mb-lg-4">
          <div class="col-lg-12">
            <div class="v-m">
              <div class="section-title"><?php echo ucfirst($post_category); ?></div>
            </div>
          </div>
        </div>

        <?php if(count($posts) > 0): ?>
          <div class="row">
            <?php $i = 1; ?>
            <?php foreach($posts as $post): ?>
              <div class="col-lg-3 pl-75 pr-75 <?php echo ($i == 1 ? 'pl-lg-3' : ($i == 4 ? 'pr-lg-3' : '')); ?>">
                <a href="<?php echo URL; ?>post/<?php echo $post['slug']; ?>">
                  <div class="box mb-lg-4">
                    <div class="box-image box-image-lg" style="background-image: url('<?php echo URL; ?>app/posts/<?php echo $post['image']; ?>');"></div>
                    <div class="box-title title-lg mt-lg-2 mb-lg-1"><?php echo $post['title']; ?></div>
                    <div class="box-info">
                      <div class="pr-lg-2 mr-lg-2"><?php echo strtoupper($post['category']); ?></div>
                      <div><?php echo strtoupper(strftime('%e %B, %Y', strtotime($post['post_date']))); ?></div>
                    </div>
                  </div>
                </a>
              </div>
              <?php $i = (++$i) % 5; ?>
              <?php if($i == 0) $i++; ?>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <div class="col-lg-12">Nu exista rezultate.</div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Scripts JS -->
    <?php include 'templates/scripts.php'; ?>
  </body>

</html>
