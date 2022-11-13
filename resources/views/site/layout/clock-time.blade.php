<li class="list-inline-item col d-flex justify-content-end">
    <button type="button"
            class="btn btn-info m-1">
                            <span><i class="fa fa-calendar-alt"></i><span>
                                    @if(app()->getLocale() == "fa")
                                        {{ convert(jdate(Carbon\Carbon::now())->format('%A, %d %B Y'))}}
                                    @else
                                        {{ Carbon\Carbon::now()->isoFormat(' dddd OD MMMM, GGGG')}}
                                    @endif
                                </span></span>
    </button>
    <button type="button"
            class="btn btn-info m-1">
                        <span><i class="fa fa-clock"></i><span>

                                    @if(app()->getLocale() == "fa")
                                    {{ convert(jdate(Carbon\Carbon::now())->format('H:i:s') )}}
                                @else
                                    {{ Carbon\Carbon::now()->isoFormat('OH:Om:Os a')}}
                                @endif
                            </span></span>
    </button>
</li>
