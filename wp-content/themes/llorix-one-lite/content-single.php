<?php
/**
 * The template for displaying single page content.
 *
 * @package llorix-one-lite
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'content-single-page' ); ?>>
	<header class="entry-header single-header">
		<?php the_title( '<h1 itemprop="headline" class="entry-title single-title">', '</h1>' ); ?>
		<div class="colored-line-left"></div>
		<div class="clearfix"></div>

		<div class="entry-meta single-entry-meta">


			<?php llorix_one_lite_after_date_in_entry_meta_trigger(); ?>

		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div itemprop="text" class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'llorix-one-lite' ),
					'after'  => '</div>',
				)
			);
		?>
	</div><!-- .entry-content -->

	<!--<footer class="entry-footer">
		<?php llorix_one_lite_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
