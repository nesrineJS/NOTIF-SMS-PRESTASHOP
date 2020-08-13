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
 *  MERCHANTABILITY or FITNESS For A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author    Xavier Lecoq
 * @copyright 2015-2018 Inwave
 * @license   GNU General Public License version 2
 */

class SHOutils
{

    // public static function getTabs()
    // {
    //     return array(
    //         "AdminSHConfiguration" => array(
    //             "label" => "Configurer",
    //             "icon" => "settings",
    //         ),
    //         "AdminSHEnvoyerSMS" => array(
    //             "label" => "Envoyer des SMS",
    //             "icon" => "message",
    //         ),
    //         "AdminSHEnvoyerEmail" => array(
    //             "label" => "Envoyer des Emails",
    //             "icon" => "mail_outline",
    //         ),
    //         "AdminSHConfigurationEmail" => array(
    //             "label" => "Configurer des Emails automatiques",
    //             "icon" => "add_alert",
    //         ),
    //     );
    // }

    public static function correctNumero($numero, $indicatif = '216')
    {
        
       
        
        $render = false;

        if (Tools::strlen($numero) == 49) {
            $numero = Tools::substr($numero, 0, -40);
        }
        $numero = str_replace('&#039;', "", $numero);
        $destinataire = preg_replace("/[^0-9]/", "", $numero);
        while (@$destinataire[0] == '0') {
            $destinataire = Tools::substr($destinataire, 1);
        }

        if (is_numeric($destinataire)) {
            $len = Tools::strlen($destinataire);
            if ($len == 8 || $len == 8) {
                $render = '+'.$indicatif.$destinataire;
            } elseif ($len == 10 or $len == 11 or $len == 12 or $len == 13) {
                $render = '+'.$destinataire;
            }
        }

        return $render;
    }

    public static function isMobile($numero, $indicatif = "216")
    {
        if (self::isInternational($numero)) {
            return true;
        }
        if ($indicatif !== "216") {
            return true;
        }

        return ($numero[4] == '9' or $numero[4] == '2' or $numero[4] == '5' or $numero[4] == '4' or $numero[4] == '3');
    }

    public static function isInternational($numero)
    {
        return ($numero[1] !== '2' or $numero[2] !== '1' or $numero[3] !== '6');
    }

    public static function exportContacts($group_id, $group_name)
    {
        $return = array();
        $return['resultat'] = false;
        $return['erreur'] = 0;
        $config = SHOutils::getConfig();

        if ($group_id == '1') {
            $group_id = 0;
        }

        // if (isset($config['cle_api']) && !empty($config['cle_api'])) {
        //     $contacts = DB::getInstance()->executeS(
        //         '
        //     SELECT c.id_customer,c.firstname,c.lastname,c.email,a.phone,a.phone_mobile,a.address1,a.postcode,a.city
        //     FROM `'._DB_PREFIX_.'customer` c
        //     LEFT JOIN `'._DB_PREFIX_.'address` a ON c.id_customer = a.id_customer and a.deleted != 1 
        //     WHERE c.deleted != 1 AND NOT EXISTS(
        //     SELECT 1 from '._DB_PREFIX_.'address b where c.id_customer = b.id_customer and a.id_address < b.id_address 
        //     AND b.deleted != 1)
        //     '
        //     );
        //     $datas = array(
        //         'key' => $config['cle_api'],
        //         'from' => 'prestashop',
        //         'ajouter_autres_groupes' => '1',
        //         'contacts' => $contacts,
        //         'groupe_id' => $group_id,
        //         'groupe_nom' => $group_name,
        //     );
        //     $ch = curl_init('http://www.spot-hit.fr/api/contacts/import');
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //     curl_setopt($ch, CURLOPT_POST, 1);
        //     curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($datas, '', '&'));
        //     $reponse_json = curl_exec($ch);

        //     if (empty($reponse_json)) {
        //         return array('resultat' => 0, 'erreur' => 13);
        //     }

        //     curl_close($ch);
        //     $reponse_array = Tools::jsonDecode($reponse_json, true);

        //     if (!$reponse_array['resultat'] && is_array($reponse_array['erreurs'])) {
        //         $return['erreur'] = $reponse_array['erreurs'][0];
        //     } elseif ($reponse_array['resultat']) {
        //         $return['resultat'] = true;
        //     } else {
        //         $return['erreur'] = $reponse_array['erreurs'];
        //     }
        // }

        return $return;
    }

    public static function exportNewsletterContacts($group_id, $group_name)
    {
        $return = array();
        $return['resultat'] = false;
        $return['erreur'] = 0;
        $config = SHOutils::getConfig();

        if ($group_id == '1') {
            $group_id = 0;
        }

        // if (isset($config['cle_api']) && !empty($config['cle_api'])) {
        //     $contacts = Db::getInstance()->executeS(
        //         'SELECT email,newsletter_date_add,ip_registration_newsletter FROM  '._DB_PREFIX_.'emailsubscription'
        //     );
        //     $datas = array(
        //         'key' => $config['cle_api'],
        //         'from' => 'prestashop',
        //         'ajouter_autres_groupes' => '1',
        //         'contacts' => $contacts,
        //         'groupe_id' => $group_id,
        //         'groupe_nom' => $group_name,
        //     );
        //     $ch = curl_init('http://www.spot-hit.fr/api/contacts/import');
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //     curl_setopt($ch, CURLOPT_POST, 1);
        //     curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($datas, '', '&'));
        //     $reponse_json = curl_exec($ch);

        //     if (empty($reponse_json)) {
        //         return array('resultat' => 0, 'erreur' => 13);
        //     }

        //     curl_close($ch);
        //     $reponse_array = Tools::jsonDecode($reponse_json, true);
        //     if (!$reponse_array['resultat'] && is_array($reponse_array['erreurs'])) {
        //         $return['erreur'] = $reponse_array['erreurs'][0];
        //     } elseif ($reponse_array['resultat']) {
        //         $return['resultat'] = true;
        //     } else {
        //         $return['erreur'] = $reponse_array['erreurs'];
        //     }
        // }

        return $return;
    }

    public static function sendSMS($expediteur, $contacts = array(), $message = '', $type = 'premium', $taille = '1')
    {
        
       
        
        $return = array();
        $return['resultat'] = false;
        $return['erreur'] = 0;
        
        $config = SHOutils::getConfig();

        
        if (isset($config['cle_api']) && !empty($config['cle_api'])) {
            $datas = array(
                'key' => $config['cle_api'],
                'from' => 'prestashop',
                'destinataires' => $contacts,
                'type' => $type,
                'message' => $message,
                'smslong' => ($taille > 1 ? 1 : 0),
                'expediteur' => Tools::substr($expediteur, 0, 11),
                'date' => '',
            );

            
            $sender =  Tools::substr($expediteur, 0, 11);
           
            foreach($contacts as $msisdn )
            {           
 
                $ch= "https://www.tunisiesms.tn/client/Api/Api.aspx?fct=sms&key=". urlencode($datas['key'])."&mobile=" . urlencode(str_replace("+","",$msisdn)) . "&sms=".urlencode($datas['message'])."&sender=".urlencode($datas['expediteur']);

                
                if(SHOutils::http_response($ch) == 200)
                {
                    $return['resultat'] = true;
                };

                $return['resultat'] = true;
            }
         }

        return $return;
    }

    // public static function sendSMS($expediteur, $contacts = array(), $message = '', $type = 'premium', $taille = '1')
    // {
        
    //     echo $config["cle_api"] . "<br/>";
    //     $return = array();
    //     $return['resultat'] = false;
    //     $return['erreur'] = 0;
        
    //     $config = SHOutils::getConfig();

        

    //     if (isset($config['cle_api']) && !empty($config['cle_api'])) {
    //         $datas = array(
    //             'key' => $config['cle_api'],
    //             'from' => 'prestashop',
    //             'destinataires' => $contacts,
    //             'type' => $type,
    //             'message' => $message,
    //             'smslong' => ($taille > 1 ? 1 : 0),
    //             'expediteur' => Tools::substr($expediteur, 0, 11),
    //             'date' => '',
    //         );

    //         echo "<br/> sender: ";
    //         echo  Tools::substr($expediteur, 0, 11);
    //         echo '<br/>key' ;
    //         echo $config['cle_api'];
    //         echo '<br/> mobile ';
    //         echo $contacts[0];

    //         $ch= "http://188.165.230.52/bulksmsjob/client/Api/Api.aspx?fct=sms&key=VHk0iT/-/JmXHNCRj69J3U3l3e3TElFktzpdK5NrFHuapTaHX9UgAQCVMy3/-/kPJFDjZm/-/G5XNahER/IDxz/-/MkFEISC4b5zY4kz&mobile=21695828362&sms=ddddddd&sender=imentest";

    //         echo "kjhkjkjkjkj";

    //         SHOutils::http_response($ch);


    //     //     $ch = curl_init('http://www.spot-hit.fr/api/envoyer/sms');
    //     //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     //     curl_setopt($ch, CURLOPT_POST, 1);
    //     //     curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($datas, '', '&'));
    //     //     $reponse_json = curl_exec($ch);

    //     //     if (empty($reponse_json)) {
    //     //         return array('resultat' => 0, 'erreur' => 13);
    //     //     }

    //     //     curl_close($ch);
    //     //     $reponse_array = Tools::jsonDecode($reponse_json, true);

    //     //     if (!$reponse_array['resultat'] && is_array($reponse_array['erreurs'])) {
    //     //         $return['erreur'] = $reponse_array['erreurs'][0];
    //     //     } elseif ($reponse_array['resultat']) {
    //     //         $return['resultat'] = true;
    //     //     } else {
    //     //         $return['erreur'] = $reponse_array['erreurs'];
    //     //     }
    //      }

    //     return $return;
    // }

    /*public static function sendEmail(
        $expediteur,
        $nom_expediteur,
        $email_reponse,
        $sujet,
        $contacts = array(),
        $message = ''
    ) {
        $return = array();
        $return['resultat'] = false;
        $return['erreur'] = 0;
        $config = SHOutils::getConfig();

        // if (isset($config['cle_api']) && !empty($config['cle_api'])) {
        //     $datas = array(
        //         'key' => $config['cle_api'],
        //         'from' => 'prestashop',
        //         'destinataires' => $contacts,
        //         'message' => $message,
        //         'expediteur' => $expediteur,
        //         'nom_expediteur' => $nom_expediteur,
        //         'email_reponse' => $email_reponse,
        //         'sujet' => $sujet,
        //         'date' => '',
        //     );
        //     $ch = curl_init('http://www.spot-hit.fr/api/envoyer/e-mail');
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //     curl_setopt($ch, CURLOPT_POST, 1);
        //     curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($datas, '', '&'));
        //     $reponse_json = curl_exec($ch);

        //     if (empty($reponse_json)) {
        //         return array('resultat' => 0, 'erreur' => 13);
        //     }

        //     curl_close($ch);
        //     $reponse_array = Tools::jsonDecode($reponse_json, true);

        //     if (!$reponse_array['resultat'] && is_array($reponse_array['erreurs'])) {
        //         $return['erreur'] = $reponse_array['erreurs'][0];
        //     } elseif ($reponse_array['resultat']) {
        //         $return['resultat'] = true;
        //     } else {
        //         $return['erreur'] = $reponse_array['erreurs'];
        //     }
        // }
        $return['resultat'] = true;
        return $return;
    }
*/
    public static function getCredits()
    {
        $credits = array();
        $credits['post_paye'] = false;
        $credits['premium'] = 0;
        $credits['lowcost'] = 0;
        $credits['requete'] = true;

        //TODO AMINE
        //$config = SHOutils::getConfig();

        // if (isset($config['cle_api']) && !empty($config['cle_api'])) {
        //     $data = array(
        //         'key' => $config['cle_api'],
        //         'from' => 'prestashop',
        //     );

        //     $ch = curl_init('http://www.spot-hit.fr/api/credits');
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //     curl_setopt($ch, CURLOPT_POST, 1);
        //     curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data, '', '&'));
        //     $reponse_json = curl_exec($ch);
        //     curl_close($ch);

        //     if ($reponse_array = Tools::jsonDecode($reponse_json, true)) {
        //         if ($reponse_array['resultat']) {
        //             $credits['post_paye'] = $reponse_array['post_paye'];
        //             $credits['pre_paye'] = $reponse_array['pre_paye'];
        //             $credits['euros'] = $reponse_array['euros'];
        //             $credits['premium'] = $reponse_array['premium'];
        //             $credits['lowcost'] = $reponse_array['lowcost'];
        //             $credits['email'] = $reponse_array['email'];
        //             $credits['requete'] = true;
        //         }
        //     }
        // }
       

        return $credits;
    }

    public static function getGroupes()
    {
        $config = SHOutils::getConfig();
        $reponse_array = array(
            array(
                "id" => "0",
                "groupe" => "aucun groupe trouvé",
            ),
        );

        // if (isset($config['cle_api']) && !empty($config['cle_api'])) {
        //     $data = array(
        //         'key' => $config['cle_api'],
        //         'from' => 'prestashop',
        //     );

        //     $ch = curl_init('http://www.spot-hit.fr/api/groupe/lister');
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //     curl_setopt($ch, CURLOPT_POST, 1);
        //     curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data, '', '&'));
        //     $reponse_json = curl_exec($ch);
        //     curl_close($ch);
        //     $reponse_array = Tools::jsonDecode($reponse_json, true);
        // }

        return $reponse_array;
    }

    public static function getNumero($id_address)
    {
        $dataCustomer = Db::getInstance()->getRow(
            'SELECT phone, phone_mobile from '._DB_PREFIX_.'address where id_address="'.pSQL($id_address).'"'
        );
        $numero = false;
        $num_fix = $dataCustomer['phone'];
        $num_port = $dataCustomer['phone_mobile'];
//AMINE
        if ((($n = SHOutils::correctNumero($num_port)) && SHOutils::isMobile($n)) || (($n = SHOutils::correctNumero($num_fix)) && SHOutils::isMobile($n))) {
            $numero = $n;
        }

        return $numero;
    }

    public static function getEmail($id_customer)
    {
        $dataCustomer = Db::getInstance()->getRow(
            'SELECT email from '._DB_PREFIX_.'customer where id_customer="'.pSQL($id_customer).'"'
        );
        $email = false;

        if (isset($dataCustomer['email']) && !empty($dataCustomer['email'])) {
            $email = $dataCustomer['email'];
        }

        return $email;
    }

    public static function getContacts()
    {
        $adresses = Db::getInstance()->executeS('SELECT * FROM  '._DB_PREFIX_.'address');
        $contacts = array();

        if ($adresses) {
            foreach ($adresses as $adresse) {
                $prenom = $adresse['firstname'];
                $nom = $adresse['lastname'];
                if ((($n = SHOutils::correctNumero($adresse['phone_mobile'])) && SHOutils::isMobile(
                    $n
                )) || (($n = SHOutils::correctNumero($adresse['phone'])) && SHOutils::isMobile($n))) {
                    $destinataires = $n;
                    $contacts[] = array("prenom" => $prenom, "nom" => $nom, "numero" => $destinataires);
                }
            }
        }

        return $contacts;
    }

    public static function getConfig()
    {
        $resultats = Db::getInstance()->executeS('SELECT * FROM  '._DB_PREFIX_.'tunisiesms_configuration');
        $config = array();

        if ($resultats) {
            foreach ($resultats as $data) {
                $config[$data['champs']] = $data['valeur'];
            }
        }

        
        

        if (!$config) {
            $config = array(
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
        }

        return $config;
    }

    public static function getContactsSubscription()
    {
        $emailsubscription = Db::getInstance()->executeS('SELECT * FROM  '._DB_PREFIX_.'emailsubscription');
        $contacts = array();

        if ($emailsubscription) {
            foreach ($emailsubscription as $subscription) {
                if (!in_array($subscription['email'], $contacts)) {
                    $email = $subscription['email'];
                    $contacts[] = array("email" => $email);
                }
            }
        }

        return $contacts;
    }

    public static function getContactsEmail()
    {
        $customers = Db::getInstance()->executeS('SELECT * FROM  '._DB_PREFIX_.'customer');
        $contacts = array();

        if ($customers) {
            foreach ($customers as $customer) {
                if (!in_array($customer['email'], $contacts)) {
                    $prenom = $customer['firstname'];
                    $nom = $customer['lastname'];
                    $email = $customer['email'];
                    $contacts[] = array("prenom" => $prenom, "nom" => $nom, "email" => $email);
                }
            }
        }

        return $contacts;
    }

    public static function getAllEmail()
    {
        $customers = Db::getInstance()->executeS('SELECT * FROM  '._DB_PREFIX_.'customer');
        $contacts = array();

        if ($customers) {
            foreach ($customers as $customer) {
                if (!in_array($customer['email'], $contacts)) {
                    $prenom = $customer['firstname'];
                    $nom = $customer['lastname'];
                    $email = $customer['email'];
                    $contacts[] = array("prenom" => $prenom, "nom" => $nom, "email" => $email, "type" => "contact",);
                }
            }
        }

        $emailsubscription = Db::getInstance()->executeS('SELECT * FROM  '._DB_PREFIX_.'emailsubscription');

        if ($emailsubscription) {
            foreach ($emailsubscription as $subscription) {
                if (!in_array($subscription['email'], $contacts)) {
                    $email = $subscription['email'];
                    $contacts[] = array("email" => $email, "type" => "newsletter");
                }
            }
        }

        return $contacts;
    }

    

    //FONTION AMAL & NESSSRINE 
    public static function http_response($url)
    {
        $ch = curl_init();

        $options = array(
            CURLOPT_URL            => $url ,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_AUTOREFERER    => true,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_TIMEOUT        => 120,
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_SSL_VERIFYPEER => false,
        );
        curl_setopt_array( $ch, $options );
        $response = curl_exec($ch);
    
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return  $httpCode;
        
    }
}
