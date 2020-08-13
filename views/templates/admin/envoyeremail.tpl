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

                {l s='Send Email' mod='tunisiesms'}

              </h1>

            </div>

          </div>

          {if $retour['resultat']}

            <div class="alert alert-success">

              {l s='Your emails have been sent!' mod='tunisiesms'}

            </div>

          {elseif !$retour['resultat'] & !empty($retour['erreur'])}

            <div class="alert alert-danger">

              {if $retour['erreur'] == 1}

                {l s='The type of SMS is unspecified or incorrect.' mod='tunisiesms'}

              {elseif $retour['erreur'] == 2}

                {l s='The message is empty.' mod='tunisiesms'}

              {elseif $retour['erreur'] == 3}

                {l s='The message contains more than 160 characters.' mod='tunisiesms'}

              {elseif $retour['erreur'] == 4}

                {l s='No valid recipient is filled.' mod='tunisiesms'}

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

                {l s='You do not have enough credit to send.' mod='tunisiesms'}

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



          <div class="row row-margin-top">

            <div class="col-md-6">

              <div class="row">

                <div class="form-group">

                  <label class="col-sm-4 control-label" for="email_expediteur">{l s='Sender *' mod='tunisiesms'}</label>

                  <div class="col-sm-1"></div>

                  <div class="col-sm-7">

                    <input type="email" class="form-control" name="email_expediteur" id="email_expediteur" value="{$config['email_expediteur']|escape:'htmlall':'UTF-8'}" required="required">

                  </div>

                </div>

              </div>

            </div>

          </div>

          <div class="row row-margin-top">

            <div class="col-md-6">

              <div class="row">

                <div class="form-group">

                  <label class="col-sm-4 control-label" for="email_nom_expediteur">{l s='Sender\'s name *' mod='tunisiesms'}</label>

                  <div class="col-sm-1"></div>

                  <div class="col-sm-7">

                    <input type="text" class="form-control" name="email_nom_expediteur" id="email_nom_expediteur" value="{$config['email_nom_expediteur']|escape:'htmlall':'UTF-8'}" required="required">

                  </div>

                </div>

              </div>

            </div>

          </div>

          <div class="row row-margin-top">

            <div class="col-md-6">

              <div class="row">

                <div class="form-group">

                  <label class="col-sm-4 control-label" for="email_reponse">{l s='Response email' mod='tunisiesms'}</label>

                  <div class="col-sm-1"></div>

                  <div class="col-sm-7">

                    <input type="text" class="form-control" name="email_reponse" id="email_reponse">

                  </div>

                </div>

              </div>

            </div>

          </div>

          <div class="row row-margin-top">

            <div class="col-md-6">

              <div class="row">

                <div class="form-group">

                  <label class="col-sm-4 control-label" for="email_sujet">{l s='Subjet *' mod='tunisiesms'}</label>

                  <div class="col-sm-1"></div>

                  <div class="col-sm-7">

                    <input type="text" class="form-control" name="email_sujet" id="email_sujet" value="{$config['sms_expediteur']|escape:'htmlall':'UTF-8'}" required="required">

                  </div>

                </div>

              </div>

            </div>

          </div>

          <div class="row row-margin-top">

            <div class="col-md-6">

              <div class="row">

                <div class="form-group">

                  <label class="col-sm-4 control-label">{l s='Your message *' mod='tunisiesms'}</label>

                  <div class="col-sm-1">

                  </div>

                  <div class="col-sm-7">

                    <textarea id="email_message" name="email_message" class="form-control notification_message rte" rows="11"></textarea>
                    <div class="row row_title" style="margin-top: 15px;">
                      <div class="col-md-12">
                        <p>
                          <b>{l s='Warning !' mod='tunisiesms'}</b>
                          <br>{l s='If you add images in your emails, make sure that they are hosted online on a server, and therefore accessible from a web browser.' mod='tunisiesms'}
                        </p>
                        <p><i>{l s='Example : http://www.mysite.com/myimage.jpg' mod='tunisiesms'}</i></p>
                        <p>{l s='If not, your recipients will not be able to view them.</p>' mod='tunisiesms'}
                      </div>
                    </div>
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

                  <p class="col-sm-12 label-destinataires">Sélectionnez des destinataires parmi vos contacts</p>

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

                          <th>{l s='Email' mod='tunisiesms'}</th>

                          <th>{l s='Type' mod='tunisiesms'}</th>

                        </tr>

                      </thead>

                      {foreach from=$contacts key=k item=contact}

                        <tr>

                          <td>

                            <input name="email_destinataires[]" type="checkbox" value="{$contact['email']|escape:'htmlall':'UTF-8'}">

                          </td>

                          <td>

                            {if isset($contact['nom'])}
                              {$contact['nom']|escape:'htmlall':'UTF-8'}
                            {/if}

                          </td>

                          <td >

                            {if isset($contact['prenom'])}
                              {$contact['prenom']|escape:'htmlall':'UTF-8'}
                            {/if}

                          </td>

                          <td >

                            {if isset($contact['email'])}
                              {$contact['email']|escape:'htmlall':'UTF-8'}
                            {/if}

                          </td>

                          <td >

                            {if isset($contact['type'])}
                              {$contact['type']|escape:'htmlall':'UTF-8'}
                            {/if}

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

                  <label class="col-sm-12 control-label label-destinataires" for="email_destinataires_autres">{l s='Manually add recipients (one per line)' mod='tunisiesms'}</label>

                  <div class="col-sm-12">

                    <textarea id="email_destinataires_autres" class="form-control" rows="4" name="email_destinataires_autres"></textarea>

                  </div>

                </div>

              </div>

            </div>

          </div>

          <div class="row row-margin-top">

            <div class="col-md-6 text-right">

              <button class="btn btn-success btn-lg" style="margin-left:25px;" name="action" value="envoyer_email" type="submit">{l s='Send' mod='tunisiesms'}</button>

            </div>

          </div>

        </div>

      </form>

    {/if}

  </div>

</div>
</div>
