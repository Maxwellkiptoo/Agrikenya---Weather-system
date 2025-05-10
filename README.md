# 🌾 AgriKenya Weather Forecast System

AgriKenya Weather Forecast is part of the **AgriKenya Smart Agriculture Platform**, built to help Kenyan farmers easily access accurate and timely weather predictions based on their location (ward or subcounty). It uses the OpenWeatherMap API and provides forecasts in a clean, intuitive interface.

## 🚀 Features

* ☀️ 7-day weather forecast with icons, temperatures, wind, and humidity
* 📍 Search forecast by ward/subcounty (any location in Kenya)
* 📊 Styled forecast grid similar to MSN Weather
* 🛍️ Quick-access clickable Kenyan weather station list
* 📱 Fully responsive and user-friendly

## 🔧 Technologies Used

* HTML5, CSS3
* JavaScript (Vanilla)
* PHP (for layout includes)
* OpenWeatherMap API
* Custom styling inspired by MSN Weather UI

## ⚙️ Setup Instructions

1. **Clone the repo**

   ```bash
   git clone https://github.com/your-username/agrikenya-weather.git
   ```

2. **Open with a local server**
   Use a PHP server like XAMPP or Laravel Valet since `navbar.php` and `footer.php` are PHP includes.

3. **Add your OpenWeatherMap API Key**
   In `weather.php`, replace this:

   ```js
   const apiKey = 'your_api_key_here';
   ```

   with your actual API key from [https://openweathermap.org/](https://openweathermap.org/).

4. **Directory structure:**

   ```
   /agrikenya-weather/
   ├── nav/
   │   ├── navbar.php
   │   └── footer.php
   ├── client/
   │   └── styles.css
   ├── img/
   │   └── weather2.jpeg
   ├── weather.php
   └── README.md
   ```

## 🌍 Live Demo
*You can host this on platforms like Vercel, Netlify, or any PHP-compatible hosting provider.*

## 📩 Contributing
Contributions are welcome!
* Fork the repo
* Create a new branch (`git checkout -b feature/weather-enhancement`)
* Commit your changes
* Push to your branch
* Open a Pull Request

## 📄 License
This project is open-source and available under the MIT License.

## 🙌 Acknowledgements

* [OpenWeatherMap](https://openweathermap.org/) — for the free weather data API
* [MSN Weather](https://www.msn.com/en-us/weather) — for UI inspiration
* agrikenya🌾 - for playing part during development
* Bridgetech(https://www.bridgetech.com) - for developing the system
