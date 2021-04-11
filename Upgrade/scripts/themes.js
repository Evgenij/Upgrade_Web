var link = document.getElementById("theme-link");
var checkbox = $('#checkbox-theme').find('.checkbox');
var themeLabel = $('.theme-label');
var lightTheme = "styles/light.css";
var darkTheme = "styles/dark.css";
var currTheme = link.getAttribute("href");

$('.checkbox-theme').click(function () {

    let theme = "";

    if(currTheme == lightTheme)
    {
        currTheme = darkTheme;
        theme = "dark";
        SetStateCheckbox(true);
    }
    else
    {    
        currTheme = lightTheme;
        theme = "light";
        SetStateCheckbox(false);
    }

    link.setAttribute("href", currTheme);

    Save(theme);

    GetTasks();
    GetTargets();
    GetAttachments();
});

function SetStateCheckbox(state) { 
    if (state == false) {
        checkbox.prop('checked', state);
        themeLabel.text('Светлая тема');
    }
    else { 
        checkbox.prop('checked', true);
        themeLabel.text('Темная тема');
    }
}

function SetThemeCheckbox() { 

    if(currTheme == lightTheme)
    {
        SetStateCheckbox(false);
    }
    else
    {    
        SetStateCheckbox(true);
    }
}

function Save(theme)
{
    var Request = new XMLHttpRequest();
    Request.open("GET", "./themes.php?theme=" + theme, true);
    Request.send();
}