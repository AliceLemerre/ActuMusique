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
                        <?= $post['title'] ?>
                        <form action="/viewPost" method="GET">
                            <input type="hidden" name="id" value="<?= $post['id'] ?>">
                            <button type="submit" class="button">Voir le post</button>
                        </form>
                        <form action="/deletePost" method="GET">
                            <input type="hidden" name="id" value="<?= $post['id'] ?>">
                            <button type="submit" class="button">supprimer</button>
                        </form>
                    </td>
                    <td class="card-back-table-body-row-data">
                        <?= $post['username'] ?>
                    </td>
                    <td class="card-back-table-body-row-data">
                        <?= $post['created_at'] ?>
                    </td>
                    <td class="card-back-table-body-row-data">
                        <?= $post['category'] ?>
                    </td>
                </tr>
                <?php endforeach; ?>    
                
            </tbody>
        </table>
</div>

