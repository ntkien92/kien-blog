<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package AcmeThemes
 * @subpackage SuperNews
 */
global $supernews_customizer_all_values;
$supernews_blog_no_image = '';
if( !has_post_thumbnail() || 'no-image' == $supernews_customizer_all_values['supernews-blog-archive-layout'] ) {
	$supernews_blog_no_image = 'blog-no-image';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $supernews_blog_no_image ); ?>>
	<?php
	if( has_post_thumbnail() && 'show-image' == $supernews_customizer_all_values['supernews-blog-archive-layout'] ) {
		?>
		<!--post thumbnal options-->
		<div class="post-thumb">
			<?php
			$thumb = 'large';
			if( 'no-sidebar' == $supernews_customizer_all_values['supernews-sidebar-layout'] ){
				$thumb = 'full';
			}
			?>
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( $thumb );?>
			</a>
			<?php supernews_list_category(); ?>
		</div><!-- .post-thumb-->
	<?php
	}
	?>
	<div class="post-content">
		<header class="entry-header">
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
			<div class="entry-meta">
				<?php if ( 'post' === get_post_type() ) : ?>
					<?php supernews_posted_on(); ?>
				<?php endif; ?>
				<?php supernews_entry_footer(); ?>
			</div><!-- .entry-meta -->
		</header><!-- .entry-header -->
		<div class="entry-content">
			<?php
			the_excerpt();
			?>
			<a class="read-more" href="<?php the_permalink(); ?> "><?php esc_html_e('Read More', 'supernews'); ?></a>

			<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'supernews' ),
				'after'  => '</div>',
			) );
			?>
		</div><!-- .entry-content -->
	</div>
</article><!-- #post-## -->
