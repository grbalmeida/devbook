<div class="col-6 mt-2" style="height: 100px;">
	<div class="card mb-2">
		<div class="card-body h-50">
			<form>
				<div class="row">
					<div class="col-12">
						<textarea class="form-control w-100" name="post" style="resize: none;"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-2 mr-1 mt-2">
						<button class="mt-2 btn btn-success" data-post-btn>Publicar</button>
					</div>
					<div class="col-1">
						<i class="fas fa-image pt-4" style="font-size: 25px;"></i>
					</div>
					<div class="ml-4 col-8 d-flex flex-row-reverse align-items-end" data-count-words></div>
				</div>
			</form>
		</div>
	</div>
	<div data-posts>
		@foreach($friendsPosts as $friendPost)
		<div class="card col-12 mb-2 w-100" data-post-id="{{ $friendPost->id }}">
			<div class="row">
				<div class="col-1 mr-3">
					<img src="{{ url('images/cover_photo_user')}}/{{ $friendPost->cover_photo }}" class="rounded-circle mt-2 mb-2" width="50">
				</div>
				<span class="col-7 pt-3 d-block">
					<a href="{{ route('profile.index', $friendPost->slug) }}">{{ $friendPost->first_name.' '.$friendPost->last_name }}</a>
				</span>
				<span class="d-block ml-auto pt-3 pr-3">
					{{ $elapsedTime($friendPost->created_at) }}
				</span>
			</div>
			<div class="row">
				<div class="col-12">
					{{ $friendPost->post }}
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<span style="font-size: 0.8em;">
						@if($friendPost->count_likes > 0)
							{{ $friendPost->count_likes }} {{ $friendPost->count_likes == 1 ? 'curtida' : 'curtidas' }}
						@endif
					</span>
					<span style="font-size: 0.8em;">
						@if($friendPost->count_comments > 0)
							{{ $friendPost->count_comments }} {{ $friendPost->count_comments == 1 ? 'comentário' : 'comentários' }}
						@endif
					</span>
	 			</div>
			</div>
			<hr>
			<div class="row mb-2">
				<div class="col-1">
					<i class="fas fa-thumbs-up @if($userHasLikedPost(Auth::user()->id, $friendPost->id) == 1) text-primary @endif" style="font-size: 25px; cursor: pointer;"></i>
				</div>
				<div class="col-1">
					<i class="fas fa-comment" style="font-size: 25px; cursor: pointer;"></i>
				</div>
			</div>
			<div class="row bg-light pl-4 pb-2 pt-2 d-none" data-comment-area>
				<div>
					<img class="rounded-circle mt-1" src="{{ url('images/cover_photo_user')}}/{{ $user->cover_photo }}" width="35">
				</div>
				<div class="col-11">
					<input type="text" class="form-control h-50" data-input-comment>
					<button class="btn-success border-0 mt-2" data-btn-comment>Comentar</button>
				</div> 
				<div data-comments-list>
					@foreach($comments($friendPost->id) as $comment)
					<div class="row">
						<div class="col-1">
							<img class="rounded-circle mt-1" src="{{ url('images/cover_photo_user')}}/{{ $comment->cover_photo }}" width="35">
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