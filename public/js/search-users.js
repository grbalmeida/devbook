(function() {

	const searchUsersInput = document.querySelector('[data-search-users]')
	const divShowUsers = document.querySelector('[data-show-users]')

	searchUsersInput.addEventListener('keyup', searchUsersByName)
	searchUsersInput.addEventListener('keydown', searchUsersByName)

	function searchUsersByName() {
		const name = searchUsersInput.value.trim()
		if(name.length > 0) {
			makeAjaxRequest(name, showUsers)
		} else {
			divShowUsers.classList.remove('show')
		}
	}

	function makeAjaxRequest(name, callback) {
		const request = new XMLHttpRequest()
		request.open('GET', `${location.origin}/search-users/${name}`)
		request.setRequestHeader('X-CSRF-TOKEN', token())
		request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		request.send()

		request.addEventListener('readystatechange', function() {
			if(request.readyState === 4 && request.status === 200) {
				const response = JSON.parse(request.responseText)
				callback(response)
			}
		})
	}

	function showDivIfLengthGreatherThenZero(response) {
		if(response.length > 0)	{
			divShowUsers.classList.add('show')
		} else {
			divShowUsers.classList.remove('show')
		}
	}

	function showUsers(response) {
		showDivIfLengthGreatherThenZero(response)
		divShowUsers.innerHTML = ''
		response.forEach(user => divShowUsers.innerHTML += getDropdownItem(user))
	}

	function getDropdownItem(response) {
		const userUrl = `${location.origin}/profile/${response.slug}`
		const img = `<img width="50" src="${location.origin}/images/profile_picture/${response.profile_picture}">`
		return `<a href="${userUrl}" class="dropdown-item">
			${img}
			${response.full_name}
			</a>`
	}

})()