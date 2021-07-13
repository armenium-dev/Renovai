<li id="comment-<?php comment_ID(); ?>" class="comment depth-<?=$depth;?>" itemscope="itemscope" itemtype="http://schema.org/Comment">

	<article class="comment-body">

		<figure class="avatar">
			<h2 class="screen-reader-text"><?php echo esc_html__( 'Post comment', 'lambda-td' ) ?></h2>

			<?php echo get_avatar( $comment, 85 ); ?>

			<div class="reply">
				<?php comment_reply_link(array_merge($args, array('reply_text' => __('reply', 'lambda-td'), 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
			</div>
		</figure>

		<div class="comment-content">

			<footer class="comment-meta">

				<b class="comment-author" itemscope="itemscope" itemtype="http://schema.org/Person"><?php comment_author_link(); ?></b>

				<a class="comment-permalink"><time class="comment-published"><?php printf( esc_html__( '%s ago', 'lambda-td' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ); ?></time></a>

			</footer>

			<?php comment_text(); ?>

			<a class="comment-permalink"><?php esc_html_e( 'Permalink', 'lambda-td' ); ?></a>  <?php edit_comment_link(); ?>

		</div>

	</article>
