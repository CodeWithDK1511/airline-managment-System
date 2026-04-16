// script.js – Dropdown navigation
document.addEventListener('DOMContentLoaded', function () {
    const navItems = document.querySelectorAll('nav ul li');
    navItems.forEach(item => {
        item.addEventListener('mouseover', function () {
            const sub = this.querySelector('ul');
            if (sub) sub.style.display = 'block';
        });
        item.addEventListener('mouseout', function () {
            const sub = this.querySelector('ul');
            if (sub) sub.style.display = 'none';
        });
    });
});
