<div class='container' style="background-color: white;padding: 20px;">
    <div>
        <h1 class="title" style="width: 100%; display:flex; font-size: 20px;color: black; text-transform: uppercase;">
            Đánh giá sản
            phẩm</h1>
        <div style="margin-top: 20px; width: 100%;" id="comment">
            @if(Auth::check() && Auth::user()->user_type=="customer")
            <div class="comment-input">
                <div class="comment-avatar"><img src="{{ Auth::user()->user_image_url }}" /></div>
                <div class="wrapper-comment-input" >
                    <input type="text" class="btn-comment" style="width: 100%;"
                        data-url="{{ route('comment.add', ['pid' => $detailProduct->id]) }}"
                        placeholder="Bình luận với vai trò {{ Auth::user()->user_name ?? Auth::user()->user_email }}" />
                
                    <div class="rating-wrapper" style="flex-shrink: 0;" data-id="raiders">
                        <div class="star-wrapper" style="font-size: 13px;">
                            <i class="fa-regular fa-star" data-rating="1"></i>
                            <i class="fa-regular fa-star" data-rating="2"></i>
                            <i class="fa-regular fa-star" data-rating="3"></i>
                            <i class="fa-regular fa-star" data-rating="4"></i>
                            <i class="fa-regular fa-star" data-rating="5"></i>
                        </div>
                        <div class="rating-value" style="display: none;"></div>
                    </div>
                

                </div>
            </div>


            @endif
            <div class="comment-content">
                @foreach($comments as $comment)
                @include('client.components.commentItem', ['comment' => $comment, 'product_id' => $detailProduct->id])
                @endforeach
            </div>
            @include('components.pagination', ['list' => $comments, 'title' => 'Không có đánh giá nào!'])
        </div>
    </div>
</div>