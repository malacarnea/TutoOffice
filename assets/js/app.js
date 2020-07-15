/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../../node_modules/@fortawesome/fontawesome-free/css/all.css';
import '../../node_modules/bootstrap/dist/css/bootstrap.min.css';
import '../../node_modules/select2/dist/css/select2.min.css';
import '../css/app.css';

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
            $("#ln_home").click(function(){
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
        $('header').removeClass("transparent-header");
    }

    //change highlight on admin menu
    if (RegExp("admin\/$").test(window.location.href)) {
        $("#formations-tab").addClass("active");
        $("#users-tab").removeClass("active");
    } else if (RegExp("admin\/users$").test(window.location.href)) {
        $("#users-tab").addClass("active");
        $("#formations-tab").removeClass("active");
    }

    //reveal block apropos page
    $(".apropos-page.reveal")
            .addClass('reveal-visible')
            .find("[class*='reveal-']")
            .each(function () {
                $(this).addClass('reveal-visible');
            });

    $('.formation-header-title .chevron').click(function(e){
        console.log("in");
        $(this).parent().parent().find("ul.chapters").fadeToggle("slow");
        let itemI=$(this).find("i.fas.fa-chevron-right");
        if(itemI.hasClass("down")){
            itemI.removeClass("down");
        }else{
            itemI.addClass("down");
        }
    });
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

$('[data-spy="scroll"]').on('activate.bs.scrollspy', function () {
    console.log("in");
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

    console.log(contentType + " " + processData);
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


const imagesContext = require.context('../images', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
imagesContext.keys().forEach(imagesContext);


