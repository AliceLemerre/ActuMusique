<div class="card-back card-back-tb">
        <header class="card-back-table-header">
            <ul class="card-back-table-header-list text-small">
                <li><a href="">tous les comptes</a></li>
                <li><a href="">supperadmins</a></li>
                <li><a href="">admin</a></li>
                <li><a href="">utilisateurs</a></li>
                <li><a href="">supprimés</a></li>
            </ul>
        </header>
        <table class="card-back-table">
            <thead class="card-back-table-head">
                <th class="card-back-table-head-text">nom d'utilisateur</th>
                <th class="card-back-table-head-text">date de création</th>
                <th class="card-back-table-head-text">rôle</th>

            </thead>
            <tbody class="card-back-table-body">
                <?php foreach ($users as $user) : ?>
                <tr class="card-back-table-body-row">
                    <td class="card-back-table-body-row-data">
                        <?= $user['username'] ?>
                        <ul class="card-back-table-body-row-data-list text-small">
                            <li><a href="">modifier les droits</a></li>
                            <li><a href="">supprimer le compte</a></li>
                        </ul>
                    </td>
                    <td class="card-back-table-body-row-data">
                        <?= $user['createdAt'] ?>
                    </td>
                    <td class="card-back-table-body-row-data">
                        <?= $page['role'] ?>
                    </td>
                </tr>
                <?php endforeach; ?>    
                
            </tbody>
        </table>
</div>