$(document).ready(function(){
    $(document).foundation();

    /*
    $('[data-open="accountModal"]').on('click',function(){
    triggerThrobber();
    }); */

    /*event listener*/
    $('[data-open="accountModal"]').on('click',function(){
    //alert('clicked!');
    triggerThrobber();
    
});

});


function triggerThrobber(){
    const spinner = $('.boarder-spinner');

    //remove & re-add the spin class to re-trigger animation
    spinner.removeClass('active-spinner');

    //force reflow so the animation restarts
    void spinner[0].offsetWidth;

    spinner.addClass('active-spinner');
}

