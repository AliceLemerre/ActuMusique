

<div class="card-back">
        <h3 class="undertitle">Posts populaires</h2>
            <ul class="card-back-list">
            <?php for ($i = 0; $i < 2; $i++) : ?>
                <li class="card-back-list-item"><a href=""><?php echo $post->getPopularpost(); ?></a>
                    <ul class="card-back-list-item-stat">
                        <li class="text-small"><?php echo $post->getNbComments(); ?> commentaires</li>
                        <li class="text-small"><?php echo $post->getNbVues(); ?> vues</li>
                    </ul>
                </li>
            <?php endfor; ?>               
            </ul>
</div>

<div>
  <p>Sauvegardez l'archive de votre site : exportez vos fichiers et la base de données </p>
  <form action="create_backup.php" method="post">
    <button type="submit">télécharger l'archive</button>
</form>
</div>
