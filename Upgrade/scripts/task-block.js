$('.task-block').click(function (e) { 
    if (!$(e.target).hasClass('rect')) {
        $('.task-block').removeClass('selection');
        $(this).toggleClass('selection');
    }
    else {
        var idTask = $(this).attr('id');
        var status = $(this).find('input').is(':checked');

        console.log(status);

        $.ajax({
            url: '/php/blocks/tasks/changeStatus.php',
            type: 'GET',
            dataType: 'json',
            data: {
                idTask: idTask,
                status: status
            },
            success(data) {
                if (data.status == false) { 
                    console.log(data.message);
                }
            }
        });
    }
})