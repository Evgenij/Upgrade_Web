// глобальные переменные

var chart, datepicker,
	taskSelection = 0,
	projectSelection = 0,
	targetSelection = 0,
	wrapp = $('.wrapp-modal');

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
	iniSelect('date-filter', 0);
	iniSelect('status-filter');
	iniSelect('projects-filter');

	//SetSelectProjects('projects-filter');
	let idProject = getValueSelect('projects-filter');

	iniSelect('executors-filter');
	SetSelectTargets(idProject, 'targets-filter');

	GetTasks();

	iniSelect('user-select', null, true);
})

$('li[value=\"tab-3\"]').click(function () {
	GetProjects();
	GetTargets();
})















// события для работы с задачами

$(document).on('click', '.task-block', function (e) {

	let currentId = $(this).attr('id')
	taskSelection = currentId;
	
	if (!$(e.target).hasClass('rect')) {
		if ($(this).hasClass('selection')) {
			$(this).removeClass('selection');
			$('.task-data__message').removeClass('hide');
			$('.task-data__information').addClass('hide');
		} else {
			$('.task-block').removeClass('selection');
			$(this).addClass('selection');

			$('.task-data__message').addClass('hide');
			$('.task-data__information').removeClass('hide');

			//console.log(taskSelection);

			$.ajax({
				url: '/php/blocks/tasks/getDataTask.php',
				type: 'GET',
				dataType: 'json',
				data: {
					idTask: currentId
				},
				success(data) {
					if (data.status == true) {

						SetDataTask(data.idProject, data.idTarget,
							data.taskDur, data.taskText, data.taskDescr,
							data.taskStatus, data.checkExecutor, data.executors, data.idExecutor);

					} else {
						$('.task-data').text(data.message);
					}
				}
			});
		}
	}
	else {
		if ($(this).find('input').is(':checked')) {
			ChangeStatusTask(false);
		} else {
			ChangeStatusTask();
		}

		GetTasks();
	}
})



$(document).on('click', '.project-block', function (e) {

	let currentId = $(this).attr('id')
	projectSelection = currentId;

	if ($(this).hasClass('selection')) {
		$(this).removeClass('selection');
	} else {
		$('.project-block').removeClass('selection');
		$(this).addClass('selection');
	}
})




function getFilesTask() {
	//var idTask = $('.task-block.selection').attr('id');

	$.ajax({
		url: '/php/blocks/tasks/getFilesTask.php',
		type: 'GET',
		dataType: 'json',
		data: {
			idTask: taskSelection
		},
		success(data) {
			if (data.status == true) {
				if (data.checkFiles == true) {
					$('.task-content__attachments').find('.uploaded-files').removeClass('hide');
					$('.task-content__attachments').find('.uploaded-files').html(data.files);
				} else {
					$('.task-content__attachments').find('.uploaded-files').addClass('hide');
				}
			} else {
				$('.task-content__attachments').find('.uploaded-files').empty();
				$('.task-content__attachments').find('.uploaded-files').text(data.message);
			}
		}
	})
}

function getSubtasksTask() {
	$.ajax({
		url: '/php/blocks/tasks/getSubtasksTask.php',
		type: 'GET',
		dataType: 'json',
		data: {
			idTask: taskSelection
		},
		success(data) {
			if (data.checkSubtasks == true) {
				$('.task-content__progress').removeClass('hide');
			}
			else {
				$('.task-content__progress').addClass('hide');
			}
			$('.task-content__progress').find('.progress-label').html(data.countDoneSubtasks + '<span class="count-subtask text regular">/' + data.countSubtasks + '</span>');
			$('.task-content__progress').find('.progress-bar__current').css({ 'width': + data.progress + '%' });
			$('.task-content__progress').find('.subtasks-list').html(data.subtasks);
		}
	})
}

function SetDataTask(idProject, idTarget,
	duration, text, description,
	status, executor, executors, idExecutor) {
	
	iniSelect('projects-task-data', idProject);
	SetSelectTargets(idProject, 'targets-task-data', idTarget);
	iniSelect('durations-task-data', duration);

	$('.task-content__text').text(text);
	$('.task-content__description').text(description);

	ChangeButtonTask(status);
	getSubtasksTask();

	if (executor == true) {
		$('.task-data__footer').removeClass('hide');
		$('.task-data__footer').find('select.user-select').html(executors);
		SetDatasSelect('user-select', executors, idExecutor, true);
	} else {
		$('.task-data__footer').addClass('hide');
	}

	getFilesTask();
}




















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
				SetSelectionTask(taskSelection);
			} else {
				$('.task-list').html('<div class="data-not-found flex f-col"><svg width="30" height="30" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="data-not-found__icon"><path d="M10 19C14.9706 19 19 14.9706 19 10C19 5.02944 14.9706 1 10 1C5.02944 1 1 5.02944 1 10C1 14.9706 5.02944 19 10 19Z" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M10 6.3999V9.9999" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M10 13.6001H10.01" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg><p class="data-not-found__text text">Данные не найдены</p></div>');
				//$('.task-data').text(data.message + '   -------------   ' + data.sql);
			}
		}
	});
}

function ChangeTaskData() {
	let idProject = getValueSelect('projects-task-data'),
		idTarget = getValueSelect('targets-task-data'),
		duration = getValueSelect('durations-task-data'),
		text = $('.task-content__text').val(),
		description = $('.task-content__description').val();

	if ($('.task-data__footer').hasClass('hide')) {
		executor = 0;
	} else {
		executor = getValueSelect('user-select');
	}

	// console.log('proj = ' + idProject, 'targ = ' + idTarget,
	// 	'dur = ' + duration, 'exec = ' + executor,
	// 	'text = ' + text, 'descr = ' + description);

	$.ajax({
		url: '/php/blocks/tasks/changeDataTask.php',
		type: 'GET',
		dataType: 'json',
		data: {
			idTask: taskSelection,
			idProject: idProject,
			idTarget: idTarget,
			duration: duration,
			executor: executor,
			text: text,
			description: description
		},
		success(data) {
			if (data.status == true) {
				GetTasks();
			} else {
				//alert(data.message);
			}
		}
	});
}


function SetSelectionTask(idTask) {
	if (idTask != 0) {
		$('.task-block[id=' + idTask + ']').addClass('selection');
	} else {
		return;
	}
}
















function GetProjects() {
	$.ajax({
		url: '/php/blocks/projects/getProjects.php',
		type: 'POST',
		dataType: 'json',
		success(data) {
			if (data.status == true) {
				$('.projects-list').html(data.blocksProject);
			} else {
				$('.projects-list').html('<div class="data-not-found flex f-col"><svg width="30" height="30" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="data-not-found__icon"><path d="M10 19C14.9706 19 19 14.9706 19 10C19 5.02944 14.9706 1 10 1C5.02944 1 1 5.02944 1 10C1 14.9706 5.02944 19 10 19Z" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M10 6.3999V9.9999" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M10 13.6001H10.01" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg><p class="data-not-found__text text">Данные не найдены</p></div>');
				//$('.projects-list').text(data.message);
			}
		}
	});
}

function GetTargets() {
	$.ajax({
		url: '/php/blocks/targets/getTargets.php',
		type: 'POST',
		dataType: 'json',
		success(data) {
			if (data.status == true) {
				$('.targets-list').html(data.blocksTarget);
			} else {
				$('.targets-list').html('<div class="data-not-found flex f-col"><svg width="30" height="30" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="data-not-found__icon"><path d="M10 19C14.9706 19 19 14.9706 19 10C19 5.02944 14.9706 1 10 1C5.02944 1 1 5.02944 1 10C1 14.9706 5.02944 19 10 19Z" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M10 6.3999V9.9999" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M10 13.6001H10.01" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg><p class="data-not-found__text text">Данные не найдены</p></div>');
				//$('.projects-list').text(data.message);
			}
		}
	});
}




















$('#btn-task-done').click(function () {
	if ($(this).hasClass('completed')) {
		ChangeStatusTask(false);
	} else {
		ChangeStatusTask();
	}
})












// события для работы с подзадачами

$('.add-subtasks').click(function () {
	$('.task-content__progress').removeClass('hide');
})

$(document).on('click', '.btn-subtask-add', function () {
	let text = $(this).siblings('input').val();
	if (text.length != 0) {
		$(this).parents('.subtask-block-add').siblings('.subtasks-list').append('<div class="subtask list-ver__item flex" id="0"><div class= "btn-subtask-delete" ></div><label class="task-status flex text"><input type="checkbox" name="checkbox_status" id="checkbox_status" class="checkbox_status" unchecked=""><div class="rect"></div><div class="subtask-text">' + text + '</div></label></div>');
		ChangeCountSubtask();
		AddSubtask(text);
		$(this).siblings('input').val('');
	}
})

$(document).on('click', '.btn-subtask-delete', function () {
	$(this).parents('.subtask').remove();

	ChangeDataTaskProgress();
	DeleteSubtask($(this));

})

$(document).on('click', '.subtask', function () {
	if (!$(this).hasClass('subtask-block-add')) {
		//let countSubtasks = $('.task-content__progress').find('.count-subtask').text().replace('/','');
		//alert(countSubtasks);
		ChangeDataTaskProgress();
		ChangeStatusSubtask($(this));
		//console.log();
		//SetDataTask1($('.task-block.selection').attr('id'));
	}
})

function ChangeDataTaskProgress() {
	ChangeCountDoneSubtask();
	ChangeCountSubtask();
	ChangeProgress();
}

function ChangeCountSubtask() {
	let countSubtasks = $('.subtask').length - 1;
	$('.task-content__progress').find('.count-subtask').text('/' + countSubtasks);
}

function ChangeCountDoneSubtask() {
	let countDoneSubtasks = $('.subtask').find("input[type='checkbox']:checked").length;
	$('.task-content__progress').find('.progress-label').html(countDoneSubtasks + '<span class="count-subtask text regular"></span>');
	
}

function ChangeProgress() {
	let countDoneSubtasks = $('.subtask').find("input[type='checkbox']:checked").length;
	let countSubtasks = $('.subtask').length - 1;

	let progress = 0;
	if (countSubtasks != 0) {
		progress = (countDoneSubtasks * 100) / countSubtasks;
	}

	$('.task-content__progress').find('.progress-bar__current').css({ 'width': progress + "%" });
	
	//console.log(progress);
	
	if (progress == 100) {
		ChangeStatusTask(true);
	}
	else {
		ChangeStatusTask(false);
	}
}

function AddSubtask(text) {
	var idTask = $('.task-block.selection').attr('id');

	$.ajax({
		url: '/php/blocks/tasks/subtasks/addSubtask.php',
		type: 'GET',
		dataType: 'json',
		data: {
			idTask: idTask,
			text: text
		},
		success(data) {
			if (data.status == false) {
				alert(data.message);
			} else {
				GetTasks();
				getSubtasksTask();
			}
		}
	})
}

function DeleteSubtask(subtask) {
	var idSubtask = $(subtask).parents('.subtask').attr('id');

	$.ajax({
		url: '/php/blocks/tasks/subtasks/deleteSubtask.php',
		type: 'GET',
		dataType: 'json',
		data: {
			idSubtask: idSubtask
		},
		success(data) {
			if (data.status == false) {
				alert(data.message);
			} else {
				GetTasks();
			}
		}
	})
}

function ChangeStatusSubtask(subtask) {
	//console.log(subtask);
	var status = 0,
		idSubtask = $(subtask).attr('id');

	if($(subtask).find('.checkbox_status').is(':checked')){
		status = 1;
	} else {
		status = 0;
	}

	$.ajax({
		url: '/php/blocks/tasks/subtasks/changeStatus.php',
		type: 'GET',
		dataType: 'json',
		data: {
			idSubtask: idSubtask,
			status: status
		},
		success(data) {
			if (data.status == false) {
				alert(data.message);
			} else {
				GetTasks();
			}
		}
	})
}

function ChangeButtonTask(taskStatus) {
	if (taskStatus == true) {
		$('#btn-task-done').addClass('completed').text('Выполнено');
	} else {
		$('#btn-task-done').removeClass('completed').text('Выполнить');
	}
}

function ChangeStatusTask(status = true) {

	ChangeButtonTask(status);

	if (status == true) {
		statusTask = 1;
	} else {
		statusTask = 0;
	}

	$.ajax({
		url: '/php/blocks/tasks/changeStatus.php',
		type: 'GET',
		dataType: 'json',
		data: {
			idTask: taskSelection,
			status: statusTask
		},
		success(data) {
			if (data.status == true) {
				GetTasks();
			} else {
				alert(data.message);
			}
		}
	})
}

$('.delete-task').click(function () {

	$.ajax({
		url: '/php/blocks/tasks/deleteTask.php',
		type: 'GET',
		dataType: 'json',
		data: {
			idTask: taskSelection
		},
		success(data) {
			if (data.status == true) {
				GetTasks();
			} else {
				alert(data.message);
			}
		}
	})
})

























// функции для работы с выпадающим списком

function getValueSelect(select) {
	return $('.custom-options#' + select).find(".custom-option.selection").data("value");
}

function iniSelect(select, id, user = false) {

	if (id != null) {
		SelectOption(select, id);
	} else {
		//console.log(select, id);
		$('.custom-options#' + select).find('.custom-option:first').addClass('selection');
	}

	if (user == false) {
		$('.custom-select-trigger#' + select).text($('.custom-options#' + select).find('.custom-option.selection').text());
	} else {
		let data = $('.custom-options#' + select).find('.custom-option.selection').html();
		$('.custom-select-trigger#' + select).html(data);
	}
}

function SetDatasSelect(select, data, id, user=false) {
	$('.custom-options#' + select).html(data);
	iniSelect(select, id, user);
}

function SelectOption(select, id) {
	$('.custom-options#' + select).find('.custom-option').removeClass('selection');
	$('.custom-options#' + select).find('.custom-option[data-value=' + id + ']').addClass('selection');
}

// функции для работы с выпадающим списком
























// функции и события общего назначения

// вывод всплывающего сообщения
function showNotification(text) {

	$('.notification').text(text).slideDown(500);

	setTimeout(() => {
		$('.notification').fadeOut(500);
	}, 2000);
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















// функции и события для работы с МОДАЛЬНЫМИ ОКНАМИ

function showModal(modal, change = false) {
	
	var modalWindow = $('.modal-window.' + $(modal).attr('id'));

	if (modalWindow.hasClass('add-project')) {
		if (change == false) {
			modalWindow.find('.head__title').text('Создание проекта');
			modalWindow.find('input').val('');
			modalWindow.find('textarea').val('');
		} else {
			modalWindow.find('.head__title').text('Изменение проекта');
		}
	} else if (modalWindow.hasClass('add-target')) {
		if (change == false) {
			modalWindow.find('.head__title').text('Создание цели');
			modalWindow.find('input').val('');
			modalWindow.find('textarea').val('');
			modalWindow.find('.select-activity[data!="default-select"]').detach();
		} else {
			modalWindow.find('.head__title').text('Изменение цели');
		}
	}

	wrapp.toggleClass('hide');
	modalWindow.addClass('show');
};

function closeModal(modal) {
	var wrapp = $('.wrapp-modal');
	wrapp.toggleClass('hide');
	modal.removeClass('show');
}





$('.head__btn-close').click(function () {
	closeModal($(this).parents('.modal-window'));
	$(this).parents('.modal-window').removeClass('change-data');
})


$('#add-task').click(function () {
	showModal(this);

	iniSelect('projects-task');

	let idProject = getValueSelect('projects-task');
	SetSelectTargets(idProject, 'targets-task');
	getExecutors(idProject, 'executors-task');

	iniSelect('durations-task');
})

$('#add-project').click(function () {
	showModal(this);
	GetUserColors($('.modal-window.add-project'));
})

$('#add-target').click(function () {
	showModal(this);
	GetUserColors($('.modal-window.add-target'));
	iniSelect('projects-target');
	iniSelect('activities-target-1');
	//$(".custom-select-wrapper#activities-target").clone().appendTo(".wrapp");
})

$('#add-team-act').click(function () {
	let classLastSelect = $("select.activities-target").filter(':last').attr('id');
	let idNewSelect = parseInt(classLastSelect.match(/\d+/)) + 1;
	
	$('<div class="wrapper-teams__item select-activity" data="temp-' + idNewSelect + '"><div class= "custom-select-wrapper"><select id="activities-target-' + idNewSelect + '" class="custom-select activities-target activities text"><option value="1">Маркетинг</option><option value="2">Web-разработка</option><option value="3">Web - дизайн</option><option value="4">UI/UX дизайн</option><option value="5">Frontend</option><option value="6">Backend</option><option value="7">SEO</option><option value="8">SMM</option><option value="9">Реклама</option><option value="10">Аналитика</option><option value="11">Логистика</option><option value="12">Менеджмент</option><option value="13">Финансы</option><option value="14">Планирование</option></select><div class="custom-select activities-target activities text"><span class="custom-select-trigger custom-select activities-target activities text" id="activities-target-' + idNewSelect + '">Маркетинг</span><div class="custom-options custom-select activities-target activities text" id="activities-target-' + idNewSelect +'"><span class="custom-option undefined selection" data-value="1">Маркетинг</span><span class="custom-option undefined" data-value="2">Web-разработка</span><span class="custom-option undefined" data-value="3">Web - дизайн</span><span class="custom-option undefined" data-value="4">UI/UX дизайн</span><span class="custom-option undefined" data-value="5">Frontend</span><span class="custom-option undefined" data-value="6">Backend</span><span class="custom-option undefined" data-value="7">SEO</span><span class="custom-option undefined" data-value="8">SMM</span><span class="custom-option undefined" data-value="9">Реклама</span><span class="custom-option undefined" data-value="10">Аналитика</span><span class="custom-option undefined" data-value="11">Логистика</span><span class="custom-option undefined" data-value="12">Менеджмент</span><span class="custom-option undefined" data-value="13">Финансы</span><span class="custom-option undefined" data-value="14">Планирование</span></div></div></div><div class="btn-delete-act"></div></div>').insertBefore($(".wrapper-teams").find('.button'));
	$('.custom-options#activities-target').attr('id', 'activities-target-' + idNewSelect);
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
							GetTasks();
						}
						else {
							alert(data.message);
						}
					}
				});
			}
			else {
				$('.add-task').find('.modal-window__message').removeClass('hide').html('<svg class="icon-mess error" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 19C14.9706 19 19 14.9706 19 10C19 5.02944 14.9706 1 10 1C5.02944 1 1 5.02944 1 10C1 14.9706 5.02944 19 10 19Z" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M10 6.3999V9.9999" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M10 13.6001H10.01" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg> Введите текст задачи...');
			}
		}
		else { // если дата не выбрана, то отображается уведомление
			$('.add-task').find('.modal-window__message').removeClass('hide').html('<svg class="icon-mess error" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 19C14.9706 19 19 14.9706 19 10C19 5.02944 14.9706 1 10 1C5.02944 1 1 5.02944 1 10C1 14.9706 5.02944 19 10 19Z" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M10 6.3999V9.9999" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M10 13.6001H10.01" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg> Не выбрана дата');
		}
	}
});

$('input').keyup(function (event) {
	if (event.keyCode == 13) {
		if ($(this).hasClass('add-project')) {
			if (!$(this).parents('.modal-window').hasClass('change-data')) {
				AddProject();
			} else {
				ChangeProject();
			}
		} else if ($(this).hasClass('add-target')) {
			if (!$(this).parents('.modal-window').hasClass('change-data')) {
				AddTarget();
			} else {
				ChangeTarget();
			}
		}
	}
});
$('textarea').keyup(function (event) {
	if (event.keyCode == 13) {
		if ($(this).hasClass('add-project')) {
			if (!$(this).parents('.modal-window').hasClass('change-data')) {
				AddProject();
			} else {
				ChangeProject();
			}
		} else if ($(this).hasClass('add-target')) {
			if (!$(this).parents('.modal-window').hasClass('change-data')) {
				AddTarget();
			} else {
				ChangeTarget();
			}
		}
	}
});



function AddProject() {
	let name = $('input.add-project').val(),
		descr = $('textarea.add-project').val(),
		mark = $('input.color_status:checked').siblings('.color-rect').css("background-color");

	if (name.length != 0) {
		$('.modal-window__message').addClass('hide');

		$.ajax({
			url: '/php/blocks/projects/addProject.php',
			type: 'POST',
			dataType: 'json',
			data: {
				name: name,
				descr: descr,
				mark: rgb_to_hex(mark)
			},
			success(data) {
				if (data.status == true) {
					showNotification('Проект добавлен!');
					GetProjects();
				}
				else {
					alert(data.message);
				}
			}
		});
	}
	else {
		$('.add-project').find('.modal-window__message.error').removeClass('hide').html('<svg class="icon-mess error" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 19C14.9706 19 19 14.9706 19 10C19 5.02944 14.9706 1 10 1C5.02944 1 1 5.02944 1 10C1 14.9706 5.02944 19 10 19Z" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M10 6.3999V9.9999" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M10 13.6001H10.01" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg> Введите название проекта');
	}
}

function ChangeProject() {

	let name = $('input.add-project').val(),
		descr = $('textarea.add-project').val(),
		mark = $('input.color_status:checked').siblings('.color-rect').css("background-color");

	$.ajax({
		url: '/php/blocks/projects/changeDataProject.php',
		type: 'GET',
		dataType: 'json',
		data: {
			idProject: projectSelection,
			name: name,
			descr: descr,
			mark: rgb_to_hex(mark)
		},
		success(data) {
			if (data.status == true) {
				GetProjects();
				GetTargets();
			} else {
				alert(data.message);
			}
		}
	});
}





function AddTarget() {
	let idProject = getValueSelect('projects-target'),
		name = $('input.add-target').val(),
		descr = $('textarea.add-target').val(),
		mark = $('input.color_status:checked').siblings('.color-rect').css("background-color");

	let teams = [];
	for (let index = 1; index <= $("select.activities-target").length; index++) {
		teams.push(getValueSelect('activities-target-'+index));
	}

	if (name.length != 0) {
		$('.modal-window__message').addClass('hide');

		$.ajax({
			url: '/php/blocks/targets/addTarget.php',
			type: 'POST',
			dataType: 'json',
			data: {
				idProject: idProject,
				teams: teams,
				name: name,
				descr: descr,
				mark: rgb_to_hex(mark)
			},
			success(data) {
				if (data.status == true) {
					showNotification('Цель добавлена!');
					GetTargets();
				}
				else {
					alert(data.message);
				}
			}
		});
	}
	else {
		$('.add-target').find('.modal-window__message.error').removeClass('hide').html('<svg class="icon-mess error" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 19C14.9706 19 19 14.9706 19 10C19 5.02944 14.9706 1 10 1C5.02944 1 1 5.02944 1 10C1 14.9706 5.02944 19 10 19Z" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M10 6.3999V9.9999" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M10 13.6001H10.01" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg> Введите название цели');
	}
}

function ChangeTarget() {
	let idProject = getValueSelect('projects-target'),
		name = $('input.add-target').val(),
		descr = $('textarea.add-target').val(),
		mark = $('input.color_status:checked').siblings('.color-rect').css("background-color");

	let activities = [], teams = [], newTeams = [];
	for (let index = 1; index <= $("select.activities-target").length; index++) {
		activities.push(getValueSelect('activities-target-' + index));
	}
	$('.modal-window.add-target').find('.select-activity').each(function (index, el) {
		if ($(el).attr('data')) {
			console.log(index);
			if ($(el).attr('data') == 'default-select') {
				teams.push(getValueSelect('activities-target-' + index));
			} else {
				newTeams.push(getValueSelect('activities-target-' + index));
			}
		} else {
			//$(el).attr('id');
			console.log(index);
			teams.push(getValueSelect('activities-target-' + index));
		}
	});
	console.log("current-teams");
	console.log(teams);
	console.log("new-teams");
	console.log(newTeams);
	// for (let index = 1; index <= $('.modal-window.add-target').find('.select-activity').length; index++) {
	// 	teams.push(getValueSelect('activities-target-temp' + index));
	// }
	// teamsSelect = $('.modal-window.add-target').find('.select-activity[id]');
	// console.log(teamsSelect);
	
	// $.ajax({
	// 	url: '/php/blocks/targets/changeDataTarget.php',
	// 	type: 'GET',
	// 	dataType: 'json',
	// 	data: {
	// 		idTarget: targetSelection,
	// 		idProject: idProject,
	// 		name: name,
	// 		descr: descr,
	// 		mark: rgb_to_hex(mark),
	// 		activities: activities
	// 	},
	// 	success(data) {
	// 		if (data.status == true) {
	// 			GetTargets();
	// 		} else {
	// 			alert(data.message);
	// 		}
	// 	}
	// });
}

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
		SetSelectTargets(idProject, 'targets-task');
		getExecutors(idProject, 'executors-task');
	}
	else if (id_select_projects == 'projects-filter') {
		SetSelectTargets(idProject, 'targets-filter');
		getExecutors(idProject, 'executors-filter');
	}
	else if (id_select_projects == 'projects-task-data') {
		SetSelectTargets(idProject, 'targets-task-data');
		ChangeTaskData();
	}
})

$('.custom-options.targets').click(function () {
	let id_select_targets = $(this).attr('id');

	if (id_select_targets == 'targets-filter') {
		GetTasks();
	} else if (id_select_targets == 'targets-task-data') {
		ChangeTaskData();
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

$('.custom-options.durations').click(function () {
	let id_select_durations = $(this).attr('id');

	if (id_select_durations == 'durations-task-data') {
		ChangeTaskData();
	}
})

function SetSelectProjects(selectProjects) {
	var idProject = getValueSelect(selectProjects);

	if ($(this).hasClass(selectProjects)) {
		SetSelectTargets(idProject, 'targets-task');
	}
	else if ($(this).hasClass(selectProjects)) {
		SetSelectTargets(idProject, 'targets-filter');
	}
}

function SetSelectTargets(idProject, selectTargets, id) {
	if (idProject != 0) {
		$.ajax({
			url: 'php/getTargets.php',
			type: 'POST',
			dataType: 'html',
			data: {
				project: idProject
			},
			success(data) {
				SetDatasSelect(selectTargets, data, id);
			}
		});
	}
	else {
		SetDatasSelect(selectTargets, GetDefaultValueSelect('Все цели'));
	}
	//getExecutors(idProject, 'executors-filter');
}

function getExecutors(idProject, selectExecutors) {

	//console.log(idProject);

	$.ajax({
		url: '/php/getExecutor.php',
		type: 'POST',
		dataType: 'json',
		data: {
			project: idProject
		},
		success(data) {
			if (data.status == true) {
				SetDatasSelect(selectExecutors, data.rows);
				$('.' + selectExecutors).parents('.custom-select-wrapper').removeClass('hide');
			}
			else {
				SetDatasSelect(selectExecutors, GetDefaultValueSelect('Все исполнители'));
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




















$(document).on('click', '.delete-data-block', function () {
	let parent = $(this).parents('.data-block');
	let idBlock = parent.attr('id');
	
	if (parent.hasClass('project-block')) {
		$.ajax({
			url: '/php/blocks/projects/deleteProject.php',
			type: 'GET',
			dataType: 'json',
			data: {
				idProject: idBlock
			},
			success(data) {
				if (data.status == true) {
					GetProjects();
					GetTargets();
				}
			}
		});
	}
})

$(document).on('click', '.change-data-block', function () {
	let parent = $(this).parents('.data-block');
	let idBlock = parent.attr('id');

	if (parent.hasClass('project-block')) {
		projectSelection = idBlock;
		ShowModalChange(idBlock, 'add-project');
	} else if (parent.hasClass('target-block')) {
		targetSelection = idBlock;
		ShowModalChange(idBlock, 'add-target');
	}
})

$(document).on('click', '.btn-delete-color', function () {
	let parent = $(this).parents('.color-block');
	let idBlock = parent.attr('id');

	$.ajax({
		url: '/php/vendor/deleteColor.php',
		type: 'GET',
		dataType: 'json',
		data: {
			id: idBlock
		},
		success(data) {
			if (data.status == true) {
				parent.remove();
				GetUserColors($('.modal-window.add-project'));
			}
		}
	});
})


$(document).on('click', '.btn-delete-act', function () {
	let parent = $(this).parents('.select-activity');
	let idBlock = parent.attr('id');

	if (!idBlock.includes('temp')) { // если id установлен
		$.ajax({
			url: '/php/blocks/teams/deleteTeam.php',
			type: 'GET',
			dataType: 'json',
			data: {
				id: idBlock
			},
			success(data) {
				if (data.status == true) {
					parent.remove();
					//GetUserColors($('.add-project'));
				}
			}
		});
	} else { // если атрибут id отсутствует
		parent.remove();
	}

	
})















function ShowModalChange(idBlock, modal) {
	$('.modal-window.' + modal).addClass('change-data');

	if (modal == 'add-project') {
		$.ajax({
			url: '/php/blocks/projects/getDataProject.php',
			type: 'GET',
			dataType: 'json',
			data: {
				id: idBlock
			},
			success(data) {
				if (data.status == true) {
					$('.modal-window.' + modal).find('.name-project').val(data.name);
					$('.modal-window.' + modal).find('.descr-project').val(data.descr);

					showModal('#'+modal, true);
					GetUserColors($('.modal-window.add-project'));
				}
			}
		});
	} else if (modal == 'add-target') {

		// удаление всех выпадающих списков кроме первого во 
		// избежание накопления создаваемых списков при открытии 
		// модального окна на изменение
		$('.modal-window.'+modal).find('.select-activity[data!="default-select"]').detach();

		$.ajax({
			url: '/php/blocks/targets/getDataTarget.php',
			type: 'GET',
			dataType: 'json',
			data: {
				id: idBlock
			},
			success(data) {
				if (data.status == true) {
					$('.modal-window.' + modal).find('.name-target').val(data.name);
					$('.modal-window.' + modal).find('.descr-target').val(data.descr);
					iniSelect('projects-target', data.idProject);

					if (data.teams.length >= 2) {
						iniSelect('activities-target-1', data.activities[0]);
						$('.modal-window.' + modal).find('.select-activity:first-child').attr('id', data.teams[0]);
						
						for (let i = 1; i < data.activities.length; i++) {
							
							$('<div class="wrapper-teams__item select-activity" id="' + data.teams[i] + '"><div class= "custom-select-wrapper"><select id="activities-target-' + data.activities[i] + '" class="custom-select activities-target activities text"><option value="1">Маркетинг</option><option value="2">Web-разработка</option><option value="3">Web - дизайн</option><option value="4">UI/UX дизайн</option><option value="5">Frontend</option><option value="6">Backend</option><option value="7">SEO</option><option value="8">SMM</option><option value="9">Реклама</option><option value="10">Аналитика</option><option value="11">Логистика</option><option value="12">Менеджмент</option><option value="13">Финансы</option><option value="14">Планирование</option></select><div class="custom-select activities-target activities text"><span class="custom-select-trigger custom-select activities-target activities text" id="activities-target-' + data.activities[i] + '">Маркетинг</span><div class="custom-options custom-select activities-target activities text" id="activities-target-' + data.activities[i] +'"><span class="custom-option undefined selection" data-value="1">Маркетинг</span><span class="custom-option undefined" data-value="2">Web-разработка</span><span class="custom-option undefined" data-value="3">Web - дизайн</span><span class="custom-option undefined" data-value="4">UI/UX дизайн</span><span class="custom-option undefined" data-value="5">Frontend</span><span class="custom-option undefined" data-value="6">Backend</span><span class="custom-option undefined" data-value="7">SEO</span><span class="custom-option undefined" data-value="8">SMM</span><span class="custom-option undefined" data-value="9">Реклама</span><span class="custom-option undefined" data-value="10">Аналитика</span><span class="custom-option undefined" data-value="11">Логистика</span><span class="custom-option undefined" data-value="12">Менеджмент</span><span class="custom-option undefined" data-value="13">Финансы</span><span class="custom-option undefined" data-value="14">Планирование</span></div></div></div><div class="btn-delete-act"></div></div>').insertBefore($(".wrapper-teams").find('.button'));
							iniSelect('activities-target-' + data.activities[i], data.activities[i]);
						}
					} else {
						iniSelect('activities-target-1', data.activities[0]);
						$('.modal-window.' + modal).find('.select-activity:first-child').attr('id', data.teams[0]);
					}
					
					showModal('#' + modal, true);
					GetUserColors($('.modal-window.add-target'));
				}
			}
		});
	}
}












$('input.color-block__picker').change(function () {

	var window = $('.modal-window.show');

	console.log(window);

	$.ajax({
		url: '/php/vendor/addColor.php',
		type: 'GET',
		dataType: 'json',
		data: {
			color: $(this).val()
		},
		success(data) {
			if (data.status == true) {
				GetUserColors(window);
			}
		}
	});
})



function GetUserColors(window) {

	//console.log(window);

	$.ajax({
		url: '/php/vendor/getUserColors.php',
		type: 'GET',
		dataType: 'json',
		success(data) {
			if (data.status == true) {
				window.find('.user-colors').html(data.colors);
			}
		}
	});
}










$('.task-content__text').focusout(function () {
	ChangeTaskData();
})
$('.task-content__description').focusout(function () {
	ChangeTaskData();
})




















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








$('textarea').on('input', function () {
	this.style.height = '1px';
	this.style.height = (this.scrollHeight + 2) + 'px';
});

function rgb_to_hex(color) {
	var rgb = color.replace(/\s/g, '').match(/^rgba?\((\d+),(\d+),(\d+)/i);
	return (rgb && rgb.length === 4) ? "#" + ("0" + parseInt(rgb[1], 10).toString(16)).slice(-2) + ("0" + parseInt(rgb[2], 10).toString(16)).slice(-2) + ("0" + parseInt(rgb[3], 10).toString(16)).slice(-2) : color;
}