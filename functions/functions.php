<?php

// Config
include '../config.php';

// Session
include 'session.php';


// Get Total Likes
function getTotalLikes($db) {
  $sql_total_likes = 'SELECT COUNT(id) AS total_likes FROM neo_likes';
  $result_total_likes = mysqli_query($db, $sql_total_likes);
  if($result_total_likes) {
    return mysqli_fetch_assoc($result_total_likes)['total_likes'];
  }
}

// Get Total Users
function getTotalUsers($db) {
  $sql_total_users = 'SELECT COUNT(id) AS total_users FROM neo_users';
  $result_total_users = mysqli_query($db, $sql_total_users);
  if($result_total_users) {
    return mysqli_fetch_assoc($result_total_users)['total_users'];
  }
}

// Get Post By Slug
function getPostBySlug($db, $slug) {
  $post = '';
  $sql_post = 'SELECT * FROM neo_posts WHERE slug = "' . $slug . '"';
  $result_post = mysqli_query($db, $sql_post);
  if($result_post) {
    if(mysqli_num_rows($result_post) > 0) {
      while($row_post = mysqli_fetch_assoc($result_post)) {
        $post = $row_post;
      }
      return $post;
    }
  }
}

// Get Post Likes
function getPostLikes($db, $post_id) {
  $sql_post_likes = 'SELECT * FROM neo_likes WHERE post_id = "' . $post_id . '"';
  $result_post_likes = mysqli_query($db, $sql_post_likes);
  if($result_post_likes) {
    return mysqli_num_rows($result_post_likes);
  }
}

// Is Post Liked By User
function isPostLikedByUser($db, $post_id, $user_id) {
  $sql_check = 'SELECT L.* FROM neo_likes L, neo_posts P WHERE L.post_id = P.id AND P.id = "' . $post_id . '" AND L.user_id = "' . $user_id . '"';
  $result_check = mysqli_query($db, $sql_check);
  if($result_check) {
    if(mysqli_num_rows($result_check) > 0) {
      return true;
    } else {
      return false;
    }
  }
}

// Get Post By ID
function getPostByID($db, $post_id) {
  $post = '';
  $sql_post = 'SELECT * FROM neo_posts WHERE id = "' . $post_id . '"';
  $result_post = mysqli_query($db, $sql_post);
  if($result_post) {
    if(mysqli_num_rows($result_post) > 0) {
      while($row_post = mysqli_fetch_assoc($result_post)) {
        $post = $row_post;
      }
      return $post;
    }
  }
}

// Get Posts By User
function getUserPosts($db, $user_id) {
  $user_posts = [];
  $sql_user_posts = 'SELECT * FROM neo_posts WHERE id_user = "' . $user_id . '" ORDER BY post_date DESC';
  $result_user_posts = mysqli_query($db, $sql_user_posts);
  if($result_user_posts) {
    if(mysqli_num_rows($result_user_posts) > 0) {
      while($row_user_posts = mysqli_fetch_assoc($result_user_posts)) {
        $user_posts[] = $row_user_posts;
      }
      return $user_posts;
    }
  }
}

// Get Highlight
function getHighlight($db) {
  $highlight = '';
  $sql_highlight = 'SELECT * FROM neo_posts WHERE highlight = 1';
  $result_highlight = mysqli_query($db, $sql_highlight);
  if($result_highlight) {
    if(mysqli_num_rows($result_highlight) > 0) {
      while($row_highlight = mysqli_fetch_assoc($result_highlight)) {
        $highlight = $row_highlight;
      }
      return $highlight;
    }
  }
}

// Get Post User
function getPostUser($db, $user_id) {
  $post_user = '';
  $sql_post_user = 'SELECT * FROM neo_users WHERE id = "' . $user_id . '"';
  $result_post_user = mysqli_query($db, $sql_post_user);
  if($result_post_user) {
    if(mysqli_num_rows($result_post_user) > 0) {
      while($row_post_user = mysqli_fetch_assoc($result_post_user)) {
        $post_user = $row_post_user;
      }
      return $post_user;
    }
  }
}

// Top 4 Popular Posts
function getPopularPosts($db) {
  $popular_posts = [];
  $sql_popular_posts = 'SELECT P.*, COUNT(L.id) AS total_likes FROM neo_posts P, neo_likes L WHERE P.highlight = 0 AND P.id = L.post_id GROUP BY P.id ORDER BY total_likes DESC';
  $result_popular_posts = mysqli_query($db, $sql_popular_posts);
  if($result_popular_posts) {
    if(mysqli_num_rows($result_popular_posts) > 0) {
      while($row = mysqli_fetch_assoc($result_popular_posts)) {
        $popular_posts[] = $row;
      }

      return $popular_posts;
    }
  }
}

// Get Latest Posts
function getLatestPosts($db, $popular_posts) {
  $latest_posts = [];
  $sql_latest_posts = 'SELECT * FROM neo_posts ORDER BY post_date DESC';
  $result_latest_posts = mysqli_query($db, $sql_latest_posts);
  if($result_latest_posts) {
    if(mysqli_num_rows($result_latest_posts) > 0) {
      while($row_latest_posts = mysqli_fetch_assoc($result_latest_posts)) {
        if(!in_array($row_latest_posts['id'], $popular_posts)) {
          $latest_posts[] = $row_latest_posts;
        }
      }
      return $latest_posts;
    }
  }
}

// Get Other Posts
function getOtherPosts($db, $post_id, $limit) {
  $other_posts = [];
  $sql_other_posts = 'SELECT * FROM neo_posts WHERE highlight = 0 AND id <> "' . $post_id . '" ORDER BY post_date DESC LIMIT ' . $limit;
  $result_other_posts = mysqli_query($db, $sql_other_posts);
  if($result_other_posts) {
    if(mysqli_num_rows($result_other_posts) > 0) {
      while($row = mysqli_fetch_assoc($result_other_posts)) {
        $other_posts[] = $row;
      }

      return $other_posts;
    }
  }
}

// Get Category Posts
function getCategoryPosts($db, $post_category) {
  $category_posts = [];
  $sql_category_posts = 'SELECT * FROM neo_posts WHERE category = "' . $post_category . '"';
  $result_category_posts = mysqli_query($db, $sql_category_posts);
  if($result_category_posts) {
    if(mysqli_num_rows($result_category_posts) > 0) {
      while($row_category_posts = mysqli_fetch_assoc($result_category_posts)) {
        $category_posts[] = $row_category_posts;
      }
      return $category_posts;
    }
  }
}

// Get User By ID
function getUserByID($db, $user_id) {
  $user = '';
  $sql_user = 'SELECT * FROM neo_users WHERE id = "' . $user_id . '"';
  $result_user = mysqli_query($db, $sql_user);
  if($result_user) {
    if(mysqli_num_rows($result_user) > 0) {
      while($row_user = mysqli_fetch_assoc($result_user)) {
        $user = $row_user;
      }
      return $user;
    }
  }
}

// Get Posts
function getPosts($db) {
  $posts = [];
  $sql_posts = 'SELECT * FROM neo_posts ORDER BY post_date DESC';
  $result_posts = mysqli_query($db, $sql_posts);
  if($result_posts) {
    if(mysqli_num_rows($result_posts) > 0) {
      while($row_posts = mysqli_fetch_assoc($result_posts)) {
        $posts[] = $row_posts;
      }
      return $posts;
    }
  }
}

// Highlight Post
function highlightPost($db, $post_id) {
  $sql_remove_highlight = 'UPDATE neo_posts SET highlight = 0';
  $result_remove_highlight = mysqli_query($db, $sql_remove_highlight);
  if($result_remove_highlight) {
    $sql_highlight = 'UPDATE neo_posts SET highlight = 1 WHERE id = "' . $post_id . '"';
    $result_highlight_post = mysqli_query($db, $sql_highlight);
    if($result_highlight_post) {
      header('Location: ' . URL . 'admin');
    }
  }
}

// Delete Post
function deletePost($db, $post_id) {
  $post = getPostByID($db, $post_id);
  if($post) {
    if(file_exists('app/posts/' . $post["image"])) {
      unlink('app/posts/' . $post["image"]);

      $sql_delete = 'DELETE FROM neo_posts WHERE id = "' . $post_id . '"';
      $result_delete = mysqli_query($db, $sql_delete);
      if($result_delete) {
        header('Location: ' . URL . 'admin');
      }
    }
  }
}

?>
