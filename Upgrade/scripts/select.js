$(".custom-select").each(function () {
	var classes = $(this).attr("class").replace('hide', ''),
		id = $(this).attr("id"),
		name = $(this).attr("name");
	var template;

	if (!classes.includes("user-select")) {
		template = '<div class="' + classes + '">';
		template += '<span class="custom-select-trigger ' + classes + '" id="' + id + '"></span>';
		template += '<div class="custom-options ' + classes + '" id="' + id + '">';
		$(this).find("option").each(function () {
			template += '<span class="custom-option ' + $(this).attr("class") + '" data-value="' + $(this).attr("value") + '">' + $(this).html() + '</span>';
		});
		template += '</div></div>';
	} else {
		template = '<div class="' + classes + '">';
		template += '<div class="custom-select-trigger ' + classes + '" id="' + id + '"></div>';

		template += '<div class="custom-options ' + classes + '" id="' + id + '">';
		$(this).find("option").each(function () {
			template += '<div class="custom-option ' + $(this).attr("class") + '" data-value="' + $(this).attr("value") + '">';
			template += '<div class="user-select-data flex">';
			template += '<div style="background-image:url(' + $(this).attr("scr-avatar") + '); background-position: center; background-size: contain;" class="user-select-avatar"></div>';
			template += '<div class="flex f-col"><p class="user-select-name"> ' + $(this).html() + '</p><span class="user-select-spec text regular">' + $(this).attr("user-spec") + '</span></div>'
			template += '</div></div>';
		});
		template += '</div></div>';
	}

	if ($(this).hasClass('hide')) {
		$(this).wrap('<div class="custom-select-wrapper hide"></div>');
	}
	else {
		$(this).wrap('<div class="custom-select-wrapper"></div>');
	}
	$(this).hide();
	$(this).after(template);
});
$(".custom-option:first-of-type").hover(function () {
	$(this).parents(".custom-options").addClass("option-hover");
}, function () {
	$(this).parents(".custom-options").removeClass("option-hover");
});
$(document).on('click', ".custom-select-trigger", function () {
	$('html').one('click', function () {
		$(".custom-select").removeClass("opened");
	});
	$(this).parents(".custom-select").toggleClass("opened");
	event.stopPropagation();
});

$('.custom-options').on("click", ".custom-option", function () {
	$(this).parents(".custom-select-wrapper").find("select").val($(this).data("value"));
	$(this).parents(".custom-options").find(".custom-option").removeClass("selection");
	$(this).addClass("selection");
	$(this).parents(".custom-select").removeClass("opened");

	if (!$(this).parents(".custom-options").hasClass('user-select')) {
		$(this).parents(".custom-select").find(".custom-select-trigger").text($(this).text());
	} else {
		$(this).parents(".custom-select").find(".custom-select-trigger").html($(this).html());
	}
});

$(document).on("click", ".custom-option", function () {
	$(this).parents(".custom-select-wrapper").find("select").val($(this).data("value"));
	$(this).parents(".custom-options").find(".custom-option").removeClass("selection");
	$(this).addClass("selection");
	$(this).parents(".custom-select").removeClass("opened");

	if (!$(this).parents(".custom-options").hasClass('user-select')) {
		$(this).parents(".custom-select").find(".custom-select-trigger").text($(this).text());
	} else {
		$(this).parents(".custom-select").find(".custom-select-trigger").html($(this).html());
	}
});