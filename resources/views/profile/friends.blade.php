@component('components.header')
@endcomponent
	@component('components.nav', ['user' => $user, 'count' => $count, 'friendshipRequesteds' => $friendshipRequesteds])
		@endcomponent
	@component('components.profile-header', ['slug' => $slug, 'informations' => $informations])
	@endcomponent
	<div class="container mt-2">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-8">
						<i class="fas fa-user-friends" style="font-size: 20px;"></i>
						<h4 style="display: inline-block; margin-left: 5px;">Amigos</h4>
					</div>
					<div class="col-4" style="border: 1px solid #DDD;" data-search>
						<i class="fas fa-search"></i>
					    <input style="padding-left: 5px; border: none; width: 94%; height: 35px; outline: none;" maxlength="30" data-input-friends placeholder="Buscar amigos" />
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container mt-2 mb-3">
		<div class="card">
			<div class="card-body" data-card>
				<div data-no-user-found></div>
				@if(count($friends) > 0)
					@foreach($friends as $friend)
						<div class="mb-2" style="width: 49%; float: left; margin-right: 0.5%; margin-left: 0.5%;" data-friend-container="{{ $friend->id }}">
							<div class="row">
								<div class="col-9">
									<img src="/images/profile_picture/{{ $friend->profile_picture }}" style="height: 80px; margin-right: 5px;">
									<span>
										<a href="{{ route('profile.index', $friend->slug) }}" data-friend-name>{{ $friend->first_name }} {{ $friend->last_name }}</a>
									</span>
								</div>
								@if($slug == Auth::user()->slug)
									<div class="col-3">
										<div class="btn-group">
										  <button type="button" class="btn btn-primary dropdown-toggle mt-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										    Amigos
										  </button>
										  <div class="dropdown-menu">
										  	<a class="dropdown-item" data-requested-id="{{ $friend->id }}">Desfazer amizade</a>
										  </div>
										</div>
									</div>
								@endif
							</div>
						</div>
					@endforeach
				@else
					<p class="text-center">Não há amigos para mostrar</p>
				@endif
			</div>
		</div>
	</div>
	<script>
		(function() {

			'use strict'

			const divSearch = document.querySelector('[data-search]')
			const inputSearchFriends = document.querySelector('[data-input-friends]')
			const card = document.querySelector('[data-card]')
			const noUserFound = document.querySelector('[data-no-user-found]')

			document.body.addEventListener('click', isLinkWithFriendId)
			divSearch.addEventListener('click', focusOnInput)
			inputSearchFriends.addEventListener('keyup', searchFriend)

			function focusOnInput() {
				inputSearchFriends.focus()
			}

			function isLinkWithFriendId(event) {
				const target = event.target
				if(target.hasAttribute('data-requested-id')) {
					event.preventDefault()
					const requestedId = target.getAttribute('data-requested-id')
					undoFriendship(requestedId, removeFriendContainer)
				}
			}

			function undoFriendship(requestedId, callback) {
					const request = new XMLHttpRequest()
					const url = `${location.origin}/undo-friendship/${requestedId}`
					request.open('DELETE', url)
					request.setRequestHeader('X-CSRF-TOKEN', token())
					request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
					request.send({ requestedId })

					request.addEventListener('readystatechange', function() {
					if(request.readyState === 4 && request.status === 200) {
						const response = JSON.parse(request.responseText)
				 		callback(response)
			 		}
				})
			}

			function removeFriendContainer(response) {
				const friendContainer = document.querySelector(`[data-friend-container="${response}"]`)
				friendContainer.parentNode.removeChild(friendContainer)
			}

			function searchFriend() {
				const userName = inputSearchFriends.value.trim()
				const allFriends = document.querySelectorAll('[data-friend-name]')
				const friendsCount = Array.from(allFriends)
					.filter(friend => friend.textContent.startsWith(userName))
					.length

				if(friendsCount === 0 && allFriends.length > 0) {
					const message = `Nenhum resultado para: ${userName}`
					noUserFound.textContent = message
				} else {
					noUserFound.textContent = ''
				}

				allFriends.forEach(friend => {
					const name = friend.textContent
					const container = friend.closest('[data-friend-container]').style
					if(!name.startsWith(userName)) {
						container.display = 'none'
					} else {
						container.display = 'block'
					}
				})
			}

		})()
	</script>
@component('components.footer')
@endcomponent