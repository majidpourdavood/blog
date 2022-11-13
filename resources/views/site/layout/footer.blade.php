<footer class="footer">
    <div class="container">
        <div class="row col-12 footer-lists">
            <div class="col-12 col-md-6 col-lg-6 item ">
                <ul class="list-group">
                    <li class="list-group-item">
                        <span>
                            <img src="{{asset('images/new/location.svg')}}" alt="" class="img-fluid">
                        </span>
                        <span><?php
                            if (isset($address)) {
                                echo $value = $address->value;
                            } else {
                                echo $value = "";
                            }
                            ?></span>
                    </li>
                    <li class="list-group-item">
                        <span>
                            <img src="{{asset('images/new/mobile.svg')}}" alt="" class="img-fluid">
                        </span>
                        <span><?php
                            if (isset($phone)) {
                                echo $value = $phone->value;
                            } else {
                                echo $value = "";
                            }
                            ?></span>
                    </li>
                </ul>


            </div>
            <div class="col-12 col-md-6 col-lg-6 item row justify-content-end align-items-end ">

                <ul class="list-inline list-social-footer">
                    <li class="list-inline-item">
                        <a href="<?php
                        if (isset($whatsapp)) {
                            echo $value = $whatsapp->value;
                        } else {
                            echo $value = "https://wa.me/989360405004";
                        }
                        ?>" title="whatsapp">
                            <img src="{{asset('images/new/whatsapp.svg')}}" alt="whatsapp" class="img-fluid">
                        </a>
                    </li>

                    <li class="list-inline-item">
                        <a href="<?php
                        if (isset($instagram)) {
                            echo $value = $instagram->value;
                        } else {
                            echo $value = "";
                        }
                        ?>" title="instagram">
                            <img src="{{asset('images/new/instagram.svg')}}" alt="instagram" class="img-fluid">
                        </a>
                    </li>

                    <li class="list-inline-item">
                        <a href="<?php
                        if (isset($telegram)) {
                            echo $value = $telegram->value;
                        } else {
                            echo $value = "https://t.me/majidpourdavood";
                        }
                        ?>" title="telegram">
                            <img src="{{asset('images/new/telegram.svg')}}" alt="telegram" class="img-fluid">
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</footer>
