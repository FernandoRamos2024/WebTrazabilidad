const weatherApiUrl = 'https://weatherapi-com.p.rapidapi.com/current.json?q=19.057250362052834%2C-98.18011522293091';
  const weatherApiOptions = {
    method: 'GET',
    headers: {
      'X-RapidAPI-Key': '2574f56971msh7816c55de66861ap16b403jsn8b4feca44481',
      'X-RapidAPI-Host': 'weatherapi-com.p.rapidapi.com'
    }
  };

  let resultP;

  fetch(weatherApiUrl, weatherApiOptions)
  .then(resp => resp.text())
  .then(result => {

      resultP = JSON.parse(result);
      const conditionText = resultP.current.condition.text;

      const translationApiUrl = 'https://google-translate1.p.rapidapi.com/language/translate/v2';
      const translationApiOptions = {
        method: 'POST',
        headers: {
          'content-type': 'application/x-www-form-urlencoded',
          'Accept-Encoding': 'application/gzip',
          'X-RapidAPI-Key': '2796a82cfamshfe7950bea87343ap1d84f6jsn6f646298a765',
          'X-RapidAPI-Host': 'google-translate1.p.rapidapi.com'
        },
        body: new URLSearchParams({
          q: conditionText,
          target: 'es',
          source: 'en'
        })
      };

      return fetch(translationApiUrl, translationApiOptions);
    })

  .then(resp => resp.json())
  .then(result => {
    const translatedText = result.data.translations[0].translatedText;

    document.getElementById("resultado").innerHTML =
    "<ul>" +
    "<li>" + resultP.current.temp_c + "° celcius</li>" +
    "<li>" + resultP.current.temp_f + "° fahrenheit</li>" +
    "<li>" + translatedText + "</li>" +
    "<img src='" + resultP.current.condition.icon + "' width='70px' height='70px'>" +
    "</ul>";
  })
  .catch(error => {
    console.error(error);
  });