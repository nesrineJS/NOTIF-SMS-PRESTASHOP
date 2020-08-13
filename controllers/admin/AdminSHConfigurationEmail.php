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
 *  @author    Xavier Lecoq
 *  @copyright 2015-2018 Inwave
 *  @license   GNU General Public License version 2
 */

include_once(dirname(__FILE__) . '/AdminSHAdmin.php');

class AdminSHConfigurationEmailController extends AdminSHAdminController
{

    public function __construct()
    {
        $this->template = 'admin/configuration_email.tpl';
        parent :: __construct();
    }

    public function setMedia($isNewTheme = false)
    {
        parent::setMedia();
        $this->addJS(_MODULE_DIR_ . 'tunisiesms/views/js/configuration_email.js');
    }

    public function initContent()
    {
        parent::initContent();
        $return = array();
        $return['resultat'] = false;
        $return['erreur'] = "";
        if (isset($_REQUEST['action']) && $_REQUEST['action'] == "email_save_configuration") {
            $return = $this->saveConfigurationEmail();
        }
        $this->displayTemplate(array("retour" => $return));
    }
}
