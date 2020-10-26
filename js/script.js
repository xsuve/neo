$(document).ready(function() {

  // Post Image
  $('#newPostInput').on('change', function() {
    if(this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#newPostInputPreview').attr('src', e.target.result);
        $('#newPostInputSpan').hide();
      }
      reader.readAsDataURL(this.files[0]);
    }
  });

  // Like Post
  $(document).on('click', '.post-like-btn.like-post', function() {
    var post_id = $(this).data('post-id');
    var user_id = $(this).data('user-id');
    $.ajax({
      url: '../functions/forms.php',
      type: 'POST',
      data: 'submit_like=1&post_id=' + post_id + '&user_id=' + user_id,
      success: function(json) {
        var result = JSON.parse(json);
        if(result.status == 'success') {
          $('.post-like-btn').removeClass('like-post');
          $('.post-like-btn').addClass('unlike-post');
          if(result.likes > 0) {
            if(result.likes > 1) {
              $('.total-post-likes span').text(result.likes + ' APRECIERI');
            } else {
              $('.total-post-likes span').text(result.likes + ' APRECIERE');
            }
          } else {
            $('.total-post-likes span').text(result.likes + ' APRECIERI');
          }
        }
      }
    });
  });

  // Unlike Post
  $(document).on('click', '.post-like-btn.unlike-post', function() {
    var post_id = $(this).data('post-id');
    var user_id = $(this).data('user-id');
    $.ajax({
      url: '../functions/forms.php',
      type: 'POST',
      data: 'submit_unlike=1&post_id=' + post_id + '&user_id=' + user_id,
      success: function(json) {
        var result = JSON.parse(json);
        if(result.status == 'success') {
          $('.post-like-btn').removeClass('unlike-post');
          $('.post-like-btn').addClass('like-post');
          if(result.likes > 0) {
            if(result.likes > 1) {
              $('.total-post-likes span').text(result.likes + ' APRECIERI');
            } else {
              $('.total-post-likes span').text(result.likes + ' APRECIERE');
            }
          } else {
            $('.total-post-likes span').text(result.likes + ' APRECIERI');
          }
        }
      }
    });
  });

});
