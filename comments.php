<section class="comments">
<?php
$comment_form_args = array(
  'title_reply' => 'コメント投稿フォーム',
  'comment_notes_after' => '<p class="form-allowed-tags">' . sprintf( __( '次の <abbr title="HyperText Markup Language">HTML</abbr> タグと属性が使えます: %s' ), ' <code>' . allowed_tags() . '</code>' ) . '</p>'
);
comment_form($comment_form_args);
if (have_comments() ) :
?>
  <p><?php comments_number('','コメントが1件あります。', 'コメントが%件あります。'); ?></p>
  <ol class="commentlist">
    <?php
    $wp_list_comments_args = array(
      'avatar_size' => '50',
    );
    wp_list_comments($wp_list_comments_args); 
    ?>
  </ol>
<?php
$paginate_comments_links_args = array(
  'prev_text' => '←前のコメントページ',
  'next_text' => '次のコメントページ→',
);
paginate_comments_links($paginate_comments_links_args);
endif;
?>
</section><!-- /.comments -->