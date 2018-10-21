@component('components.header')
@endcomponent
	@component('components.nav', ['user' => $user, 'count' => $count, 'friendshipRequesteds' => $friendshipRequesteds])
		@endcomponent
	@component('components.profile-header', ['slug' => $slug, 'informations' => $informations])
	@endcomponent
	<div class="container mt-2">
		<div class="row">
			<div class="col-4">
				<div class="card mb-2">
					<div class="card-body">
						<h5><i class="fas fa-globe-americas"></i> Apresentação</h5>
						@if($informations->actual_city != null)
						<div>
							<i class="fas fa-home"></i> 
							Mora em {{ $informations->actual_city }}</div>
						@endif
						@if($informations->hometown != null)
						<div>
							<i class="fas fa-map-marker-alt"></i> 
							De {{ $informations->hometown }}
						</div>
						@endif
						@if($informations->company != null)
							<div>
								<i class="fas fa-briefcase"></i>
								@if($informations->occupation)
									{{ $informations->occupation }} na empresa {{ $informations->company }}
								@else
									Trabalha na empresa {{ $informations->company }}
								@endif
							</div>
						@endif
						@if($informations->educational_institution)
							<div>
								<i class="fas fa-graduation-cap"></i>
								@if($informations->course)
									Estudou {{ $informations->course }} na instituição de ensino {{ $informations->educational_institution }}
								@else
									Estudou na instituição de ensino {{ $informations->educational_institution }}
								@endif
							</div>
						@endif
						<div>
							<i class="fas fa-heart"></i> {{ $getRelationshipStatus($informations->relationship_status) }}
						</div>
					</div>
				</div>
				<div class="card mb-2">
					<div class="card-body">
						<h5><i class="fas fa-user-friends"></i> Amigos</h5>
						@if($friends)
							@foreach($friends as $friend)
								<a href="{{ route('profile.index', $friend->slug) }}" class="text-dark" style="text-decoration: none;">
									<img src="{{ url('/images/profile_picture')}}/{{ $friend->profile_picture }}" class="mb-2" width="57" 
									title="{{ $friend->first_name.' '.$friend->last_name }}">
								</a>
							@endforeach
						@endif
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<h5><i class="fas fa-images"></i> Fotos</h5>
						@if($photos)
							@foreach($photos as $photo)
								<img src="{{ url('/images/user_posts')}}/{{ $photo->image }}" class="mb-2" width="73">
							@endforeach
						@endif
					</div>
				</div>
			</div>
			<div class="col-8">
				<div data-posts>
				@foreach($userPosts as $post)
				<div class="card col-12 mb-2 w-100" data-post-id="{{ $post->id }}">
					<div class="row">
						<div class="col-1 mr-3">
							<img src="{{ url('images/profile_picture')}}/{{ $post->profile_picture }}" class="rounded-circle mt-2 mb-2" width="50">
						</div>
						<span class="col-7 pt-3 d-block">
							<a href="{{ route('profile.index', $post->slug) }}">{{ $post->first_name.' '.$post->last_name }}</a>
						</span>
						<span class="d-block ml-auto pt-3 pr-3">
							{{ $elapsedTime($post->created_at) }}
						</span>
					</div>
					<div class="row">
						<div class="col-12">
							{{ $post->post }}
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<span style="font-size: 0.8em;">
								@if($post->count_likes > 0)
									{{ $post->count_likes }} {{ $post->count_likes == 1 ? 'curtida' : 'curtidas' }}
								@endif
							</span>
							<span style="font-size: 0.8em;">
								@if($post->count_comments > 0)
									{{ $post->count_comments }} {{ $post->count_comments == 1 ? 'comentário' : 'comentários' }}
								@endif
							</span>
			 			</div>
					</div>
					<hr>
					<div class="row mb-2">
						<div class="col-1">
							<i class="fas fa-thumbs-up @if($userHasLikedPost(Auth::user()->id, $post->id) == 1) text-primary @endif" style="font-size: 25px; cursor: pointer;"></i>
						</div>
						<div class="col-1">
							<i class="fas fa-comment" style="font-size: 25px; cursor: pointer;"></i>
						</div>
					</div>
					<div class="row bg-light pl-4 pb-2 pt-2 d-none" data-comment-area>
						<div>
							<img class="rounded-circle mt-1" src="{{ url('images/profile_picture')}}/{{ $user->profile_picture }}" width="35">
						</div>
						<div class="col-11">
							<input type="text" class="form-control h-50" data-input-comment>
							<button class="btn-success border-0 mt-2" data-btn-comment>Comentar</button>
						</div> 
						<div data-comments-list>
							@foreach($comments($post->id) as $comment)
							<div class="row">
								<div class="col-1">
									<img class="rounded-circle mt-1" src="{{ url('images/profile_picture')}}/{{ $comment->profile_picture }}" width="35">
								</div>
								<div class="ml-3 col-9 pt-2">
									<a href="{{ route('profile.index', $comment->slug) }}">{{ $comment->first_name.' '.$comment->last_name }} </a>
								</div>
							</div>
							<div class="row">
								<div class="col-1"></div>
								<div class="ml-3 col-9 pt-2">{{ $comment->comment }}</div>
							</div>
							@endforeach
						</div>
					</div>
				</div>
				@endforeach
			</div>
			</div>
		</div>
	</div>
@component('components.footer')
@endcomponent