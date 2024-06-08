<div class='container' style="background-color: white;margin-top: 20px;padding: 20px;">
        <div>
            <h1 class="title"
                style="width: 100%; display:flex; font-size: 20px;color: black; text-transform: uppercase;">Đánh giá sản
                phẩm</h1>
            <div style="margin-top: 20px; width: 100%;" id="comment">
                @if(Auth::check())
                <div class="comment-input">
                    <div class="comment-avatar"><img src="{{ Auth::user()->user_image_url }}" /></div>
                    <input type="text" class="btn-comment"
                        data-url="{{ route('comment.add', ['pid' => $detailProduct->id]) }}"
                        placeholder="Bình luận với vai trò {{ Auth::user()->user_name ?? Auth::user()->user_email }}" />
                </div>
                @endif
                <div class="comment-content">
                    @foreach($comments as $comment)
                    @include('components.commentItem', ['comment' => $comment, 'product_id' => $detailProduct->id])
                    @endforeach
                </div>
                @include('components.pagination', ['list' => $comments, 'title' => 'Không có đánh giá nào!'])
            </div>
        </div>
    </div>