<div class="comments-section">
    <h2>Comments</h2>
    <!-- Aqui falta atualizar pagina dps do novo comment ser inserido -->
    <form action="{{ '/comment/create' }}" method="post">
        @csrf
        <input type="hidden" name="article_id" value="{{ $article->article_id }}">
        <label for="text">Leave a comment:</label>
        <textarea class="comment-input" name="text" id="text" cols="30" rows="5"></textarea>
        <button type="submit">Submit Comment</button>
    </form>

    <ul class="comment-list">
        @foreach($comments as $comment)
        <li class="li" id="comment{{ $comment->comment_id }}_2">
            <div class="comment-section">
                <div class="comment-header">
                    <div class="comment-author-date-section">
                        <a href="{{ url('profile/'.$comment->user_id) }}" class="author-name2">
                            <strong>{{ $comment->user->name }}</strong>
                        </a>
                        <p class="comment-date">{{ \Carbon\Carbon::parse($comment->date)->diffForHumans() }}</p>
                    </div>
                    @if(Auth::user())
                        @if($comment->user_id === Auth::user()->user_id)
                            <div class="comment-edit-delete-section">
                                <button class="comment-edit-button"><a href="{{ url('/comment/edit/'.$comment->comment_id) }}"><i id="edit-comment"class="bi bi-pencil"></i> </a></button>
                                <form action="{{ url('/comment/delete') }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" name="comment_id2" value="{{ $comment->comment_id }}">
                                    <button type="submit" id="deleteCommentBtn2" class="comment-delete-button"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        @endif
                    @endif
                </div>
                <p class="comment-text">{{ $comment->text }}</p>

                <!-- ... (comment details) ... -->
                @if(Auth::user())
                <?php
                    $comment_vote = App\Models\Comment_vote::where('user_id', Auth::user()->user_id)
                        ->where('comment_id', $comment->comment_id)
                        ->first();
                ?>
               
                <div class="comment-likes-section">
                    <!--------------------------------LIKE COMMENT----------------------------------------------------------------------->
                    <div class="comment-likes">
                        @if($comment_vote && $comment_vote->is_like === TRUE)
                        <form action="{{ url('/comments/'.$comment->comment_id.'/unlike') }}" method="POST">
                            @csrf
                            <button type="submit" id="unlike-comment-button" class="fw-light nav-link fs-6">
                                <span class="fas fa-thumbs-up"> </span>
                            </button>
                        </form>
                        @else
                        <form action="{{ url('/comments/'.$comment->comment_id.'/like') }}" method="POST">
                            @csrf
                            <input type="hidden" name="comment_id" value="{{ $comment->comment_id }}">
                            <button type="submit" id="like-comment-button" class="fw-light nav-link fs-6">
                                <span class="far fa-thumbs-up"> </span>
                            </button>
                        </form>
                        @endif
                        <p id="like-count"> {{ $comment->likes }} </p>
                    </div>

                    <!-------------------------------------------DISLIKE COMMENT--------------------------------------------------------------->
                    <div class="comment-dislikes">
                        @if($comment_vote && $comment_vote->is_like === FALSE)
                        <form action="{{ url('/comments/'.$comment->comment_id.'/undislike') }}" method="POST">
                            @csrf
                            <button type="submit" id="undislike-comment-button" class="fw-light nav-link fs-6">
                                <span class="fas fa-thumbs-down"> </span>
                            </button>
                        </form>
                        @else
                        <form action="{{ url('/comments/'.$comment->comment_id.'/dislike') }}" method="POST">
                            @csrf
                            <button type="submit" id="dislike-comment-button" class="fw-light nav-link fs-6">
                                <span class="far fa-thumbs-down"> </span>
                            </button>
                        </form>
                        @endif
                        <p> {{ $comment->dislikes }} </p>
                    </div>
                </div>
                @endif
            </div>
        </li>
        @endforeach

    </ul>
</div>