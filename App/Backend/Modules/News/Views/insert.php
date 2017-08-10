<h2>Ajouter un article</h2>
<form action="" method="post">
  <p>

    <?= $form ?>
      <input type="hidden" name="token" id="token"  value="<?= $token; ?>"/>
    <input class="btn btn-primary" type="submit" value="Ajouter" />
  </p>
</form>