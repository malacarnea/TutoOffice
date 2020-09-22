// any CSS you import will output into a single css file (app.css in this case)
import '../../node_modules/@fortawesome/fontawesome-free/css/all.css';
import '../../node_modules/bootstrap/dist/css/bootstrap.min.css';
import '../../node_modules/select2/dist/css/select2.min.css';
import '../css/app.css';
import '../css/mobiles.css';
// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
import $ from 'jquery';
require('popper.js');
require('bootstrap');
require('select2');


$(document).ready(function () {
    //unset gradiant background on header when visit home page and login page.
    if (RegExp("login|local\/$|#accueil$").test(window.location.href)) {
        if (RegExp("login").test(window.location.href)) {
            $("#ln_home").css('color', "#fff");
            $("#ln_home").click(function () {
                animate("animate reverse");
                $("#ln_home").css('color', '#2572ff');
                setTimeout(function () {
                    window.location.assign("/");
                }, 1500)
            })
        } else {
            //homepage to login animations
            $("#ln_connection.connection-bt").click(function () {
                animate("animate");
                $("#ln_home").css('color', '#ffffff');
                setTimeout(function () {
                    window.location.assign("/login");
                }, 1500)
            });
        }
    } else {
        $('header').removeClass("header--transparent");
    }

    //change highlight on admin menu
    if (RegExp("admin\/$").test(window.location.href)) {
        $("#formations-tab").addClass("active");
        $("#users-tab").removeClass("active");
    } else if (RegExp("admin\/users$").test(window.location.href)) {
        $("#users-tab").addClass("active");
        $("#formations-tab").removeClass("active");
    }
    //display responsive menu
    let elem = $("ul.nav");
    let ul = elem[0];
    $(".ln--icon a").click(function (e) {
        if (ul.className === "nav") {
            ul.className += " responsive";
            $("header").css('height', "18em");
            $("nav").css("align-items", "start");
        } else {
            ul.className = "nav";
            $("header").css('height', "6em");
            $("nav").css("align-items", "center");
        }
    });
    $(".ln--slarge a").click(function (e) {
        ul.className = "nav";
        $("header").css('height', "6em");
        $("nav").css("align-items", "center");
    });
    //reveal block apropos page
    $(".apropos-page.reveal")
            .addClass('reveal-visible')
            .find("[class*='reveal-']")
            .each(function () {
                $(this).addClass('reveal-visible');
            });

    $('.formation-header-title .chevron').click(function (e) {
        console.log("in");
        $(this).parent().parent().find("ul.chapters").fadeToggle("slow");
        let itemI = $(this).find("i.fas.fa-chevron-right");
        if (itemI.hasClass("down")) {
            itemI.removeClass("down");
        } else {
            itemI.addClass("down");
        }
    });

    //cookies
    //vérifier que la date des cookies existe et n'est pas dépassée, 
    //sinon charger en bas de page le bandeau de cookies.
    let cookies = document.cookies;

});

$('#formBox').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var modal = $(this);
    var data = {id_parent: button.parent().data('id')};
    var url = button.data("url");
    $.post(url, data, function (res) {
        modal.find('.modal-content').html(res);
        $('select').select2();
        $('#save').on('click', callModalBySaveBtn);

    });
});


function animate(classAnim) {
    $(".slide-to-co").addClass(classAnim);
    $(".slide-fieldset").addClass(classAnim);
    $(".img-relative").addClass(classAnim);
    $(".accroche").addClass(classAnim);

}

function callModalBySaveBtn(e) {
    var button = $(this);
    var modal = $("#formBox");
    var form = button.closest("form");
    var data = form.serialize();
    var url = button.data("url");
    e.stopPropagation();//keep the modal visible

    var contentType = "application/x-www-form-urlencoded";
    var processData = true;
    if (url.search("tutorials") !== -1) {
        contentType = false;
        processData = false;
        data = new FormData(form[0]);
    }

    $.ajax({
        type: "POST",
        url: url,
        data: data,
        contentType: contentType,
        processData: processData,
        success: function (res) {
            if (res.hasOwnProperty("url")) {
                window.location.assign(res.url);
            } else {
                modal.find('.modal-content').html(res);
                $('select').select2();
                $('#save').on('click', callModalBySaveBtn);
            }
        },
        error: function (xhr, status, error) {
            console.log(error)
        }
    });
}


let button = document.querySelector("#cookies-agree");
console.log(document.cookie);
checkCookie();
button.addEventListener("click", function (e) {
    setCookie("AcceptCookies", "toto", 365);
    document.querySelector(".cookies-band").style = "display:none";
});
// setCookie("Test", "toto",0);
console.log(document.cookie);

function setCookie(cname, cvalue, exdays) {
    let d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires + ";  SameSite=Lax; path=/";
}

function getCookie(cname) {
    let name = cname;
    let ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function checkCookie() {
    let cookiesExists = getCookie("AcceptCookies");
    if (cookiesExists === "") {
        console.log("no cookies");
        document.querySelector(".cookies-band").style = "display:grid";
    } else {
        console.log("yes cookies");
        document.querySelector(".cookies-band").style = "display:none";
    }
}

const imagesContext = require.context('../images', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
imagesContext.keys().forEach(imagesContext);


