<?php /** Default blog and archive template. @package NYDLACustom */ get_header(); ?>
<?php
if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'archive' ) ) {
	get_footer();
	return;
}
?>
<main id="main-content" class="inner-page">
	<div class="container content-container">
		<header class="page-heading"><span class="eyebrow"><?php esc_html_e( 'Explore NYDLA', 'nydla-custom' ); ?></span><h1><?php echo esc_html( is_home() && ! is_front_page() ? get_the_title( get_option( 'page_for_posts' ) ) : wp_get_document_title() ); ?></h1></header>
		<?php if ( have_posts() ) : ?>
			<div class="post-grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<article <?php post_class( 'post-card' ); ?>>
						<?php if ( has_post_thumbnail() ) : ?><a class="post-image" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'medium_large' ); ?></a><?php endif; ?>
						<div class="post-content"><span class="post-meta"><?php echo esc_html( get_the_date() ); ?></span><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p><a class="text-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read article', 'nydla-custom' ); ?> ↗</a></div>
					</article>
				<?php endwhile; ?>
			</div>
			<div class="pagination"><?php the_posts_pagination(); ?></div>
		<?php else : ?>
			<p><?php esc_html_e( 'No posts have been published yet.', 'nydla-custom' ); ?></p>
		<?php endif; ?>
	</div>
</main>
<?php get_footer(); ?>
