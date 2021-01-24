
// Реализация скрития/показа пароля в полях ввода
function mouseDown(target) {
    var input = document.querySelector('.password-input');
	if (input.getAttribute('type') == 'password') {
		target.classList.add('view');
		input.setAttribute('type', 'text');
	}
	return false;
}

function mouseUp(target) {
    var input = document.querySelector('.password-input');
	if (input.getAttribute('type') == 'text') {
		target.classList.remove('view');
		input.setAttribute('type', 'password');
	}
	return false;
}

$('#btn-reg').click(function (e) {
	e.preventDefault();

	$(`input`).removeClass('error');
	$('.custom-select-trigger').removeClass('error');
	$('.nick-error').addClass('hide');
	$('.message-block').addClass('hide');
	
	let name = $('input[name="name"]').val(),
		surname = $('input[name="surname"]').val(),
		nickname = $('input[name="nickname"]').val(),
		id_spec = $('.custom-option.selection').data("value");
		email = $('input[name="email"]').val(),
		password = $('input[name="password"]').val(),
		password_confirm = $('input[name="password_confirm"]').val();
	
	if (id_spec == undefined) { 
		id_spec == 0;
	}
	
	let formData = new FormData();
    formData.append('name', name);
	formData.append('surname', surname);
	formData.append('nickname', nickname);
	formData.append('specialization', id_spec);
	formData.append('email', email);
	formData.append('password', password);
	formData.append('password_confirm', password_confirm);
	
	$.ajax({
        url: 'vendor/signup.php',
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
		data: formData,
		success(data) {
			if (data.status) {
				//$('.message-block').removeClass('hide').text(data.message);
			}
			else { 
				if (data.type === 1) { // поля не прошли валидацию
					data.fields.forEach(function (field) {
						$(`input[name="${field}"]`).addClass('error');

						if (field == 'nickname') {
							$('.nick-error').removeClass('hide').text("Ник не может содержать цифры или быть пустым");
						}
						if (field == 'specializations') {
							$('.custom-select-trigger').addClass('error');
						}
					});

					$('.message-block').removeClass('hide').text(data.message);
				}
				else if (data.type === 2) {
					data.fields.forEach(function (field) {
						$(`input[name="${field}"]`).addClass('error');
					});

					$('.message-block').removeClass('hide').text(data.message);
				}
				else { 
					$('.message-block').removeClass('hide').text(data.message);
				}
			}
			// $('.message-block').text(data);
        }
    });
});