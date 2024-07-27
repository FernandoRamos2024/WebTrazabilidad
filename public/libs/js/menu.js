document.addEventListener('DOMContentLoaded', function() {
const menu = document.getElementById('menu-principal');
const firstSection = document.getElementById('hero');
const headerHeight = menu.offsetHeight;
let menuVisible = false;


function mostrarOcultarMenu() {
  if (window.scrollY > firstSection.offsetHeight - headerHeight) {
    if (!menuVisible) {
      menu.style.display = 'block';
      menuVisible = true;
    }
  } else {
    if (menuVisible) {
      menu.style.display = 'none';
      menuVisible = false;
    }
  }
}


window.addEventListener('scroll', mostrarOcultarMenu);
});