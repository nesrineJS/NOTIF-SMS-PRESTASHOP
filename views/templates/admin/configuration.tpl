{*
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
*  @copyright 2015-2019 Inwave
*  @license   GNU General Public License version 2
*}


<div class="tunisiesms">

  {include file="$templates_dir/admin/credits.tpl"}

  {include file="$templates_dir/admin/export_contacts.tpl"}

  {if isset($config['cle_api']) & !empty($config['cle_api']|escape:'htmlall':'UTF-8') & $credits['requete']}
  <div class="panel">
  <div class="row configuration">

    <form method="POST" role="form" class="form-horizontal">

      <div class="col-md-12">

        <div class="row">

          <div class="col-md-12">

            <h1>
              {l s='Configuration' mod='tunisiesms'}

            </h1>

          </div>

        </div>

        {if $retour['resultat']}

        <div class="alert alert-success">

          {l s='Your configuration has been updated!' mod='tunisiesms'}

        </div>

        {elseif !$retour['resultat'] & !empty($retour['erreur'])}

        <div class="alert alert-danger">

          {if $retour['erreur'] == "expediteur"}

            {l s='Your sender must not be a phone number and must have' mod='tunisiesms'} <strong>{l s='11 characters -' mod='tunisiesms'} <span
                class="nbr_sms">1</span>{l s=' SMS maximum' mod='tunisiesms'}</strong>.

          {elseif $retour['erreur'] == "type"}

            {l s='SMS type is invalid, please choose between' mod='tunisiesms'} <strong>{l s='Premium' mod='tunisiesms'}</strong> {l s='and' mod='tunisiesms'}<strong> {l s='Lowcost' mod='tunisiesms'}</strong>.

          {else}

            {l s='An error has occurred, please check your fields.' mod='tunisiesms'}

          {/if}

        </div>

        {/if}

        <div class="row row-margin-top">

          <div class="col-md-6">

            <div class="row row_title">

              <div class="col-md-12">

                <h2><span class="icon icon-edit"></span>{l s='General configuration' mod='tunisiesms'}</h2>

              </div>

            </div>

          </div>

        </div>

        <div class="row row-margin-top">

          <div class="col-md-6">

            <div class="row">

              <div class="form-group">

                <label class="col-sm-4 control-label" for="cle_api">{l s='API Key' mod='tunisiesms'}</label>

                <div class="col-sm-1"></div>

                <div class="col-sm-7">

                  <input type="text" class="form-control" name="cle_api" id="cle_api"
                         value="{$config['cle_api']|escape:'htmlall':'UTF-8'}">

                </div>

              </div>

            </div>

          </div>

        </div>

        <div class="row row-margin-top" style="display:none">

          <div class="col-md-6">

            <div class="row">

              <div class="form-group">

                <label class="col-sm-4 control-label" for="type">{l s='Type' mod='tunisiesms'}</label>

                <div class="col-sm-1"></div>

                <div class="col-sm-7">

                  <select class="form-control" name="type" id="type">

                    <option value="premium" {if $config[
                    'sms_type'] == "premium"}selected="selected"{/if}>{l s='Premium' mod='tunisiesms'}</option>

                    <option value="lowcost" {if $config[
                    'sms_type'] == "lowcost"}selected="selected"{/if}>{l s='Lowcost' mod='tunisiesms'}</option>

                  </select>

                </div>

              </div>

            </div>

          </div>

        </div>

        <div class="row row-margin-top taille_max" {if $config[
        'sms_type'] == "lowcost"}style="display:none;"{/if}>

        <div class="col-md-6">

          <div class="row">

            <div class="form-group">

              <label class="col-sm-4 control-label" for="sms_taille">{l s='Maximum size of the SMS' mod='tunisiesms'}</label>

              <div class="col-sm-1"></div>

              <div class="col-sm-7">

                <select class="form-control" name="sms_taille" id="sms_taille">

                  <option value="1" {if $config[
                  'sms_taille'] == "1"}selected="selected"{/if}>1 SMS</option>

                  <option value="2" {if $config[
                  'sms_taille'] == "2"}selected="selected"{/if}>2 SMS</option>

                  <option value="3" {if $config[
                  'sms_taille'] == "3"}selected="selected"{/if}>3 SMS</option>

                

                </select>

              </div>

            </div>

          </div>

        </div>

      </div>

      <div class="row row-margin-top expediteur" {if $config[
      'sms_type'] != "premium"}style="display:none;"{/if}>

      <div class="col-md-6">

        <div class="row">

          <div class="form-group">

            <label class="col-sm-4 control-label" for="expediteur">{l s='Sender\'s name' mod='tunisiesms'}</label>

            <div class="col-sm-1"></div>

            <div class="col-sm-7">

              <input type="text" class="form-control" name="expediteur" maxlength="11" id="expediteur"
                     value="{$config['sms_expediteur']|escape:'htmlall':'UTF-8'}">

            </div>

          </div>

        </div>

      </div>

  </div>

  <div class="row row-margin-top">

    <div class="col-md-6">

      <div class="row row_title">

        <div class="col-md-12">

          <h2><span class="icon icon-comment"></span>{l s='Configuring SMS notifications' mod='tunisiesms'}</h2>

        </div>

      </div>

    </div>

  </div>


  <div class="row row-margin-top">

    <div class="col-md-6">

      <div class="choix_type_param">

        <label for="sms_etat_annule" class="label_block">

          <div class="row">

            <div class="col-md-12">

              <p class="text-left"><input type="checkbox" class="form-control" name="sms_etat_annule"
                                          id="sms_etat_annule" {if
                                          $config['sms_etat_annule']}checked="checked"{/if}><span
                    class="select_choix"><span class="icon icon-check"></span></span>
                {l s='Enable notifications for the status "Canceled"' mod='tunisiesms'}</p>

            </div>

          </div>

          <div class="row row_notification">

            <div class="col-md-12">

              <textarea name="sms_etat_annule_message" class="form-control notification_message" rows="3"
                        id="sms_etat_annule_message">{$config['sms_etat_annule_message']|escape:'htmlall':'UTF-8'}</textarea>

              <div id="sms_etat_annule_message_compteur" class="message_compteur"><span
                    class="caracteres">0</span>/<span class="max_caracteres">160</span> {l s='characters -' mod='tunisiesms'} <span
                    class="nbr_sms">1</span> SMS
              </div>

            </div>

          </div>

        </label>

      </div>

    </div>

  </div>


  <div class="row row-margin-top">

    <div class="col-md-6">

      <div class="choix_type_param">

        <label for="sms_etat_en_cours" class="label_block">

          <div class="row">

            <div class="col-md-12">

              <p class="text-left"><input type="checkbox" class="form-control" name="sms_etat_en_cours"
                                          id="sms_etat_en_cours" {if $config['sms_etat_en_cours']}checked="checked"{/if}><span
                    class="select_choix"><span class="icon icon-check"></span></span>
                {l s='Enable notifications for the status "In preparation"' mod='tunisiesms'}
              </p>

            </div>

          </div>

          <div class="row row_notification">

            <div class="col-md-12">

              <textarea name="sms_etat_en_cours_message" class="form-control notification_message" rows="3"
                        id="sms_etat_en_cours_message">{$config['sms_etat_en_cours_message']|escape:'htmlall':'UTF-8'}</textarea>

              <div id="sms_etat_en_cours_message_compteur" class="message_compteur"><span
                    class="caracteres">0</span>/<span class="max_caracteres">160</span> {l s='characters -' mod='tunisiesms'} <span
                    class="nbr_sms">1</span> SMS
              </div>

            </div>

          </div>

        </label>

      </div>

    </div>

  </div>


  <div class="row row-margin-top">

    <div class="col-md-6">

      <div class="choix_type_param">

        <label for="sms_etat_expedie" class="label_block">

          <div class="row">

            <div class="col-md-12">

              <p class="text-left"><input type="checkbox" class="form-control" name="sms_etat_expedie"
                                          id="sms_etat_expedie" {if
                                          $config['sms_etat_expedie']}checked="checked"{/if}><span class="select_choix"><span
                      class="icon icon-check"></span></span> {l s='Enable notifications for the "Shipped" state' mod='tunisiesms'}</p>

            </div>

          </div>

          <div class="row row_notification">

            <div class="col-md-12">

              <textarea name="sms_etat_expedie_message" class="form-control notification_message" rows="3"
                        id="sms_etat_expedie_message">{$config['sms_etat_expedie_message']|escape:'htmlall':'UTF-8'}</textarea>

              <div id="sms_etat_expedie_message_compteur" class="message_compteur"><span
                    class="caracteres">0</span>/<span class="max_caracteres">160</span> {l s='characters -' mod='tunisiesms'} <span
                    class="nbr_sms">1</span> SMS
              </div>

            </div>

          </div>

        </label>

      </div>

    </div>

  </div>


  <div class="row row-margin-top">

    <div class="col-md-6">

      <div class="choix_type_param">

        <label for="sms_etat_livre" class="label_block">

          <div class="row">

            <div class="col-md-12">

              <p class="text-left"><input type="checkbox" class="form-control" name="sms_etat_livre" id="sms_etat_livre"
                                          {if $config['sms_etat_livre']}checked="checked"{/if}><span
                    class="select_choix"><span class="icon icon-check"></span></span>
                {l s='Enable notifications for the "Delivered" state' mod='tunisiesms'}
              </p>

            </div>

          </div>

          <div class="row row_notification">

            <div class="col-md-12">

              <textarea name="sms_etat_livre_message" class="form-control notification_message" rows="3"
                        id="sms_etat_livre_message">{$config['sms_etat_livre_message']|escape:'htmlall':'UTF-8'}</textarea>

              <div id="sms_etat_livre_message_compteur" class="message_compteur"><span class="caracteres">0</span>/<span
                    class="max_caracteres">160</span> {l s='characters -' mod='tunisiesms'} <span class="nbr_sms">1</span> SMS
              </div>

            </div>

          </div>

        </label>

      </div>

    </div>

  </div>


  <div class="row row-margin-top">

    <div class="col-md-6">

      <div class="choix_type_param">

        <label for="sms_etat_rembourse" class="label_block">

          <div class="row">

            <div class="col-md-12">

              <p class="text-left"><input type="checkbox" class="form-control" name="sms_etat_rembourse"
                                          id="sms_etat_rembourse" {if $config['sms_etat_rembourse']}checked="checked"{/if}><span
                    class="select_choix"><span class="icon icon-check"></span></span>
                {l s='Enable notifications for the "Refunded" state' mod='tunisiesms'}
              </p>

            </div>

          </div>

          <div class="row row_notification">

            <div class="col-md-12">

              <textarea name="sms_etat_rembourse_message" class="form-control notification_message" rows="3"
                        id="sms_etat_rembourse_message">{$config['sms_etat_rembourse_message']|escape:'htmlall':'UTF-8'}</textarea>

              <div id="sms_etat_rembourse_message_compteur" class="message_compteur"><span
                    class="caracteres">0</span>/<span class="max_caracteres">160</span> {l s='characters -' mod='tunisiesms'} <span
                    class="nbr_sms">1</span> SMS
              </div>

            </div>

          </div>

        </label>

      </div>

    </div>

  </div>


  <div class="row row-margin-top">

    <div class="col-md-6 text-right">

      <button class="btn btn-success btn-lg" style="margin-left:25px;" name="action" value="save_configuration"
              type="submit">{l s='Save' mod='tunisiesms'}
      </button>

    </div>

  </div>


</div>

</form>
</div>
</div>

{/if}

<div class="alert alert-info">
<strong> If you want you can use these order keys in your message :</strong><br/>
<ul>
<li>{l s='%COMMANDE%    : Commande Id.' mod='tunisiesms'}</li>
<li>{l s='%REFERENCE%   : Commande Reference.' mod='tunisiesms'}</li>
<li>{l s='%PAYMENT%     : Payement Type.' mod='tunisiesms'}</li>
<li>{l s='%PRICE%       : Total To Pay.' mod='tunisiesms'}</li>


</ul>
</div>
</div>

