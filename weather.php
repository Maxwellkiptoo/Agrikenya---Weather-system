<?php 
include_once "nav/navbar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Weather Prediction | AgriKenya</title>
  <link rel="stylesheet" href="client/styles.css"/>

  <!-- Leaflet CSS & JS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    body {
      margin: 0;
      padding: 0;
      background-image: url('img/weather2.jpeg');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      background-attachment: fixed;
      font-family: Arial, sans-serif;
    }

    .hero {
      padding: 80px 20px;
      text-align: center;
      color: white;
      z-index: 2;
    }

    .hero h1 {
      font-size: 3em;
      margin-bottom: 10px;
    }

    .hero p {
      font-size: 1.2em;
      color: #eee;
    }

    .weather-section {
      padding: 60px 20px;
      background-color: #f1f1f1;
      text-align: center;
    }

    .weather-section h2 {
      color: #2d6a4f;
      font-size: 2em;
      margin-bottom: 20px;
    }

    .weather-form {
      max-width: 500px;
      margin: 0 auto 30px;
    }

    .weather-form input,
    .weather-form button {
      width: 100%;
      padding: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
      margin-bottom: 15px;
      font-size: 16px;
    }

    .weather-form button {
      background-color: #2d6a4f;
      color: #fff;
      border: none;
      cursor: pointer;
    }

    .weather-form button:hover {
      background-color: #225e3b;
    }

    .weather-result {
      display: none;
      border-radius: 8px;

    }

    .forecast-box {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 10px;
      margin-top: 40px;
      padding: 20px;
      border-radius: 10px;
    }

    .forecast-day {
      border: 1px solid #ccc;
      border-radius: 6px;
      padding: 10px;
    background-color: CADETBLUE;
      text-align: center;
    }

    .forecast-day img {
      width: 40px;
    }

    .stations span {
      display: inline-block;
      background-color: #d4edda;
      margin: 4px;
      padding: 4px 8px;
      border-radius: 4px;
      cursor: pointer;
    }

    #weatherMap {
      height: 400px;
      width: 100%;
      margin-top: 40px;
    }
  </style>
</head>
<body>

<!-- Hero Section -->
<section class="hero">
  <h1>Weather Forecast</h1><br><br>
  <p>Enter your ward or subcounty to check the latest weather forecast.</p><br><br>
    <div class="cta-button">
      <a href="client/sign.php">Get Started Today</a>
    </div>
</section>

<!-- Weather Section -->
<section class="weather-section">
  <h2>Check Weather by Ward</h2>
  <form class="weather-form" onsubmit="getWeather(event)">
    <input type="text" id="location" placeholder="Enter your ward name..." required />
    <button type="submit">Get Weather</button>
  </form>

  <div class="weather-result" id="weatherResult">
    <h3>Weather for <span id="cityName"></span></h3>

    <div class="current-weather">
      <img id="weatherIcon" src="" alt="" class="weather-icon"/>
      <p id="condition"></p>
      <p><strong id="temperature"></strong> | Feels like <strong id="feelsLike"></strong></p>
      <p>💧 <strong>Humidity:</strong> <span id="humidity"></span>% | 🌬️ <strong>Wind:</strong> <span id="wind"></span> km/h</p>
      <p>🌞 <strong>Sunrise:</strong> <span id="sunrise"></span> | 🌇 <strong>Sunset:</strong> <span id="sunset"></span></p>
    </div>

    <h4>Hourly Forecast (Next 12 Hours)</h4>
    <div class="forecast-box" id="hourlyForecast"></div>

    <h4>7-Day Forecast</h4>
    <div class="forecast-box" id="dailyForecast"></div>

    <h4>Weather Map for <span id="cityNameMap"></span></h4>
    <div id="weatherMap"></div>

    <h4>Important Weather Stations in Kenya</h4>
    <div class="stations">
      <span>Nairobi</span><span>Kisumu</span><span>Mombasa</span><span>Nakuru</span>
      <span>Eldoret</span><span>Kitale</span><span>Nyeri</span><span>Wajir</span>
      <span>Voi</span><span>Thika</span><span>Machakos</span><span>Malindi</span>
    </div>
  </div>
</section>

<script>
  const apiKey = '6391af950e3bb7496c0284bd366933af';
  let map; // Global map variable

  async function getWeather(event) {
    event.preventDefault();
    const location = document.getElementById('location').value.trim();
    if (!location) return alert("Please enter a location");

    try {
      const response = await fetch(`https://api.openweathermap.org/data/2.5/forecast?q=${location},KE&units=metric&appid=${apiKey}`);
      if (!response.ok) throw new Error("Location not found");

      const forecastData = await response.json();
      const current = forecastData.list[0];
      const lat = forecastData.city.coord.lat;
      const lon = forecastData.city.coord.lon;

      document.getElementById('weatherResult').style.display = 'block';
      document.getElementById('cityName').textContent = forecastData.city.name;
      document.getElementById('cityNameMap').textContent = forecastData.city.name;
      document.getElementById('temperature').textContent = `${current.main.temp.toFixed(1)}°C`;
      document.getElementById('feelsLike').textContent = `${current.main.feels_like.toFixed(1)}°C`;
      document.getElementById('condition').textContent = current.weather[0].description;
      document.getElementById('humidity').textContent = current.main.humidity;
      document.getElementById('wind').textContent = (current.wind.speed * 3.6).toFixed(1);
      document.getElementById('sunrise').textContent = new Date(forecastData.city.sunrise * 1000).toLocaleTimeString();
      document.getElementById('sunset').textContent = new Date(forecastData.city.sunset * 1000).toLocaleTimeString();
      document.getElementById('weatherIcon').src = `https://openweathermap.org/img/wn/${current.weather[0].icon}.png`;

      const hourlyHTML = forecastData.list.slice(0, 12).map(hour => `
        <div class="forecast-day">
          <strong>${new Date(hour.dt * 1000).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</strong>
          <img src="https://openweathermap.org/img/wn/${hour.weather[0].icon}.png" alt=""/>
          <p>${hour.main.temp.toFixed(1)}°C</p>
          <p>${hour.weather[0].description}</p>
        </div>
      `).join("");
      document.getElementById("hourlyForecast").innerHTML = hourlyHTML;

      const dailyHTML = forecastData.list.filter((_, i) => i % 8 === 0).map(day => `
        <div class="forecast-day">
          <strong>${new Date(day.dt * 1000).toLocaleDateString()}</strong>
          <img src="https://openweathermap.org/img/wn/${day.weather[0].icon}.png" alt=""/>
          <p>${day.weather[0].description}</p>
          <p><strong>${day.main.temp_max.toFixed(1)}°C</strong> / ${day.main.temp_min.toFixed(1)}°C</p>
          <p>💧 ${day.main.humidity}% | 🌬️ ${(day.wind.speed * 3.6).toFixed(1)} km/h</p>
        </div>
      `).join("");
      document.getElementById("dailyForecast").innerHTML = dailyHTML;

      // Destroy and reinitialize the map
      if (map) map.remove();
      map = L.map('weatherMap').setView([lat, lon], 10);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
      }).addTo(map);

      L.marker([lat, lon])
        .addTo(map)
        .bindPopup(`<strong>${forecastData.city.name}</strong><br>${current.weather[0].description}<br>${current.main.temp.toFixed(1)}°C`)
        .openPopup();

    } catch (error) {
      alert("Error: " + error.message);
      document.getElementById('weatherResult').style.display = 'none';
    }
  }

  // Enable quick search from predefined stations
  document.querySelectorAll('.stations span').forEach(station => {
    station.addEventListener('click', () => {
      document.getElementById('location').value = station.textContent;
      getWeather(new Event('submit'));
    });
  });
</script>

</body>
</html>
