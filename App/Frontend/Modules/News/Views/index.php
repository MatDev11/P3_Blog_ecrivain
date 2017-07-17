<h1>Article</h1>


<?php
foreach ($listeNews as $news)
{
    ?>
    <div class="col-md-10">
        <article class="blogShort">

            <h2><a href="http://localhost/Blog_Billet_simple_pour_l_Alaska/web/news-<?= $news['id'] ?>.html"><?= $news['titre'] ?></a></h2>
            <p><?= nl2br($news['contenu']) ?></p>
        </article>
    </div>
    <?php
}
?>