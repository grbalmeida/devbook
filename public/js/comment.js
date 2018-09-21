(function() {

	'use strict'

	const body = document.querySelector('body')

	body.addEventListener('click', showCommentArea)

	function showCommentArea(event) {
		const target = event.target
		if(target.classList.contains('fa-comment')) {
			const card = target.parentNode.parentNode.parentNode
			const commentArea = card.querySelector('[data-comment-area]')
			commentArea.classList.remove('d-none')
		}
	}

})()