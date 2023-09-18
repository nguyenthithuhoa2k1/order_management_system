import jQuery from 'jquery';
window.$ = jQuery;
import 'jquery-validation';

$(document).ready(function () {
    $(document).on('click', '.close', function () {
        $(this).closest('.errors').addClass('hide');
        $(this).closest('.success').addClass('hide');
    });
});
