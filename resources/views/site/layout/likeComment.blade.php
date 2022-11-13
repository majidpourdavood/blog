<div class="like_dislike_comment">
    @if($subject)  <ul class="list-inline " id="parent_like_comment-<?php echo $subject["codeNumber"]; ?>">
        <li class="list-inline-item ">
            <span class="span_like" code="{{count($subject->likes()->where('like','=', 1)->get())}}">
                {{count($subject->likes()->where('like','=', 1)->get())}}</span>
            <span class="like_comment" id="like-<?php echo $subject["codeNumber"]; ?>"
                  onClick="likeComment(this,<?php echo $subject["codeNumber"]; ?>);">
                <i class="fas fa-thumbs-up"></i>
                <input type="hidden" class="likeable_id" name="likeable_id" value="{{ $subject->id }}">
                <input type="hidden" class="likeable_type" name="likeable_type" value="{{ get_class($subject) }}">
            </span>
        </li>
        <li class="list-inline-item " >
            <span class="span_disLike" code="{{count($subject->likes()->where('like','=', 0)->get())}}">
                {{count($subject->likes()->where('like','=', 0)->get())}}</span>
            <span class="dislike_comment"  id="disLike-<?php echo $subject["codeNumber"]; ?>"
                  onClick="disLikeComment(this,<?php echo $subject["codeNumber"]; ?>);">
                <i class="fas fa-thumbs-down"></i>
                <input type="hidden" class="likeable_id" name="likeable_id" value="{{ $subject->id }}">
                 <input type="hidden" class="likeable_type" name="likeable_type" value="{{ get_class($subject) }}">
            </span>
        </li>
    </ul>
    @else
        <span>{{translate('This comment has been deleted')}}</span>
    @endif
</div>




