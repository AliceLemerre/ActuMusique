<?php foreach ($comments as $comment) :
     if ($comment->status == 0) : ?>

<div class="card card-comment">
        <div>
            <p><?php echo $comment->content;?></p>
        </div>
        <div class="card-comment-stats">
            <p>par : <a href=""><?php echo $comment->user;?></a> </p>
            <p>sur l'article : <a href=""><?php echo $comment->post;?></a></p>
            <p class="text-small"><?php echo $comment->date_created;?></p>
        </div>
        <div class="card-interaction">
            <button class="button button-round button-orange button-sm"><img src="../assets/images/accept-icon.svg"
                    alt=""></button>
            <button class="button button-round button-orange button-sm"><img src="../assets/images/delete-icon.svg"
                    alt=""></button>
        </div>
    </div>
<?php endif; 
endforeach; ?>


<?php
$comments = $this->data['comments']; 

?>


<section style="display: flex; justify-content: space-between; width: 100%; margin: auto;">
    <?php if (!empty($comments)) { ?>
        <article class="card card-menu" style="width: 80%;">
            <h1>Liste des commentaires en attentes</h1>
            <?php foreach ($comments as $comment) : ?>
                <p><?= $comment['user_id'] ?></p>
                <p><?= $comment['content'] ?></p>
                <ul class="card-list">
                    <li class="card-list-item">
                        <div class="card-list-item-buttons">
                            <form action="/viewPage" method="GET">
                                <input type="hidden" name="id" value="<?= $comment['page_id'] ?>">
                                <button type="submit" class="button button-sm button-light-blue">Voir la page du commentaire</button>
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
    <?php } else { ?>
        <article class="card card-menu" style="width: 80%;">
            <h1>Liste des commentaires</h1>
            <p>Il n'y a pas de commentaires en attentes</p>
        </article>
    <?php } ?>

</section>