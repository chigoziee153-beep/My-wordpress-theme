<?php
/**
 * Native Gutenberg homepage sections and a non-destructive, opt-in importer.
 *
 * This keeps the original NYDLA HTML and CSS owned by the theme while making
 * all prominent content editable in Pages > Home. No Elementor dependency.
 *
 * @package NYDLACustom
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Field metadata is used by the server renderer, editor, and starter importer. */
function nydla_custom_home_schema() {
	return array(
		'hero' => array(
			'title' => 'NYDLA — Homepage Hero', 'icon' => 'cover-image', 'description' => 'Main hero, buttons and original purple artwork.',
			'fields' => array(
				'eyebrow' => array( 'label' => 'Small heading', 'mod' => 'nydla_hero_eyebrow', 'default' => 'From distance learning to digital living' ),
				'title' => array( 'label' => 'Main heading', 'mod' => 'nydla_hero_title', 'default' => 'Distance learning. Digital learning. Digital living.' ),
				'description' => array( 'label' => 'Intro paragraph', 'mod' => 'nydla_hero_description', 'default' => 'Explore the people and ideas connecting education, technology, and everyday life.', 'multiline' => true ),
				'primaryLabel' => array( 'label' => 'Primary button text', 'mod' => 'nydla_hero_button_text', 'default' => 'Explore NYDLA' ),
				'primaryUrl' => array( 'label' => 'Primary button link', 'default' => '#explore', 'url' => true ),
				'secondaryLabel' => array( 'label' => 'Secondary button text', 'default' => 'Join our community' ),
				'secondaryUrl' => array( 'label' => 'Secondary button link (blank uses membership URL)', 'default' => '', 'url' => true ),
				'caption' => array( 'label' => 'Small tagline below buttons', 'default' => 'Digital learning • Professional connections • Shared progress' ),
				'panelWord1' => array( 'label' => 'Purple artwork word 1', 'default' => 'Ideas.' ),
				'panelWord2' => array( 'label' => 'Purple artwork word 2', 'default' => 'People.' ),
				'panelWord3' => array( 'label' => 'Purple artwork word 3', 'default' => 'Progress.' ),
			),
		),
		'about' => array(
			'title' => 'NYDLA — About Section', 'icon' => 'groups', 'description' => 'Association introduction and link.',
			'fields' => array(
				'eyebrow' => array( 'label' => 'Small heading', 'mod' => 'nydla_about_eyebrow', 'default' => 'The NYDLA community' ),
				'title' => array( 'label' => 'Section heading', 'mod' => 'nydla_about_title', 'default' => 'Connecting learning with life.' ),
				'description' => array( 'label' => 'About paragraph', 'mod' => 'nydla_about_text', 'default' => 'NYDLA brings together people, knowledge, and opportunities across distance learning, digital learning, and digital living.', 'multiline' => true ),
				'linkLabel' => array( 'label' => 'About link text', 'default' => 'Discover our focus' ),
				'linkUrl' => array( 'label' => 'About link destination', 'default' => '#explore', 'url' => true ),
			),
		),
		'journey' => array(
			'title' => 'NYDLA — Brand Journey', 'icon' => 'networking', 'description' => 'Three steps: Distance Learning → Digital Learning → Digital Living.',
			'fields' => array(
				'eyebrow' => array( 'label' => 'Small heading', 'mod' => 'nydla_journey_eyebrow', 'default' => 'Our evolving focus' ),
				'title' => array( 'label' => 'Section heading', 'mod' => 'nydla_journey_title', 'default' => 'From learning at a distance to living digitally.' ),
				'description' => array( 'label' => 'Section description', 'mod' => 'nydla_journey_description', 'default' => 'Three connected ideas that guide how we explore learning, technology, and community.', 'multiline' => true ),
				'stage1Title' => array( 'label' => 'Stage 1 heading', 'mod' => 'nydla_journey_1_title', 'default' => 'Distance Learning' ),
				'stage1Text' => array( 'label' => 'Stage 1 description', 'mod' => 'nydla_journey_1_text', 'default' => 'Learning beyond the boundaries of a physical classroom.', 'multiline' => true ),
				'stage2Title' => array( 'label' => 'Stage 2 heading', 'mod' => 'nydla_journey_2_title', 'default' => 'Digital Learning' ),
				'stage2Text' => array( 'label' => 'Stage 2 description', 'mod' => 'nydla_journey_2_text', 'default' => 'Knowledge, tools, and connections in a digital world.', 'multiline' => true ),
				'stage3Title' => array( 'label' => 'Stage 3 heading', 'mod' => 'nydla_journey_3_title', 'default' => 'Digital Living' ),
				'stage3Text' => array( 'label' => 'Stage 3 description', 'mod' => 'nydla_journey_3_text', 'default' => 'Exploring how technology shapes everyday life and possibility.', 'multiline' => true ),
			),
		),
		'features' => array(
			'title' => 'NYDLA — Feature Cards', 'icon' => 'grid-view', 'description' => 'Four original NYDLA feature cards.',
			'fields' => array(
				'eyebrow' => array( 'label' => 'Small heading', 'mod' => 'nydla_features_eyebrow', 'default' => 'Explore the possibilities' ),
				'title' => array( 'label' => 'Section heading', 'mod' => 'nydla_features_title', 'default' => 'Built around what matters.' ),
				'description' => array( 'label' => 'Section description', 'mod' => 'nydla_features_description', 'default' => 'Find fresh perspectives, meaningful connections, and opportunities to keep growing.', 'multiline' => true ),
				'card1Title' => array( 'label' => 'Card 1 title', 'mod' => 'nydla_card_1_title', 'default' => 'Digital Learning' ),
				'card1Text' => array( 'label' => 'Card 1 description', 'mod' => 'nydla_card_1_text', 'default' => 'Ideas and conversations shaping learning in a connected world.', 'multiline' => true ),
				'card2Title' => array( 'label' => 'Card 2 title', 'mod' => 'nydla_card_2_title', 'default' => 'Our Community' ),
				'card2Text' => array( 'label' => 'Card 2 description', 'mod' => 'nydla_card_2_text', 'default' => 'A place to meet people who believe in shared progress.', 'multiline' => true ),
				'card3Title' => array( 'label' => 'Card 3 title', 'mod' => 'nydla_card_3_title', 'default' => 'Podcasts & Insights' ),
				'card3Text' => array( 'label' => 'Card 3 description', 'mod' => 'nydla_card_3_text', 'default' => 'Explore perspectives and stories from across the digital learning community.', 'multiline' => true ),
				'card4Title' => array( 'label' => 'Card 4 title', 'mod' => 'nydla_card_4_title', 'default' => 'Events & Experiences' ),
				'card4Text' => array( 'label' => 'Card 4 description', 'mod' => 'nydla_card_4_text', 'default' => 'Discover opportunities for learning, conversations, and collaboration.', 'multiline' => true ),
			),
		),
		'membership' => array(
			'title' => 'NYDLA — Membership Panel', 'icon' => 'heart', 'description' => 'The main membership call to action.',
			'fields' => array(
				'eyebrow' => array( 'label' => 'Small heading', 'mod' => 'nydla_membership_eyebrow', 'default' => 'Make the connection' ),
				'title' => array( 'label' => 'Section heading', 'mod' => 'nydla_membership_title', 'default' => 'The best ideas grow together.' ),
				'description' => array( 'label' => 'Description', 'mod' => 'nydla_membership_text', 'default' => 'Become part of a community exploring the people and possibilities of digital learning.', 'multiline' => true ),
				'buttonLabel' => array( 'label' => 'Button text', 'mod' => 'nydla_membership_button_text', 'default' => 'Explore membership' ),
				'buttonUrl' => array( 'label' => 'Button link (blank uses membership URL)', 'default' => '', 'url' => true ),
			),
		),
		'insights' => array(
			'title' => 'NYDLA — Latest Articles', 'icon' => 'admin-post', 'description' => 'Shows the three newest published posts automatically.',
			'fields' => array(
				'eyebrow' => array( 'label' => 'Small heading', 'default' => 'Ideas worth sharing' ),
				'title' => array( 'label' => 'Section heading', 'mod' => 'nydla_articles_title', 'default' => 'Latest perspectives.' ),
				'description' => array( 'label' => 'Description', 'mod' => 'nydla_articles_text', 'default' => 'Fresh content from the NYDLA community.', 'multiline' => true ),
			),
		),
	);
}

function nydla_custom_block_value( $slug, $attributes, $field ) {
	$schema = nydla_custom_home_schema();
	if ( isset( $attributes[ $field ] ) && is_scalar( $attributes[ $field ] ) ) {
		return (string) $attributes[ $field ];
	}
	if ( ! isset( $schema[ $slug ]['fields'][ $field ] ) ) {
		return '';
	}
	$info = $schema[ $slug ]['fields'][ $field ];
	return isset( $info['mod'] ) ? (string) get_theme_mod( $info['mod'], $info['default'] ) : $info['default'];
}

/** Use the newly created internal Membership page by default. */
function nydla_custom_membership_url() {
	$custom = get_theme_mod( 'nydla_membership_url', '' );
	if ( is_string( $custom ) && '' !== trim( $custom ) ) {
		return $custom;
	}
	$page = get_page_by_path( 'membership-join', OBJECT, 'page' );
	if ( $page instanceof WP_Post && 'publish' === $page->post_status ) {
		return get_permalink( $page );
	}
	return home_url( '/membership-join/' );
}

function nydla_custom_register_home_blocks() {
	$version = wp_get_theme()->get( 'Version' );
	wp_register_script(
		'nydla-custom-home-blocks-editor',
		get_template_directory_uri() . '/assets/js/home-blocks.js',
		array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n' ),
		$version,
		true
	);
	$editor_schema = array();
	foreach ( nydla_custom_home_schema() as $slug => $definition ) {
		$attributes = array();
		$fields = array();
		foreach ( $definition['fields'] as $key => $info ) {
			$default = isset( $info['mod'] ) ? get_theme_mod( $info['mod'], $info['default'] ) : $info['default'];
			$attributes[ $key ] = array( 'type' => 'string', 'default' => (string) $default );
			$fields[] = array(
				'key' => $key, 'label' => $info['label'], 'default' => (string) $default,
				'multiline' => ! empty( $info['multiline'] ), 'url' => ! empty( $info['url'] ),
			);
		}
		$editor_schema[ $slug ] = array(
			'title' => $definition['title'], 'icon' => $definition['icon'],
			'description' => $definition['description'], 'fields' => $fields,
		);
		register_block_type( 'nydla/' . $slug, array(
			'api_version' => 2,
			'editor_script' => 'nydla-custom-home-blocks-editor',
			'attributes' => $attributes,
			'render_callback' => function ( $attributes ) use ( $slug ) {
				return nydla_custom_render_home_block( $slug, $attributes );
			},
		) );
	}
	wp_add_inline_script( 'nydla-custom-home-blocks-editor', 'window.NYDLAHomeBlockDefinitions = ' . wp_json_encode( $editor_schema ) . ';', 'before' );
}
add_action( 'init', 'nydla_custom_register_home_blocks' );

/** Render either the editable section or the identical legacy fallback. */
function nydla_custom_render_home_block( $slug, $attributes = array() ) {
	$renderer = 'nydla_custom_render_' . $slug;
	return function_exists( $renderer ) ? call_user_func( $renderer, $attributes ) : '';
}

/** Optional, explicit importer: never silently overwrite the user's Home page. */
function nydla_custom_home_setup_menu() {
	add_management_page( 'NYDLA Editable Homepage', 'NYDLA Home Setup', 'manage_options', 'nydla-home-setup', 'nydla_custom_home_setup_screen' );
}
add_action( 'admin_menu', 'nydla_custom_home_setup_menu' );
require_once get_template_directory() . '/inc/journey.php';

function nydla_custom_home_setup_screen() {
	if ( ! current_user_can( 'manage_options' ) ) return;
	$home = get_page_by_path( 'home', OBJECT, 'page' );
	$status = isset( $_GET['nydla_status'] ) && is_string( $_GET['nydla_status'] ) ? sanitize_key( wp_unslash( $_GET['nydla_status'] ) ) : '';
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'NYDLA — Editable Home Page', 'nydla-custom' ); ?></h1>
		<p><?php esc_html_e( 'This optional setup adds the original NYDLA sections to WordPress Gutenberg so you can edit them under Pages → Home, without reconstructing the design manually.', 'nydla-custom' ); ?></p>
		<?php if ( 'success' === $status ) : ?><div class="notice notice-success"><p><?php esc_html_e( 'The editable homepage is installed. Open Pages → Home → Edit to change its section content.', 'nydla-custom' ); ?></p></div><?php endif; ?>
		<?php if ( 'occupied' === $status ) : ?><div class="notice notice-warning"><p><?php esc_html_e( 'The Home page already contains content. No changes were made; back it up and review it before importing.', 'nydla-custom' ); ?></p></div><?php endif; ?>
		<?php if ( 'v4success' === $status ) : ?><div class="notice notice-success"><p><?php esc_html_e( 'v4 branding and Brand Journey block added. Your other page content was preserved. Review the copy before client approval.', 'nydla-custom' ); ?></p></div><?php endif; ?>
		<?php if ( 'v4already' === $status ) : ?><div class="notice notice-info"><p><?php esc_html_e( 'No stock copy or missing Brand Journey block was found. Nothing was changed.', 'nydla-custom' ); ?></p></div><?php endif; ?>
		<?php if ( 'v4unavailable' === $status ) : ?><div class="notice notice-warning"><p><?php esc_html_e( 'This upgrade is for Home pages containing the NYDLA Gutenberg blocks. No changes were made.', 'nydla-custom' ); ?></p></div><?php endif; ?>
		<?php if ( 'error' === $status ) : ?><div class="notice notice-error"><p><?php esc_html_e( 'The setup could not finish; no existing Home content was overwritten.', 'nydla-custom' ); ?></p></div><?php endif; ?>
		<?php if ( $home instanceof WP_Post && has_block( 'nydla/hero', $home->post_content ) ) : ?>
			<hr><h2><?php esc_html_e( 'v4: Brand Journey + homepage copy', 'nydla-custom' ); ?></h2>
			<p><?php esc_html_e( 'Adds the new editable Brand Journey block after About and updates only unchanged v3 placeholder hero/About copy. Custom text and other blocks are preserved. Review and back up the Home page first.', 'nydla-custom' ); ?></p>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="nydla_upgrade_home_v4">
				<?php wp_nonce_field( 'nydla_upgrade_home_v4' ); ?>
				<?php submit_button( __( 'Add v4 Brand Journey and update unchanged sample copy', 'nydla-custom' ), 'secondary' ); ?>
			</form>
		<?php endif; ?>
		<?php if ( $home instanceof WP_Post && '' !== trim( $home->post_content ) ) : ?>
			<p><strong><?php esc_html_e( 'The existing Home page contains content. Import is disabled to protect it.', 'nydla-custom' ); ?></strong></p>
		<?php else : ?>
			<p><?php esc_html_e( 'Only use this on your Hostinger staging site after saving a backup. This will publish Home and set it as the static front page.', 'nydla-custom' ); ?></p>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="nydla_import_home">
				<?php wp_nonce_field( 'nydla_import_home' ); ?>
				<?php submit_button( __( 'Install editable NYDLA homepage on staging', 'nydla-custom' ) ); ?>
			</form>
		<?php endif; ?>
	</div>
	<?php
}

function nydla_custom_import_home() {
	if ( ! current_user_can( 'manage_options' ) ) wp_die( esc_html__( 'You do not have permission to do this.', 'nydla-custom' ) );
	check_admin_referer( 'nydla_import_home' );
	$redirect = admin_url( 'tools.php?page=nydla-home-setup' );
	$home = get_page_by_path( 'home', OBJECT, 'page' );
	if ( $home instanceof WP_Post && '' !== trim( $home->post_content ) ) {
		wp_safe_redirect( add_query_arg( 'nydla_status', 'occupied', $redirect ) );
		exit;
	}
	$content = '';
	foreach ( nydla_custom_home_schema() as $slug => $definition ) {
		$attributes = array();
		foreach ( $definition['fields'] as $key => $field ) {
			$attributes[ $key ] = (string) ( isset( $field['mod'] ) ? get_theme_mod( $field['mod'], $field['default'] ) : $field['default'] );
		}
		$content .= serialize_block( array(
			'blockName' => 'nydla/' . $slug,
			'attrs' => $attributes,
			'innerBlocks' => array(),
			'innerHTML' => '',
			'innerContent' => array(),
		) ) . "\n\n";
	}
	$data = array( 'post_title' => 'Home', 'post_name' => 'home', 'post_type' => 'page', 'post_status' => 'publish', 'post_content' => wp_slash( $content ) );
	if ( $home instanceof WP_Post ) $data['ID'] = $home->ID;
	$page_id = $home instanceof WP_Post ? wp_update_post( $data, true ) : wp_insert_post( $data, true );
	if ( is_wp_error( $page_id ) || ! $page_id ) {
		wp_safe_redirect( add_query_arg( 'nydla_status', 'error', $redirect ) );
		exit;
	}
	update_post_meta( (int) $page_id, '_nydla_home_blocks_installed', '1' );
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', (int) $page_id );
	wp_safe_redirect( add_query_arg( 'nydla_status', 'success', $redirect ) );
	exit;
}
add_action( 'admin_post_nydla_import_home', 'nydla_custom_import_home' );

/** The hero uses original NYDLA CSS artwork, not any commercial-theme assets. */
function nydla_custom_render_hero( $a ) {
	$g = function ( $field ) use ( $a ) { return nydla_custom_block_value( 'hero', $a, $field ); };
	$join_url = $g( 'secondaryUrl' ) ?: nydla_custom_membership_url();
	ob_start();
	?>
	<section class="hero-section" aria-labelledby="hero-title">
		<div class="hero-glow glow-one" aria-hidden="true"></div>
		<div class="hero-glow glow-two" aria-hidden="true"></div>
		<div class="container hero-grid">
			<div class="hero-copy">
				<div class="eyebrow eyebrow-light"><span class="signal-dot" aria-hidden="true"></span><?php echo esc_html( $g( 'eyebrow' ) ); ?></div>
				<h1 id="hero-title"><?php echo esc_html( $g( 'title' ) ); ?></h1>
				<p class="hero-description"><?php echo esc_html( $g( 'description' ) ); ?></p>
				<div class="hero-actions">
					<a class="button button-primary" href="<?php echo esc_url( $g( 'primaryUrl' ) ); ?>"><?php echo esc_html( $g( 'primaryLabel' ) ); ?> <span aria-hidden="true">↗</span></a>
					<a class="button button-outline" href="<?php echo esc_url( $join_url ); ?>"><?php echo esc_html( $g( 'secondaryLabel' ) ); ?> <span aria-hidden="true">↗</span></a>
				</div>
				<div class="hero-caption"><span class="caption-line" aria-hidden="true"></span><?php echo esc_html( $g( 'caption' ) ); ?></div>
			</div>
			<div class="hero-art" aria-hidden="true">
				<div class="visual-orbit orbit-one"></div><div class="visual-orbit orbit-two"></div>
				<div class="hero-main-panel">
					<div class="panel-top"><span class="panel-indicator"></span><span>NYDLA / CONNECT</span><span class="panel-plus">✳</span></div>
					<div class="panel-center"><span class="panel-kicker">Discover what is possible</span><strong><?php echo esc_html( $g( 'panelWord1' ) ); ?><br><?php echo esc_html( $g( 'panelWord2' ) ); ?><br><em><?php echo esc_html( $g( 'panelWord3' ) ); ?></em></strong></div>
					<div class="panel-bottom"><span>Learn together</span><span>↗</span></div>
				</div>
				<div class="float-card float-card-left"><span class="float-symbol">✦</span><strong>New perspectives</strong><small>Open the conversation</small></div>
				<div class="float-card float-card-right"><span class="float-symbol">↗</span><strong>Connected minds</strong><small>Stronger together</small></div>
			</div>
		</div>
		<div class="container hero-bottom-rule"><span>LEARN</span><span>CONNECT</span><span>EVOLVE</span></div>
	</section>
	<?php
	return ob_get_clean();
}

function nydla_custom_render_about( $a ) {
	$g = function ( $field ) use ( $a ) { return nydla_custom_block_value( 'about', $a, $field ); };
	ob_start();
	?>
	<section id="about" class="intro-section section-padding" aria-labelledby="about-heading">
		<div class="container intro-grid">
			<div><span class="eyebrow"><span class="eyebrow-dash"></span><?php echo esc_html( $g( 'eyebrow' ) ); ?></span><h2 id="about-heading" class="section-title"><?php echo esc_html( $g( 'title' ) ); ?></h2></div>
			<div class="intro-right"><p><?php echo esc_html( $g( 'description' ) ); ?></p><a class="text-link" href="<?php echo esc_url( $g( 'linkUrl' ) ); ?>"><?php echo esc_html( $g( 'linkLabel' ) ); ?> <span aria-hidden="true">↗</span></a></div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

function nydla_custom_render_membership( $a ) {
	$g = function ( $field ) use ( $a ) { return nydla_custom_block_value( 'membership', $a, $field ); };
	$button_url = $g( 'buttonUrl' ) ?: nydla_custom_membership_url();
	ob_start();
	?>
	<section class="membership-section section-padding" aria-labelledby="membership-heading">
		<div class="container membership-panel"><div class="membership-rings" aria-hidden="true"></div>
			<div class="membership-content"><span class="eyebrow eyebrow-light"><span class="signal-dot" aria-hidden="true"></span><?php echo esc_html( $g( 'eyebrow' ) ); ?></span><h2 id="membership-heading"><?php echo esc_html( $g( 'title' ) ); ?></h2><p><?php echo esc_html( $g( 'description' ) ); ?></p><a class="button button-white" href="<?php echo esc_url( $button_url ); ?>"><?php echo esc_html( $g( 'buttonLabel' ) ); ?> <span aria-hidden="true">↗</span></a></div>
			<div class="membership-symbol" aria-hidden="true">✳</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

function nydla_custom_render_features( $a ) {
	$g = function ( $field ) use ( $a ) { return nydla_custom_block_value( 'features', $a, $field ); };
	ob_start();
	?>
	<section id="explore" class="explore-section section-padding" aria-labelledby="explore-heading">
		<div class="container">
			<div class="section-heading"><div><span class="eyebrow"><span class="eyebrow-dash"></span><?php echo esc_html( $g( 'eyebrow' ) ); ?></span><h2 id="explore-heading" class="section-title"><?php echo esc_html( $g( 'title' ) ); ?></h2></div><p><?php echo esc_html( $g( 'description' ) ); ?></p></div>
			<div class="bento-grid">
				<article class="bento-card card-learning"><div class="card-icon" aria-hidden="true">✳</div><div class="card-copy"><span class="card-index">01 / DISCOVER</span><h3><?php echo esc_html( $g( 'card1Title' ) ); ?></h3><p><?php echo esc_html( $g( 'card1Text' ) ); ?></p></div><span class="card-decoration" aria-hidden="true">✦</span></article>
				<article class="bento-card card-community"><div class="card-icon" aria-hidden="true">↗</div><div class="card-copy"><span class="card-index">02 / CONNECT</span><h3><?php echo esc_html( $g( 'card2Title' ) ); ?></h3><p><?php echo esc_html( $g( 'card2Text' ) ); ?></p></div><div class="community-circles" aria-hidden="true"><i></i><i></i><i></i></div></article>
				<article class="bento-card card-podcast"><div class="card-icon" aria-hidden="true">◉</div><div class="card-copy"><span class="card-index">03 / LISTEN</span><h3><?php echo esc_html( $g( 'card3Title' ) ); ?></h3><p><?php echo esc_html( $g( 'card3Text' ) ); ?></p></div><div class="wave-bars" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i></div></article>
				<article class="bento-card card-events"><div class="card-icon" aria-hidden="true">◇</div><div class="card-copy"><span class="card-index">04 / PARTICIPATE</span><h3><?php echo esc_html( $g( 'card4Title' ) ); ?></h3><p><?php echo esc_html( $g( 'card4Text' ) ); ?></p></div><div class="events-graphic" aria-hidden="true"><span>NY</span><span>DL</span><span>A.</span></div></article>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

function nydla_custom_render_insights( $a ) {
	$g = function ( $field ) use ( $a ) { return nydla_custom_block_value( 'insights', $a, $field ); };
	ob_start();
	?>
	<section class="insights-section section-padding" id="insights" aria-labelledby="insights-heading">
		<div class="container">
			<div class="section-heading"><div><span class="eyebrow"><span class="eyebrow-dash"></span><?php echo esc_html( $g( 'eyebrow' ) ); ?></span><h2 id="insights-heading" class="section-title"><?php echo esc_html( $g( 'title' ) ); ?></h2></div><p><?php echo esc_html( $g( 'description' ) ); ?></p></div>
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
	return ob_get_clean();
}
