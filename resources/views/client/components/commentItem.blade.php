<div class="comment-item">
    <div class="comment-item-avatar">
        <img src="{{$comment->user->user_image_url??""}}" alt="User Avatar" />
    </div>
    <div class="comment-item-body">
        <div class="comment-item-content">
            <div>
                <span>{{$comment->user->user_name}}</span>
                @include("utils.formatRating", ['rating' => $comment->comment_rating])
                <span style="font-size: 12px; color: rgba(0, 0, 0, .54);">
                    {{\Carbon\Carbon::parse($comment->created_at)->locale('vi')->diffForHumans()}}
                </span>
            </div>
            <div style="margin: 10px 0;">
                <span style="font-size: 14px;">{{$comment->comment_content}}</span>
            </div>
            <div style="display: flex; font-size: 10px; margin: 3px 0; align-items: center;">
                @if(Auth::check())
                @if(Auth::user()->id != $comment->user->id)
                <button class="btn-rep-comment" style="font-weight: 700; color: #65676B; cursor: pointer;">Phản
                    hồi</button>
                @endif
                @if(Auth::user()->id == $comment->user->id)
                <button class="btn-delete-comment" data-url="{{route('comment.delete', ['cid' => $comment->id])}}"
                    style="font-weight: 700; color: #65676B; cursor: pointer;">Xóa</button>
                @endif
                @endif
            </div>
            @if(Auth::check())
            <input type="text" class="input-comment-rep"
                data-url="{{route('comment.add-children', ['pid' => $product_id, 'cid' => $comment->id])}}"
                placeholder="Bình luận với vai trò {{Auth::user()->user_name ?? Auth::user()->user_email}}" />
            @endif
        </div>

        <div class="comment-children-container" style="margin-top: 10px;">
            @foreach($comment->commentChildren as $commentChildren)
            <div class="comment-item children">
                <div class="comment-item-avatar">
                    <img src="{{$commentChildren->user->user_image_url}}" alt="User Avatar" />
                </div>
                <div class="comment-item-content">
                    <div style="display: flex; flex-direction: column; ">
                        <span>{{$commentChildren->user->user_name}}</span>
                        <span style="font-size: 12px; color: rgba(0, 0, 0, .54);">
                            {{\Carbon\Carbon::parse($commentChildren->created_at)->locale('vi')->diffForHumans()}}
                        </span>
                    </div>
                    <div style="margin: 10px 0;">
                        <span style="font-size: 14px;">{{$commentChildren->comment_content}}</span>
                    </div>
                    <div style="display: flex; font-size: 10px; margin: 3px 0; align-items: center;">
                        @if(Auth::check()&& Auth::user()->id == $commentChildren->user->id)
                        <button class="btn-delete-comment"
                            data-url="{{route('comment.delete', ['cid' => $commentChildren->id])}}"
                            style="font-weight: 700; color: #65676B; cursor: pointer;">Xóa</button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>