<?php

// Config
include 'config.php';

// Session
include 'functions/session.php';

if(!isset($_SESSION['user'])) {
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

    <!-- Post -->
    <div class="section new-post pt-lg-5 pb-lg-5">
      <div class="container-fluid">
        <div class="row mb-lg-4">
          <div class="col-lg-9">
            <div class="v-m">
              <div class="section-title">Posteaza un nou articol</div>
            </div>
          </div>
          <div class="col-lg-3 text-right">
            <div class="v-m">
              <a href="<?php echo URL; ?>account">
                <div class="section-view-all">
                  <div class="mr-lg-2">Vei posta ca <?php echo $_SESSION['user']['full_name']; ?></div> <i class="material-icons">arrow_forward</i>
                </div>
              </a>
            </div>
          </div>
        </div>

        <form action="<?php echo URL; ?>functions/forms.php" method="post" enctype="multipart/form-data">
          <div class="row form mt-lg-5">
            <div class="col-lg-6">
              <div class="form-inputs">

                <?php include 'templates/alerts.php'; ?>

                <div class="form-group mb-lg-4">
                  <label>Titlul</label>
                  <input type="text" name="title" class="form-control" placeholder="Titlul articolului">
                </div>
                <div class="form-group mb-lg-4">
                  <label>Categorie</label>
                  <select name="category" class="form-control">
                    <option disabled selected>Categoria articolului</option>
                    <option value="coronavirus">Coronavirus</option>
                    <option value="noutati">Noutati</option>
                    <option value="topuri">Topuri</option>
                    <option value="gadgeturi">Gadgeturi</option>
                    <option value="recenzii">Recenzii</option>
                  </select>
                </div>
                <div class="form-group mb-lg-4">
                  <label>Textul</label>
                  <textarea type="text" name="text" class="form-control" placeholder="Textul articolului"></textarea>
                </div>
                <div class="text-right">
                  <button type="submit" name="submit_new" class="btn btn-dark">Posteaza articol</button>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="new-post-image-wrapper">
                <div class="new-post-input text-center">
                  <div class="new-post-image">
                    <img src="" id="newPostInputPreview" alt="">
                  </div>
                  <input type="file" name="image" id="newPostInput">
                  <i class="material-icons v-m" id="newPostInputSpan">add_circle_outline</i>
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
