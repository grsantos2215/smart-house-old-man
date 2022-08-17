'use strict';

let weather = [];
let weatherComponent = null;

window.addEventListener('load', async () => {
    weatherComponent = document.querySelector('#weather');
});

const fetchWeather = async () => {
    const request = new Request(`assets/php/request.php`);

    const res = await fetch(request);

    const json = await res.json();

    // console.log(json);

    weather = json;

    // console.log(weather);
    renderWeather();
};

const renderWeather = () => {
    // console.log(weather);
    let weatherHTML = `<div class="row">`;

    const weatherTemplate = `
		<div class="weather-container">
			<div class="weather-header">
				<h1>${weather.location.region}</h1>
				<h2>${weather.location.country}</h2>
			</div>
			<div class="weather-body">
				<div class="weather-temp">
					<h1>${weather.current.temperature}</h1>
				</div>
				<div class="weather-description">
					<h1>${weather.current.weather_descriptions}</h1>
				</div>
			</div>
		</div>
	`;
    weatherHTML += weatherTemplate;
    weatherHTML += `</div>`;

    weatherComponent.innerHTML += weatherTemplate;
};

export { fetchWeather };
