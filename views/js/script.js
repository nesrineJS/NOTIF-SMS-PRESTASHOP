/**
 *
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

  var timeoutCompteur = null;

  $(document).on('change', 'select[name="type"]', function () {

    if ($(this).val() == "lowcost") {
      $('.taille_max').hide();
      $('.expediteur').hide();
    } else {
      $('.taille_max').show();
      $('.expediteur').show();
    }
  });

  $(document).on('change', 'select[name="sms_taille"]', function () {
    compteur("sms_etat_annule_message");
    compteur("sms_etat_en_cours_message");
    compteur("sms_etat_expedie_message");
    compteur("sms_etat_livre_message");
    compteur("sms_etat_rembourse_message");
    compteur("message");
  });


  $(document).on('keyup', '.notification_message', function () {
    clearTimeout(timeoutCompteur);
    var id = $(this).attr('id');
    timeoutCompteur = setTimeout(function () {
      compteur(id);
    }, 500);
  });


  var xhr = [];

  function compteur(id_message) {

    if ($('#' + id_message)) {

      var supprimer = 0;

      var nbr_sms_max = 1;

      if ($('select[name="type"]').val() == "premium") {
        nbr_sms_max = $('select[name="sms_taille"]').val();
      }

      if (xhr[id_message]) {

        xhr[id_message].abort();

      }

      xhr[id_message] = $.ajax({

        type: "POST",

        url: "https://www.spot-hit.fr/api/nombre_caracteres",

        dataType: 'json',

        data: {message: $('#' + id_message).val(), taille: nbr_sms_max, supprimer: "", add: ""}

      }).done(function (datas) {

        if (datas[2]) {

          datas[0] = datas[0] + supprimer;

        }

        var replace = datas[0] > 160;

        setMessage(id_message, datas[1], replace);

        setCompteur(id_message, datas[0]);

      });

    }

  }


  function setCompteur(id_message, nbr) {

    var max_caracteres_by_sms = 160;
    var nbr_sms_max = 1;

    if ($('select[name="type"]').val() == "premium") {
      nbr_sms_max = $('select[name="sms_taille"]').val();
    }

    if (nbr_sms_max > 1 && nbr > 160) {
      max_caracteres_by_sms = 153;
    } else {
      max_caracteres_by_sms = 160;
    }

    var max_caracteres = max_caracteres_by_sms * nbr_sms_max;

    if (nbr > max_caracteres) {
      nbr = max_caracteres;
    }

    var nbr_sms = Math.ceil(nbr / max_caracteres_by_sms);

    if (nbr_sms == 0) {
      nbr_sms = 1;
    }

    if (nbr > 0 && (nbr % max_caracteres_by_sms) == 0) {
      $('#' + id_message + '_compteur .caracteres').text(max_caracteres_by_sms);
    } else {
      $('#' + id_message + '_compteur .caracteres').text(nbr % max_caracteres_by_sms);
    }
    $('#' + id_message + '_compteur .max_caracteres').text(max_caracteres_by_sms);
    $('#' + id_message + '_compteur .nbr_sms').text(nbr_sms);

  }


  function setMessage(id_message, msg, replace) {

    if (replace) {

      var pos = $('#' + id_message).prop("selectionStart");

      $('#' + id_message).val(msg);

      $('#' + id_message).prop("selectionStart", pos);

      $('#' + id_message).prop("selectionEnd", pos);

    }

    return false;

  }


  compteur("sms_etat_annule_message");

  compteur("sms_etat_en_cours_message");

  compteur("sms_etat_expedie_message");

  compteur("sms_etat_livre_message");

  compteur("sms_etat_rembourse_message");

  compteur("message");

  tinymce.init({
    selector: '.rte',
    height: 500,
    theme: 'modern',
    plugins: 'image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools  contextmenu colorpicker textpattern help',
    toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
    image_advtab: true,
    templates: [
      {title: 'Test template 1', content: 'Test 1'},
      {title: 'Test template 2', content: 'Test 2'}
    ],
  });

});
