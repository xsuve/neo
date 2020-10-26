<?php

// Config
include '../config.php';

// MySQL
include 'mysql.php';

// Session
include 'session.php';

// Session
include 'functions.php';


// Register
if(isset($_POST['submit_register'])) {
  if(!empty($_POST['full_name']) && !empty($_POST['email']) && !empty($_POST['password'])) {
    $full_name = filter_var($_POST['full_name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_SPECIAL_CHARS);
    $today = time();
    $signup_date = date('Y-m-d', $today);

    $sql_check = 'SELECT * FROM neo_users WHERE email = "' . $email . '"';
    $result_check = mysqli_query($db, $sql_check);
    if($result_check) {
      if(mysqli_num_rows($result_check) == 0) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $sql_register = 'INSERT INTO neo_users (full_name, email, password, signup_date) VALUES ("' . $full_name . '", "' . $email . '", "' . $password_hash . '", "' . $signup_date . '")';
        $result_register = mysqli_query($db, $sql_register);

        if($result_register) {
          $_SESSION['alert'] = array('type' => '', 'text' => '');
          header('Location: ' . URL . 'login');
        } else {
          $_SESSION['alert'] = array('type' => 'alert-danger', 'text' => 'A aparut o eroare.');
          header('Location: ' . URL . 'register');
        }
      } else {
        $_SESSION['alert'] = array('type' => 'alert-danger', 'text' => 'Acest email este deja inregistrat.');
        header('Location: ' . URL . 'register');
      }
    } else {
      $_SESSION['alert'] = array('type' => 'alert-danger', 'text' => 'A aparut o eroare.');
      header('Location: ' . URL . 'register');
    }
  } else {
    $_SESSION['alert'] = array('type' => 'alert-danger', 'text' => 'Va rugam sa completati toate campurile.');
    header('Location: ' . URL . 'register');
  }
} elseif(isset($_POST['submit_login'])) {
  if(!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_SPECIAL_CHARS);

    $sql_check = 'SELECT * FROM neo_users WHERE email = "' . $email . '"';
    $result_check = mysqli_query($db, $sql_check);
    if($result_check) {
      if(mysqli_num_rows($result_check) > 0) {
        $user = mysqli_fetch_assoc($result_check);

        if(password_verify($password, $user['password'])) {
          $_SESSION['user'] = $user;
          header('Location: ' . URL . 'index');
        } else {
          $_SESSION['alert'] = array('type' => 'alert-danger', 'text' => 'Datele de conectare nu sunt valide.');
          header('Location: ' . URL . 'login');
        }
      } else {
        $_SESSION['alert'] = array('type' => 'alert-danger', 'text' => 'Acest email nu exista.');
        header('Location: ' . URL . 'login');
      }
    } else {
      $_SESSION['alert'] = array('type' => 'alert-danger', 'text' => 'A aparut o eroare.');
      header('Location: ' . URL . 'login');
    }
  } else {
    $_SESSION['alert'] = array('type' => 'alert-danger', 'text' => 'Va rugam sa completati toate campurile.');
    header('Location: ' . URL . 'login');
  }
} elseif(isset($_POST['submit_new'])) {
  if(!empty($_POST['title']) && !empty($_POST['category']) && !empty($_POST['text'])) {
    if($_FILES['image']['size'] > 0 && $_FILES['image']['error'] == 0) {
      $title = filter_var($_POST['title'], FILTER_SANITIZE_SPECIAL_CHARS);
      $category = filter_var($_POST['category'], FILTER_SANITIZE_SPECIAL_CHARS);
      $text = $_POST['text'];
      $today = time();
      $post_date = date('Y-m-d', $today);
      $post_slug = strtolower(str_replace(' ', '-', str_replace(str_split('\\/:*?"<>,|'), '', $title)));

      $image_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
      if($image_extension == 'jpg' || $image_extension == 'png' || $image_extension == 'jpeg') {
        $image_info = getimagesize($_FILES['image']['tmp_name']);

        if($image_info[0] == 1920 && $image_info[1] == 960) {
          $posts_folder = '../app/posts/';
          $image_name = $today . '-' . mt_rand() . '.' . $image_extension;
          $target_file = $posts_folder . $image_name;

          if(!file_exists($target_file)) {
            if(move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
              $sql_new = 'INSERT INTO neo_posts (id_user, slug, title, category, post_text, post_date, image, highlight) VALUES ("' . $_SESSION["user"]["id"] . '", "' . $post_slug . '", "' . $title . '", "' . $category . '", "' . $text . '", "' . $post_date . '", "' . $image_name . '", 0)';
              $result_new = mysqli_query($db, $sql_new);

              if($result_new) {
                $_SESSION['alert'] = array('type' => '', 'text' => '');
                header('Location: ' . URL . 'post/' . $post_slug);
              } else {
                $_SESSION['alert'] = array('type' => 'alert-danger', 'text' => 'A aparut o eroare.');
                header('Location: ' . URL . 'new');
              }
            } else {
              $_SESSION['alert'] = array('type' => 'alert-danger', 'text' => 'A aparut o eroare la incarcarea imaginii.');
              header('Location: ' . URL . 'new');
            }
          } else {
            $_SESSION['alert'] = array('type' => 'alert-danger', 'text' => 'Aceasta imagine exista deja.');
            header('Location: ' . URL . 'new');
          }
        } else {
          $_SESSION['alert'] = array('type' => 'alert-danger', 'text' => 'Imaginea trebuie sa aiba 1920 pixeli lungime si 960 pixeli inaltime.');
          header('Location: ' . URL . 'new');
        }
      } else {
        $_SESSION['alert'] = array('type' => 'alert-danger', 'text' => 'Numai imagini cu extensia .jpg, .jpeg sau .png sunt permise.');
        header('Location: ' . URL . 'new');
      }
    } else {
      $_SESSION['alert'] = array('type' => 'alert-danger', 'text' => 'Va rugam sa adaugati o imagine pentru articol.');
      header('Location: ' . URL . 'new');
    }
  } else {
    $_SESSION['alert'] = array('type' => 'alert-danger', 'text' => 'Va rugam sa completati toate campurile.');
    header('Location: ' . URL . 'new');
  }
} elseif(isset($_POST['submit_edit'])) {
  $post_id = filter_var($_POST['post_id'], FILTER_SANITIZE_SPECIAL_CHARS);
  $post = getPostByID($db, $post_id);

  if($post) {
    if(!empty($_POST['title']) && !empty($_POST['category']) && !empty($_POST['text'])) {
      $title = filter_var($_POST['title'], FILTER_SANITIZE_SPECIAL_CHARS);
      $category = filter_var($_POST['category'], FILTER_SANITIZE_SPECIAL_CHARS);
      $text = $_POST['text'];
      $post_slug = strtolower(str_replace(' ', '-', str_replace(str_split('\\/:*?"<>,|'), '', $title)));

      if($_FILES['image']['size'] > 0 && $_FILES['image']['error'] == 0) {
        $image_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        if($image_extension == 'jpg' || $image_extension == 'png' || $image_extension == 'jpeg') {
          $image_info = getimagesize($_FILES['image']['tmp_name']);

          if($image_info[0] == 1920 && $image_info[1] == 960) {
            $posts_folder = '../app/posts/';
            $image_name = $post['image'];
            $target_file = $posts_folder . $image_name;

            if(!file_exists($target_file)) {
              if(move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $sql_edit = 'UPDATE neo_posts SET slug = "' . $post_slug . '", title = "' . $title . '", category = "' . $category . '", post_text = "' . $text . '" WHERE id = "' . $post["id"] . '"';
                $result_edit = mysqli_query($db, $sql_edit);

                if($result_edit) {
                  $_SESSION['alert'] = array('type' => '', 'text' => '');
                  header('Location: ' . URL . 'post/' . $post_slug);
                } else {
                  $_SESSION['alert'] = array('type' => 'alert-danger', 'text' => 'A aparut o eroare.');
                  header('Location: ' . URL . 'admin?action=edit&id=' . $post["id"]);
                }
              } else {
                $_SESSION['alert'] = array('type' => 'alert-danger', 'text' => 'A aparut o eroare la incarcarea imaginii.');
                header('Location: ' . URL . 'admin?action=edit&id=' . $post["id"]);
              }
            } else {
              $_SESSION['alert'] = array('type' => 'alert-danger', 'text' => 'Aceasta imagine exista deja.');
              header('Location: ' . URL . 'admin?action=edit&id=' . $post["id"]);
            }
          } else {
            $_SESSION['alert'] = array('type' => 'alert-danger', 'text' => 'Imaginea trebuie sa aiba 1920 pixeli lungime si 960 pixeli inaltime.');
            header('Location: ' . URL . 'admin?action=edit&id=' . $post["id"]);
          }
        } else {
          $_SESSION['alert'] = array('type' => 'alert-danger', 'text' => 'Numai imagini cu extensia .jpg, .jpeg sau .png sunt permise.');
          header('Location: ' . URL . 'admin?action=edit&id=' . $post["id"]);
        }
      } else {
        $sql_edit = 'UPDATE neo_posts SET slug = "' . $post_slug . '", title = "' . $title . '", category = "' . $category . '", post_text = "' . $text . '" WHERE id = "' . $post["id"] . '"';
        $result_edit = mysqli_query($db, $sql_edit);

        if($result_edit) {
          $_SESSION['alert'] = array('type' => '', 'text' => '');
          header('Location: ' . URL . 'post/' . $post_slug);
        } else {
          $_SESSION['alert'] = array('type' => 'alert-danger', 'text' => 'A aparut o eroare.');
          header('Location: ' . URL . 'admin?action=edit&id=' . $post["id"]);
        }
      }
    } else {
      $_SESSION['alert'] = array('type' => 'alert-danger', 'text' => 'Va rugam sa completati toate campurile.');
      header('Location: ' . URL . 'admin?action=edit&id=' . $post["id"]);
    }
  } else {
    $_SESSION['alert'] = array('type' => 'alert-danger', 'text' => 'Nu s-a gasit articolul.');
    header('Location: ' . URL . 'admin?action=edit&id=' . $post_id);
  }

} elseif(isset($_POST['submit_like'])) {
  if(!empty($_POST['post_id']) && !empty($_POST['user_id'])) {
    $post_id = filter_var($_POST['post_id'], FILTER_SANITIZE_SPECIAL_CHARS);
    $user_id = filter_var($_POST['user_id'], FILTER_SANITIZE_SPECIAL_CHARS);

    $liked_post = isPostLikedByUser($db, $post_id, $user_id);
    if(!$liked_post) {
      $sql_like_post = 'INSERT INTO neo_likes (post_id, user_id) VALUES ("' . $post_id . '", "' . $user_id . '")';
      $result_like_post = mysqli_query($db, $sql_like_post);

      if($result_like_post) {
        $post_likes = getPostLikes($db, $post_id);
        echo json_encode(
          array(
            'status' => 'success',
            'likes' => $post_likes
          )
        );
      }
    }
  }
} elseif(isset($_POST['submit_unlike'])) {
  if(!empty($_POST['post_id']) && !empty($_POST['user_id'])) {
    $post_id = filter_var($_POST['post_id'], FILTER_SANITIZE_SPECIAL_CHARS);
    $user_id = filter_var($_POST['user_id'], FILTER_SANITIZE_SPECIAL_CHARS);

    $liked_post = isPostLikedByUser($db, $post_id, $user_id);
    if($liked_post) {
      $sql_unlike_post = 'DELETE FROM neo_likes WHERE post_id = "' . $post_id . '" AND user_id = "' . $user_id . '"';
      $result_unlike_post = mysqli_query($db, $sql_unlike_post);

      if($result_unlike_post) {
        $post_likes = getPostLikes($db, $post_id);
        echo json_encode(
          array(
            'status' => 'success',
            'likes' => $post_likes
          )
        );
      }
    }
  }
} else {
  header('Location: ' . URL . 'index');
}

?>
