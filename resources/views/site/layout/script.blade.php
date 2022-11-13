
<?php
$setting = \App\Model\Setting::where('key', 'versionCss')
    ->lang()->where('active', 1)->first();

if (isset($setting)) {
    $versionCss = $setting->value;
} else {
    $versionCss = '1.56';
}
?>

<script src="/js/app.js?v=<?php echo $versionCss;?>"></script>

<script src="{{ asset('js/jquery.lazy.min.js') }}"></script>



<script>


    function likeComment(obj, codeNumber) {
        $.ajax({
            url: '/likeComment',
            data: {
                "_token": "{{ csrf_token() }}",
                "likeable_id": $('#like-' + codeNumber + ' .likeable_id').val(),
                "likeable_type": $('#like-' + codeNumber + ' .likeable_type').val()
            },
            type: "POST",
            success: function (data) {
                console.log(data);
                var like = $('#parent_like_comment-' + codeNumber + ' .span_like');
                var disLike = $('#parent_like_comment-' + codeNumber + ' .span_disLike');
                like.html(data.count);
                disLike.html(data.countdis);
            },
            error: function (data) {
                console.log(data);

            }
        })

    }

    function disLikeComment(obj, codeNumber) {
        $.ajax({
            url: '/disLikeComment',
            data: {
                "_token": "{{ csrf_token() }}",
                "likeable_id": $('#disLike-' + codeNumber + ' .likeable_id').val(),
                "likeable_type": $('#disLike-' + codeNumber + ' .likeable_type').val()
            },
            type: "POST",
            success: function (data) {
                var like = $('#parent_like_comment-' + codeNumber + ' .span_like');
                var disLike = $('#parent_like_comment-' + codeNumber + ' .span_disLike');
                like.html(data.count);
                disLike.html(data.countdis);
                console.log(data);

            },
            error: function (data) {
                console.log(data);


            }
        })

    }

    $(function () {
        $('.lazy').lazy();
    });


    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        $('.parent-header').addClass('active');
        // document.getElementById("header-top").style.top = "-100px";
        // document.getElementById('logo').src = "./images/yaremohajer-2.png";

    } else {
        // document.getElementById("header-top").style.top = "0";
        // document.getElementById("header-top").style.backgroundColor = "unset";
        $('.parent-header').removeClass('active');
        // document.getElementById('logo').src = "./images/yaremohajer.png";

    }

    window.onscroll = function () {
        scrollFunction()
    };

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            $('.parent-header').addClass('active');
            // document.getElementById("header-top").style.top = "-100px";
            // document.getElementById('logo').src = "./images/yaremohajer-2.png";

        } else {
            // document.getElementById("header-top").style.top = "0";
            // document.getElementById("header-top").style.backgroundColor = "unset";
            $('.parent-header').removeClass('active');
            // document.getElementById('logo').src = "./images/yaremohajer.png";


        }
    }



    var TxtType = function (el, toRotate, period) {
        this.toRotate = toRotate;
        this.el = el;
        this.loopNum = 0;
        this.period = parseInt(period, 10) || 2000;
        this.txt = '';
        this.tick();
        this.isDeleting = false;
    };

    TxtType.prototype.tick = function () {
        var i = this.loopNum % this.toRotate.length;
        var fullTxt = this.toRotate[i];

        if (this.isDeleting) {
            this.txt = fullTxt.substring(0, this.txt.length - 1);
        } else {
            this.txt = fullTxt.substring(0, this.txt.length + 1);
        }

        this.el.innerHTML = '<span class="wrap">' + this.txt + '</span>';

        var that = this;
        var delta = 200 - Math.random() * 100;

        if (this.isDeleting) {
            delta /= 2;
        }

        if (!this.isDeleting && this.txt === fullTxt) {
            delta = this.period;
            this.isDeleting = true;
        } else if (this.isDeleting && this.txt === '') {
            this.isDeleting = false;
            this.loopNum++;
            delta = 500;
        }

        setTimeout(function () {
            that.tick();
        }, delta);
    };

    window.onload = function () {
        var elements = document.getElementsByClassName('typewrite');
        for (var i = 0; i < elements.length; i++) {
            var toRotate = elements[i].getAttribute('data-type');
            var period = elements[i].getAttribute('data-period');
            if (toRotate) {
                new TxtType(elements[i], JSON.parse(toRotate), period);
            }
        }
        // INJECT CSS
        var css = document.createElement("style");
        css.type = "text/css";
        css.innerHTML = ".typewrite > .wrap { border-left: 0.08em solid #fff}";
        document.body.appendChild(css);
    };

    $('.reply_comment_all_btn').click(function (event) {
        event.preventDefault();
        var parent_id = $(this).data('parent');
        // alert( parent_id);
        var currentContent = $(this).parent().parent().parent().find('.comment_post_repl_input');
        $('.comment_post_repl_input').not(currentContent).slideUp();
        $('#replay_comment' + parent_id).slideToggle('slow');
        $('#replay_comment' + parent_id).find("[name='parent_id']").val(parent_id);
    });



</script>
