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
        <div class="row configuration">

            <form method="POST" role="form" class="form-horizontal">

                <div class="col-md-12">

                    <div class="row">

                        <div class="col-md-12">

                            <h1>

                              {l s='Email configuration' mod='tunisiesms'}

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

                              {l s='Your sender must not be a phone number and must have' mod='tunisiesms'} <strong>{l s='11 characters -' mod='tunisiesms'} <span class="nbr_sms">1</span>{l s=' SMS maximum' mod='tunisiesms'}</strong>.

                            {elseif $retour['erreur'] == "type"}

                              {l s='SMS type is invalid, please choose between' mod='tunisiesms'} <strong>{l s='Premium' mod='tunisiesms'}</strong> {l s='and' mod='tunisiesms'} <strong>{l s='Lowcost' mod='tunisiesms'}</strong>.

                            {else}

                              {l s='An error has occurred, please check your fields.' mod='tunisiesms'}

                            {/if}

                        </div>

                    {/if}

                    <div class="row row-margin-top">

                        <div class="col-md-6">

                            <div class="row row_title">

                                <div class="col-md-12">

                                    <h2><span class="icon icon-edit"></span>{l s='General configuration of emails' mod='tunisiesms'}</h2>

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

                                        <input type="text" class="form-control" name="cle_api" id="cle_api" value="{$config['cle_api']|escape:'htmlall':'UTF-8'}">

                                    </div>

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

                                        <input type="email" class="form-control" name="email_expediteur" id="email_expediteur" value="{$config['email_expediteur']|escape:'htmlall':'UTF-8'}">

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

                                        <input type="text" class="form-control" name="email_nom_expediteur" id="email_nom_expediteur" value="{$config['email_nom_expediteur']|escape:'htmlall':'UTF-8'}">

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

                                        <input type="text" class="form-control" name="email_reponse" id="email_reponse" value="{$config['email_reponse']|escape:'htmlall':'UTF-8'}">

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="row row-margin-top">

                        <div class="col-md-6">

                            <div class="row">

                                <div class="form-group">

                                    <label class="col-sm-4 control-label" for="email_sujet">{l s='Subject *' mod='tunisiesms'}</label>

                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-7">

                                        <input type="text" class="form-control" name="email_sujet" id="email_sujet" value="{$config['email_sujet']|escape:'htmlall':'UTF-8'}">

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="row row-margin-top">

                        <div class="col-md-6">

                            <div class="row row_title">

                                <div class="col-md-12">

                                    <h2><span class="icon icon-comment"></span>{l s='Configuring email notifications' mod='tunisiesms'}</h2>

                                </div>

                            </div>

                        </div>

                    </div>


                  <div class="row row-margin-top">
                    <div class="col-md-6">
                      <div class="row row_title">
                        <div class="col-md-12">
                          <p>
                            <b>{l s='Warning !' mod='tunisiesms'}</b>
                            <br>{l s='If you add images in your emails, make sure that they are hosted online on a server, and therefore accessible from a web browser.' mod='tunisiesms'}
                          </p>
                          <p><i>{l s='Example : http://www.mysite.com/myimage.jpg' mod='tunisiesms'}</i></p>
                          <p>{l s='If not, your recipients will not be able to view them.' mod='tunisiesms'}</p>
                        </div>
                      </div>
                    </div>
                  </div>

                    <div class="row row-margin-top">

                        <div class="col-md-6">

                            <div class="choix_type_param">

                                <label for="email_etat_annule" class="label_block">

                                    <div class="row">

                                        <div class="col-md-12">

                                            <p class="text-left"><input type="checkbox" class="form-control" name="email_etat_annule" id="email_etat_annule" {if $config['email_etat_annule']}checked="checked"{/if}><span class="select_choix"><span class="icon icon-check"></span></span> {l s='Enable notifications for the status "Canceled"' mod='tunisiesms'}</p>

                                        </div>

                                    </div>

                                    <div class="row row_notification">

                                        <div class="col-md-12">

                                            <textarea name="email_etat_annule_message" class="form-control rte" rows="3" id="email_etat_annule_message">{$config['email_etat_annule_message']|escape:'htmlall':'UTF-8'}</textarea>

                                        </div>

                                    </div>

                                </label>

                            </div>

                        </div>

                    </div>



                    <div class="row row-margin-top">

                        <div class="col-md-6">

                            <div class="choix_type_param">

                                <label for="email_etat_en_cours" class="label_block">

                                    <div class="row">

                                        <div class="col-md-12">

                                            <p class="text-left"><input type="checkbox" class="form-control" name="email_etat_en_cours" id="email_etat_en_cours" {if $config['email_etat_en_cours']}checked="checked"{/if}><span class="select_choix"><span class="icon icon-check"></span></span> {l s='Enable notifications for the status "In preparation"' mod='tunisiesms'}</p>

                                        </div>

                                    </div>

                                    <div class="row row_notification">

                                        <div class="col-md-12">

                                            <textarea name="email_etat_en_cours_message" class="form-control rte" rows="3" id="email_etat_en_cours_message">{$config['email_etat_en_cours_message']|escape:'htmlall':'UTF-8'}</textarea>

                                        </div>

                                    </div>

                                </label>

                            </div>

                        </div>

                    </div>



                    <div class="row row-margin-top">

                        <div class="col-md-6">

                            <div class="choix_type_param">

                                <label for="email_etat_expedie" class="label_block">

                                    <div class="row">

                                        <div class="col-md-12">

                                            <p class="text-left"><input type="checkbox" class="form-control" name="email_etat_expedie" id="email_etat_expedie" {if $config['email_etat_expedie']}checked="checked"{/if}><span class="select_choix"><span class="icon icon-check"></span></span> {l s='Enable notifications for the "Shipped" state' mod='tunisiesms'}</p>

                                        </div>

                                    </div>

                                    <div class="row row_notification">

                                        <div class="col-md-12">

                                            <textarea name="email_etat_expedie_message" class="form-control rte" rows="3" id="email_etat_expedie_message">{$config['email_etat_expedie_message']|escape:'htmlall':'UTF-8'}</textarea>

                                        </div>

                                    </div>

                                </label>

                            </div>

                        </div>

                    </div>



                    <div class="row row-margin-top">

                        <div class="col-md-6">

                            <div class="choix_type_param">

                                <label for="email_etat_livre" class="label_block">

                                    <div class="row">

                                        <div class="col-md-12">

                                            <p class="text-left"><input type="checkbox" class="form-control" name="email_etat_livre" id="email_etat_livre" {if $config['email_etat_livre']}checked="checked"{/if}><span class="select_choix"><span class="icon icon-check"></span></span> {l s='Enable notifications for the "Delivered" state' mod='tunisiesms'}</p>

                                        </div>

                                    </div>

                                    <div class="row row_notification">

                                        <div class="col-md-12">

                                            <textarea name="email_etat_livre_message" class="form-control rte" rows="3" id="email_etat_livre_message">{$config['email_etat_livre_message']|escape:'htmlall':'UTF-8'}</textarea>

                                        </div>

                                    </div>

                                </label>

                            </div>

                        </div>

                    </div>



                    <div class="row row-margin-top">

                        <div class="col-md-6">

                            <div class="choix_type_param">

                                <label for="email_etat_rembourse" class="label_block">

                                    <div class="row">

                                        <div class="col-md-12">

                                            <p class="text-left"><input type="checkbox" class="form-control" name="email_etat_rembourse" id="email_etat_rembourse" {if $config['email_etat_rembourse']}checked="checked"{/if}><span class="select_choix"><span class="icon icon-check"></span></span> {l s='Enable notifications for the "Refunded" state' mod='tunisiesms'}</p>

                                        </div>

                                    </div>

                                    <div class="row row_notification">

                                        <div class="col-md-12">

                                            <textarea name="email_etat_rembourse_message" class="form-control rte" rows="3" id="email_etat_rembourse_message">{$config['email_etat_rembourse_message']|escape:'htmlall':'UTF-8'}</textarea>

                                        </div>

                                    </div>

                                </label>

                            </div>

                        </div>

                    </div>



                    <div class="row row-margin-top">

                        <div class="col-md-6 text-right">

                            <button class="btn btn-success btn-lg" style="margin-left:25px;" name="action" value="email_save_configuration" type="submit">{l s='Save' mod='tunisiesms'}</button>

                        </div>

                    </div>



                </div>

            </form>
        </div>
        </div>

    {/if}

</div>
