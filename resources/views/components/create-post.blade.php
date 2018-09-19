<div class="col-5 mt-2 ml-4 mr-3" style="height: 100px;">
	<div class="card mb-3">
		<div class="card-body h-50">
			<form>
				<div class="row">
					<div class="col-12">
						<textarea class="form-control w-100" style="resize: none;"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-2 mr-1">
						<button class="mt-4 btn btn-success">Publicar</button>
					</div>
					<div class="col-1">
						<i class="fas fa-image mt-4" style="font-size: 25px;"></i>
					</div>
				</div>
			</form>
		</div>
	</div>
	@foreach($friendsPosts as $friendPost)
	<div class="card col-12 mb-2 w-100" data-post-id="{{ $friendPost->id }}">
		<div class="row">
			<div class="col-1 mr-3">
				<img src="{{ url('images/default.jpg') }}" class="rounded-circle mt-2 mb-2" width="50">
			</div>
			<span class="col-7 pt-3 d-block">{{ $friendPost->first_name.' '.$friendPost->last_name }}</span>
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
				@if($friendPost->count_likes > 0)
				<span style="font-size: 0.8em;">{{ $friendPost->count_likes }} {{ $friendPost->count_likes == 1 ? 'curtida' : 'curtidas' }}</span>
				@endif
				@if($friendPost->count_comments > 0)
				<span style="font-size: 0.8em;">{{ $friendPost->count_comments }} {{ $friendPost->count_comments == 1 ? 'comentário' : 'comentários' }}</span>
				@endif
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
	</div>
	@endforeach
</div>