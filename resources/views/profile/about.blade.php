@component('components.header')
@endcomponent
	@component('components.nav', ['user' => $user, 'count' => $count, 'friendshipRequesteds' => $friendshipRequesteds])
		@endcomponent
	@component('components.profile-header', ['slug' => $slug, 'informations' => $informations])
	@endcomponent
@php 
	function hiddenDivIfIdNotEqualSession($id) {
		if(session('active') == null || $id != session('active')) {
			return true;
		}
		return false;
	}
@endphp
<div class="container mt-2">
	<div class="card">
		<div class="row">
			<div class="col-4">
				<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
				  <a class="nav-link @if(!session('active')) active @endif" data-nav id="general">Geral</a>
				  <a class="nav-link @if(session('active') == 'work-education') active @endif" data-nav id="work-education">Trabalho e Educação</a>
				  <a class="nav-link @if(session('active') == 'places') active @endif" data-nav id="places">Lugares onde Morou</a>
				  <a class="nav-link @if(session('active') == 'relationship') active @endif" data-nav id="relationship">Relacionamento</a>
				  <a class="nav-link @if(session('active') == 'biography') active @endif" data-nav id="biography">Biografia</a>
				</div>
			</div>
			<div class="col-8">
			  <div class="mt-3" @if(session('active') != null) hidden="true" @endif data-div-id="general">
			  	<div class="row">
			  		<div class="col-8">
			  			@component('components.profile.about-company', ['informations' => $informations])
			  			@endcomponent
				  		@component('components.profile.about-institutional_education', ['informations' => $informations])
				  		@endcomponent
				  		@component('components.profile.about-places', ['informations' => $informations])
				  		@endcomponent
			  		</div>
			  		<div class="col-4">
			  			<div>
			  				<i class="fas fa-birthday-cake"></i>
			  				@php $birthday = $userVisited->birthday; @endphp
			  				{{ date('d', strtotime($birthday)) }} de {{ $months[intval(date('m', strtotime($birthday))) - 1] }} de {{ date('Y', strtotime($birthday)) }}
			  			</div>
			  		</div>
			  	</div>
			  </div>
			  <div class="mt-3" @if(hiddenDivIfIdNotEqualSession('work-education')) hidden @endif data-div-id="work-education">
			  	@if(Auth::user()->slug == $slug)
			  	<form method="POST" action="{{ route('profile.work-education') }}">
			  		@csrf
			  		<input type="hidden" name="_method" value="PUT">
			  		<label for="ocuppation">Profissão</label>
			  		<input type="text" name="occupation" class="form-control col-6" value="{{ $informations->occupation }}">
			  		<label for="company">Empresa</label>
			  		<input type="text" name="company" class="form-control col-6" value="{{ $informations->company }}">
			  		<label for="course">Curso</label>
			  		<input type="text" name="course" class="form-control col-6" value="{{ $informations->course }}">
			  		<label for="educational_education">Instituição de Ensino</label>
			  		<input type="text" name="educational_institution" class="form-control col-6" value="{{ $informations->educational_institution }}">
			  		<input type="submit" value="Salvar alterações" class="btn btn-success mt-2 mb-2">
			  	</form>
			  	@else
			  		<div class="row">
			  			<div class="col-11">
			  				<h6>TRABALHO</h6>
					  		@component('components.profile.about-company', ['informations' => $informations])
					  		@endcomponent
					  		<h6 class="mt-2">EDUCAÇÃO</h6>
					  		@component('components.profile.about-institutional_education', ['informations' => $informations])
						  	@endcomponent
			  			</div>
			  		</div>
			  	@endif
			  </div>
			  <div class="mt-3" @if(hiddenDivIfIdNotEqualSession('places')) hidden @endif data-div-id="places">
			  	@if(Auth::user()->slug == $slug)
			  	<form method="POST" action="{{ route('profile.cities') }}">
			  		@csrf
			  		<input type="hidden" name="_method" value="PUT">
			  		<label for="actual-city">Cidade Atual</label>
			  		<input list="actual_city" type="text" name="actual_city" id="actual-city" 
			  		class="form-control col-6" value="{{ $informations->actual_city }}" 
			  		data-actual-city autocomplete="off">
			  		<datalist id="actual_city" data-datalist-actual-city></datalist>
			  		<label class="mt-2" for="hometown_">Cidade Natal</label>
			  		<input list="hometown" type="text" name="hometown" id="hometown_" 
			  		class="form-control col-6" value="{{ $informations->hometown }}" 
			  		data-hometown autocomplete="off">
			  		<datalist id="hometown" data-datalist-hometown></datalist>
			  		<input class="btn btn-success mt-3 mb-2" type="submit" value="Salvar alterações">
			  	</form>
			  	@else
			  		<h6>CIDADE NATAL E ATUAL</h6>
			  		@component('components.profile.about-places', ['informations' => $informations])
			  		@endcomponent
			  	@endif
			  </div>
			  <div class="mt-3" @if(hiddenDivIfIdNotEqualSession('relationship')) hidden @endif data-div-id="relationship">
			  	@if(Auth::user()->slug == $slug)
			  	<form method="POST" action="{{ route('profile.update-relationship-status') }}">
			  		@csrf
			  		<input type="hidden" name="_method" value="PUT">
			  		<select name="relationship_status" class="form-control col-6">
			  		@foreach($getRelationshipStatus as $index => $status)
			  			<option value="{{ $index }}" @if($index == $informations->relationship_status) selected @endif>{{ $status }}</option>
			  		@endforeach
				  	</select>
				  	<input type="submit" value="Salvar alterações" class="btn btn-success mt-2">
			  	</form>
			  	@else
			  		<h6>RELACIONAMENTO</h6>
			  		<div>
			  			<i class="fas fa-heart" style="font-size: 25px;"></i>
			  			{{ $getRelationshipStatus[$informations->relationship_status] }}
			  		</div>
			  	@endif
			  </div>
			  <div class="mt-3" @if(hiddenDivIfIdNotEqualSession('biography')) hidden @endif data-div-id="biography">
			  	@if(Auth::user()->slug == $slug)
			  	<form method="POST" action="{{ route('profile.update-biography') }}">
			  		@csrf
			  		<input type="hidden" name="_method" value="PUT">
			  		<textarea name="biography" class="form-control mb-2 col-6" style="resize: none;">{{ $informations->biography }}</textarea>
			  		<input type="submit" value="Salvar alterações" class="btn btn-success">
			  	</form>
			  	@else
			  		<h6>SOBRE {{ mb_convert_case($userVisited->first_name, MB_CASE_UPPER, 'UTF-8') }}</h6>
			  		<div>
				  		@if($informations->biography)	
				  			{{ $informations->biography }}
				  		@else
				  			Nenhum detalhe adicional a ser exibido
				  		@endif
			  		</div>
			  	@endif
			  </div>
			</div>
		</div>
	</div>
</div>
<script src="{{ url('js/search-cities.js') }}"></script>
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
@component('components.footer')
@endcomponent