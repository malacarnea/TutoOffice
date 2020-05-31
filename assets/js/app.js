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

});

$('#formBox').on('show.bs.modal', callBackModal);

function callBackModal(event) {
    var button;
    var modal;
    var data;
    if ($(this).attr("id") === "formBox") {
        button = $(event.relatedTarget); // Button that triggered the modal
        modal = $(this);
        data = {id_parent: button.parent().data('id')};
    } else {
        button = $(this);
        modal = $("#formBox");
        data = button.closest("form").serialize();

    }

    var url = button.data("url");
    $.post(url, data, function (res) {
        console.log(res);
        if (res.hasOwnProperty("url")) {
            window.location.assign(res.url);
        } else {
            event.preventDefault();
            modal.find('.modal-content').html(res);
            $('select').select2();
            $("#save").on("click", callBackModal);
           // modal.modal('show');
        }
    });

}


const imagesContext = require.context('../images', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
imagesContext.keys().forEach(imagesContext);

