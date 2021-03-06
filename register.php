<?php

// Config
include 'config.php';

// Session
include 'functions/session.php';

if(isset($_SESSION['user'])) {
  header('Location: ' . URL . 'index');
}

?>

<!DOCTYPE html>
<html>

  <!-- Head -->
  <?php include 'templates/head.php'; ?>

  <body>

    <!-- Register -->
    <div class="container-fluid form">
      <div class="row">
        <div class="col-lg-5 pl-lg-0 pr-lg-0">
          <div class="form-left">
            <div class="v-m">
              <div class="form-logo mb-lg-5">
                <a href="<?php echo URL; ?>index">
                  <img src="<?php echo URL; ?>img/neo-logo-dark.svg" alt="neo - Lideri in stiri despre tehnologie in Romania">
                </a>
              </div>
              <div class="form-title mb-lg-2">Inregistreaza-te pe platforma</div>
              <div class="form-text">Bine ai venit! Foloseste formularul de mai jos pentru a te inregistra pe platforma.</div>
              <div class="form-inputs mt-lg-5">

                <?php include 'templates/alerts.php'; ?>

                <form action="<?php echo URL; ?>functions/forms.php" method="post">
                  <div class="form-group mb-lg-4">
                    <label>Nume si prenume</label>
                    <input type="text" name="full_name" class="form-control" placeholder="Nume si prenume">
                  </div>
                  <div class="form-group mb-lg-4">
                    <label>Adresa de email</label>
                    <input type="email" name="email" class="form-control" placeholder="Adresa de email">
                  </div>
                  <div class="form-group mb-lg-4">
                    <label>Parola</label>
                    <input type="password" name="password" class="form-control" placeholder="Parola">
                  </div>
                  <div class="text-right">
                    <button type="submit" name="submit_register" class="btn btn-dark">Inregistreaza-te</button>
                  </div>
                </form>
              </div>
              <div class="form-text mt-lg-5">Ai deja un cont? <a href="<?php echo URL; ?>login">Logheaza-te</a></div>
            </div>
          </div>
        </div>
        <div class="col-lg-7 pl-lg-0 pr-lg-0">
          <div class="form-right">
            <div class="form-right-mask">
              <div class="v-m">
                <div class="form-right-title">Cele mai noi stiri din tehnologie.</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </body>

</html>
