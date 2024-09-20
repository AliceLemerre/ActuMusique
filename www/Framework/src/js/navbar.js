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
