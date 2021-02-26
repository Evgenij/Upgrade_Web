$('.task-block').click(function (e) { 
    if (!$(e.target).hasClass('rect')) {
        $('.task-data').append('1');
    }
    else {
        var idTarget = $(this).attr('id');
        var status = $(this).find('input').is(':checked');


        // $.ajax({
        //     url: '/php/blocks/tasks/changeStatus.php',
        //     type: 'GET',
        //     dataType: 'html',
        //     data: {
        //         idTarget: idTarget
        //     },
        //     success(data) {
        //         alert(data)
        //     }
        // });
    }
})