$('.rating ul li').on('click', function () {

    let li = $(this),
        ul = li.parent(),
        rating = ul.parent(),
        last = ul.find('.current');
    let val=li.index()*1+1;

    if (!rating.hasClass('animate-left') && !rating.hasClass('animate-right')) {
        last.removeClass('current');

        ul.children('li').each(function () {
            let current = $(this);
            current.toggleClass('active', li.index() > current.index());
        });

        rating.addClass(li.index() > last.index() ? 'animate-right' : 'animate-left');
        rating.css({
            '--x': li.position().left + 'px'
        });
        li.addClass('move-to');
        last.addClass('move-from');

        setTimeout(() => {
            li.addClass('current');
            li.removeClass('move-to');
            last.removeClass('move-from');
            rating.removeClass('animate-left animate-right');
        }, 800);
    }

})
