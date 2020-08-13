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
    jQuery('#check_all_contacts').change(function () {
        var checked = jQuery(this).is(':checked');
        jQuery('#destinataires input[name="email_destinataires[]"]').each(function (index, value) {
            jQuery(this).prop('checked', checked);
        });
    });

    jQuery('#destinataires').dataTable({
        "order": [[ 1, "asc" ]],
        "columnDefs":  [ { "targets": 0, "orderable": false } ],
        "language": {
            "url": "../modules/tunisiesms/views/js/french.json"
        }
    });
});
