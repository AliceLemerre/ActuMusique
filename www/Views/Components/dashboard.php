<div class="stats-graph">
    <div class=" card-back card-stats graph">
      <h3 >Commentaires par mois</h3>
      <canvas id="myChart"></canvas>
    </div>
</div>

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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script type="module">
  let chart = document.querySelector('#myChart');

  let $nbCommentsPerMonth = 5;

  let start = new Date();

  const months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre']

  const currentDate = new Date()
  const dates = []

  for (let i = 5; i >= 0; i--) {
    const currentMonth = new Date(currentDate)
    currentMonth.setMonth(currentDate.getMonth() - i)
    const monthName = months[currentMonth.getMonth()]
    dates.push(monthName)
  }


  new Chart(
    chart, {
      type: 'line',
      data: {
        labels: dates,
        datasets: [{
            label: 'Commentaires par mois',
            data: <?= json_encode($nbCommentsPerMonth); ?>,
            borderColor: 'rgb(255, 99, 132)',
            backgroundColor: 'rgba(255, 99, 132, 0.5)',
            tension: 0.5,
          },

        ]
      },
      options: {
        plugins: {
          legend: {
            position: 'bottom'
          }
        },
        responsive: true,
        scales: {
          x: {
            stacked: true
          },
          y: {
            stacked: true
          }
        }
      }

    });
</script>