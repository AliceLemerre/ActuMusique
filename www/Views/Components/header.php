<header>
    <nav class="nav-front">
        <div class="nav-front-top">
            <a class="logo nav-front-logo" href="/"><img src="Framework/assets/images/Actumusique.png" alt="ActuMusique"></a>
            <a class="navbar-li navbar-li-back" href="/dashboard"><button class="button button-sm nav-front-dashboard">dashboard</button></a>

            <div> 
                <button class="navbar-burger" data-target="#content"><span></span>
                </button>
            </div>
        </div>

        <div class="toggle-content" id="content">
        <ul class="nav-front-menu">
            <li class="a"> <a href="/">accueil</a></li>
            <li class="a"><a href="/events">évènements</a></li>
            <li class="a"><a href="/articles">articles</a></li>
            <?php if (isset($_SESSION['userID'])): ?>
            <li><a href="/logout">Déconnexion</a></li>
        <?php else: ?>
            <li><a href="/login">Connexion</a></li>
            <li><a href="/register">Inscription</a></li>
        <?php endif; ?>
        </ul>
        </div>
       
    </nav>
   
    
    <div class="banner banner-text" style="background-image: url('Framework/assets/images/banner.png')">
        <div class="card card-banner">
          <p>Avec Actumusique, créez un site pour tenir les fans à jour sur l'actualité de votre groupe de musique préféré, enregistrer ses prochains évènements, se renseigner sur le groupe et ses œuvres, s'organiser pour se rencontrer aux concerts.</p>
          <a href="/register" class="button button-primary">rejoignez la communauté</a>
         </div>
     </div> 

</header>

<main>

<script>
window.addEventListener("load", () => {
	document.querySelectorAll(".navbar-burger").forEach((elem) => {
        console.log(elem);

		elem.onclick = () => {
			const targetName = elem.getAttribute("data-target");
            const target = document.querySelector(targetName);
            target.classList.toggle("toggled");
            elem.classList.toggle("toggled");

			if (target.classList.contains("toggled")) {
				target.style.maxHeight = target.scrollHeight + "px";
			} else {
				target.style.maxHeight = 0;
			}
		};
	});
});

</script>
