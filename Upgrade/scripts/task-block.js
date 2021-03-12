$(document).on('click', '.task-block',  function (e) {

    if (!$(e.target).hasClass('rect')) {
        if ($(this).hasClass('selection')) {
            $(this).removeClass('selection');
            $('.task-data').html('<div class="task-data__message flex f-col"><h3 class="task-data__title title text">Информационная панель задачи</><h2 class="task-data__subtitle text">выберите задачу для просмотра детальной информации о ней</h2></div>');
        } else {
            $('.task-block').removeClass('selection');
            $(this).addClass('selection');
        }
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
            }
        });
    }
})