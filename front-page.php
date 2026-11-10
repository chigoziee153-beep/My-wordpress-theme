<?php
/**
 * NYDLA custom homepage. All layout, markup, and styling are original.
 *
 * @package NYDLACustom
 */

get_header();
// Only pages explicitly edited with Elementor (or its editor preview) use this
// full-width path. All existing Gutenberg and Customizer homepage paths remain.
if ( nydla_custom_is_elementor_content( get_queried_object_id() ) ) :
	?>
	<main id="main-content" class="nydla-elementor-content">
		<?php while ( have_posts() ) : the_post(); the_content(); endwhile; ?>
	</main>
	<?php
	get_footer();
	return;
endif;
// A one-click Home import replaces the legacy hardcoded sections with native,
// individually editable Gutenberg blocks. Until then the v0.2 homepage stays
// intact, including every saved Customizer choice.
$home_post = get_queried_object();
if ( $home_post instanceof WP_Post && ( has_block( 'nydla/hero', $home_post->post_content ) || get_post_meta( $home_post->ID, '_nydla_home_blocks_installed', true ) ) ) :
	?>
	<main id="main-content" class="nydla-editable-home">
		<?php while ( have_posts() ) : the_post(); the_content(); endwhile; ?>
	</main>
	<?php
	get_footer();
	return;
endif;
$membership_url = nydla_custom_membership_url();
?>
<main id="main-content">
	<section class="hero-section" aria-labelledby="hero-title">
		<div class="hero-glow glow-one" aria-hidden="true"></div>
		<div class="hero-glow glow-two" aria-hidden="true"></div>
		<div class="container hero-grid">
			<div class="hero-copy">
				<div class="eyebrow eyebrow-light"><span class="signal-dot" aria-hidden="true"></span><?php echo esc_html( get_theme_mod( 'nydla_hero_eyebrow', 'From distance learning to digital living' ) ); ?></div>
				<h1 id="hero-title"><?php echo esc_html( get_theme_mod( 'nydla_hero_title', 'Distance learning. Digital learning. Digital living.' ) ); ?></h1>
				<p class="hero-description"><?php echo esc_html( get_theme_mod( 'nydla_hero_description', 'Explore the people and ideas connecting education, technology, and everyday life.' ) ); ?></p>
				<div class="hero-actions">
					<a class="button button-primary" href="#explore"><?php echo esc_html( get_theme_mod( 'nydla_hero_button_text', 'Explore NYDLA' ) ); ?> <span aria-hidden="true">↗</span></a>
					<a class="button button-outline" href="<?php echo esc_url( $membership_url ); ?>"><?php esc_html_e( 'Join our community', 'nydla-custom' ); ?> <span aria-hidden="true">↗</span></a>
				</div>
				<div class="hero-caption"><span class="caption-line" aria-hidden="true"></span><?php esc_html_e( 'Digital learning • Professional connections • Shared progress', 'nydla-custom' ); ?></div>
			</div>
			<div class="hero-art" aria-hidden="true">
				<div class="visual-orbit orbit-one"></div><div class="visual-orbit orbit-two"></div>
				<div class="hero-main-panel"><div class="panel-top"><span class="panel-indicator"></span><span>NYDLA / CONNECT</span><span class="panel-plus">✳</span></div><div class="panel-center"><span class="panel-kicker">Discover what is possible</span><strong>Ideas.<br>People.<br><em>Progress.</em></strong></div><div class="panel-bottom"><span>Learn together</span><span>↗</span></div></div>
				<div class="float-card float-card-left"><span class="float-symbol">✦</span><strong>New perspectives</strong><small>Open the conversation</small></div>
				<div class="float-card float-card-right"><span class="float-symbol">↗</span><strong>Connected minds</strong><small>Stronger together</small></div>
			</div>
		</div>
		<div class="container hero-bottom-rule"><span><?php esc_html_e( 'LEARN', 'nydla-custom' ); ?></span><span><?php esc_html_e( 'CONNECT', 'nydla-custom' ); ?></span><span><?php esc_html_e( 'EVOLVE', 'nydla-custom' ); ?></span></div>
	</section>

	<section id="about" class="intro-section section-padding" aria-labelledby="about-heading">
		<div class="container intro-grid">
			<div><span class="eyebrow"><span class="eyebrow-dash"></span><?php echo esc_html( get_theme_mod( 'nydla_about_eyebrow', 'The NYDLA community' ) ); ?></span><h2 id="about-heading" class="section-title"><?php echo esc_html( get_theme_mod( 'nydla_about_title', 'Connecting learning with life.' ) ); ?></h2></div>
			<div class="intro-right"><p><?php echo esc_html( get_theme_mod( 'nydla_about_text', 'NYDLA brings together people, knowledge, and opportunities across distance learning, digital learning, and digital living.' ) ); ?></p><a class="text-link" href="#explore"><?php esc_html_e( 'Discover our focus', 'nydla-custom' ); ?> <span aria-hidden="true">↗</span></a></div>
		</div>
	</section>

	<?php if ( get_theme_mod( 'nydla_enable_brand_journey', true ) ) echo nydla_custom_render_journey( array() ); ?>

	<section id="explore" class="explore-section section-padding" aria-labelledby="explore-heading">
		<div class="container">
			<div class="section-heading"><div><span class="eyebrow"><span class="eyebrow-dash"></span><?php echo esc_html( get_theme_mod( 'nydla_features_eyebrow', 'Explore the possibilities' ) ); ?></span><h2 id="explore-heading" class="section-title"><?php echo esc_html( get_theme_mod( 'nydla_features_title', 'Built around what matters.' ) ); ?></h2></div><p><?php echo esc_html( get_theme_mod( 'nydla_features_description', 'Find fresh perspectives, meaningful connections, and opportunities to keep growing.' ) ); ?></p></div>
			<div class="bento-grid">
				<article class="bento-card card-learning"><div class="card-icon" aria-hidden="true">✳</div><div class="card-copy"><span class="card-index">01 / DISCOVER</span><h3><?php echo esc_html( get_theme_mod( 'nydla_card_1_title', 'Digital Learning' ) ); ?></h3><p><?php echo esc_html( get_theme_mod( 'nydla_card_1_text', 'Ideas and conversations shaping learning in a connected world.' ) ); ?></p></div><span class="card-decoration" aria-hidden="true">✦</span></article>
				<article class="bento-card card-community"><div class="card-icon" aria-hidden="true">↗</div><div class="card-copy"><span class="card-index">02 / CONNECT</span><h3><?php echo esc_html( get_theme_mod( 'nydla_card_2_title', 'Our Community' ) ); ?></h3><p><?php echo esc_html( get_theme_mod( 'nydla_card_2_text', 'A place to meet people who believe in shared progress.' ) ); ?></p></div><div class="community-circles" aria-hidden="true"><i></i><i></i><i></i></div></article>
				<article class="bento-card card-podcast"><div class="card-icon" aria-hidden="true">◉</div><div class="card-copy"><span class="card-index">03 / LISTEN</span><h3><?php echo esc_html( get_theme_mod( 'nydla_card_3_title', 'Podcasts & Insights' ) ); ?></h3><p><?php echo esc_html( get_theme_mod( 'nydla_card_3_text', 'Explore perspectives and stories from across the digital learning community.' ) ); ?></p></div><div class="wave-bars" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i></div></article>
				<article class="bento-card card-events"><div class="card-icon" aria-hidden="true">◇</div><div class="card-copy"><span class="card-index">04 / PARTICIPATE</span><h3><?php echo esc_html( get_theme_mod( 'nydla_card_4_title', 'Events & Experiences' ) ); ?></h3><p><?php echo esc_html( get_theme_mod( 'nydla_card_4_text', 'Discover opportunities for learning, conversations, and collaboration.' ) ); ?></p></div><div class="events-graphic" aria-hidden="true"><span>NY</span><span>DL</span><span>A.</span></div></article>
			</div>
		</div>
	</section>

	<section class="membership-section section-padding" aria-labelledby="membership-heading">
		<div class="container membership-panel"><div class="membership-rings" aria-hidden="true"></div><div class="membership-content"><span class="eyebrow eyebrow-light"><span class="signal-dot" aria-hidden="true"></span><?php echo esc_html( get_theme_mod( 'nydla_membership_eyebrow', 'Make the connection' ) ); ?></span><h2 id="membership-heading"><?php echo esc_html( get_theme_mod( 'nydla_membership_title', 'The best ideas grow together.' ) ); ?></h2><p><?php echo esc_html( get_theme_mod( 'nydla_membership_text', 'Become part of a community exploring the people and possibilities of digital learning.' ) ); ?></p><a class="button button-white" href="<?php echo esc_url( $membership_url ); ?>"><?php echo esc_html( get_theme_mod( 'nydla_membership_button_text', 'Explore membership' ) ); ?> <span aria-hidden="true">↗</span></a></div><div class="membership-symbol" aria-hidden="true">✳</div></div>
	</section>

	<section class="insights-section section-padding" id="insights" aria-labelledby="insights-heading">
		<div class="container"><div class="section-heading"><div><span class="eyebrow"><span class="eyebrow-dash"></span><?php esc_html_e( 'Ideas worth sharing', 'nydla-custom' ); ?></span><h2 id="insights-heading" class="section-title"><?php echo esc_html( get_theme_mod( 'nydla_articles_title', 'Latest perspectives.' ) ); ?></h2></div><p><?php echo esc_html( get_theme_mod( 'nydla_articles_text', 'Fresh content from the NYDLA community.' ) ); ?></p></div>
			<?php
			$latest = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 3, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) );
			if ( $latest->have_posts() ) : ?>
				<div class="post-grid">
					<?php while ( $latest->have_posts() ) : $latest->the_post(); ?>
						<article <?php post_class( 'post-card' ); ?>>
							<?php if ( has_post_thumbnail() ) : ?><a class="post-image" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'medium_large' ); ?></a><?php endif; ?>
							<div class="post-content"><span class="post-meta"><?php echo esc_html( get_the_date() ); ?></span><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 16 ) ); ?></p><a class="text-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read more', 'nydla-custom' ); ?> ↗</a></div>
						</article>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
			<?php else : ?>
				<div class="empty-insights"><span class="empty-symbol" aria-hidden="true">✧</span><h3><?php esc_html_e( 'Stories will appear here.', 'nydla-custom' ); ?></h3><p><?php esc_html_e( 'Once articles are published in WordPress, the latest posts will automatically populate this section.', 'nydla-custom' ); ?></p></div>
			<?php endif; ?>
		</div>
	</section>
	<?php
	// When a static WordPress page is assigned as the homepage, its editable
	// Gutenberg content can add entirely new sections below the theme layout.
	if ( is_page() && have_posts() ) :
		while ( have_posts() ) :
			the_post();
			if ( trim( (string) get_the_content() ) ) :
				?>
				<section class="home-block-content section-padding" aria-label="<?php esc_attr_e( 'Additional homepage content', 'nydla-custom' ); ?>">
					<div class="container prose home-prose"><?php the_content(); ?></div>
				</section>
				<?php
			endif;
		endwhile;
	endif;
	?>
</main>
<?php get_footer(); ?>
