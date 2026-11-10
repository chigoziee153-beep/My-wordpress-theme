<?php
/** Brand journey section and non-destructive v4 Gutenberg upgrade. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/** Show the section once on an already-imported v3 Home page, without editing page data. */
function nydla_custom_inject_journey_after_about( $content, $block ) {
	if ( is_admin() || ! is_front_page() || ! get_theme_mod( 'nydla_enable_brand_journey', true ) ) return $content;
	if ( empty( $block['blockName'] ) || 'nydla/about' !== $block['blockName'] ) return $content;
	$home = get_queried_object();
	if ( ! ( $home instanceof WP_Post ) || has_block( 'nydla/journey', $home->post_content ) ) return $content;
	return $content . nydla_custom_render_journey( array() );
}
add_filter( 'render_block', 'nydla_custom_inject_journey_after_about', 10, 2 );

/** Note: journey editorial copy is proposed copy pending NYDLA approval. */
function nydla_custom_render_journey( $a ) {
	if ( ! get_theme_mod( 'nydla_enable_brand_journey', true ) ) return '';
	$g = function ( $key ) use ( $a ) { return nydla_custom_block_value( 'journey', $a, $key ); };
	ob_start(); ?>
	<section class="nydla-journey-section section-padding" id="nydla-journey" aria-labelledby="nydla-journey-title">
		<div class="container">
			<div class="nydla-journey-heading">
				<div><span class="eyebrow"><span class="eyebrow-dash" aria-hidden="true"></span><?php echo esc_html( $g( 'eyebrow' ) ); ?></span>
				<h2 class="section-title" id="nydla-journey-title"><?php echo esc_html( $g( 'title' ) ); ?></h2></div>
				<p><?php echo esc_html( $g( 'description' ) ); ?></p>
			</div>
			<div class="nydla-journey-line" aria-hidden="true"><span></span></div>
			<div class="nydla-journey-grid">
				<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
					<article class="nydla-journey-step" data-journey-step="<?php echo esc_attr( (string) $i ); ?>">
						<span class="nydla-journey-marker" aria-hidden="true"><?php echo esc_html( str_pad( (string) $i, 2, '0', STR_PAD_LEFT ) ); ?></span>
						<h3><?php echo esc_html( $g( 'stage' . $i . 'Title' ) ); ?></h3>
						<p><?php echo esc_html( $g( 'stage' . $i . 'Text' ) ); ?></p>
						<span class="nydla-journey-arrow" aria-hidden="true">↗</span>
					</article>
				<?php endfor; ?>
			</div>
		</div>
	</section>
	<?php return ob_get_clean();
}

/** Upgrade only the original stock wording. Customized copy stays as-is. */
function nydla_custom_upgrade_home_v4() {
	if ( ! current_user_can( 'manage_options' ) ) wp_die( esc_html__( 'You do not have permission.', 'nydla-custom' ) );
	check_admin_referer( 'nydla_upgrade_home_v4' );
	$url = admin_url( 'tools.php?page=nydla-home-setup' );
	$home = get_page_by_path( 'home', OBJECT, 'page' );
	if ( ! ( $home instanceof WP_Post ) || ! has_block( 'nydla/hero', $home->post_content ) ) {
		wp_safe_redirect( add_query_arg( 'nydla_status', 'v4unavailable', $url ) ); exit;
	}
	$blocks = parse_blocks( $home->post_content );
	$replacements = array(
		'nydla/hero' => array(
			'eyebrow' => array( 'A community for what comes next', 'From distance learning to digital living' ),
			'title' => array( 'Learning without limits. Connecting without borders.', 'Distance learning. Digital learning. Digital living.' ),
			'description' => array( 'Explore the people, ideas, and technologies shaping how we learn, work, and collaborate.', 'Explore the people and ideas connecting education, technology, and everyday life.' ),
		),
		'nydla/about' => array(
			'title' => array( 'A better way to learn, together.', 'Connecting learning with life.' ),
			'description' => array( 'New ideas become more powerful when we share them. NYDLA brings people together around digital learning, professional growth, and the future of how we connect.', 'NYDLA brings together people, knowledge, and opportunities across distance learning, digital learning, and digital living.' ),
		),
	);
	$has_journey = has_block( 'nydla/journey', $home->post_content );
	$new_blocks = array();
	$changed = false;
	foreach ( $blocks as $block ) {
		$name = isset( $block['blockName'] ) ? $block['blockName'] : '';
		if ( isset( $replacements[ $name ] ) ) {
			foreach ( $replacements[ $name ] as $field => $pair ) {
				if ( isset( $block['attrs'][ $field ] ) && $pair[0] === $block['attrs'][ $field ] ) {
					$block['attrs'][ $field ] = $pair[1]; $changed = true;
				}
			}
		}
		$new_blocks[] = $block;
		if ( 'nydla/about' === $name && ! $has_journey ) {
			$attrs = array();
			foreach ( nydla_custom_home_schema()['journey']['fields'] as $key => $f ) {
				$attrs[ $key ] = (string) ( isset( $f['mod'] ) ? get_theme_mod( $f['mod'], $f['default'] ) : $f['default'] );
			}
			$new_blocks[] = array( 'blockName' => 'nydla/journey', 'attrs' => $attrs, 'innerBlocks' => array(), 'innerHTML' => '', 'innerContent' => array() );
			$has_journey = true; $changed = true;
		}
	}
	// If an old default was explicitly saved in the Customizer, update that exact
	// untouched stock phrase too. Never replace a client's edited wording.
	$mod_pairs = array(
		'nydla_hero_eyebrow' => $replacements['nydla/hero']['eyebrow'],
		'nydla_hero_title' => $replacements['nydla/hero']['title'],
		'nydla_hero_description' => $replacements['nydla/hero']['description'],
		'nydla_about_title' => $replacements['nydla/about']['title'],
		'nydla_about_text' => $replacements['nydla/about']['description'],
	);
	foreach ( $mod_pairs as $mod => $pair ) {
		if ( get_theme_mod( $mod, null ) === $pair[0] ) {
			set_theme_mod( $mod, $pair[1] );
			$changed = true;
		}
	}
	if ( ! $changed ) {
		wp_safe_redirect( add_query_arg( 'nydla_status', 'v4already', $url ) ); exit;
	}
	// WordPress maintains revisions, and this edit doesn't touch unrelated blocks.
	$result = wp_update_post( array( 'ID' => $home->ID, 'post_content' => wp_slash( serialize_blocks( $new_blocks ) ) ), true );
	wp_safe_redirect( add_query_arg( 'nydla_status', is_wp_error( $result ) ? 'error' : 'v4success', $url ) ); exit;
}
add_action( 'admin_post_nydla_upgrade_home_v4', 'nydla_custom_upgrade_home_v4' );
