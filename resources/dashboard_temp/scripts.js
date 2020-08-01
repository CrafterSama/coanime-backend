$(function () {
    // Active the TimeAgo Plugin
    jQuery('time.timeago').timeago();

    // Script to make Videos Responsive
    $('iframe[src*="youtube.com"]').each(function () {
        $(this).parent().addClass('embed-responsive embed-responsive-16by9');
        $(this).addClass('embed-responsive-item');
    });
    $('iframe[src*="vimeo.com"]').each(function () {
        $(this).parent().addClass('embed-responsive embed-responsive-16by9');
        $(this).addClass('embed-responsive-item');
    });
    $('iframe[src*="dailymotion.com"]').each(function () {
        $(this).parent().addClass('embed-responsive embed-responsive-16by9');
        $(this).addClass('embed-responsive-item');
    });
    $('iframe[src*="brightcove.net"]').each(function () {
        $(this).parent().addClass('embed-responsive embed-responsive-16by9');
        $(this).addClass('embed-responsive-item');
    });
    $('[data-toggle="tooltip"]').tooltip();

    function stringToSlug(str) {
        str = str.replace(/^\s+|\s+$/g, ""); // trim
        str = str.toLowerCase();

        // remove accents, swap ñ for n, etc
        var from = "åàáãäâèéëêìíïîòóöôùúüûñç×·_,:;/";
        var to = "aaaaaaeeeeiiiioooouuuuncx-----";

        for (var i = 0, l = from.length; i < l; i++) {
            str = str.replace(new RegExp(from.charAt(i), "g"), to.charAt(i));
        }

        str = str
            .replace(/[^a-z0-9 -]/g, "") // remove invalid chars
            .replace(/\s+/g, "-") // collapse whitespace and replace by -
            .replace(/-+/g, "-"); // collapse dashes

        return str;
    }

    days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
    var options = { formatMatcher: "best fit", weekday: 'long'/*, year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit'*/, hour12: false };
    var current_date = new Date()/* .toLocaleTimeString('en-us', options) */;
    var weekday_value = current_date.getDay();
    var today = days[weekday_value];

    fetch(`https://api.jikan.moe/v3/schedule/${today}`)
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            const dataResult = data[today];

            console.log(data);

            var legion = '<h3 class="other-info-title col-md-12">Animes al Aire hoy</h3><div class="text-justify col-md-12"><dd>';
            var items = [];
            var i = 0;
            $.each(dataResult, function (key, value) {
                items.push(
                    '<dl class="list"><i class="fa fa-tv"></i> <a href="ecma/titulos/tv/' + stringToSlug(value.title) + '">' + value.title + ' <span class="text-italic">(' + value.type + ')</span></a></dl>'
                );
                i++
            });
            items = items.join('');
            legion += items;
            legion += '</dd></div>';
            $('#legion-anime').html(legion);
        });
        

    // Load the Slider
    $("#events-slider").slidesjs({
        width: 365,
        height: 450,
        navigation: {
            active: false,
            effect: "fade"
        },
        pagination: {
            active: false,
            effect: "fade"
        },
        effect: {
            fade: {
                speed: 400
            }
        },
        play: {
            active: false,
            effect: "fade",
            interval: 7000,
            auto: true,
            swap: true,
            pauseOnHover: true,
            restartDelay: 4500
        }
    });

    function vote (type) {
        const vote = document.getElementById(type);
        var post = { 
            'post_id' : vote.dataset.post,
            'user_id' : vote.dataset.user,
            'status' : vote.dataset.status,
        };
        //console.log(post);
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            //the route pointing to the post function
            url: '/posts/vote',
            type: 'POST',
            // send the csrf-token and the input to the controller
            data: post,
            dataType: 'JSON',
            // remind that 'data' is the response of the AjaxController
            success: function (res) {
                if (res.success) {
                    var data = res.data;
                    console.log(data);
                    document.querySelector('.post-vote').classList.remove('like');
                    document.querySelector('.post-vote').classList.remove('dislike');
                    document.querySelector('.post-vote').classList.remove('neutral');
                    document.querySelector('.post-vote').classList.add(data.status);
                    if(data.status == 'like') {
                        document.querySelector('#quantity').innerText = Number(document.querySelector('#quantity').innerText) + 1;
                        document.querySelector('.fa-thumbs-up').classList.add('semiBounce');
                    }
                } else {
                    swal(
                        'Opps!',
                        res.message,
                        'info'
                    );
                }
            },
            error: function (xhr, textStatus, errorThrown) {
                console.log(xhr.status);
                swal(
                    'Opps!',
                    'Para votar debes estar logueado, logueate <a class="orange" href="/login">aquí</a>',
                    'info'
                );
            }
        });
    }

    var postVotes = document.querySelectorAll('.vote')
    postVotes.forEach((element) => { 
        var $tag = element;
        element.addEventListener('click', function (e) { 
            e.preventDefault(); 
            vote(this.attributes.id.value);
        }); 
    });

    // Load the Masonry Grid
    var container = $('.grid');
    container.imagesLoaded(function () {
        container.masonry({
            columnWidth: '.grid-item',
            itemSelector: '.grid-item',
            gutter: 15
        });
    });
    const player = new Plyr('#player');
    
});