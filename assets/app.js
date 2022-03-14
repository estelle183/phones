/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';


// start the Stimulus application
import 'bootstrap-table/dist/bootstrap-table.js'
import 'bootstrap-table';
import './bootstrap';

import '@fortawesome/fontawesome-free/css/all.min.css';
import '@fortawesome/fontawesome-free/js/all.js';

const $ = require('jquery');
global.$ = global.jQuery = $;

$(document).on('change', '.custom-file-input', function () {
    let fileName = $(this).val().replace(/\\/g, '/').replace(/.*\//, '');
    $(this).parent('.custom-file').find('.custom-file-label').text(fileName);
});

$('#add-imei').click(function(){
    //Je récupère le numéro des futurs champs que je vais créer
    const index = +$('#widgets-counter').val();

    //Je récupère le prototype des entrées
    const tmpl = $('#phone_idNumbers').data('prototype').replace(/__name__/g, index);


    //J'injecte ce code au sein de la div
    $('#phone_idNumbers').append(tmpl);

    $('#widgets-counter').val(index + 1);

    //Je gère le bouton supprimer
    handleDeleteButtons();
});


function handleDeleteButtons() {
    $('button[data-action="delete"]').click(function(){
        const target = this.dataset.target;
        $(target).remove();
    })
}

function updateImeiCounter() {
    const count = +$('#phone_idNumbers div.form-group').length;
    $('#widget-counter').val(count);
}

updateImeiCounter();
handleDeleteButtons();