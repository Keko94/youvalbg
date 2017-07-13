$(function(){
    var labelWasClicked = function labelWasClicked(){
        var input = $(this).siblings().filter('input');
        console.log(input);
        if (input.attr('disabled')) {
            return;
        }
        input.val($(this).attr('data-value'));
    }

    var turnToStar = function turnToStar(){
        if ($(this).find('input').attr('disabled')) {
            return;
        }
        var labels = $(this).find('div');
        labels.removeClass();
        labels.addClass('star');
    }

    var turnStarBack = function turnStarBack(){
        var rating = parseInt($(this).find('input').val());
        if (rating > 0) {
            var selectedStar = $(this).children().filter('#rating_star_'+rating)
            var prevLabels = $(selectedStar).nextAll();
            prevLabels.removeClass();
            prevLabels.addClass('star-full');
            selectedStar.removeClass();
            selectedStar.addClass('star-full');
        }
    }

    /*$('body').on('click', '.star', function(){
        //$('.rating-well').each(turnStarBack);
        //$('.rating-well').hover(turnToStar,turnStarBack);
        labelWasClicked();
    });*/

    //findME();

    /*function findME() {
        if ($(".star, .rating-well").size() <= 12) {
            window.requestAnimationFrame(findME);
        }else {
            console.log('FOUUND');
            $('.star, .rating-well').click(labelWasClicked);
            $('.rating-well').each(turnStarBack);
            $('.rating-well').hover(turnToStar,turnStarBack);
        }
    };*/

/*    var checkExist = setInterval(function() {
        if ($('.star, .rating-well').size() > 12) {
            console.log("Exists!");
            //clearInterval(checkExist);
            $('.star, .rating-well').click(labelWasClicked);
            $('.rating-well').each(turnStarBack);
            $('.rating-well').hover(turnToStar,turnStarBack);
        }
    }, 100); // check every 100ms*/
    $('.star, .rating-well').click(labelWasClicked);
    $('.rating-well').each(turnStarBack);
    $('.rating-well').hover(turnToStar,turnStarBack);

});

