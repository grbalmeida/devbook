(function() {

	const currentCity = document.querySelector('[data-actual-City')
	const hometown = document.querySelector('[data-hometown]')
	const datalistCurrentCity = document.querySelector('[data-datalist-actual-city]')
	const datalistHometown = document.querySelector('[data-datalist-hometown]')
	let cities = {}

	currentCity.addEventListener('keyup', searchCurrentCity)
	hometown.addEventListener('keyup', searchHometown)


	function searchCurrentCity(event) {
		executeIfIsValidLetter(currentCity, event.keyCode, datalistCurrentCity, showCities)
	}

	function searchHometown(event) {
		executeIfIsValidLetter(hometown, event.keyCode, datalistHometown, showCities)
	}

	window.addEventListener('load', function() {
		setTimeout(()=>{
			const request = new XMLHttpRequest()
			const url = `${location.origin}/cities/cities.json`
			request.open('GET', url)
			request.send()

			request.addEventListener('readystatechange', function() {
				if(request.readyState === 4 && request.status === 200) {
					cities = JSON.parse(request.responseText)
				}
			})
		}, 500)
	})

	function getCitiesByName(initialName) {
		const citiesList = cities.filter(city => 
			city.Nome.toLowerCase().startsWith(initialName.toLowerCase()))
		return citiesList.slice(0, 5)
	}

	function showCities(cities, datalist) {
		datalist.innerHTML = ''
		cities.forEach(city => {
			const option = `<option value="${city.Nome}">${city.Nome}</option>`
			datalist.innerHTML += option
		})
	}

	function executeIfIsValidLetter(input, keyCode, datalist, callback) {
		if(input.value.length > 0) {
			if(keyCode > 64 && keyCode < 91 || keyCode === 8) {
				const citiesList = getCitiesByName(input.value)
				callback(citiesList, datalist)
			}
		} else {
			datalist.innerHTML = ''
		}
	}
})()