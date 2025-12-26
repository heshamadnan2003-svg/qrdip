import './bootstrap';
document.addEventListener('DOMContentLoaded', function () {

    const buttons = document.querySelectorAll('.time-btn');
    const input   = document.getElementById('start_time');

    buttons.forEach(btn => {
        btn.addEventListener('click', function () {

            buttons.forEach(b => b.classList.remove('active'));

            this.classList.add('active');

            input.value = this.dataset.time;
        });
    });

});
