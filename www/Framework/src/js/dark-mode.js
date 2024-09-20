

  // Add an event listener for the 'load' event of the window
window.addEventListener("load", () => {
    const switchDark = document.querySelector('.button-switch');
   // const logo = document.querySelector('.navbar-li-logo');


    function getCurrentTheme(){
        let theme = window.matchMedia('(prefers-color-scheme: dark)')
        .matches ? 'dark' : 'light';
        localStorage.getItem('opencmf.theme') ? theme =
        localStorage.getItem('opencmf.theme') : null;
        return theme;
    }

   
    function loadTheme(theme){
        const root = document.querySelector('html');
      /*  if (theme === "light"){
            logo.innerHTML = '<img src="/OpenCMF/framework/assets/images/opencmf-tranparent_cmf-logo.png"alt="open cmf" class="navbar-back-logo"></img>';
        }else{
            logo.innerHTML = '<img src="/OpenCMF/framework/assets/images/opencmf-tranparent_cmf-logo-white-text.png"alt="open cmf" class="navbar-back-logo"></img>';

        }*/
        root.setAttribute('color-scheme', theme);
    }


    switchDark.addEventListener('click', () => {
    switchDark.classList.toggle("switched");


        let theme = getCurrentTheme();
        if(theme === 'dark'){
            theme = 'light';
        }else {
            theme = 'dark';
        }
        localStorage.setItem('opencmf.theme', theme);
        loadTheme(theme);
    })

    window.addEventListener('DOMContentLoaded', () => {
        loadTheme(getCurrenttheme());
    })

  });
  