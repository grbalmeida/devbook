(function(){

	'use strict'

	const btnPost = document.querySelector('[data-post-btn]')
	const form = document.querySelector('form')
	const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
	const textarea = document.querySelector('textarea')
	const posts = document.querySelector('[data-posts]')

	btnPost.addEventListener('click', function(event) {
		event.preventDefault()
		validateForm(form)
	})

	function validateForm(form) {
		const formData = new FormData(form)
		if(formData.get('post')) {
			createPost(formData.get('post'))
		}
	}

	function createPost(post) {
		const url =  `${location.href}add-post/${post}`
		makeAjaxPostRequest(url, 'POST', addPost, post)
	}

	function addPost(post) {
		const card = `<div class="card col-12 mb-2 w-100" data-post-id="${post.id}">
			<div class="row">
				${getProfileImage()}
				${getFormattedName(post)}
				<span class="d-block ml-auto pt-3 pr-3">
					1 segundo atrás
				</span>
			</div>
			${getPost(post)}
			<hr>
			${getIcons()}
		</div>`	
		posts.insertAdjacentHTML('afterbegin', card)
		cleanFields()
	}

	function cleanFields() {
		textarea.value = ''
		textarea.focus()
	}

	function makeAjaxPostRequest(url, method, callback, post) {
		const request = new XMLHttpRequest()
		request.open(method, url)
		request.setRequestHeader('X-CSRF-TOKEN', token)
		request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		request.send({ post })

		request.addEventListener('readystatechange', function() {
			if(request.readyState === 4 && request.status === 200) {
				if(request.responseText) {
					callback(JSON.parse(request.responseText))
				}
			}
		})
	}

	function getPost(post) {
		return `<div class="row">
				<div class="col-12">
					${post.post}
				</div>
		</div>`
	}

	function getProfileImage() {
		return `<div class="col-1 mr-3">
					<img src="/images/default.jpg" class="rounded-circle mt-2 mb-2" width="50">
				</div>`
	}

	function getFormattedName(post) {
		return `<span class="col-7 pt-3 d-block">${post.first_name} ${post.last_name}</span>`
	}

	function getIcons() {
		return `<div class="row mb-2">
				<div class="col-1">
					<i class="fas fa-thumbs-up" style="font-size: 25px; cursor: pointer;"></i>
				</div>
				<div class="col-1">
					<i class="fas fa-comment" style="font-size: 25px; cursor: pointer;"></i>
				</div>
		</div>`
	}

})()