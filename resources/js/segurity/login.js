import axios from 'axios';

const btn_reload = document.getElementById('btn_reload');
const captcha_container = document.getElementById('captcha_container');

const disableButton = () => {
    btn_reload.disabled = true;
    btn_reload.title = "Espere 2seg antes de pedir el siguiente captcha";
    setTimeout( () =>
    {
        btn_reload.disabled = false;
        btn_reload.title = "";
    }, 2000);
}

btn_reload.addEventListener('click', async e => {
    await axios.get('/reload_captcha').then( resp => {
        const captcha = captcha_container.querySelector('img');
        captcha_container.removeChild(captcha);
        captcha_container.innerHTML = resp.data.captcha;
        captcha_container.append(btn_reload);
        disableButton();
    } );
});
