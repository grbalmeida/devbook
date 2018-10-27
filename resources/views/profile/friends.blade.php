@component('components.header')
@endcomponent
	@component('components.nav', ['user' => $user, 'count' => $count, 'friendshipRequesteds' => $friendshipRequesteds])
		@endcomponent
	@component('components.profile-header', ['slug' => $slug, 'informations' => $informations])
	@endcomponent
@component('components.footer')
@endcomponent