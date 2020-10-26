<?php

// Config
include 'config.php';

// Session
include 'functions/session.php';

if(isset($_SESSION['user'])) {
  session_destroy();
  header('Location: ' . URL . 'index');
} else {
  header('Location: ' . URL . 'index');
}

?>
