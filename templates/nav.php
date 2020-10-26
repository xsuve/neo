<?php

// Config
include 'config.php';

// Session
include 'functions/session.php';

?>

<nav class="nav">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-2 text-left">
        <div class="v-m">
          <a href="<?php echo URL; ?>index">
            <div class="nav-logo">
              <img src="<?php echo URL; ?>img/neo-logo-dark.svg" alt="neo - Lideri in stiri despre tehnologie in Romania">
            </div>
          </a>
        </div>
      </div>
      <div class="col-lg-6 text-center">
        <div class="v-m">
          <div class="nav-links">
            <div class="mr-lg-4">
              <a href="<?php echo URL; ?>">Acasa</a>
            </div>
            <div class="mr-lg-4">
              <a href="<?php echo URL; ?>category/coronavirus">Coronavirus</a>
            </div>
            <div class="mr-lg-4">
              <a href="<?php echo URL; ?>category/noutati">Noutati</a>
            </div>
            <div class="mr-lg-4">
              <a href="<?php echo URL; ?>category/topuri">Topuri</a>
            </div>
            <div class="mr-lg-4">
              <a href="<?php echo URL; ?>category/gadgeturi">Gadgeturi</a>
            </div>
            <div>
              <a href="<?php echo URL; ?>category/recenzii">Recenzii</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 text-right">
        <div class="v-m">
          <div class="nav-links">
            <div class="mr-lg-4">
              <a href="<?php echo URL; ?>new">
                <i class="material-icons">add_circle_outline</i>
              </a>
            </div>
            <div>
              <?php if(isset($_SESSION['user'])): ?>
                <?php if(in_array($_SESSION['user']['email'], $admins)): ?>
                  <div class="mr-lg-4">
                    <a href="<?php echo URL; ?>admin">
                      <i class="material-icons">settings</i></span>
                    </a>
                  </div>
                <?php endif; ?>
                <a href="<?php echo URL; ?>account">
                  <i class="material-icons">account_circle</i> <span class="ml-lg-2"><?php echo $_SESSION['user']['full_name']; ?></span>
                </a>
              <?php else: ?>
                <a href="<?php echo URL; ?>login">
                  <i class="material-icons">account_circle</i>
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>
