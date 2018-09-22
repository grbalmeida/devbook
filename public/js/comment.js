(function() {

	'use strict'

	const body = document.querySelector('body')
	const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')

	body.addEventListener('click', showCommentArea)
	body.addEventListener('click', commentPost)

	function showCommentArea(event) {
		const target = event.target
		if(target.classList.contains('fa-comment')) {
			const card = target.parentNode.parentNode.parentNode
			const commentArea = card.querySelector('[data-comment-area]')
			commentArea.classList.remove('d-none')
		}
	}

	function commentPost(event) {
		const target = event.target
		if(target.hasAttribute('data-btn-comment')) {
			const commentArea = target.parentNode
			const inputComment = commentArea.querySelector('[data-input-comment]')
			if(isEmptyInputComment(inputComment)) {
				const comment = inputComment.value
				const card = commentArea.parentNode.parentNode
				const postId = card.getAttribute('data-post-id')
				const url = `${location.href}add-comment/${postId}/${comment}`
				makeAjaxRequest(url, 'POST', postId, comment, addCommentToCommentList, commentArea)
				cleanFields(inputComment)
			}
		} 
	}

	function isEmptyInputComment(inputComment) {
		return inputComment.value.trim().length != 0
	}

	function makeAjaxRequest(url, method, postId, comment, callback, commentArea) {
		const request = new XMLHttpRequest()
		request.open(method, url)
		request.setRequestHeader('X-CSRF-TOKEN', token)
		request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		request.send({postId, comment})

		request.addEventListener('readystatechange', function() {
			if(request.readyState === 4 && request.status === 200) {
				if(request.responseText) {
					callback(JSON.parse(request.responseText), commentArea)
				}
			}
		})
	}

	function addCommentToCommentList(response, commentArea) {
		const commentInformations = getCommentInformations(response)
		const btnComment = commentArea.children[1]
		btnComment.parentNode.insertAdjacentHTML('afterend', commentInformations)
	}

	function cleanFields(input) {
		input.value = ''
		input.focus()
	}

	function getCommentInformations(response) {
		return `<div class="mt-2 w-100" data-comment-user-id="${response.id}">
					<div class="row">
						<div class="col-1"">
							<img class="rounded-circle mt-1" src="/images/default.jpg" width="35">
						</div>
						<div class="col-11 d-flex align-items-center pt-1">
							<a href="profile/${response.slug}">
								${response.first_name} ${response.last_name}
							</a>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col-1"></div>
						<div class="col-11">${response.comment}</div>
					</div>
		</div>`
	}

})()