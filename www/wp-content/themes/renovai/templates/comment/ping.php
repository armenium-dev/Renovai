<li class="comment">

	<header class="comment-meta">

		<cite class="comment-author"><?php comment_author_link(); ?></cite><br />

		<time class="comment-published"><?php printf( esc_html__( '%s ago', 'lambda-td' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ); ?></time>

		<a class="comment-permalink"><?php esc_html_e( 'Permalink', 'lambda-td' ); ?></a>

		<?php edit_comment_link(); ?>

	</header><!-- .comment-meta -->

<?php // No closing </li> is needed.  WordPress will know where to add it. ?>
