<div class="card-back card-back-tb">
        <header class="card-back-table-header">
            <ul class="card-back-table-header-list text-small">
                <li><a href="">tous les posts</a></li>
                <li><a href="">posts supprimés</a></li>
            </ul>
        </header>
        <table class="card-back-table">
            <thead class="card-back-table-head">
                <th class="card-back-table-head-text">titre</th>
                <th class="card-back-table-head-text">auteur</th>
                <th class="card-back-table-head-text">date de création</th>
                <th class="card-back-table-head-text">type</th>

            </thead>
            <tbody class="card-back-table-body">
                <?php foreach ($posts as $post) : ?>
                <tr class="card-back-table-body-row">
                    <td class="card-back-table-body-row-data">
                        <?php echo $post->getPostTitle(); ?>
                        <ul class="card-back-table-body-row-data-list text-small">
                            <li><a href="">modifier les droits</a></li>
                            <li><a href="">supprimer le compte</a></li>
                        </ul>
                    </td>
                    <td class="card-back-table-body-row-data">
                        <?php echo $post->getAuthor(); ?>
                    </td>
                    <td class="card-back-table-body-row-data">
                        <?php echo $post->getCreationDate(); ?>
                    </td>
                    <td class="card-back-table-body-row-data">
                        <?php echo $post->getPostType(); ?>
                    </td>
                </tr>
                <?php endforeach; ?>    
                
            </tbody>
        </table>
</div>


<?php
$pages = $this->data['pages'];
?>
<section style="display: flex; justify-content: space-between; width: 100%; margin: auto;">
    <article class="card card-menu" style="width:80%">
    <h1>Mes pages</h1>
        <?php foreach ($pages as $page): ?>
            <h3 class="under-title">
                <?= $page['title'] ?>
            </h3>
            <ul class="card-list">
                <li class="card-list-item">
                    <p>Créée le :
                        <?= $page['created_at'] ?>
                    </p>
                    <div class="card-list-item-buttons">
                        <form action="/viewPage" method="GET">
                            <input type="hidden" name="id" value="<?= $page['id'] ?>">
                            <button type="submit" class="button button-sm button-light-blue">Voir la page</button>
                        </form>
                        <form action="/deletePage" method="GET">
                            <input type="hidden" name="id" value="<?= $page['id'] ?>">
                            <button type="submit" class="button button-sm button-light-blue">Delete</button>
                        </form>
                    </div>
                </li>
            </ul>
        <?php endforeach; ?>
    </article>

</section>