(function() {

	const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
	const friendshipSuggestions = document.querySelector('[data-friendship-suggestions]')

	document.addEventListener('click', getRequestedUserId)
	document.addEventListener('click', function(event) {
		const cancel = 'data-cancel-friendship-suggestion'
		const id = event.target.getAttribute(cancel)
		if(id) {
			removeFrienshipSuggestion(`[${cancel}="${id}"]`)
		}
	})

	function getRequestedUserId(event) {
		if(event.target.hasAttribute('data-user-suggestion-id')) {
			const requestedUserId = event.target.getAttribute('data-user-suggestion-id')
			const url = `${location.href}add-friend/${requestedUserId}`
			makeAjaxRequest(url, 'POST', requestedUserId)
		}
	}

	function makeAjaxRequest(url, method, requestedUserId) {
		const request = new XMLHttpRequest()
		request.open(method, url)
		request.setRequestHeader('X-CSRF-TOKEN', token)
		request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		request.send({ requestedUserId })

		request.addEventListener('readystatechange', function() {
			if(request.readyState === 4 && request.status === 200) {
				if(request.responseText) {
					removeFrienshipSuggestion(`[data-user-suggestion-id="${requestedUserId}"]`)
				}
			}
		})
	}

	function removeFrienshipSuggestion(target) {
		console.log(target)
		const friendshipSuggestion = document.querySelector(target)
		friendshipSuggestions.removeChild(friendshipSuggestion.parentNode)
	}

})()