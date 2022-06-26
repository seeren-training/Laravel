import './bootstrap';

document.querySelector('.navbar-burger').onclick = (e) => {
    const className = 'is-active';
    const burger = e.target;
    const navbar = burger.parentNode.parentNode.querySelector('.navbar-menu');
    if (burger.classList.contains(className)) {
        burger.classList.remove(className);
        navbar.classList.remove(className);
    } else {
        burger.classList.add(className);
        navbar.classList.add(className);
    }
}
