<?php if(isset($_SESSION['alert']) && $_SESSION['alert']['text'] != ''): ?>
  <div class="alert <?php echo $_SESSION['alert']['type']; ?> mb-lg-3"><?php echo $_SESSION['alert']['text']; ?></div>
<?php endif; ?>
<?php $_SESSION['alert'] = array('type' => '', 'text' => ''); ?>
