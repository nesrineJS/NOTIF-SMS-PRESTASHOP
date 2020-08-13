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

  {if isset($config['cle_api']) & !empty($config['cle_api']) & $credits['requete']}
    <div class="panel">
    <div class="row envoyersms">

      <form method="POST" role="form" class="form-horizontal">

        <div class="col-md-12">

          <div class="row">

            <div class="col-md-12">

              <h1>

                {l s='Send SMS' mod='tunisiesms'}

              </h1> 

            </div>

          </div>

          {if $retour['resultat']}

            <div class="alert alert-success">

              {l s='Your SMS have been sent!' mod='tunisiesms'}

            </div>

          {elseif !$retour['resultat'] & !empty($retour['erreur'])}

            <div class="alert alert-danger">

              {if $retour['erreur'] == 1}

                {l s='The type of SMS is unspecified or incorrect.' mod='tunisiesms'}

              {elseif $retour['erreur'] == 2}

                {l s='The message is empty' mod='tunisiesms'}

              {elseif $retour['erreur'] == 3}

                {l s='The message contains more than 160 characters.' mod='tunisiesms'}

              {elseif $retour['erreur'] == 4}

                {l s='No valid recipient is filled' mod='tunisiesms'}

              {elseif $retour['erreur'] == 5}

                {l s='Prohibited number: only shipments in Metropolitan France are authorized for Lowcost SMS.' mod='tunisiesms'}

              {elseif $retour['erreur'] == 6}

                {l s='Invalid recipient number.' mod='tunisiesms'}

              {elseif $retour['erreur'] == 7}

                {l s='Your account does not have a defined formula.' mod='tunisiesms'}

              {elseif $retour['erreur'] == 8}

                {l s='The sender can only contain 11 characters.' mod='tunisiesms'}

              {elseif $retour['erreur'] == 9}

                {l s='The system has encountered an error, please contact us.' mod='tunisiesms'}

              {elseif $retour['erreur'] == 10}

                {l s='You do not have enough SMS to send.' mod='tunisiesms'}

              {elseif $retour['erreur'] == 11}

                {l s='Sending messages is disabled for the demonstration.' mod='tunisiesms'}

              {elseif $retour['erreur'] == 12}

                {l s='Your account has been suspended. Contact us for more information.' mod='tunisiesms'}

              {elseif $retour['erreur'] == 13}

                {l s='The registered API key is not correct.' mod='tunisiesms'}

              {else}

                {l s='An error occurred, please check your fields.' mod='tunisiesms'}

              {/if}

            </div>

          {/if}



          <div class="row row-margin-top">

            <div class="col-md-6">

              <div class="row row_title">

                <div class="col-md-12">

                  <h2><span class="icon icon-comment"></span>Message</h2>

                </div>

              </div>

            </div>

          </div>



          <div class="row row-margin-top" style="display:none">

            <div class="col-md-6">

              <div class="row">

                <div class="form-group">

                  <label class="col-sm-4 control-label" for="type">Type</label>

                  <div class="col-sm-1"></div>

                  <div class="col-sm-7">

                    <select class="form-control" name="type" id="type">

                      <option value="premium" {if $config['sms_type'] == "premium"}selected="selected"{/if}>{l s='Premium' mod='tunisiesms'}</option>

                      <option value="lowcost" {if $config['sms_type'] == "lowcost"}selected="selected"{/if}>{l s='Lowcost' mod='tunisiesms'}</option>

                    </select>

                  </div>

                </div>

              </div>

            </div>

          </div>

          <div class="row row-margin-top taille_max" {if $config['sms_type'] == "lowcost"}style="display:none;"{/if}>

            <div class="col-md-6">

              <div class="row">

                <div class="form-group">

                  <label class="col-sm-4 control-label" for="sms_taille">{l s='Maximum size of the SMS' mod='tunisiesms'}</label>

                  <div class="col-sm-1"></div>

                  <div class="col-sm-7">

                    <select class="form-control" name="sms_taille" id="sms_taille">

                      <option value="1" {if $config['sms_taille'] == "1"}selected="selected"{/if}>1 SMS</option>

                      <option value="2" {if $config['sms_taille'] == "2"}selected="selected"{/if}>2 SMS</option>

                      <option value="3" {if $config['sms_taille'] == "3"}selected="selected"{/if}>3 SMS</option>

           

                    </select>

                  </div>

                </div>

              </div>

            </div>

          </div>

          <div class="row row-margin-top expediteur" {if $config['sms_type'] != "premium"}style="display:none;"{/if}>

            <div class="col-md-6">

              <div class="row">

                <div class="form-group">

                  <label class="col-sm-4 control-label" for="expediteur">{l s='Sender\'s name' mod='tunisiesms'}</label>

                  <div class="col-sm-1"></div>

                  <div class="col-sm-7">

                    <input type="text" class="form-control" name="expediteur" maxlength="11" id="expediteur" value="{$config['sms_expediteur']|escape:'htmlall':'UTF-8'}">

                  </div>

                </div>

              </div>

            </div>

          </div>

          <div class="row row-margin-top">

            <div class="col-md-6">

              <div class="row">

                <div class="form-group">

                  <label class="col-sm-4 control-label" for="message">{l s='Your message' mod='tunisiesms'}</label>

                  <div class="col-sm-1">

                  </div>

                  <div class="col-sm-7">

                    <textarea required="required" name="message" class="form-control notification_message" rows="3" id="message"></textarea>

                    <div id="message_compteur"><span class="caracteres">0</span>/<span class="max_caracteres">160</span> {l s='characters -' mod='tunisiesms'} <span class="nbr_sms">1</span> SMS</div>

                  </div>

                </div>

              </div>

            </div>

          </div>



          <div class="row row-margin-top">

            <div class="col-md-6">

              <div class="row row_title">

                <div class="col-md-12">

                  <h2><span class="icon icon-user"></span>{l s='Recipients' mod='tunisiesms'}</h2>

                </div>

              </div>

            </div>

          </div>



          <div class="row row-margin-top">

            <div class="col-md-6">

              <div class="row">

                <div class="form-group">

                  <p class="col-sm-12 label-destinataires">{l s='Select recipients from your contacts' mod='tunisiesms'}</p>

                  <div class="col-sm-12">

                    <table class="display table table-striped" id="destinataires">

                      <thead> 

                        <tr>                     

                          <th>

                            <label for="check_all_contacts">

                              <input type="checkbox" id="check_all_contacts"/>

                            </label>

                          </th>                  

                          <th>{l s='Last Name' mod='tunisiesms'}</th>

                          <th>{l s='First Name' mod='tunisiesms'}</th>

                          <th>{l s='Number' mod='tunisiesms'}</th>

                        </tr>                    

                      </thead>

                      {foreach from=$contacts key=k item=contact}

                        <tr>

                          <td>

                            <input name="destinataires[]" type="checkbox" value="{$contact['numero']|escape:'htmlall':'UTF-8'}">

                          </td>

                          <td>

                            {$contact['nom']|escape:'htmlall':'UTF-8'}

                          </td>

                          <td >

                            {$contact['prenom']|escape:'htmlall':'UTF-8'}

                          </td>

                          <td >

                            {$contact['numero']|escape:'htmlall':'UTF-8'}

                          </td>

                        </tr>

                      {/foreach}

                    </table>

                  </div>

                </div>

              </div>

            </div>

          </div>

          <div class="row row-margin-top">

            <div class="col-md-6">

              <div class="row">

                <div class="form-group">

                  <label class="col-sm-12 control-label label-destinataires" for="destinataires_autres">{l s='Manually add recipients (one per line)' mod='tunisiesms'}</label>

                  <div class="col-sm-12">

                    <textarea id="destinataires_autres" class="form-control" rows="4" name="destinataires_autres"></textarea>

                  </div>

                </div>

              </div>

            </div>

          </div>

          <div class="row row-margin-top">

            <div class="col-md-6 text-right">

              <button class="btn btn-success btn-lg" style="margin-left:25px;" name="action" value="envoyer_sms" type="submit">{l s='Send' mod='tunisiesms'}</button>

            </div>

          </div>

        </div>

      </form>

    {/if}
    </div>
  </div>

</div>
