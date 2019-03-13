<?php
$gallery = get_field('gallery', 5, false);
preg_match('/\[gallery.*ids=.(.*).\]/', $gallery, $ids);
$images = explode(",", $ids[1]);
$first_big = wp_get_attachment_image_src( $images[0], 'about-big' ); $first_big = $first_big[0];
$first_full = wp_get_attachment_image_src( $images[0], 'full' ); $first_full = $first_full[0];
?>

<div class="about-big">
  <div class="about-big-left">
    <a href="<?php echo $first_full; ?>" data-num="1" class="about-img">
      <img src="<?php echo $first_big; ?>">
    </a>
  </div>
  <div class="about-big-right">
    <h2 class="text-left dark-text">Готовые проекты</h2>
    <div class="colored-line-left"></div>
    <br><br>
    <div class="about-text">
      <p>Представляем Вам несколько готовых проектов домов. Оптимальные варианты по цене и качеству. Выполненные из деревянного каркаса. С привлекательными фасадами, просторными комнатами и планировками.</p>
      <a href="#popmake-18" class="about-button">Подобрать проект</a>
    </div>
  </div>
</div>

<div class="about-thumbs-wrap">
  <div class="about-thumbs">
  <?php for($i=0;$i<count($images);$i++): ?>
  <?php
    $image_small = wp_get_attachment_image_src( $images[$i], 'about-small' ); $image_small = $image_small[0];
    $image_big = wp_get_attachment_image_src( $images[$i], 'about-big' ); $image_big = $image_big[0];
    $image_full = wp_get_attachment_image_src( $images[$i], 'full' ); $image_full = $image_full[0];
     ?>
      <div data-num="<?php echo $i+1; ?>" class="about-thumb-wrap"><a data-fancybox="about" data-medium="<?php echo $image_big; ?>" href="<?php echo $image_full; ?>"><img src="<?php echo $image_small; ?>"></a><span></span></div>
  <?php endfor; ?>

  </div>
</div>
