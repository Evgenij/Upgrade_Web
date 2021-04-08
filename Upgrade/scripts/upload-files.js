const ParentFile = { Attachment: 'red', GREEN: 'green', BLUE: 'blue' };

$(document).ready(function () {

    $('.area-files').bind('dragover',function () {
        $(this).addClass('area-drag-file');
        return false;
    });

    $('.area-files').bind('dragleave', function () {
        $(this).removeClass('area-drag-file');
        return false;
    });

    $('.area-files').on('drop', function (e) {
        let parent = $(this).parents('.wrapp-area-files');
        e.preventDefault();
        $(this).removeClass('area-drag-file');

        
        var formData = new FormData();
        var files_list = e.originalEvent.dataTransfer.files;
        for (let i = 0; i < files_list.length; i++) {
            formData.append('file[]', files_list[i]);
        }
        
        if (parent.hasClass('task-content__attachments')) {
            uploadFiles(formData);
        } else if (parent.hasClass('attachment-files')) {
            setFilesAttachment(formData);
        }

        
    });

    $('input[type="file"]').on('change', function (e) {

        let parent = $(this).parents('.wrapp-area-files');

        var formData = new FormData();
        $.each($(this)[0].files, function (key, input) {
            formData.append('file[]', input);
        });

        if (parent.hasClass('task-content__attachments')) {
            uploadFiles(formData);
        } else if (parent.hasClass('attachment-files')) {
            setFilesAttachment(formData);
        }
    });

    function uploadFiles(formData) {
        if ($('.task-block.selection').attr('id') != undefined) {
            formData.append('idTask', $('.task-block.selection').attr('id'));
        } else {
            formData.append('idTask', '');
        }

        // if ($('.task-block.selection').attr('name') != undefined) {
        //     formData.append('idTask', $('.task-block.selection').attr('name'));
        // } else {
        //     formData.append('idAttach', '');
        // }

        formData.append('idAttach', '');
        
        $.ajax({
            url: "/php/uploadFiles.php",
            method: "POST",
            dataType: 'json',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success(data) {
                if (data.status == false) {
                    $('.uploaded-files').text(data.message);
                } else {
                    getFilesTask();
                }
            }
        })
    }

    function setFilesAttachment(formData) {
        // if ($('.task-block.selection').attr('id') != undefined) {
        //     formData.append('idTask', $('.task-block.selection').attr('id'));
        // } else {
        //     formData.append('idTask', '');
        // }

        //formData.append('idTask', '');
        // if ($('.task-block.selection').attr('name') != undefined) {
        //     formData.append('idTask', $('.task-block.selection').attr('name'));
        // } else {
        //     formData.append('idAttach', '');
        // }

        //formData.append('idAttach', '');

        $.ajax({
            url: "/php/blocks/attachments/setAttachmetFiles.php",
            method: "POST",
            dataType: 'json',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success(data) {
                if (data.status == false) {
                    alert(data.message);
                } else {
                    //getFilesTask();
                    $('.attachment-files').find('.uploaded-files').html(data.files);
                }
            }
        })
    }
});

$(document).on('click', '.btn-close', function () {

    var idFile = $(this).parents('.file').attr('id');

    if (idFile) {
        $.ajax({
            url: "/php/vendor/deleteFile.php",
            method: "GET",
            dataType: 'json',
            data: {
                idFile: idFile
            },
            success(data) {
                if (data.status == true) {
                    //alert(1);
                    $('.file[id=' + idFile + ']').remove();
                    //$(this).parents('.file').detach();
                } else {
                    $('.uploaded-files').text(data.message);
                }
            }
        })
    } else {
        $(this).parents('.file').remove();
    }
    
});