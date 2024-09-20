<header>
    <nav class="nav-front">
        <div class="nav-front-top">
            <a class="logo" href="/"><img src="Framework/assets/images/Actumusique.png" alt="ActuMusique"></a>
            <a class="navbar-li navbar-li-back" href="/dashboard"><button class="button button-sm">dashboard</button></a>

            <div> 
                <button class="navbar-burger" data-target="#content"><span></span>
                </button>
            </div>
        </div>

        <div class="toggle-content" id="content">
        <ul class="nav-front-menu">
            <li> <a href="/">accueil</a></li>
            <li><a href="/events">évènements</a></li>
            <li><a href="/articles">articles</a></li>
            <li><a href="/login">connexion</a></li>
            <li class="button button-lg button-primary button-register"><a href="/register">inscription</a></li>
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