/**
 * NOTICE OF LICENSE
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *  @author    Xavier Lecoq
 *  @copyright 2015-2018 Inwave
 *  @license   GNU General Public License version 2
 */
$(document).ready(function () {

	$('.choix_type_param input:checkbox').each(function() {
	  if ($(this).is(':checked')) {
	  	$(this).parents('.choix_type_param').addClass("active");
	  }
	  else{
	  	$(this).parents('.choix_type_param').removeClass("active");
	  }
	});

	$(document).on('change', '.choix_type_param input:checkbox', function(e) {
        $(this).parents('.choix_type_param').toggleClass("active");
    });
  $(document).on('change', $('#id_export'), function(e) {
    if ($('#id_export').val() == '1') {
      $("#nom_export").show()
    } else {
      $("#nom_export").hide()
    }
  });

  $(document).on('change', $('#id_export_newsletter'), function(e) {
    if ($('#id_export_newsletter').val() == '1') {
      $("#nom_export_newsletter").show()
    } else {
      $("#nom_export_newsletter").hide()
    }
  });
});
