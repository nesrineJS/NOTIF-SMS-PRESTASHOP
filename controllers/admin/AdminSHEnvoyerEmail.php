<?php
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
 * @author    Xavier Lecoq
 * @copyright 2015-2018 Inwave
 * @license   GNU General Public License version 2
 */

include_once(dirname(__FILE__).'/AdminSHAdmin.php');

class AdminSHEnvoyerEmailController extends AdminSHAdminController
{

    public function __construct()
    {
        $this->template = 'admin/envoyeremail.tpl';
        parent:: __construct();
    }

    public function setMedia($isNewTheme = false)
    {
        parent::setMedia();
        $this->addCSS(_MODULE_DIR_.'tunisiesms/views/css/dataTables.bootstrap.css');
        $this->addJS(_MODULE_DIR_.'tunisiesms/views/js/jquery.dataTables.min.js');
        $this->addJS(_MODULE_DIR_.'tunisiesms/views/js/dataTables.bootstrap.min.js');
        $this->addJS(_MODULE_DIR_.'tunisiesms/views/js/envoyeremail.js');
    }

    public function initContent()
    {
        parent::initContent();
        $return = array();
        $return['resultat'] = false;
        $return['erreur'] = "";
        $contacts = SHOutils::getAllEmail();
        if (isset($_REQUEST['action']) && $_REQUEST['action'] == "envoyer_email") {
            $return = $this->sendEmail();
        }
        $this->displayTemplate(array('retour' => $return, 'contacts' => $contacts));
    }
}
