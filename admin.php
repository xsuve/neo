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
  if(in_array($_SESSION['user']['email'], $admins)) {
    $posts = getPosts($db);
  } else {
    header('Location: ' . URL . 'index');
  }
} else {
  header('Location: ' . URL . 'login');
}

?>

<?php if(isset($_GET['action']) && isset($_GET['id'])): ?>
  <?php
    $action = mysqli_real_escape_string($db, $_GET['action']);
    $post_id = mysqli_real_escape_string($db, $_GET['id']);
  ?>
  <?php if($action == 'highlight'): ?>
    <?php highlightPost($db, $post_id); ?>
  <?php elseif($action == 'edit'): ?>
    <?php $post = getPostByID($db, $post_id); ?>
    <?php if($post): ?>
      <!DOCTYPE html>
      <html>

        <!-- Head -->
        <?php include 'templates/head.php'; ?>

        <body>

          <!-- Nav -->
          <?php include 'templates/nav.php'; ?>

          <!-- Edit -->
          <div class="section new-post pt-lg-5 pb-lg-5">
            <div class="container-fluid">
              <div class="row mb-lg-4">
                <div class="col-lg-9">
                  <div class="v-m">
                    <div class="section-title"><?php echo $post['title']; ?></div>
                  </div>
                </div>
              </div>

              <form action="<?php echo URL; ?>functions/forms.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                <div class="row form mt-lg-5">
                  <div class="col-lg-6">
                    <div class="form-inputs">

                      <?php include 'templates/alerts.php'; ?>

                      <div class="form-group mb-lg-4">
                        <label>Titlul</label>
                        <input type="text" name="title" class="form-control" placeholder="Titlul articolului" value="<?php echo $post['title']; ?>">
                      </div>
                      <div class="form-group mb-lg-4">
                        <label>Categorie</label>
                        <select name="category" class="form-control">
                          <option disabled>Categoria articolului</option>
                          <option value="coronavirus" <?php echo ($post['category'] == 'coronavirus' ? 'selected' : ''); ?>>Coronavirus</option>
                          <option value="noutati" <?php echo ($post['category'] == 'noutati' ? 'selected' : ''); ?>>Noutati</option>
                          <option value="topuri" <?php echo ($post['category'] == 'topuri' ? 'selected' : ''); ?>>Topuri</option>
                          <option value="gadgeturi" <?php echo ($post['category'] == 'gadgeturi' ? 'selected' : ''); ?>>Gadgeturi</option>
                          <option value="recenzii" <?php echo ($post['category'] == 'recenzii' ? 'selected' : ''); ?>>Recenzii</option>
                        </select>
                      </div>
                      <div class="form-group mb-lg-4">
                        <label>Textul</label>
                        <textarea type="text" name="text" class="form-control" placeholder="Textul articolului"><?php echo $post['post_text']; ?></textarea>
                      </div>
                      <div class="text-right">
                        <button type="submit" name="submit_edit" class="btn btn-dark">Editeaza articol</button>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="new-post-image-wrapper">
                      <div class="new-post-input text-center">
                        <div class="new-post-image">
                          <img src="<?php echo URL; ?>app/posts/<?php echo $post['image']; ?>" id="newPostInputPreview" alt="">
                        </div>
                        <input type="file" name="image" id="newPostInput">
                      </div>
                      <div class="form-text mt-lg-4">Imaginea articolului trebuie sa aiba 1920 pixeli lungime si 960 pixeli inaltime.</div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <!-- Scripts JS -->
          <?php include 'templates/scripts.php'; ?>
        </body>

      </html>
    <?php else: ?>
      <?php header('Location: ' . URL . 'admin'); ?>
    <?php endif; ?>
  <?php elseif($action == 'delete'): ?>
    <?php deletePost($db, $post_id); ?>
  <?php endif; ?>

<?php else: ?>
<?php

$total_likes = getTotalLikes($db);
$total_users = getTotalUsers($db);

?>

<!DOCTYPE html>
<html>

  <!-- Head -->
  <?php include 'templates/head.php'; ?>

  <body>

    <!-- Nav -->
    <?php include 'templates/nav.php'; ?>

    <!-- Admin -->
    <div class="section admin-posts pt-lg-5 pb-lg-5">
      <div class="container-fluid">
        <div class="row admin-stats pb-lg-5 mb-lg-5">
          <div class="col-lg-4">
            <div class="admin-stats-box text-center p-lg-4">
              <div class="admin-stats-box-title mb-lg-2">POSTARI TOTALE</div>
              <div class="admin-stats-box-nr"><?php echo count($posts); ?></div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="admin-stats-box text-center p-lg-4">
              <div class="admin-stats-box-title mb-lg-2">TOTAL APRECIERI</div>
              <div class="admin-stats-box-nr"><?php echo $total_likes; ?></div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="admin-stats-box text-center p-lg-4">
              <div class="admin-stats-box-title mb-lg-2">UTILIZATORI TOTALI</div>
              <div class="admin-stats-box-nr"><?php echo $total_users; ?></div>
            </div>
          </div>
        </div>

        <!-- Posts -->
        <?php if(count($posts) > 0): ?>
          <?php $i = 1; ?>
          <?php foreach($posts as $post): ?>
            <div class="row admin-posts-post <?php echo ($i == count($posts) ? 'last' : 'mb-lg-3 pb-lg-3'); ?>">
              <div class="col-lg-8">
                <div class="box">
                  <a href="<?php echo URL; ?>post/<?php echo $post['slug']; ?>" target="_blank">
                    <div class="box-title title-lg mt-lg-2 mb-lg-1"><?php echo $post['title']; ?></div>
                  </a>
                  <div class="box-info">
                    <div class="pr-lg-2 mr-lg-2"><?php echo strtoupper($post['category']); ?></div>
                    <div><?php echo strtoupper(strftime('%e %B, %Y', strtotime($post['post_date']))); ?></div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 text-right">
                <div class="v-m">
                  <div class="admin-posts-post-actions">
                    <div class="mr-lg-5">
                      <?php if($post['highlight'] == 1): ?>
                        <i class="material-icons highlight">star</i>
                      <?php else: ?>
                        <a href="<?php echo URL; ?>admin?action=highlight&id=<?php echo $post['id']; ?>">
                          <i class="material-icons highlight">star_border</i>
                        </a>
                      <?php endif; ?>
                    </div>
                    <div class="mr-lg-5">
                      <a href="<?php echo URL; ?>admin?action=edit&id=<?php echo $post['id']; ?>">
                        <i class="material-icons edit">edit</i>
                      </a>
                    </div>
                    <div>
                      <a href="<?php echo URL; ?>admin?action=delete&id=<?php echo $post['id']; ?>">
                        <i class="material-icons delete">delete</i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php $i++; ?>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>

    <!-- Scripts JS -->
    <?php include 'templates/scripts.php'; ?>
  </body>

</html>
<?php endif; ?>
