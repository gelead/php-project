const showBtn = document.querySelectorAll('.show');

let clicked = 0;

showBtn.forEach(btn => {
    btn.addEventListener('click', () => {
        if (clicked === 0) {
            btn.previousElementSibling.setAttribute('type', 'text');
            btn.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
            clicked = 1;
        } else {
            btn.previousElementSibling.setAttribute('type', 'password');
            btn.innerHTML = '<i class="fa-solid fa-eye"></i>';
            clicked = 0;
        }
    });
});