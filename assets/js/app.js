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
require('bootstrap');
require('select2');
$(document).ready(function () {
    console.log(window.location.href);
    //change highlight on admin menu
    if(RegExp("admin\/$").test(window.location.href)){
        $("#formations-tab").addClass("active");
        $("#users-tab").removeClass("active");
    }else if(RegExp("admin\/users$").test(window.location.href)){
         $("#users-tab").addClass("active");
        $("#formations-tab").removeClass("active");
    }
});

$('#formBox').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var modal = $(this);
    var data = {id_parent: button.parent().data('id')};
    var url = button.data("url");
    $.get(url, data, function (res) {
        modal.find('.modal-content').html(res);
        $('select').select2();
        $('#save').on('click', callModalBySaveBtn);

    });
});

function callModalBySaveBtn(e) {
    var button = $(this);
    var modal = $("#formBox");
    var data = button.closest("form").serialize();
    var url = button.data("url");
    e.stopPropagation();//keep the modal visible
    $.post(url, data, function (res) {
        if (res.hasOwnProperty("url")) {
            window.location.assign(res.url);
        } else {
            modal.find('.modal-content').html(res);
            $('select').select2();
            $('#save').on('click', callModalBySaveBtn);
        }
    });
}



const imagesContext = require.context('../images', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
imagesContext.keys().forEach(imagesContext);

