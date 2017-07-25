
    <div class="panel panel-default" id="comment-<?=$comment['id'] ?>">
        <div class="panel-body">

            <legend>
                Posté par <strong><?= htmlspecialchars($comment['auteur']) ?></strong> le <?= $comment['date']->format('d/m/Y à H\hi') ?>
                <?php if ($comment['depth'] <= 1): ?>
                <span class="comment-action comment-reply-link"> <a class="reply" data-id="<?= $comment['id'] ?>">Répondre</a></span>
                <?php endif;?>
                <span class="comment-action comment-reply-link"> <a href="http://localhost/Blog_Billet_simple_pour_l_Alaska/web/comment-report-<?= $comment['id']?>.html">Signaler</a></span>

            </legend>
            <p><?= nl2br(htmlspecialchars($comment['contenu'])) ?></p>

        </div>
    </div>
    <div style="margin-left: 50px;">



        <?php if (isset($comment->children)): ?>
            <?php foreach ($comment->children as $comment): ?>
                <?php require 'comments.php' ?>
            <?php endforeach ?>
        <?php endif; ?>
    </div>