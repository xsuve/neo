<?php

// Config
include 'config.php';

// MySQL
include 'functions/mysql.php';

// Session
include 'functions/session.php';

// Session
include 'functions/functions.php';


if(isset($_SESSION['user'])) {
  $account_posts = getUserPosts($db, $_SESSION['user']['id']);
} else {
  header('Location: ' . URL . 'login');
}

?>

<!DOCTYPE html>
<html>

  <!-- Head -->
  <?php include 'templates/head.php'; ?>

  <body>

    <!-- Nav -->
    <?php include 'templates/nav.php'; ?>

    <!-- Account -->
    <div class="section account pt-lg-5 pb-lg-5">
      <div class="container-fluid">
        <div class="row mb-lg-5">
          <div class="col-lg-5">
            <div class="section-title mb-lg-2"><?php echo $_SESSION['user']['full_name']; ?></div>
            <div class="section-text mb-lg-3"><?php echo $_SESSION['user']['email']; ?></div>
            <div class="section-text">Membru din <?php echo strftime('%e %B, %Y', strtotime($_SESSION['user']['signup_date'])); ?></div>
          </div>
          <div class="col-lg-4">
            <div class="v-m">
              <div class="account-badge"><?php echo count($account_posts); ?> <span>total postari</span></div>
            </div>
          </div>
          <div class="col-lg-3 text-right">
            <div class="v-m">
              <a href="<?php echo URL; ?>logout">
                <button class="btn btn-dark">Delogheaza-te</button>
              </a>
            </div>
          </div>
        </div>

        <!-- Other Posts -->
        <?php if(count($account_posts) > 0): ?>
          <div class="row other-posts pt-lg-5">
            <?php $i = 1; ?>
            <?php foreach($account_posts as $account_post): ?>
              <div class="col-lg-3 pl-75 pr-75 <?php echo ($i == 1 ? 'pl-lg-0' : ($i == 4 ? 'pr-lg-0' : '')); ?>">
                <a href="<?php echo URL; ?>post/<?php echo $account_post['slug']; ?>">
                  <div class="box mb-lg-4">
                    <div class="box-image box-image-lg" style="background-image: url('<?php echo URL; ?>app/posts/<?php echo $account_post['image']; ?>');"></div>
                    <div class="box-title title-lg mt-lg-2 mb-lg-1"><?php echo $account_post['title']; ?></div>
                    <div class="box-info">
                      <div class="pr-lg-2 mr-lg-2"><?php echo strtoupper($account_post['category']); ?></div>
                      <div><?php echo strtoupper(strftime('%e %B, %Y', strtotime($account_post['post_date']))); ?></div>
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
