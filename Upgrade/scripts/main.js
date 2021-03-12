// глобальные переменные

var chart, datepicker;

// глобальные переменные




// функции заполнения данными окон пуктовменю

function iniMainWindow() {
	SetThemeCheckbox();
	iniSelect('periods_stat');
	setDataForWeeklyChart();
	getDataTodays();
	datepicker = new Datepicker('#datepicker');
	GetGeneralData();
}

$('li[value=\"tab-1\"]').click(function () {
	iniMainWindow();
})

$('li[value=\"tab-2\"]').click(function () {
	iniSelect('date-filter', 3);
	iniSelect('status-filter');
	iniSelect('projects-filter');

	//SetSelectProjects('projects-filter');
	let idProject = getValueSelect('projects-filter');

	iniSelect('executors-filter');
	SetSelectTargets(idProject, 'targets-filter', 'executors-filter');

	GetTasks();
})







// функции и события общего назначения

// получение данных из выпадающего списка
function getValueSelect(select) {
	return $('.custom-options#' + select).find(".custom-option.selection").data("value");
}

// вывод всплывающего сообщения
function showNotification(text) {

	$('.notification').text(text).slideDown(500);

	setTimeout(() => {
		$('.notification').fadeOut(500);
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

function iniSelect(select, num) {

	if (num) {
		$('.custom-options#' + select).find('.custom-option:nth-child(' + num + ')').addClass('selection');
	}
	else {
		$('.custom-options#' + select).find('.custom-option:first').addClass('selection');
	}
	$('.custom-select-trigger#' + select).text($('.custom-options#' + select).find('.custom-option.selection').text());

	//console.log('iniSelect');
}

function setDatasSelect(select, data) {

	$('.custom-options#' + select).html(data);
	iniSelect(select);

	//console.log('setDatasSelect');
}

// функции и события общего назначения






function GetGeneralData() {
	$.ajax({
		url: 'php/getGeneralData.php',
		type: 'POST',
		dataType: 'json',
		success(data) {
			$('.count-task').text(data.countTask + " задач(и)");
			$('.count-project').text(data.countProject + "-мя проектами");
		}
	});
}







// функции и события для запполнения данными компоненты пункта меню - ОСНОВНОЕ

function setDataForWeeklyChart() {
	let period = getValueSelect('periods_stat');

	$.ajax({
		url: 'php/getWeeklyStatistic.php',
		type: 'POST',
		dataType: 'json',
		data: {
			period: period
		},
		success(data) {

			if (data.type == 1) {
				$('.week-statistic').find('.current-performance').html("Эффективность за неделю <span class=\"current-performance__value text-gradient\"></span>");
				$('.week-statistic').find('.last-performance').html("Эффективность за прошлую неделю <span class=\"last-performance__value\"></span>");
			}
			else if (data.type == 2) {
				$('.week-statistic').find('.current-performance').html("Эффективность за месяц <span class=\"current-performance__value text-gradient\"></span>");
				$('.week-statistic').find('.last-performance').html("Эффективность за прошлый месяц <span class=\"last-performance__value\"></span>");
			}

			if (!data.empty) {
				$('.week-statistic__chart').empty();
				$('.current-performance__value').text(data.perfCurrPeriod + '%');
				$('.last-performance__value').text(data.perfLastPeriod + '%');
				setChartValues(data.labels, data.doneTaskCurrPeriod, data.failTaskCurrPeriod);
			}
			else {
				$('.week-statistic__chart').html(
					'<div class="data-not-found flex f-col"><svg width="30" height="30" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="data-not-found__icon"><path d="M10 19C14.9706 19 19 14.9706 19 10C19 5.02944 14.9706 1 10 1C5.02944 1 1 5.02944 1 10C1 14.9706 5.02944 19 10 19Z" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M10 6.3999V9.9999" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M10 13.6001H10.01" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg><p class="data-not-found__text text">Данные для построения графика не найдены</p></div>');
			}
		}
	});
}

function getDataTodays() {
	$.ajax({
		url: 'php/getDataTodays.php',
		type: 'POST',
		dataType: 'json',
		success(data) {
			$('.welcome__text').html('Тебе необходимо завершить сегодня <span class="task-todays color-bold">' + data.countTaskToday + ' задач(и).</span> Твоя общая эффективность работы <span class="task-todays color-bold">' + data.currentPerformance + '%.</span>');
		}
	});
}

function setChartValues(labels, valuesDone, valuesFailed) {

	$('.weekly-chart').detach();


	settings = {
		animate: {
			show: true,
			duration: 0.5,
		},
		point: {
			show: true,
			radius: 5,
			strokeWidth: 4,
			stroke: "#fff", // null or color by hex/rgba
		},
		tooltip: {
			show: true,
			backgroundColor: "rgba(240, 242, 255, 0.8)",
			fontColor: "#000000",
			object: null,
		},
	};
	chart = new liteChart("weekly-chart", settings);

	// Inject chart into DOM object
	let container = document.getElementById("week-stat__chart");
	chart.inject(container);

	// Set labels
	chart.setLabels(labels);

	// Set legends and values
	chart.addLegend({
		"name": "Выполнено задач",
		"stroke": "#5FC569",
		"fill": "#fff",
		"values": valuesDone
	});
	chart.addLegend({
		"name": "Не выполнено задач",
		"stroke": "#F86A6A",
		"fill": "#fff",
		"values": valuesFailed
	});

	// Draw
	chart.draw();
	delete chart;
}

$('#periods_stat.custom-options').click(function (e) {
	setDataForWeeklyChart();
})

// функции и события для запполнения данными компоненты пункта меню - ОСНОВНОЕ











function GetTasks() {

	let period = getValueSelect('date-filter'),
		idProject = getValueSelect('projects-filter'),
		idTarget = getValueSelect('targets-filter'),
		status = getValueSelect('status-filter'),
		executor = getValueSelect('executors-filter');

	//console.log(period, idProject, idTarget, status, executor);

	$.ajax({
		url: 'php/blocks/tasks/getTasks.php',
		type: 'POST',
		dataType: 'json',
		data: {
			period: period,
			project: idProject,
			target: idTarget,
			status: status,
			executor: executor
		},
		success(data) {
			if (data.status == true) {
				//$('.task-data').text(data.sql);
				$('.task-list').html(data.tasks);
			} else {
				$('.task-list').html('<div class="data-not-found flex f-col"><svg width="30" height="30" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="data-not-found__icon"><path d="M10 19C14.9706 19 19 14.9706 19 10C19 5.02944 14.9706 1 10 1C5.02944 1 1 5.02944 1 10C1 14.9706 5.02944 19 10 19Z" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M10 6.3999V9.9999" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M10 13.6001H10.01" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg><p class="data-not-found__text text">Данные не найдены</p></div>');
				//$('.task-data').text(data.message + '   -------------   ' + data.sql);
			}
		}
	});
}










// функции и события для работы с МОДАЛЬНЫМИ ОКНАМИ

function showModal(modal, close) {

	var wrapp = $('.wrapp-modal');
	var modalWindow = $('.' + $(modal).attr('id'));

	wrapp.toggleClass('hide');
	if (close == true) {
		$('.modal-window').toggleClass('show');
	}
	else {
		modalWindow.toggleClass('show');
	}
};

$('#add-task').click(function () {
	showModal(this);

	iniSelect('projects-task');

	let idProject = getValueSelect('projects-task');
	SetSelectTargets(idProject, 'targets-task', 'executors-task');
	getExecutors(idProject, 'executors-task');
	
	//console.log(idProject);

	$.ajax({
		url: 'php/getTargets.php',
		type: 'POST',
		dataType: 'html',
		data: {
			project: idProject
		},
		success(data) {
			setDatasSelect('targets-task', data);
		}
	});

	iniSelect('durations-task');
})

$('.head__btn-close').click(function () {
	showModal(this, true);
})

$('input.add-task').keyup(function (event) {
	if (event.keyCode == 13) {

		let text = this.value,
			date = $('.date-picker__date').val().split('.');
			idTarget = getValueSelect('targets-task'),
			duration = getValueSelect('durations-task');

		if (!$('.executors-task').parents('.custom-select-wrapper').hasClass('hide')) {
			executor = getValueSelect('executors-task');
		}
		else {
			executor = 0;
		}

		if (date != '') {

			if (text.length != 0) {
				$('.modal-window__message').addClass('hide');

				$.ajax({
					url: 'php/blocks/tasks/addTask.php',
					type: 'POST',
					dataType: 'json',
					data: {
						text: text,
						date: date,
						target: idTarget,
						duration: duration,
						executor: executor
					},
					success(data) {
						if (data.status == true) {
							showNotification('Задача добавлена!');
						}
						else {
							alert(data.message);
						}
					}
				});
			}
			else {
				$('.modal-window__message').removeClass('hide').html('<svg class="icon-mess error" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 19C14.9706 19 19 14.9706 19 10C19 5.02944 14.9706 1 10 1C5.02944 1 1 5.02944 1 10C1 14.9706 5.02944 19 10 19Z" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M10 6.3999V9.9999" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M10 13.6001H10.01" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg> Введите текст задачи...');
			}
		}
		else { // если дата не выбрана, то отображается уведомление
			$('.modal-window__message').removeClass('hide').html('<svg class="icon-mess error" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 19C14.9706 19 19 14.9706 19 10C19 5.02944 14.9706 1 10 1C5.02944 1 1 5.02944 1 10C1 14.9706 5.02944 19 10 19Z" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M10 6.3999V9.9999" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M10 13.6001H10.01" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg> Не выбрана дата');
		}
	}
});

// функции и события для работы с модальными окнами












// функции и события для ВЫПАДАЮЩЕГО МЕНЮ ПОЛЬЗОВАТЕЛЯ

$('.user-panel-wrapper').on('click', function (e) {
	if (!($(e.target).parents('.user-menu').length == 1)) {
		$(this).toggleClass('active');
		$('.user-menu').toggleClass('active');
	}
});

$('.user-menu').on('mouseleave', function (e) {
	$('.user-menu').toggleClass('active');
	$('.user-panel-wrapper').toggleClass('active');
});

// функции и события для ВЫПАДАЮЩЕГО МЕНЮ ПОЛЬЗОВАТЕЛЯ














// функции для работы с выпадающими списками

$('.custom-options.projects').click(function () {

	let id_select_projects = $(this).attr('id');
	idProject = getValueSelect(id_select_projects);

	if (id_select_projects == 'projects-task') {
		SetSelectTargets(idProject, 'targets-task', 'executors-task');
		getExecutors(idProject, 'executors-task');
	}
	else if (id_select_projects == 'projects-filter') {
		SetSelectTargets(idProject, 'targets-filter', 'executors-filter');
		getExecutors(idProject, 'executors-filter');
		//GetTasks();
	}
})

$('.custom-options.targets').click(function () {
	let id_select_targets = $(this).attr('id');

	if (id_select_targets == 'targets-filter') {
		GetTasks();
	}
})

$('.custom-options.date').click(function () {
	GetTasks();
})

$('.custom-options.status').click(function () {
	GetTasks();
})

$('.custom-options.executors').click(function () {
	GetTasks();
})

function SetSelectProjects(selectProjects) {
	var idProject = getValueSelect(selectProjects);

	if ($(this).hasClass(selectProjects)) {
		SetSelectTargets(idProject, 'targets-task', 'executors-task');
	}
	else if ($(this).hasClass(selectProjects)) {
		SetSelectTargets(idProject, 'targets-filter', 'executors-filter');
	}
}

function SetSelectTargets(idProject, selectTargets, selectExecutors) {
	if (idProject != 0) {
		$.ajax({
			url: 'php/getTargets.php',
			type: 'POST',
			dataType: 'html',
			data: {
				project: idProject
			},
			success(data) {
				setDatasSelect(selectTargets, data);
			}
		});

	}
	else {
		setDatasSelect(selectTargets, GetDefaultValueSelect('Все цели'));
	}

	//getExecutors(idProject, 'executors-filter');
}

function getExecutors(idProject, selectExecutors) {

	//console.log(1);

	$.ajax({
		url: 'php/getExecutor.php',
		type: 'POST',
		dataType: 'json',
		data: {
			project: idProject
		},
		success(data) {
			if (data.status == true) {
				setDatasSelect(selectExecutors, data.rows);
				$('.' + selectExecutors).parents('.custom-select-wrapper').removeClass('hide');
			}
			else {
				setDatasSelect(selectExecutors, GetDefaultValueSelect('Все исполнители'));
				$('.' + selectExecutors).parents('.custom-select-wrapper').addClass('hide');
			}

			GetTasks();
		}
	});
}

// функции для работы с выпадающими списками


function GetDefaultValueSelect(string) {
	return '<span class="custom-option undefined" data-value="0">' + string + '</span>';
}

















// функции и события для ОПЕРАЦИЙ С ПОЛЬЗОВАТЕЛЯМИ

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

// функции и события для ОПЕРАЦИЙ С ПОЛЬЗОВАТЕЛЯМИ































// реализация раскрывающегося списка целей для проектов

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