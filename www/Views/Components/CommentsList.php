<?php
$comments = $this->data['comments']; 

if (!empty($comments)) : ?>

<section style="display: flex; justify-content: space-between; width: 100%; margin: auto;">
    <?php if (!empty($comments)) : ?>
        <article class="card card-menu" style="width: 80%;">
            <h1>Liste des commentaires en attentes</h1>
            <?php foreach ($comments as $comment) : ?>
                <p><?= $comment['user_id'] ?></p>
                <p><?= $comment['content'] ?></p>
                <ul class="card-list">
                    <li class="card-list-item">
                        <div class="card-list-item-buttons">
                            <form action="/viewPage" method="GET">
                                <input type="hidden" name="id" value="<?= $comment['post_id'] ?>">
                                <button type="submit" class="button button-sm button-light-blue">Voir le post du commentaire</button>
                            </form>
                            <form action="/validateComment" method="GET">
                                <input type="hidden" name="id" value="<?= $comment['id'] ?>">
                                <button type="submit" class="button button-sm button-light-blue">Valider</button>
                            </form>
                            <form action="/deleteComment" method="GET">
                                <input type="hidden" name="id" value="<?= $comment['id'] ?>">
                                <button type="submit" class="button button-sm button-light-blue">Delete</button>
                            </form>
                        </div>
                    </li>
                </ul>
            <?php endforeach; ?>
        </article>
    <?php  else : ?>
        <article class="card card-menu" style="width: 80%;">
            <h1>Liste des commentaires</h1>
            <p>Il n'y a pas de commentaires en attentes</p>
        </article>
    <?php endif; ?>
</section>
<?php endif; ?>