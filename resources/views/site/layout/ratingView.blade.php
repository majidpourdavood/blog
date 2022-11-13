
    @if($subject)
        <div id="tutorial-<?php echo $subject["id"]; ?>">
        <input type="hidden" name="rating" class="ratingName" value=""/>
     <div class="rateYoView" code="<?php echo $subject["id"]; ?>" ></div>
        <input type="hidden" id="rating<?php echo $subject["id"]; ?>" value="{{$ratings}}" >
    </div>
    @else
        <span>{{translate('This item has been deleted')}}</span>
    @endif

