<h2><?= $title ?></h2>

<p style="text-align: center">Il y a actuellement <?= $nombreComments ?> commentaires. En voici la liste :</p>

<table class="table">
    <thead>
    <tr>
        <th>Auteur</th>
        <th>Date d'ajout</th>

        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($listeComments as $comment) { ?>
        <?php if ($comment['report'] == 1): ?>
            <tr style="color: red;">
        <?php else: ?>
            <tr>
        <?php endif;?>


                <td><?= $comment['auteur']?></td>
                <td>le <?= date('d/m/y à H\hi', strtotime($comment['date']));?></td>
             
                <td><a class="btn btn-info btn-xs" href="http://localhost/test/web/admin/comment-update-<?= $comment['id']?>.html"><span class="glyphicon glyphicon-edit"></span></a>


                <form action="http://localhost/test/web/admin/comment-delete-<?= $comment['id']?>.html" method="post" style="display:inline-block">
                    <input  type="hidden" name="id" value="<?= $comment['id']?>">
                    <input type="hidden" name="id_parent" value="<?= $comment['id_prent']?>">
                    <input  type="hidden" name="depth" value="<?=$comment['depth']?>">
                    <input  type="hidden" name="news" value="<?=$comment['news']?>">
                    <button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>
                </form>
            </td>
                            </tr>
   <?php
    }
    ?>
    </tbody>
</table>