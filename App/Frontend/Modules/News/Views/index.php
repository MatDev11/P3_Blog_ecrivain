<h1>Articles :</h1>


<?php
foreach ($listeNews as $news)
{
    ?>
    <div class="col-md-10">
        <article class="blogShort">

            <h2><a href="<?= $url ?>news-<?= $news['id'] ?>.html"><?= $news['titre'] ?></a></h2>
            <p><?= nl2br($news['contenu']) ?></p>
        </article>
    </div>
    <?php
}
?>