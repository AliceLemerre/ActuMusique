
<button class="button"><a href="/create-post">écrire un post</a></button>

<section class="main-flex">
<?php

$this->includeComponent("event", []);

$this->includeComponent("article", []);
?>

</section>

 <div>
  <p>Sauvegardez l'archive de votre site : exportez vos fichiers et la base de données </p>
  <form action="create_backup.php" method="post">
    <button type="submit">télécharger l'archive</button>
</form>
</div>
