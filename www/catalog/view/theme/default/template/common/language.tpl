<?php if (count($languages) > 1) { ?>
<div>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="language">
  <!--<div class="btn-group">
    <button class="btn btn-link dropdown-toggle" data-toggle="dropdown">-->
    <?php foreach ($languages as $language) { ?>
    <?php if ($language['code'] == $code) { ?>
    <!--<img src="image/flags/<?php //echo $language['image']; ?>" alt="<?php //echo $language['name']; ?>" title="<?php //echo $language['name']; ?>">-->
    <?php } ?>
    <?php } ?>
    <!--<span class="hidden-xs hidden-sm hidden-md"><?php //echo $text_language; ?></span> <i class="fa fa-caret-down"></i></button>-->
    <!--<ul class="dropdown-menu">-->
      <?php foreach ($languages as $key=>$language) { ?>
      <!--<li><a href="<?php //echo $language['code']; ?>"><img src="image/flags/<?php //echo $language['image']; ?>" alt="<?php //echo $language['name']; ?>" title="<?php //echo $language['name']; ?>" /> <?php //echo $language['name']; ?></a></li>-->
      <?php
        if ($key > 0)
            echo "/";
      ?>
      <a style="margin-left:0px;" href="<?php echo $language['code']; ?>"><img src="image/flags/<?php echo $language['image']; ?>" alt="<?php echo $language['name']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
      <?php } ?>
    <!--</ul>-->
  <!--</div>-->
  <input type="hidden" name="code" value="" />
  <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
</form>
</div>
<?php } ?>