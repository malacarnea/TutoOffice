/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../../node_modules/@fortawesome/fontawesome-free/css/all.css';
import '../../node_modules/bootstrap/dist/css/bootstrap.min.css';
import '../css/app.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
import $ from 'jquery';
require('bootstrap');

$(document).ready(function(){
   
});

$('#formBox').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); // Button that triggered the modal
  var url=button.data("url");
  
  var modal = $(this);
  $.post(url, {
      id_parent: button.parent().data('id')
  }, function(response){
    modal.find('.modal-content').html(response);
  });
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  
  
});



const imagesContext = require.context('../images', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
imagesContext.keys().forEach(imagesContext);

