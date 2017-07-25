<p>Par <em><?= $news['auteur'] ?></em>, le <?= $news['dateAjout']->format('d/m/Y à H\hi') ?></p>
<h2><?= $news['titre'] ?></h2>
<p><?= nl2br($news['contenu']) ?></p>

<?php if ($news['dateAjout'] != $news['dateModif']) { ?>
    <p style="text-align: right;"><small><em>Modifiée le <?= $news['dateModif']->format('d/m/Y à H\hi') ?></em></small></p>
<?php }

if (empty($comments))
{
    ?>
    <p>Aucun commentaire n'a encore été posté. Soyez le premier à en laisser un !</p>
    <?php
}

foreach ($comments as $comment)
{
    ?>
    <?php require 'comments.php' ?>
    <?php
}
?>

<h2>Ajouter un commentaire</h2>
<form method="post" id="form-comment">
    <input type="hidden" name="parent_id" value="0" id="parent_id">
    <input type="hidden" name="id" value="<?= $news['id'] ?>" id="id">
    <input type="hidden" name="report" value="0" id="reprort">
    <p>
        <?= $form ?>
        <input class="btn btn-primary" type="submit" value="Commenter" />
    </p>
</form>