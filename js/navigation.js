(function ($) {

  $('.navbar-toggler[data-toggle="modal"]').click(function() {
    $(this).toggleClass('collapsed');
  });

  $('#nav-modal').on('hide.bs.modal', function() {
    $('body').removeClass('modal-open');
  });

})(jQuery);
