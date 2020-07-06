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
    if (!RegExp("login|local\/|#accueil$").test(window.location.href)) {
        $('header').removeClass("transparent-header");
        
    }else{
        if (RegExp("login").test(window.location.href)) {
            $("#ln_home a").css('color', "#fff");
        }
    }
    
    //homepage to login animations
    if (RegExp("local\/|#accueil$").test(window.location.href)) {
       $("#ln_connection").click(function(){
           $(".slide-fieldset").addClass("animate");
           $(".slide-to-co").addClass("animate");
           $(".img-relative img").addClass("animate");
           $(".accroche").addClass("animate");
           
           setTimeout(function(){
                window.location.assign("/login");
           }, 1500)
       });
    }
    //change highlight on admin menu
    if (RegExp("admin\/$").test(window.location.href)) {
        $("#formations-tab").addClass("active");
        $("#users-tab").removeClass("active");
    } else if (RegExp("admin\/users$").test(window.location.href)) {
        $("#users-tab").addClass("active");
        $("#formations-tab").removeClass("active");
    }
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

//const videosContext = require.context('../videos', true, /\.(mp4)$/);
//videosContext.keys().forEach(videosContext);

