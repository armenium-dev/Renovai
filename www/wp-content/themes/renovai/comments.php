<?php
/**
 * Main functions file
 *
 * @package Lambda
 * @subpackage Frontend
 * @since 0.1
 *
 * @copyright (c) 2015 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.54.0
 */

if ( post_password_required() )
    return;
?>
<?php if ( have_comments() ) : ?>
<div class="comments padded" id="comments">
    <div class="comments-head">
        <h3>
            <?php
                printf( _n( '1 comment', '%s comments', get_comments_number(), THEME_TD ), number_format_i18n( get_comments_number() ) );
            ?>
        </h3>
        <small>
            <?php _e( 'Join the conversation', THEME_TD ); ?>
        </small>
    </div>
    <ul class="comments-list comments-body media-list">
        <?php wp_list_comments( array(
            'callback'     => array('\Digidez\Functions', 'oxy_comment_callback'),
            'end-callback' => array('\Digidez\Functions', 'oxy_comment_end_callback'),
            'style'        => 'div'
        )); ?>
    </ul>

    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
    <nav id="comment-nav-below" class="navigation" role="navigation">
        <ul class="pager">
        <li class="previous"><?php previous_comments_link( __( '&larr; Older', THEME_TD ) ); ?></li>
        <li class="next"><?php next_comments_link( __( 'Newer &rarr;', THEME_TD ) ); ?></li>
        </ul>
    </nav>
    <?php endif; // check for comment navigation ?>

    <?php
    /* If there are no comments and comments are closed, let's leave a note.
     * But we only want the note on posts and pages that had comments in the first place.
     */
    if ( ! comments_open() && get_comments_number() ) : ?>
    <br>
    <h3 class="nocomments text-center"><?php _e( 'Comments are closed.', THEME_TD ); ?></h3>
    <?php endif; ?>

</div>
<?php endif; ?>

<?php comment_form(); ?>
