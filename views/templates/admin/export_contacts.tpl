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
* AMINE A EFFACE FALSE DS IF
*}




    {if isset($config['cle_api']) && !empty($config['cle_api']) && $credits['requete'] && false}
  <div class="panel">
        <div class="row configuration">

            <form method="POST" role="form" class="form-horizontal">

                <div class="col-md-12">

                    <div class="row">

                        <div class="col-md-12">

                            <h1>

                              {l s='Export contacts' mod='tunisiesms'}

                            </h1>

                        </div>

                    </div>

                    {if $retour['resultat']}

                        <div class="alert alert-success">

                            {l s='Your contact export has been made!' mod='tunisiesms'}

                        </div>

                    {elseif !$retour['resultat'] && !empty($retour['erreur'])}

                        <div class="alert alert-danger">

                            {if $retour['erreur'] == "expediteur"}

                                {l s='Your sender must not be a phone number and must have' mod='tunisiesms'}<strong> {l s='11 characters -' mod='tunisiesms'} <span class="nbr_sms">1</span>{l s=' SMS maximum' mod='tunisiesms'}</strong>.

                            {elseif $retour['erreur'] == "type"}

                                {l s='SMS type is invalid, please choose between' mod='tunisiesms'} <strong>{l s='Premium' mod='tunisiesms'}</strong> {l s='and' mod='tunisiesms'} <strong>{l s='Lowcost' mod='tunisiesms'}</strong>.

                            {else}

                                {l s='An error has occurred, please check your fields.' mod='tunisiesms'}

                            {/if}

                        </div>

                    {/if}

                    <form method="POST" role="form" class="form-horizontal">

                    <div class="row row-margin-top">

                        <div class="col-md-6">

                            <div class="row row_title">

                                <div class="col-md-12">

                                    <h2><span class="icon icon-edit"></span>{l s='Export contacts' mod='tunisiesms'}</h2>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="row row-margin-top">

                        <div class="col-md-6">

                            <div class="row">

                                <div class="form-group">

                                    <label class="col-sm-4 control-label" for="id_export">{l s='Group' mod='tunisiesms'}</label>

                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-3">

                                        <select class="form-control export_js" name="id_export" id="id_export">

                                            <option value="1" {if isset($config['groupe_id']) && $config['groupe_id'] == "1"}selected="selected"{/if}>{l s='New group' mod='tunisiesms'}</option>

                                          {if isset($groupes)}

                                            {foreach from=$groupes item=v}

                                            <option value="{$v['id']|escape:'htmlall':'UTF-8'}" {if $config['nom_export'] == {$v['groupe']|escape:'htmlall':'UTF-8'}}selected="selected"{/if}>{$v['groupe']}</option>

                                            {/foreach}

                                          {/if}

                                        </select>

                                    </div>

                                    <div class="col-sm-4">

                                        <input type="text" class="form-control" name="nom_export" id="nom_export" style={if $config['id_export'] != 0}"display: none;"{/if} value={if isset($config['groupe_name'])}{$config['groupe_name']|escape:'htmlall':'UTF-8'}{/if}>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="row row-margin-top">

                        <div class="col-md-6 text-right">

                            <button class="btn btn-success btn-lg" name="action" value="export_contacts" type="submit">{l s='Export on TunisieSMS.tn' mod='tunisiesms'}</button>

                        </div>

                    </div>

                    </form>

                    <form method="POST" role="form" class="form-horizontal">
                    <div class="row row-margin-top">

                        <div class="col-md-6">

                            <div class="row row_title">

                                <div class="col-md-12">

                                    <h2><span class="icon icon-edit"></span>{l s='Export newsletter list' mod='tunisiesms'}</h2>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="row row-margin-top">

                        <div class="col-md-6">

                            <div class="row">

                                <div class="form-group">

                                    <label class="col-sm-4 control-label" for="cle_api">{l s='Group' mod='tunisiesms'}</label>

                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-3">

                                        <select class="form-control export_js" name="id_export_newsletter" id="id_export_newsletter">

                                            <option value="1" {if $config['id_export_newsletter'] == "1"}selected="selected"{/if}>{l s='New group' mod='tunisiesms'}</option>

                                          {if isset($groupes)}

                                            {foreach from=$groupes item=v}

                                            <option value="{$v['id']|escape:'htmlall':'UTF-8'}" {if $config['nom_export_newsletter'] == {$v['groupe']|escape:'htmlall':'UTF-8'}}selected="selected"{/if}>{$v['groupe']|escape:'htmlall':'UTF-8'}</option>

                                            {/foreach}

                                          {/if}

                                        </select>

                                    </div>

                                    <div class="col-sm-4">

                                        <input type="text" class="form-control" name="nom_export_newsletter" id="nom_export_newsletter" style={if $config['id_export_newsletter'] != 0}"display: none;"{/if} value={if isset($config['groupe_name'])}{$config['groupe_name']|escape:'htmlall':'UTF-8'}{/if}>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="row row-margin-top">

                        <div class="col-md-6 text-right">

                            <button class="btn btn-success btn-lg" name="action" value="newsletter_export_contacts" type="submit">{l s='Export on Spot-Hit' mod='tunisiesms'}</button>

                        </div>

                    </div>
                    </form>

                </div>

            </form>

        </div>
  </div>
    {/if}


