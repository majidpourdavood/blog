
<div class="ratingModel">
    @if($subject)   <div id="tutorial-<?php echo $subject["id"]; ?>">
        <input type="hidden" name="rating" class="ratingName" value=""/>
        <input type="hidden" class="ratingable_id" name="ratingable_id" value="{{ $subject->id }}">
        <input type="hidden" class="ratingable_type" name="ratingable_type" value="{{ get_class($subject) }}">
        <div class="rateYo" code="<?php echo $subject["id"]; ?>" onClick="addRating(this,<?php echo $subject["id"]; ?>);"></div>
        <input type="hidden" id="rating<?php echo $subject["id"]; ?>" value="{{$ratings}}" >
    </div>
    @else
        <span>{{translate('This item has been deleted')}}</span>
    @endif
</div>
