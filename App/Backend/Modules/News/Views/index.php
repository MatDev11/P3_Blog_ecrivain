<h2><?= $title ?></h2>

<p>
    <a href="http://localhost/Blog_Billet_simple_pour_l_Alaska/web/admin/news-insert.html" class="btn btn-primary">Ajouter</a>
</p>

<p style="text-align: center">Il y a actuellement <?= $nombreNews ?> news. En voici la liste :</p>

<table class="table">
    <thead>
    <tr>
        <th>Auteur</th>
        <th>Titre</th>
        <th>Date d'ajout</th>
        <th>Dernière modification</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($listeNews as $news) {?>
            <tr>
                <td><?= $news['auteur']?> </td>
                <td><?= $news['titre']?> </td>
                <td>le <?= $news['dateAjout']->format('d/m/Y à H\hi')?></td>
                <td><?= ($news['dateAjout'] == $news['dateModif'] ? '-' : 'le ' . $news['dateModif']->format('d/m/Y à H\hi'))?></td>
                <td>
           <a class="btn btn-info btn-xs" href="http://localhost/Blog_Billet_simple_pour_l_Alaska/web/admin/news-update-<?= $news['id'] ?>.html"><span class="glyphicon glyphicon-edit"></span></a>
                    <!--  <a class="btn btn-danger btn-xs" href="http://localhost/Blog_Billet_simple_pour_l_Alaska/web/admin/news-delete-', $news['id'], '.html"><span class="glyphicon glyphicon-remove"></span></a>-->
                    <form action="http://localhost/Blog_Billet_simple_pour_l_Alaska/web/admin/news-delete-<?= $news['id'] ?>.html"
                          method="post" style="display:inline-block">


                        <input type="hidden" name="token"  value="<?= $token; ?>"/>

                        <button type="submit"  class="btn btn-danger delet"><span class="glyphicon glyphicon-remove"></span>
                        </button>
                    </form>
    </td>
      </tr>

   <?php
    }
    ?>
    </tbody>
</table>