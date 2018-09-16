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
	document.addEventListener('click', removeFriendRequest)
	document.addEventListener('click', acceptFriendRequest)

	function getRequestedUserId(event) {
		if(event.target.hasAttribute('data-user-suggestion-id')) {
			const requestedUserId = event.target.getAttribute('data-user-suggestion-id')
			const url = `${location.href}add-friend/${requestedUserId}`
			makeAjaxRequest(url, 'POST', requestedUserId, removeFrienshipSuggestion, `[data-user-suggestion-id="${requestedUserId}"]`)
		}
	}

	function makeAjaxRequest(url, method, userId, callback, argument) {
		const request = new XMLHttpRequest()
		request.open(method, url)
		request.setRequestHeader('X-CSRF-TOKEN', token)
		request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		request.send({ userId })

		request.addEventListener('readystatechange', function() {
			if(request.readyState === 4 && request.status === 200) {
				if(request.responseText) {
					callback(argument)
				}
			}
		})
	}

	function removeFrienshipSuggestion(target) {
		const friendshipSuggestion = document.querySelector(target)
		friendshipSuggestions.removeChild(friendshipSuggestion.parentNode)
	}

	function removeFriendRequest(event) {
		if(event.target.hasAttribute('data-remove-friend-request')) {
			event.preventDefault()
			const requestUserId = event.target.getAttribute('data-remove-friend-request')
			const url = `${location.href}remove-friend-request/${requestUserId}`
			makeAjaxRequest(url, 'POST', requestUserId, removeChildFromFriendsRequest, event.target.parentNode.parentNode)
		}
	}

	function acceptFriendRequest(event)
	{
		if(event.target.hasAttribute('data-accept-friend-request')) {
			event.preventDefault()
			const requestUserId = event.target.getAttribute('data-accept-friend-request')
			const url = `${location.href}accept-friend-request/${requestUserId}`
			makeAjaxRequest(url, 'POST', requestUserId, removeChildFromFriendsRequest, event.target.parentNode.parentNode)
		}
	}

	function removeChildFromFriendsRequest(target) {
		const friendsRequest = document.querySelector('[data-friends-request]').removeChild(target)
	}

})()