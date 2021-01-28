
// получение данных из выпадающего списка
function getValueSelect(select) { 
	return $('.custom-option').parents('.' + select).find(".custom-option.selection").data("value");
}

// вывод всплывающего сообщения
function showNotification(text) { 
	$('.notification').addClass('show').text(text);
	setTimeout(() => {
		$('.notification').removeClass('show');
	}, 3000);
}

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

$('#btn-auth').click(function (e) {
	e.preventDefault();

	$(`input`).removeClass('error');
	$('.message-block').addClass('hide');
	
	let email = $('input[name="email"]').val(),
		password = $('input[name="password"]').val();
	
	$.ajax({
        url: 'vendor/signin.php',
        type: 'POST',
        dataType: 'json',
		data: {
			email: email,
			password: password
		},
		success(data) {
			if (data.status) {
				window.location.href = '/main.php';
			}
			else { 
				data.fields.forEach(function (field) {
					$(`input[name="${field}"]`).addClass('error');
				});
				$('.message-block').removeClass('hide').text(data.message);
			}
        }
    });
});

$('#btn-reg').click(function (e) {
	e.preventDefault();

	$(`input`).removeClass('error');
	$('.custom-select-trigger').removeClass('error');
	$('.nick-error').addClass('hide');
	$('.message-block').addClass('hide');
	
	let name = $('input[name="name"]').val(),
		surname = $('input[name="surname"]').val(),
		nickname = $('input[name="nickname"]').val(),
		id_spec = getValueSelect('specializations');
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
				window.location.href = '/index.php';
				showNotification('Регистрация прошла успешно!');
			}
			else { 
				if (data.type === 0) { 
					$('.message-block').removeClass('hide').text(data.message);
				}
				else if (data.type === 1) { // поля не прошли валидацию
					data.fields.forEach(function (field) {
						$(`input[name="${field}"]`).addClass('error');

						if (field == 'nickname') {
							$('.nick-error').removeClass('hide').text("Ник не может содержать цифры или быть пустым");
						}
						if (field == 'specializations') {
							$('.custom-select-trigger').addClass('error');
						}
					});
				}
				else if (data.type === 2) { // пароли не совпадают
					data.fields.forEach(function (field) {
						$(`input[name="${field}"]`).addClass('error');
					});
				}
				
				$('.message-block').removeClass('hide').text(data.message);
			}
        }
    });
});

$('#btn-rec_pass').click(function (e) {
	e.preventDefault();

	$(`input`).removeClass('error');
	$('.message-block').addClass('hide');
	
	let email = $('input[name="email"]').val();
	
	$.ajax({
        url: 'vendor/recovery_password.php',
        type: 'POST',
        dataType: 'json',
		data: {
			email: email
		},
		success(data) {
			if (data.status) {
				window.location.href = '/index.php';
				showNotification('Новый пароль отправлен на вашу электронную почту!');
			}
			else { 
				if (data.type === 1 || data.type === 2) {
					$(`input[name="email"]`).addClass('error');
					$('.message-block').removeClass('hide').text(data.message);
				} else { 
					$('.message-block').removeClass('hide').text(data.message);
				}
			}
        }
    });
});

$('.user-panel-wrapper').click(function (e) {
	if (!($(e.target).parents('.user-menu').length == 1)) {
		$(this).toggleClass('active');
		$('.user-menu').toggleClass('active');
	}
});

$('.user-menu').mouseleave(function (e) {
	$('.user-menu').toggleClass('active');
	$('.user-panel-wrapper').toggleClass('active');
});






var containers;
function initDrawers() {
	// Get the containing elements
	containers = document.querySelectorAll(".container");
	setHeights();
	wireUpTriggers();
	window.addEventListener("resize", setHeights);
}

window.addEventListener("load", initDrawers);

function setHeights() {
	containers.forEach(container => {
		// Get content
		let content = container.querySelector(".content");
		// Needed if this is being fired after a resize
		content.removeAttribute("aria-hidden");
		// Height of content to show/hide
		let heightOfContent = content.getBoundingClientRect().height;
		// Set a CSS custom property with the height of content
		container.style.setProperty("--containerHeight", `${heightOfContent}px`);
		// Once height is read and set
		setTimeout(e => {
			container.classList.add("height-is-set");
			content.setAttribute("aria-hidden", "true");
		}, 0);
	});
}

function wireUpTriggers() {
	containers.forEach(container => {
		// Get each trigger element
		let btn = container.querySelector(".trigger");
		// Get content
		let content = container.querySelector(".content");
		btn.addEventListener("click", () => {
			container.setAttribute(
				"data-drawer-showing",
				container.getAttribute("data-drawer-showing") === "true" ? "false" : "true"
			);
			content.setAttribute(
				"aria-hidden",
				content.getAttribute("aria-hidden") === "true" ? "false" : "true"
			);
		});
	});
}

$('.trigger').click(function () {
	$(this).toggleClass('active');
});










