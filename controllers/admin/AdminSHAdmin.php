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

include_once(dirname(__FILE__).'/../../class/SHOutils.php');

class AdminSHAdminController extends AdminController
{

    public function __construct()
    {
        parent:: __construct();
        $this->bootstrap = true;
        $this->context->smarty->assign("templates_dir", _PS_MODULE_DIR_.'tunisiesms/views/templates');
    }

    public function createTemplate($tpl_name)
    {
        if (file_exists($this->getTemplatePath()."/".$tpl_name) && $this->viewAccess()) {
            return $this->context->smarty->createTemplate(
                $this->getTemplatePath()."/".$tpl_name,
                $this->context->smarty
            );
        }

        return parent::createTemplate($tpl_name);
    }

    public function getTemplatePath()
    {
        return _PS_MODULE_DIR_.'tunisiesms/views/templates';
    }

    public function displayTemplate($datas)
    {
        $this->context->smarty->assign(
            array_merge(
                $datas,
                array(
                    "config" => SHOutils::getConfig(),
                    "credits" => SHOutils::getCredits(),
                    "groupes" => SHOutils::getGroupes(),
                )
            )
        );
    }

    public function initContent()
    {
        parent::initContent();
        if (isset($_REQUEST['action']) && $_REQUEST['action'] == "save_cle_api") {
            $this->saveCleAPI();
        }
    }

    public function setMedia($isNewTheme = false)
    {
        parent::setMedia();
        $this->context->controller->addCSS(_MODULE_DIR_.'tunisiesms/views/css/styles.css');
        $this->context->controller->addCss(_MODULE_DIR_.'tunisiesms/views/css/tab.css');
        $this->context->controller->addJquery();
        $this->context->controller->addJS(_MODULE_DIR_.'tunisiesms/views/libraries/tinymce/tinymce.min.js');
        $this->context->controller->addJS(_MODULE_DIR_.'tunisiesms/views/js/script.js');
    }

    public function clearCache()
    {
    }

    public function getFields()
    {
    }

    public function saveCleAPI()
    {
        $config = SHOutils::getConfig();

       if (isset($_REQUEST['cle_api'])) {
            $config['cle_api'] = $_REQUEST['cle_api'];
       }

        return Db::getInstance()->update(
            'tunisiesms_configuration',
            array('valeur' => $config['cle_api']),
            "champs = 'cle_api'"
        );
    }

    public function saveConfiguration()
    {
        $return = array();
        $return['resultat'] = false;
        $return['erreur'] = "";
        $config = SHOutils::getConfig();

        if (isset($_REQUEST['cle_api'])) {
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => pSQL(trim($_REQUEST['cle_api']))),
                "champs = 'cle_api'"
            )
            ) {
                $config['cle_api'] = pSQL(trim($_REQUEST['cle_api']));
            }
        }
        if (isset($_REQUEST['type']) && in_array($_REQUEST['type'], array("premium", "lowcost"))) {
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => pSQL($_REQUEST['type'])),
                "champs = 'sms_type'"
            )) {
                $config['sms_type'] = pSQL($_REQUEST['type']);
            }
        } else {
            $return['erreur'] = "type";
        }

        if (isset($_REQUEST['sms_taille']) && in_array(
            $_REQUEST['sms_taille'],
            array("1", "2", "3", "4", "5")
        )) {
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => (int) $_REQUEST['sms_taille']),
                "champs = 'sms_taille'"
            )) {
                $config['sms_taille'] = (int) $_REQUEST['sms_taille'];
            }
        } else {
            $return['erreur'] = "taille";
        }

        if (isset($_REQUEST['expediteur']) && $config['sms_type'] == "premium") {
            $expediteur = Db::getInstance()->escape(trim($_REQUEST['expediteur']));
            if (Tools::strlen($expediteur) <= 11 && !is_numeric($expediteur)) {
                if (Db::getInstance()->update(
                    'tunisiesms_configuration',
                    array('valeur' => $expediteur),
                    "champs = 'sms_expediteur'"
                )) {
                    $config['sms_expediteur'] = $expediteur;
                }
            } else {
                $return['erreur'] = "expediteur";
            }
        }

        if (isset($_REQUEST['sms_etat_annule'])) {
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => true),
                "champs = 'sms_etat_annule'"
            )) {
                $config['sms_etat_annule'] = true;
            }
        } else {
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => false),
                "champs = 'sms_etat_annule'"
            )) {
                $config['sms_etat_annule'] = false;
            }
        }

        if (isset($_REQUEST['sms_etat_annule_message'])) {
            $str = Db::getInstance()->escape(trim($_REQUEST['sms_etat_annule_message']));
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => $str),
                "champs = 'sms_etat_annule_message'"
            )) {
                $config['sms_etat_annule_message'] = $str;
            }
        }

        if (isset($_REQUEST['sms_etat_en_cours'])) {
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => true),
                "champs = 'sms_etat_en_cours'"
            )) {
                $config['sms_etat_en_cours'] = true;
            }
        } else {
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => false),
                "champs = 'sms_etat_en_cours'"
            )) {
                $config['sms_etat_en_cours'] = false;
            }
        }

        if (isset($_REQUEST['sms_etat_en_cours_message'])) {
            $str = Db::getInstance()->escape(trim($_REQUEST['sms_etat_en_cours_message']));
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => $str),
                "champs = 'sms_etat_en_cours_message'"
            )) {
                $config['sms_etat_en_cours_message'] = $str;
            }
        }

        if (isset($_REQUEST['sms_etat_expedie'])) {
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => true),
                "champs = 'sms_etat_expedie'"
            )) {
                $config['sms_etat_expedie'] = true;
            }
        } else {
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => false),
                "champs = 'sms_etat_expedie'"
            )) {
                $config['sms_etat_expedie'] = false;
            }
        }

        if (isset($_REQUEST['sms_etat_expedie_message'])) {
            $str = Db::getInstance()->escape(trim($_REQUEST['sms_etat_expedie_message']));
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => $str),
                "champs = 'sms_etat_expedie_message'"
            )) {
                $config['sms_etat_expedie_message'] = $str;
            }
        }

        if (isset($_REQUEST['sms_etat_livre'])) {
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => true),
                "champs = 'sms_etat_livre'"
            )) {
                $config['sms_etat_livre'] = true;
            }
        } else {
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => false),
                "champs = 'sms_etat_livre'"
            )) {
                $config['sms_etat_livre'] = false;
            }
        }

        if (isset($_REQUEST['sms_etat_livre_message'])) {
            $str = Db::getInstance()->escape(trim($_REQUEST['sms_etat_livre_message']));
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => $str),
                "champs = 'sms_etat_livre_message'"
            )) {
                $config['sms_etat_livre_message'] = $str;
            }
        }

        if (isset($_REQUEST['sms_etat_rembourse'])) {
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => true),
                "champs = 'sms_etat_rembourse'"
            )) {
                $config['sms_etat_rembourse'] = true;
            }
        } else {
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => false),
                "champs = 'sms_etat_rembourse'"
            )) {
                $config['sms_etat_rembourse'] = false;
            }
        }

        if (isset($_REQUEST['sms_etat_rembourse_message'])) {
            $str = Db::getInstance()->escape(trim($_REQUEST['sms_etat_rembourse_message']));
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => $str),
                "champs = 'sms_etat_rembourse_message'"
            )) {
                $config['sms_etat_rembourse_message'] = $str;
            }
        }

        if (empty($return['erreur'])) {
            if ($config['sms_type'] == "lowcost") {
                if (Db::getInstance()->update(
                    'tunisiesms_configuration',
                    array('valeur' => false),
                    "champs = 'sms_etat_livre_message'"
                )) {
                    $config['sms_taille'] = "1";
                }
            }
        }

        return $return;
    }

    public function saveConfigurationEmail()
    {
        $return = array();
        $return['resultat'] = false;
        $return['erreur'] = "";
        $config = SHOutils::getConfig();
        if (isset($_REQUEST['cle_api'])) {
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => pSQL(trim($_REQUEST['cle_api']))),
                "champs = 'cle_api'"
            )) {
                $config['cle_api'] = pSQL(trim($_REQUEST['cle_api']));
            }
        }

        if (isset($_REQUEST['email_expediteur'])) {
            $str = Db::getInstance()->escape($_REQUEST['email_expediteur']);
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => $str),
                "champs = 'email_expediteur'"
            )) {
                $config['email_expediteur'] = $str;
            }
        }

        if (isset($_REQUEST['email_nom_expediteur'])) {
            $str = Db::getInstance()->escape($_REQUEST['email_nom_expediteur']);
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => $str),
                "champs = 'email_nom_expediteur'"
            )) {
                $config['email_nom_expediteur'] = $str;
            }
        }

        if (isset($_REQUEST['email_reponse'])) {
            $str = Db::getInstance()->escape($_REQUEST['email_reponse']);
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => $str),
                "champs = 'email_reponse'"
            )) {
                $config['email_reponse'] = $str;
            }
        }

        if (isset($_REQUEST['email_sujet'])) {
            $str = Db::getInstance()->escape($_REQUEST['email_sujet']);
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => $str),
                "champs = 'email_sujet'"
            )) {
                $config['email_sujet'] = $str;
            }
        }

        if (isset($_REQUEST['email_etat_annule'])) {
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => true),
                "champs = 'email_etat_annule'"
            )) {
                $config['email_etat_annule'] = true;
            }
        } else {
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => false),
                "champs = 'email_etat_annule'"
            )) {
                $config['email_etat_annule'] = false;
            }
        }

        if (isset($_REQUEST['email_etat_annule_message'])) {
            $str = Db::getInstance()->escape($_REQUEST['email_etat_annule_message'], true);
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => $str),
                "champs = 'email_etat_annule_message'"
            )) {
                $config['email_etat_annule_message'] = $str;
            }
        }

        if (isset($_REQUEST['email_etat_en_cours'])) {
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => true),
                "champs = 'email_etat_en_cours'"
            )) {
                $config['email_etat_en_cours'] = true;
            }
        } else {
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => false),
                "champs = 'email_etat_en_cours'"
            )) {
                $config['email_etat_en_cours'] = false;
            }
        }

        if (isset($_REQUEST['email_etat_en_cours_message'])) {
            $str = Db::getInstance()->escape($_REQUEST['email_etat_en_cours_message'], true);
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => $str),
                "champs = 'email_etat_en_cours_message'"
            )) {
                $config['email_etat_en_cours_message'] = $str;
            }
        }

        if (isset($_REQUEST['email_etat_expedie'])) {
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => true),
                "champs = 'email_etat_expedie'"
            )) {
                $config['email_etat_expedie'] = true;
            }
        } else {
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => false),
                "champs = 'email_etat_expedie'"
            )) {
                $config['email_etat_expedie'] = false;
            }
        }

        if (isset($_REQUEST['email_etat_expedie_message'])) {
            $str = Db::getInstance()->escape($_REQUEST['email_etat_expedie_message'], true);
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => $str),
                "champs = 'email_etat_expedie_message'"
            )) {
                $config['email_etat_expedie_message'] = $str;
            }
        }

        if (isset($_REQUEST['email_etat_livre'])) {
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => true),
                "champs = 'email_etat_livre'"
            )) {
                $config['email_etat_livre'] = true;
            }
        } else {
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => false),
                "champs = 'email_etat_livre'"
            )) {
                $config['email_etat_livre'] = false;
            }
        }

        if (isset($_REQUEST['email_etat_livre_message'])) {
            $str = Db::getInstance()->escape($_REQUEST['email_etat_livre_message'], true);
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => $str),
                "champs = 'email_etat_livre_message'"
            )) {
                $config['email_etat_livre_message'] = $str;
            }
        }

        if (isset($_REQUEST['email_etat_rembourse'])) {
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => true),
                "champs = 'email_etat_rembourse'"
            )) {
                $config['email_etat_rembourse'] = true;
            }
        } else {
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => false),
                "champs = 'email_etat_rembourse'"
            )) {
                $config['email_etat_rembourse'] = false;
            }
        }

        if (isset($_REQUEST['email_etat_rembourse_message'])) {
            $str = Db::getInstance()->escape($_REQUEST['email_etat_rembourse_message'], true);
            if (Db::getInstance()->update(
                'tunisiesms_configuration',
                array('valeur' => $str),
                "champs = 'email_etat_rembourse_message'"
            )) {
                $config['email_etat_rembourse_message'] = $str;
            }
        }

        return $return;
    }

    public function exportContacts()
    {
        $return = array();
        $return['resultat'] = false;
        $return['erreur'] = "";
        $config = SHOutils::getConfig();
        $id_export = "";
        $nom_export = "";

        if (isset($_REQUEST['id_export']) && $_REQUEST['id_export'] != '1') {
            $id_export = $_REQUEST['id_export'];
            $nom_export = '';
        } elseif (isset($_REQUEST['id_export'])
            && $_REQUEST['id_export'] == '1'
            && isset($_REQUEST['nom_export'])
            && !empty($_REQUEST['nom_export'])) {
            $id_export = "1";
            $nom_export = Db::getInstance()->escape($_REQUEST['nom_export']);
        }

        if (Db::getInstance()->update(
            'tunisiesms_configuration',
            array('valeur' => (int) $id_export),
            "champs = 'id_export'"
        )) {
            $config['id_export'] = $id_export;
        }

        if (Db::getInstance()->update(
            'tunisiesms_configuration',
            array('valeur' => $nom_export),
            "champs = 'nom_export'"
        )) {
            $config['nom_export'] = $nom_export;
        }

        if ($id_export) {
            return SHOutils::exportContacts($id_export, $nom_export);
        }

        $return['erreur'] = "export_contacts";

        return $return;
    }

    public function exportNewsletterContacts()
    {
        $return = array();
        $return['resultat'] = false;
        $return['erreur'] = '';
        $config = SHOutils::getConfig();
        $id_export_newsletter = '';
        $nom_export_newsletter = '';

        if (isset($_REQUEST['id_export_newsletter']) && $_REQUEST['id_export_newsletter'] != '1') {
            $id_export_newsletter = Db::getInstance()->escape($_REQUEST['$id_export_newsletter']);
            $nom_export_newsletter = '';
        } elseif (isset($_REQUEST['id_export_newsletter']) && ($_REQUEST['id_export_newsletter'] == '1')
            && isset($_REQUEST['nom_export_newsletter']) && !empty($_REQUEST['nom_export_newsletter'])) {
            $id_export_newsletter = '1';
            $nom_export_newsletter = Db::getInstance()->escape($_REQUEST['nom_export_newsletter']);
        }

        if (Db::getInstance()->update(
            'tunisiesms_configuration',
            array('valeur' => (int) $id_export_newsletter),
            "champs = 'id_export_newsletter'"
        )) {
            $config['id_export_newsletter'] = $id_export_newsletter;
        }

        if (Db::getInstance()->update(
            'tunisiesms_configuration',
            array('valeur' => $nom_export_newsletter),
            "champs = 'nom_export_newsletter'"
        )) {
            $config['nom_export_newsletter'] = $nom_export_newsletter;
        }

        if (!empty($id_export_newsletter)) {
            return SHOutils::exportNewsletterContacts($id_export_newsletter, $nom_export_newsletter);
        }

        $return['erreur'] = "newsletter_export_contacts";

        return $return;
    }

    public function sendSMS()
    {
        $expediteur = "";
        $destinataires = array();
        $message = "";
        $type = "premium";
        $taille = "1";        

        if (isset($_REQUEST['destinataires_autres']) && !empty($_REQUEST['destinataires_autres'])) {
            $destinataires_autres = explode("\n", $_REQUEST['destinataires_autres']);
            foreach ($destinataires_autres as $destinataire_autre) {
                if (($n = SHOutils::correctNumero($destinataire_autre)) && !in_array($n, $destinataires)) {
                    $destinataires[] = $n;
                }
            }
        }

        if (isset($_REQUEST['destinataires']) && !empty($_REQUEST['destinataires'])) {
            $destinataires_liste = $_REQUEST['destinataires'];
            foreach ($destinataires_liste as $destinataire_liste) {
                if (($n = SHOutils::correctNumero($destinataire_liste)) && !in_array($n, $destinataires)) {
                    $destinataires[] = $n;
                }
            }
        }

        if (isset($_REQUEST['expediteur']) && !empty($_REQUEST['expediteur'])) {
            $expediteur = trim($_REQUEST['expediteur']);
        }

        if (isset($_REQUEST['message']) && !empty($_REQUEST['message'])) {
            $message = trim($_REQUEST['message']);
        }
       

        if (isset($_REQUEST['type']) && in_array($_REQUEST['type'], array("premium", "lowcost"))) {
            $type = $_REQUEST['type'];
        }

        if (isset($_REQUEST['sms_taille']) && in_array($_REQUEST['sms_taille'], array("1", "2", "3", "4", "5"))) {
            $taille = $_REQUEST['sms_taille'];
        }

        if ($type == "lowcost") {
            $taille = "1";
            $expediteur = "";
        }

        return SHOutils::sendSMS($expediteur, $destinataires, $message, $type, $taille);
    }

    public function sendEmail()
    {
        $email_expediteur = "";
        $email_nom_expediteur = "";
        $email_sujet = "";
        $email_reponse = "";
        $email_destinataires = array();
        $email_message = "";

        if (isset($_REQUEST['email_destinataires_autres']) && !empty($_REQUEST['email_destinataires_autres'])) {
            $destinataires_autres = explode(PHP_EOL, $_REQUEST['email_destinataires_autres']);
            foreach ($destinataires_autres as $destinataire_autre) {
                if (($destinataire_autre) && !in_array($destinataire_autre, $email_destinataires)) {
                    $email_destinataires[] = $destinataire_autre;
                }
            }
        }

        if (isset($_REQUEST['email_destinataires']) && !empty($_REQUEST['email_destinataires'])) {
            $destinataires_liste = $_REQUEST['email_destinataires'];
            foreach ($destinataires_liste as $destinataire_liste) {
                if (($destinataires_liste) && !in_array($destinataire_liste, $email_destinataires)) {
                    $email_destinataires[] = $destinataire_liste;
                }
            }
        }

        if (isset($_REQUEST['email_expediteur']) && !empty($_REQUEST['email_expediteur'])) {
            $email_expediteur = $_REQUEST['email_expediteur'];
        }

        if (isset($_REQUEST['email_nom_expediteur']) && !empty($_REQUEST['email_nom_expediteur'])) {
            $email_nom_expediteur = $_REQUEST['email_nom_expediteur'];
        }

        if (isset($_REQUEST['email_reponse']) && !empty($_REQUEST['email_reponse'])) {
            $email_reponse = $_REQUEST['email_reponse'];
        }

        if (isset($_REQUEST['email_sujet']) && !empty($_REQUEST['email_sujet'])) {
            $email_sujet = $_REQUEST['email_sujet'];
        }

        if (isset($_REQUEST['email_message']) && !empty($_REQUEST['email_message'])) {
            $email_message = $_REQUEST['email_message'];
        }

        return SHOutils::sendEmail(
            $email_expediteur,
            $email_nom_expediteur,
            $email_reponse,
            $email_sujet,
            $email_destinataires,
            $email_message
        );
    }
}
