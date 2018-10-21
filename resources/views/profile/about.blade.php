@component('components.header')
@endcomponent
	@component('components.nav', ['user' => $user, 'count' => $count, 'friendshipRequesteds' => $friendshipRequesteds])
		@endcomponent
	@component('components.profile-header', ['slug' => $slug, 'informations' => $informations])
	@endcomponent
<div class="container mt-2">
	<div class="card">
		<div class="row">
			<div class="col-4">
				<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
				  <a class="nav-link active" data-nav id="general">Geral</a>
				  <a class="nav-link" data-nav id="work-education">Trabalho e Educação</a>
				  <a class="nav-link" data-nav id="places">Lugares onde Morou</a>
				  <a class="nav-link" data-nav id="relationship">Relacionamento</a>
				  <a class="nav-link" data-nav id="biography">Biografia</a>
				</div>
			</div>
			<div class="col-8">
			  <div data-div-id="general">Geral</div>
			  <div hidden="true" data-div-id="work-education">Trabalho e Educação</div>
			  <div hidden="true" data-div-id="places">Lugares onde Morou</div>
			  <div hidden="true" data-div-id="relationship">Relacionamento</div>
			  <div hidden="true" data-div-id="biography">Biografia</div>
			</div>
		</div>
	</div>
</div>

<script>
	(function() {

		'use strict'

		document.body.addEventListener('click', function(event) {
			const target = event.target
			if(target.hasAttribute('data-nav')) {
				removeAllActiveNavLinks()
				const id = target.id
				target.classList.add('active')
				hiddenAllDivs()
				displayDiv(id)
			}

			function removeAllActiveNavLinks() {
				let allActiveNavLinks = document.querySelectorAll('[data-nav]')
				allActiveNavLinks = Array.from(allActiveNavLinks).filter(element => element.classList.contains('active'))[0].classList.remove('active')
			}

			function hiddenAllDivs() {
				let allDivsDisplayed = document.querySelectorAll('[data-div-id]')
				allDivsDisplayed = Array.from(allDivsDisplayed).map(element => element.setAttribute('hidden', true))
			}

			function displayDiv(id) {
				const divToBeDisplayed = document.querySelector(`[data-div-id=${id}]`).removeAttribute('hidden')
			}

		})

	})()
</script>