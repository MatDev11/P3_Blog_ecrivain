<h2>Modifier un article</h2>
<form action="" method="post">
    <input type="hidden" name="token" id="token" value="<?= $token; ?>"/>
  <p>
    <?= $form ?>
    
    <input class="btn btn-primary" type="submit" value="Modifier" />
  </p>
</form>