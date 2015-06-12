var Socializr = (function (win, doc, $) {
  'use strict';

  var exports = {};

  exports.numOfRows = 0;

  var _addProfile = function (e) {
    var att;
    var $template  = $(".template-of-profile");
    var name = $(this).parent().parent().attr('id');
    var $newProfile = $template.clone(true, true)
      .insertAfter('[id=' + name + ']')
      .removeClass('template-of-profile');

    exports.numOfRows++;
    $newProfile.attr('id', exports.numOfRows);
    att = $newProfile.children('input').attr('name');

    $('#' + exports.numOfRows + ' > td > input').each(function (index, value) {
        value.name = value.name.replace('[0]', '[' + exports.numOfRows + ']');
    });
  };

  var _removeProfile = function (e) {
    var $parent  = $(this).parent().parent();

    if($('[form-profile-rows] > tr').length > 1) {
        $parent.remove();
    }
  }

  var _typeChange = function (e) {
   var val = $(this).val();
   var $profile = $('[form-profile]');
   var $share = $('[form-share]');

   if (val === 'SHARE') {
      $profile.addClass('hidden');
      $share.removeClass('hidden');
      return;
   }

   $profile.removeClass('hidden');
   $share.addClass('hidden');
  }

  exports.init = function () {
    $('[profile-remove]').on('click', _removeProfile);
    $('[profile-add]').on('click', _addProfile);
    $('[type-selector]').on('change', _typeChange);
  };

  return exports;
})(window, document, jQuery);
