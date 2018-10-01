$(document).ready(function () {
    $('.sidebar-menu').tree();

    toastr.options.hideDuration = 5000;
    toastr.options.escapeHTML = true;
    toastr.options.closeButton = true;
    toastr.options.closeHtml = '<button type="button" class="close"><span aria-hidden="true">×</span></button>';
    toastr.options.closeMethod = 'fadeOut';
    toastr.options.closeDuration = 300;
    toastr.options.closeEasing = 'swing';

    var success = $('meta[name=success]').attr('content');
    var danger = $('meta[name=danger]').attr('content');

    if(success != '') toastr.success(success);
    if(danger != '') toastr.error(danger);
})
