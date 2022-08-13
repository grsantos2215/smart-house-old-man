import { fetchWeather } from './weather.api.js';

window.addEventListener('load', async () => {
    await fetchWeather();
});
