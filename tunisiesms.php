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
 *  @author    Tunisie SMS
 *  @copyright 2015-2019 Inwave
 *  @license   GNU General Public License version 2
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

include_once(dirname(__FILE__) . '/class/SHOutils.php');
include_once(dirname(__FILE__) . '/controllers/admin/AdminSHAdmin.php');

class TunisieSMS extends Module
{

    public function __construct()
    {
        //$this->module_key = '9ea5b0405d787be83a4aff15fe8379cv';
        $this->name = 'tunisiesms';
        $this->tab = 'administration';
        $this->version = '3.0.2';
        $this->author = 'TunisieSMS.tn';
		
        $this->need_instance = 0;
        //$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->l('Module Presta-Tunisie SMS');
        $this->description = $this->l('Découvrez  notre module API SMS pour Prestashop qui vous permet d’envoyer de manière automatique des SMS à différentes étapes du parcours de paiement / livraison des commandes de vos clients.Le module permet de personnaliser les messages avec des fonctionnalités d’envoi automatique, ainsi qu’une garantie de remise des messages SMS envoyés depuis votre espace Prestashop.');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
        $this->context->smarty->assign("templates_dir", _PS_MODULE_DIR_ . 'tunisiesms/views/templates');
        if (!Configuration::get('TUNISIE_SMS_NAME')) {
            $this->warning = $this->l('No name provided');
        }
        $this->tabs = array(
            "AdminSHConfiguration" => array(
                "label" => $this->l('Configure'),
                "icon" => "settings",
            ),
            "AdminSHEnvoyerSMS" => array(
                "label" => $this->l('Send SMS'),
                "icon" => "message",
            ),
            // "AdminSHEnvoyerEmail" => array(
            //     "label" => $this->l('Send Emails'),
            //     "icon" => "mail_outline",
            // ),
            // "AdminSHConfigurationEmail" => array(
            //     "label" => $this->l('Configure Automatic Emails'),
            //     "icon" => "add_alert",
            // ),
        );
        $this->addRessources();
    }

    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }

        if (!parent::install()
        || !$this->installHooks()
        || !$this->installTabs()
        || !$this->installDB()) {
            return false;
        }

        return true;
    }

    public function installConfiguration()
    {
        $configuration = array(
            "cle_api" => "",
            "sms_expediteur" => "",
            "type" => "premium",
            "sms_taille" => "1",
            "sms_etat_annule" => false,
            "sms_etat_annule_message" => "Votre commande a été annulée. Pour plus d'informations et effectuer une nouvelle commande, rendez-vous directement sur notre site internet.",
            "sms_etat_en_cours" => false,
            "sms_etat_en_cours_message" => "Votre commande est en cours de préparation. Pour plus d'informations et suivre votre commande, rendez-vous directement sur notre site internet.",
            "sms_etat_expedie" => false,
            "sms_etat_expedie_message" => "Votre commande vient d'être expédiée. Pour plus d'informations et suivre votre commande, rendez-vous directement sur notre site internet.",
            "sms_etat_livre" => false,
            "sms_etat_livre_message" => "Votre commande vous a été livrée. Pour effectuer une nouvelle commande, rendez-vous directement sur notre site internet.",
            "sms_etat_rembourse" => false,
            "sms_etat_rembourse_message" => "Votre commande vient de vous être remboursée. Pour plus d'informations et effectuer une nouvelle commande, rendez-vous directement sur notre site internet.",

            "email_expediteur" => "",
            "email_nom_expediteur" => "",
            "email_reponse" => "",
            "email_sujet" => "",
            "email_etat_annule" => false,
            "email_etat_annule_message" => "Votre commande a été annulée. Pour plus d'informations et effectuer une nouvelle commande, rendez-vous directement sur notre site internet.",
            "email_etat_en_cours" => false,
            "email_etat_en_cours_message" => "Votre commande est en cours de préparation. Pour plus d'informations et suivre votre commande, rendez-vous directement sur notre site internet.",
            "email_etat_expedie" => false,
            "email_etat_expedie_message" => "Votre commande vient d'être expédiée. Pour plus d'informations et suivre votre commande, rendez-vous directement sur notre site internet.",
            "email_etat_livre" => false,
            "email_etat_livre_message" => "Votre commande vous a été livrée. Pour effectuer une nouvelle commande, rendez-vous directement sur notre site internet.",
            "email_etat_rembourse" => false,
            "email_etat_rembourse_message" => "Votre commande vient de vous être remboursée. Pour plus d'informations et effectuer une nouvelle commande, rendez-vous directement sur notre site internet."
        );
        return Configuration::updateValue('TUNISIE_SMS_NAME', "TunisieSMS") && Configuration::updateValue('TUNISIE_SMS_SETTINGS', serialize($configuration));
    }

    public function installHooks()
    {
        return $this->registerHook('actionOrderStatusUpdate');
    }

    public function installDB()
    {
        return Db::getInstance()->execute(
            'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'tunisiesms_configuration (champs VARCHAR(255) NOT NULL UNIQUE, valeur LONGTEXT NOT NULL)'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="id_export", valeur = ""'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="nom_export", valeur = ""'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="id_export_newsletter", valeur = ""'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="nom_export_newsletter", valeur = ""'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="cle_api", valeur = ""'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="sms_expediteur", valeur = ""'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="sms_type", valeur = "premium"'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="sms_taille", valeur = "1"'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="sms_etat_annule", valeur = ""'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="sms_etat_annule_message", valeur = "Votre commande %COMMANDE% a été annulée. Pour plus d\'informations et effectuer une nouvelle commande, rendez-vous directement sur notre site internet."'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="sms_etat_en_cours", valeur = ""'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="sms_etat_en_cours_message", valeur = "Votre commande %COMMANDE% est en cours de préparation. Pour plus d\'informations et suivre votre commande, rendez-vous directement sur notre site internet."'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="sms_etat_expedie", valeur = ""'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="sms_etat_expedie_message", valeur = "Votre commande %COMMANDE% vient d\'être expédiée. Pour plus d\'informations et suivre votre commande, rendez-vous directement sur notre site internet."'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="sms_etat_livre", valeur = ""'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="sms_etat_livre_message", valeur = "Votre commande %COMMANDE% vous a été livrée. Pour effectuer une nouvelle commande, rendez-vous directement sur notre site internet."'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="sms_etat_rembourse", valeur = ""'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="sms_etat_rembourse_message", valeur = "Votre commande %COMMANDE% vient de vous être remboursée. Pour plus d\'informations et effectuer une nouvelle commande, rendez-vous directement sur notre site internet."'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="email_expediteur", valeur = ""'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="email_nom_expediteur", valeur = ""'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="email_reponse", valeur = ""'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="email_sujet", valeur = ""'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="email_etat_annule", valeur = ""'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="email_etat_annule_message", valeur = "Votre commande a été annulée. Pour plus d\'informations et effectuer une nouvelle commande, rendez-vous directement sur notre site internet."'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="email_etat_en_cours", valeur = ""'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="email_etat_en_cours_message", valeur = "Votre commande est en cours de préparation. Pour plus d\'informations et suivre votre commande, rendez-vous directement sur notre site internet."'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="email_etat_expedie", valeur = ""'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="email_etat_expedie_message", valeur = "Votre commande vient d\'être expédiée. Pour plus d\'informations et suivre votre commande, rendez-vous directement sur notre site internet."'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="email_etat_livre", valeur = ""'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="email_etat_livre_message", valeur = "Votre commande vous a été livrée. Pour effectuer une nouvelle commande, rendez-vous directement sur notre site internet."'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="email_etat_rembourse", valeur = ""'
        ) && Db::getInstance()->execute(
            'INSERT INTO '._DB_PREFIX_.'tunisiesms_configuration SET champs ="email_etat_rembourse_message", valeur = "Votre commande vient de vous être remboursée. Pour plus d\'informations et effectuer une nouvelle commande, rendez-vous directement sur notre site internet."'
        );
    }

    private function installTabs()
    {
        $tab = new Tab();
        foreach (Language::getLanguages(false) as $lang) {
            $tab->name[$lang['id_lang']] = $this->l("TunisieSMS");
        }
        $tab->class_name = "AdminSHEnvoyerSMSS";
        $tab->id_parent = 0;
        $tab->module = $this->name;
        if ($tab->save()) {
            $id_parent = $tab->id;
            foreach ($this->tabs as $k => $options) {
                $tab = new Tab();
                foreach (Language::getLanguages(false) as $lang) {
                    $tab->name[$lang['id_lang']] = $this->l($options['label']);
                }
                $tab->class_name = $k;
                $tab->id_parent = $id_parent;
                $tab->module = $this->name;
                $tab->icon = $options['icon'];
                if (!$tab->save()) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    public function uninstall()
    {
        $this->uninstallDB();
        $this->uninstallHooks();
        $this->uninstallTabs();
        return parent::uninstall();
    }

    public function uninstallConfiguration()
    {
        return Configuration::deleteByName('TUNISIE_SMS_SETTINGS') && Configuration::deleteByName('TUNISIE_SMS_NAME');
    }

    public function uninstallDB()
    {
        return Db::getInstance()->execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'tunisiesms_configuration'.' ;');
    }

    private function uninstallTabs()
    {
        foreach ($this->tabs as $k => $v) {
            $this->uninstallTab($k);
        }
        $this->uninstallTab("AdminSHEnvoyerSMSS");
        return true;
    }

    private function uninstallTab($tabClass)
    {
        $idTab = Tab::getIdFromClassName($tabClass);
        if ($idTab) {
            $tab = new Tab($idTab);
            return $tab->delete();
        }
        return false;
    }

    public function uninstallHooks()
    {
        return $this->unregisterHook('actionOrderStatusUpdate');
    }

    public function formatMessageSMS($message, $params)
    {
        // %COMMANDE%   ==> $params['id_order'];
        // %REFERENCE%  ==> $order['reference'];
        // %PRICE%      ==> $order['total_paid'];
        // %PAYMENT%    ==> $order['payment'];

        $order = new Order((int) $params['id_order']);        
        
        $message = str_replace('%COMMANDE%',$params['id_order'],$message);

        if($order)
        {
            $message = str_replace('%REFERENCE%',$order->reference,$message);
            $message = str_replace('%PRICE%',$order->total_paid,$message);
            $message = str_replace('%PAYMENT%',$order->payment,$message);
        }

        return $message;
        
    }

    public function hookActionOrderStatusUpdate($params)
    {      

        
        
        
        if (isset($params['cart']) && !empty($params['cart'])) {
            $id_address = $params['cart']->id_address_delivery;
            $id_customer = $params['cart']->id_customer;


          if ($numero = SHOutils::getNumero($id_address)) {               

                $config = SHOutils::getConfig();
                if ($config['sms_etat_annule'] && !empty($config['sms_etat_annule_message']) && $params['newOrderStatus']->id == (int) Configuration::get('PS_OS_CANCELED')) {
                    SHOutils::sendSMS($config['sms_expediteur'], array($numero), $this->formatMessageSMS($config['sms_etat_annule_message'], $params), $config['sms_type'], $config['sms_taille']);
                } elseif ($config['sms_etat_en_cours'] && !empty($config['sms_etat_en_cours_message']) && $params['newOrderStatus']->id == (int) Configuration::get('PS_OS_PREPARATION')) {
                    SHOutils::sendSMS($config['sms_expediteur'], array($numero), $this->formatMessageSMS($config['sms_etat_en_cours_message'], $params), $config['sms_type'], $config['sms_taille']);
                } elseif ($config['sms_etat_expedie'] && !empty($config['sms_etat_expedie_message']) && $params['newOrderStatus']->id == (int) Configuration::get('PS_OS_SHIPPING')) {
                    SHOutils::sendSMS($config['sms_expediteur'], array($numero), $this->formatMessageSMS($config['sms_etat_expedie_message'], $params), $config['sms_type'], $config['sms_taille']);
                } elseif ($config['sms_etat_livre'] && !empty($config['sms_etat_livre_message']) && $params['newOrderStatus']->id == (int) Configuration::get('PS_OS_DELIVERED')) {
                    SHOutils::sendSMS($config['sms_expediteur'], array($numero), $this->formatMessageSMS($config['sms_etat_livre_message'], $params), $config['sms_type'], $config['sms_taille']);
                } elseif ($config['sms_etat_rembourse'] && !empty($config['sms_etat_rembourse_message']) && $params['newOrderStatus']->id == (int) Configuration::get('PS_OS_REFUND')) {
                    SHOutils::sendSMS($config['sms_expediteur'], array($numero), $this->formatMessageSMS($config['sms_etat_rembourse_message'], $params), $config['sms_type'], $config['sms_taille']);
                }
            }
            /*if ($numero = SHOutils::getNumero($id_address)) {
                $config = SHOutils::getConfig();
                if ($config['sms_etat_annule'] && !empty($config['sms_etat_annule_message']) && $params['newOrderStatus']->id == (int) Configuration::get('PS_OS_CANCELED')) {
                    SHOutils::sendSMS($config['sms_expediteur'], array($numero), $config['sms_etat_annule_message'], $config['sms_type'], $config['sms_taille']);
                } elseif ($config['sms_etat_en_cours'] && !empty($config['sms_etat_en_cours_message']) && $params['newOrderStatus']->id == (int) Configuration::get('PS_OS_PREPARATION')) {
                    SHOutils::sendSMS($config['sms_expediteur'], array($numero), $config['sms_etat_en_cours_message'], $config['sms_type'], $config['sms_taille']);
                } elseif ($config['sms_etat_expedie'] && !empty($config['sms_etat_expedie_message']) && $params['newOrderStatus']->id == (int) Configuration::get('PS_OS_SHIPPING')) {
                    SHOutils::sendSMS($config['sms_expediteur'], array($numero), $config['sms_etat_expedie_message'], $config['sms_type'], $config['sms_taille']);
                } elseif ($config['sms_etat_livre'] && !empty($config['sms_etat_livre_message']) && $params['newOrderStatus']->id == (int) Configuration::get('PS_OS_DELIVERED')) {
                    SHOutils::sendSMS($config['sms_expediteur'], array($numero), $config['sms_etat_livre_message'], $config['sms_type'], $config['sms_taille']);
                } elseif ($config['sms_etat_rembourse'] && !empty($config['sms_etat_rembourse_message']) && $params['newOrderStatus']->id == (int) Configuration::get('PS_OS_REFUND')) {
                    SHOutils::sendSMS($config['sms_expediteur'], array($numero), $config['sms_etat_rembourse_message'], $config['sms_type'], $config['sms_taille']);
                }
            }*/

            if ($email = SHOutils::getEmail($id_customer)) {
                $config = SHOutils::getConfig();
                if ($config['email_etat_annule'] && !empty($config['email_etat_annule_message']) && $params['newOrderStatus']->id == (int) Configuration::get('PS_OS_CHEQUE')) {
                    SHOutils::sendEmail($config['email_expediteur'], $config['email_nom_expediteur'], $config['email_reponse'], $config['email_sujet'], array($email), $config['email_etat_annule_message']);
                } elseif ($config['email_etat_en_cours'] && !empty($config['email_etat_en_cours_message']) && $params['newOrderStatus']->id == (int) Configuration::get('PS_OS_PREPARATION')) {
                    SHOutils::sendEmail($config['email_expediteur'], $config['email_nom_expediteur'], $config['email_reponse'], $config['email_sujet'], array($email), $config['email_etat_en_cours_message']);
                } elseif ($config['email_etat_expedie'] && !empty($config['email_etat_expedie_message']) && $params['newOrderStatus']->id == (int) Configuration::get('PS_OS_SHIPPING')) {
                    SHOutils::sendEmail($config['email_expediteur'], $config['email_nom_expediteur'], $config['email_reponse'], $config['email_sujet'], array($email), $config['email_etat_expedie_message']);
                } elseif ($config['email_etat_livre'] && !empty($config['email_etat_livre_message']) && $params['newOrderStatus']->id == (int) Configuration::get('PS_OS_DELIVERED')) {
                    SHOutils::sendEmail($config['email_expediteur'], $config['email_nom_expediteur'], $config['email_reponse'], $config['email_sujet'], array($email), $config['email_etat_livre_message']);
                } elseif ($config['email_etat_rembourse'] && !empty($config['email_etat_rembourse_message']) && $params['newOrderStatus']->id == (int) Configuration::get('PS_OS_REFUND')) {
                    SHOutils::sendEmail($config['email_expediteur'], $config['email_nom_expediteur'], $config['email_reponse'], $config['email_sujet'], array($numero), $config['email_etat_rembourse_message']);
                }
            }
        }
    }

    public function addRessources()
    {
        // $this->context->controller->addCSS(($this->_path . '/views/css/styles.css'), 'all');
        // $this->context->controller->addCss(($this->_path . '/views/css/tab.css'), 'all');
        // $this->context->controller->addJquery();
        // $this->context->controller->addJS(($this->_path . '/views/js/script.js'));
        // $this->context->controller->addJS(($this->_path . '/views/js/configuration.js'));
    }

    public function getContent()
    {
        $return = array();
        $return['resultat'] = false;
        $return['erreur'] = "";
        if (isset($_REQUEST['action']) && $_REQUEST['action'] == "save_cle_api") {
            $ConfigurationController = new AdminSHAdminController();
            $ConfigurationController->saveCleAPI();
        }

        if (isset($_REQUEST['action']) && $_REQUEST['action'] == "save_configuration") {
            $ConfigurationController = new AdminSHAdminController();
            $return = $ConfigurationController->saveConfiguration();
        }

        if (isset($_REQUEST['action']) && $_REQUEST['action'] == "email_save_configuration") {
            $ConfigurationController = new AdminSHAdminController();
            $return = $ConfigurationController->saveConfigurationEmail();
        }

        if (isset($_REQUEST['action']) && $_REQUEST['action'] == "export_contacts") {
            $ConfigurationController = new AdminSHAdminController();
            $return = $ConfigurationController->exportContacts();
        }

        $this->context->smarty->assign("config", SHOutils::getConfig());
        $this->context->smarty->assign("credits", SHOutils::getCredits());
        $this->context->smarty->assign("retour", $return);
        return $this->display(__FILE__, 'views/templates/admin/configuration.tpl');
    }
}
