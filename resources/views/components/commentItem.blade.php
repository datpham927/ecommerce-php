<div class="comment-item">
    <div class="comment-item-avatar">
        <img src="{{$comment->user->user_image_url}}" />
    </div>
    <div class="comment-item-body">
        <div class="comment-item-content">
            <div class="name">
                {{$comment->user->user_name}}
            </div>
            <div class="content">
                {{$comment->comment_content}}
            </div>
        </div>
        <div style="display: flex; font-size: 10px; margin:3px 0; align-items: center;">
            <span style="margin:0 10px;">
                {{\Carbon\Carbon::parse($comment->created_at)->locale('vi')->diffForHumans()}}
            </span>
            @if(Auth::check())
            @if(Auth::user()->id!=$comment->user->id)
            <button class="btn-rep-comment" style="font-weight: 700; color:#65676B; cursor:pointer">Phản hồi
            </button>
            @endif
            @if(Auth::user()->id==$comment->user->id)
            <button class="btn-delete-comment" data-url="{{route("comment.delete",['cid'=>$comment->id])}}"
                style="font-weight: 700; color:#65676B; cursor:pointer">Xóa
            </button>
            @endif
            @endif
        </div>
        @if(Auth::check())
        <input type="text" class="input-comment-rep"
            data-url="{{route("comment.add-children",["pid"=>$product_id,'cid'=>$comment->id])}}"
            placeholder="Bình luận với vai trò {{Auth::user()->user_name??Auth::user()->user_email}}" />
        @endif
        <div class="comment-children-container" style="margin-top: 10px;">
            @foreach($comment->commentChildren as $commentChildren )
            <div class="comment-item children">
                <div class="comment-item-avatar">
                    <img src="{{$commentChildren->user->user_image_url}}" />
                </div>
                <div style="width: 100%;">
                    <div class="comment-item-content">
                        <div class="name">
                            {{$comment->user->user_name}}
                        </div>
                        <div class="content">
                            {{$commentChildren->comment_content}}
                        </div>
                    </div>
                    <div style="display: flex; font-size: 10px; margin:3px 0;">
                        <span style="margin:0 5px;">
                            {{\Carbon\Carbon::parse($commentChildren->created_at)->locale('vi')->diffForHumans()}}
                        </span>

                        @if(Auth::check()&&Auth::user()->id==$commentChildren->user->id)
                        <button class="btn-delete-comment" data-url="{{route("comment.delete",['cid'=>$commentChildren->id])}}"
                style="font-weight: 700; color:#65676B; cursor:pointer">Xóa
            </button>
                        @endif
                    </div>
                </div>
            </div>

            @endforeach
        </div>
    </div>
</div>