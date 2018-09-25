(function() {

	const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
	const friendshipSuggestions = document.querySelector('[data-friendship-suggestions]')
	const friendshipRequests = document.querySelector('[data-friends-request]')
	const iconUserFriends = document.querySelector('.fa-user-friends')
	const dropdownMenu = document.querySelector('.dropdown-menu')

	document.addEventListener('click', getRequestedUserId)
	document.addEventListener('click', function(event) {
		const cancel = 'data-cancel-friendship-suggestion'
		const id = event.target.getAttribute(cancel)
		if(id) {
			removeFriendshipSuggestion(null, `[${cancel}="${id}"]`)
		}
	})
	document.addEventListener('click', removeFriendRequest)
	document.addEventListener('click', acceptFriendRequest)

	function getRequestedUserId(event) {
		if(event.target.hasAttribute('data-user-suggestion-id')) {
			const requestedUserId = event.target.getAttribute('data-user-suggestion-id')
			const url = `${location.origin}/add-friend/${requestedUserId}`
			makeAjaxRequest(url, 'POST', requestedUserId, removeFriendshipSuggestion, `[data-user-suggestion-id="${requestedUserId}"]`)
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
					callback(JSON.parse(request.responseText), argument)
				}
			}
		})
	}

	function removeFriendshipSuggestion(response, target) {
		const friendshipSuggestion = document.querySelector(target)
		friendshipSuggestions.removeChild(friendshipSuggestion.parentNode)
		if(response != null) {
			friendshipSuggestions.insertAdjacentHTML('beforeend', getAnotherFriendSuggestion(response));
		}
	}

	function removeFriendRequest(event) {
		if(event.target.hasAttribute('data-remove-friend-request')) {
			event.preventDefault()
			const requestUserId = event.target.getAttribute('data-remove-friend-request')
			const url = `${location.origin}/remove-friend-request/${requestUserId}`
			makeAjaxRequest(url, 'POST', requestUserId, removeChildFromFriendsRequest, event.target.parentNode.parentNode)
		}
	}

	function acceptFriendRequest(event)
	{
		if(event.target.hasAttribute('data-accept-friend-request')) {
			event.preventDefault()
			const requestUserId = event.target.getAttribute('data-accept-friend-request')
			const url = `${location.origin}/accept-friend-request/${requestUserId}`
			makeAjaxRequest(url, 'POST', requestUserId, removeChildFromFriendsRequest, event.target.parentNode.parentNode)
		}
	}

	function removeChildFromFriendsRequest(response, target) {
		const friendsRequest = friendshipRequests.removeChild(target)
		if(response != null) {
			friendshipRequests.insertAdjacentHTML('beforeend', getAnotherFrienshipRequesteds(response))
		}
		if(friendshipRequests.children.length == 0) {
			iconUserFriends.classList.remove('text-danger')
			iconUserFriends.classList.add('text-dark')
			dropdownMenu.classList.remove('show')
			dropdownMenu.innerHTML = getMenuWhenCountFriendsRequestsEqualZero()
		}
	}

	$(document).delegate(".dropdown-menu [data-keepOpenOnClick]", "click", stopPropagation)

	function stopPropagation(event) {
		event.stopPropagation()
	}

	function getMenuWhenCountFriendsRequestsEqualZero() {
		return `<a class="dropdown-item">
						    	Não há solicitações de amizade
						    </a>`	
	}

	function getAnotherFrienshipRequesteds(response) {
		return `<a class="dropdown-item" href="/profile/${response.slug}">
	    	<div>
	    		<img src="/images/profile_picture/${response.profile_picture}" width="50" class="rounded-circle">
	    		${response.first_name} ${response.last_name}
	    	</div>
	    	<div class="w-100 mb-2"></div>
	    	<div>
	    		<button class="btn btn-success mr-2" data-accept-friend-request="${response.id}" data-keepOpenOnClick>Aceitar</button>
	    		<button class="btn btn-secondary" data-remove-friend-request="${response.id}" data-keepOpenOnClick>Excluir</button>
	    	</div>
	    </a>`
	}

	function getAnotherFriendSuggestion(response) {
		return `<div class="row">
			<a href="/profile/${response.slug}">
				<img src="/images/profile_picture/${response.profile_picture}" height="40" class="rounded-circle">
				<span class="db-block ml-3">${response.first_name} ${response.last_name}</span>
			</a>
			<i class="fas fa-times d-block pt-2 ml-5" style="font-size: 20px; cursor: pointer;" data-cancel-friendship-suggestion="${response.id}"></i>
			<div class="w-100"></div>
			<button class="btn btn-primary mb-3 mt-3" data-user-suggestion-id="${response.id}">Adicionar</button>
		</div>`
	}

})()