<?php /** Single post template. @package NYDLACustom */ get_header(); ?>
<?php
if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'single' ) ) {
	get_footer();
	return;
}
if ( nydla_custom_is_elementor_content( get_queried_object_id() ) ) : ?>
<main id="main-content" class="nydla-elementor-content">
	<?php while ( have_posts() ) : the_post(); the_content(); endwhile; ?>
</main>
<?php get_footer(); return; endif; ?>
<main id="main-content" class="inner-page"><div class="container content-container">
	<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class( 'page-article' ); ?>><header class="page-heading"><span class="eyebrow"><?php echo esc_html( get_the_date() ); ?></span><h1><?php the_title(); ?></h1></header><?php if ( has_post_thumbnail() ) : ?><div class="single-featured"><?php the_post_thumbnail( 'large' ); ?></div><?php endif; ?><div class="prose"><?php the_content(); ?></div></article>
	<?php endwhile; ?>
</div></main>
<?php get_footer(); ?>
