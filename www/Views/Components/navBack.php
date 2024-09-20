<div class="navbar navbar-back">
    <ul class="navbar-ul navbar-back-ul">
        <li class="navbar-li navbar-li-back"><a href="">
            
      
            </a></li>
        <li class="navbar-li navbar-li-back"><a href="/"><button class="button button-sm">front</button></a></li>
        <li class="navbar-li navbar-li-back">
            <button class="button button-orange button-switch button-round">
                <img src="Framework/assets/images/sun-icon.svg" class="sun" alt="light mode">
                <img src="Framework/assets/images/moon-icon.svg" class="moon" alt="dark mode">
            </button>
        </li>
        <li class="navbar-li navbar-li-back">
            <button class="navbar-burger navbar-burger-back" data-target="#content"><span></span></button>
        </li>
    </ul>
</div>

<div class="side-nav-back side-nav-back-mobile toggle-content" id="content">
<ul class="side-nav-back-ul">
    <li class="side-nav-back-ul-li"><a href="/dashboard">Tableau de bord</a></li>
    <li class="side-nav-back-ul-li"><a href="/dashboard-posts">Posts</a></li>
    <li class="side-nav-back-ul-li"><a href="/dashboard-comments">Commentaires</a></li>
    <li class="side-nav-back-ul-li"><a href="/dashboard-accounts">Utilisateurs</a></li>
    <li class="side-nav-back-ul-li"><a href="/dashboard-design">Design</a></li>
</ul>
</div>

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