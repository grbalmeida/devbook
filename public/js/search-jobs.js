(function() {

	const occupation = document.querySelector('[data-occupation]')
	const datalistJobs = document.querySelector('[data-datalist-jobs]')

	occupation.addEventListener('keyup', searchJobs)

	function searchJobs(event) {
		executeIfIsValidLetter(occupation, event.keyCode, showJobs)
	}

	function executeIfIsValidLetter(input, keyCode, callback) {
		if(input.value.trim().length > 0) {
			if(keyCode > 64 && keyCode < 91 || keyCode === 8) {
				const jobsList = getJobsByName(input.value, callback)
			}
		} else {
			datalistJobs.innerHTML = ''
		}
	}

	function getJobsByName(name, callback) {
		const request = new XMLHttpRequest()
		const url = `http://apps.diogomachado.com/api-profissoes/v1?callback=CALLBACK_JSONP&s=${name}`
		request.open('GET', url)
		request.send()

		request.addEventListener('readystatechange', function() {
			if(request.readyState === 4 && request.status === 200) {
				let response = request.responseText
				response = response.replace('CALLBACK_JSONP(', '')
				response = response.slice(0, response.length - 2)
				response += '}'
				response = new Set(Object.values(JSON.parse(response)).slice(0, 5))
				callback(response)
			}
		})
	}

	function showJobs(jobs) {
		datalistJobs.innerHTML = ''
		jobs.forEach(job => {
			const option = `<option value="${job}">${job}</option>`
			datalistJobs.innerHTML += option
		})
	}
})()