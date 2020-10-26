<!-- Header -->
<div class="header" style="background-image: url('<?php echo URL; ?>app/posts/<?php echo $highlight['image']; ?>');">
  <div class="header-mask"></div>
  <div class="header-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-6">
          <a href="<?php echo URL; ?>post/<?php echo $highlight['slug']; ?>">
            <div class="header-title"><?php echo $highlight['title']; ?></div>
          </a>
          <div class="header-info mt-lg-3">
            <div class="pr-lg-3 mr-lg-3">
              <a href="<?php echo URL; ?>category/<?php echo $highlight['category']; ?>"><?php echo strtoupper($highlight['category']); ?></a>
            </div>
            <div class="pr-lg-3 mr-lg-3">DE
              <a href="<?php echo URL; ?>user/<?php echo $highlight_user['id']; ?>"><?php echo strtoupper($highlight_user['full_name']); ?></a>
            </div>
            <div class="pr-lg-3 mr-lg-3"><?php echo strtoupper(strftime('%e %B, %Y', strtotime($highlight['post_date']))); ?></div>
            <div><i class="material-icons mr-lg-2">favorite_border</i><span><?php echo $highlight_likes; ?> <?php echo ($highlight_likes > 0 ? ($highlight_likes > 1 ? 'APRECIERI' : 'APRECIERE') : 'APRECIERI'); ?></span></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
