(function(){

	'use strict'

	const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')

	document.addEventListener('click', addRemoveLike)

	function addRemoveLike(event) {
		setTimeout(() => {
			if(event.target.classList.contains('fa-thumbs-up')) {
				const card = event.target.parentNode.parentNode.parentNode
				const postId = card.getAttribute('data-post-id')
				const url = `${location.origin}/add-remove-like/${postId}`
				makeAjaxRequest(url, 'POST', postId, changeLikeButton, event.target)
			}
		}, 100)
	}

	function changeLikeButton(response, button) {
		const card = button.parentNode.parentNode.parentNode
		const countLikesAndComments = card.children[2]
		const countLikes = countLikesAndComments.children[0].children[0]
		if(response.count == 1) {
			button.classList.remove('text-primary')
		} else {
			button.classList.add('text-primary')
		}
		countLikes.textContent = getTextLikes(response.countAllLikes)
	}

	function makeAjaxRequest(url, method, postId, callback, button) {
		const request = new XMLHttpRequest()
		request.open(method, url)
		request.setRequestHeader('X-CSRF-TOKEN', token)
		request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		request.send({ postId })

		request.addEventListener('readystatechange', function() {
			if(request.readyState === 4 && request.status === 200) {
				const response = JSON.parse(request.responseText)
				if(response) {
					callback(response, button)
				}
			}
		})
	}

	function getTextLikes(count) {
		if(count == 0) {
			return ''
		} else if(count == 1) {
			return `${count} curtida`
		} 
		return `${count} curtidas`
	}

})()