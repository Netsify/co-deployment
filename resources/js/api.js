import axios from 'axios';

let lang = document.getElementById('language').innerText.trim().toLowerCase();
switch (lang) {
    case 'ru': lang = ''; break;
    case 'en': lang = '/en'; break;
}

let Api = axios.create({
    baseURL: lang + '/api'
});

export default Api;