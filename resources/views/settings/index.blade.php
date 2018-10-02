@component('components.header')
@endcomponent
	@component('components.nav', ['user' => $user, 'count' => $count, 'friendshipRequesteds' => $friendshipRequesteds])
	@endcomponent
	<div class="container-fluid">
		<div class="row mx-auto">
			@component('components.settings.menu')
			@endcomponent
			@component('components.settings.index', 
			['user' => $user, 
			'days' => $days, 
			'months' => $months,
			'years' => $years])
			@endcomponent
		</div>
	</div>
@component('components.footer')
@endcomponent