{*
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

<div class="panel">
 <h1>
              <img src="/prestashop/modules/tunisiesms/logo.png">
              {l s='TunisieSMS.tn' mod='tunisiesms'}

  </h1>
  <br>
<div class="alert alert-info"><strong>{l s='If you have not yet completed your API key.' mod='tunisiesms'}</strong><br>{l s='You can find it on your client area in' mod='tunisiesms'} <strong><a href="https://www.tunisiesms.tn/client/UserLogin.aspx" target="_blank">{l s='Account settings' mod='tunisiesms'}</a></strong> {l s='or if you do not have an account you can' mod='tunisiesms'} <strong><a href="https://www.tunisiesms.tn/" target="_blank">{l s='register on the Spot-Hit platform' mod='tunisiesms'}</a></strong>.</div>
</div>
 
{if isset($config['cle_api']) & !empty($config['cle_api']) & $credits['requete']}
    {if $credits['post_paye']}
        <div class="alert alert-info">{l s='Your account is in' mod='tunisiesms'} <strong>{l s='monthly billing' mod='tunisiesms'}</strong>.</div>
    {elseif $credits['pre_paye']}
    <div class="panel">
    <div class="row widget widget_credits">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <h1>
                      {l s='Remaining credit' mod='tunisiesms'}  (<a href="https://www.tunisiesms.tn" target="_blank">{l s='Shipment History' mod='tunisiesms'}</a>)
                    </h1> 
                </div>
            </div>
            <div class="row row-margin-top">
                <div class="col-md-6 type_credit credit_euros">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="produit"><span>Euros</span></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <p class="quantite" style="margin-top:10px;">{$credits['euros']|escape:'htmlall':'UTF-8'}</p>
                            <p class="credit"></p>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <p class="lien_recharge"><a href="http://www.spot-hit.fr/espace-client/commandes?produit=credit" target="_blank"><span class="icone"></span> <span class="texte">{l s='Recharge' mod='tunisiesms'}</span></a></p>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {else}
    <div class="panel" style="display:none">
    <div class="row widget widget_credits">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <h1>
                      {l s='Remaining credit' mod='tunisiesms'} (<a href="http://www.spot-hit.fr/espace-client/envois-effectues" target="_blank">{l s='Shipment History' mod='tunisiesms'}</a>)
                    </h1> 
                </div>
            </div>
            <div class="row row-margin-top">
                <div class="col-md-6 type_credit credit_sms">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="produit"><span>SMS</span></p>
                        </div>
                        <div class="col-md-3">
                            <p class="produit"><span>Email</span></p>
                        </div>
                    </div>
                    <div class="row produit_credits">
                        <div id="consommation_premium" class="col-md-3 col-xs-12">
                            <p class="quantite">{$credits['premium']|escape:'htmlall':'UTF-8'|number_format:0:".":" "}</p>
                            <p class="credit">Premium</p>
                        </div>
                        <div id="consommation_lowcost" class="col-md-3 col-xs-12">
                            <p class="quantite">{$credits['lowcost']|escape:'htmlall':'UTF-8'|number_format:0:".":" "}</p>
                            <p class="credit">Low Cost</p>
                        </div>
                        <div id="consommation_email" class="col-md-3 col-xs-12">
                            <p class="quantite">{$credits['email']|escape:'htmlall':'UTF-8'|number_format:0:".":" "}</p>
                            <p class="credit">Emails</p>
                        </div>
                        <div class="col-md-3 col-xs-12">
                            <p class="lien_recharge"><a href="http://www.spot-hit.fr/espace-client/commandes?produit=sms&key={$config['cle_api']|escape:'htmlall':'UTF-8'}" target="_blank"><span class="icone"></span> <span class="texte">{l s='Recharge' mod='tunisiesms'}</span></a></p>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {/if}
{else}
    {if !isset($config['cle_api']) || empty($config['cle_api'])}
    <br/>
    {else}
    <div class="alert alert-danger"><strong>{l s='Your API key is invalid, please edit it.' mod='tunisiesms'}</strong><br>{l s='You can find it on your client area in' mod='tunisiesms'} <strong><a href="http://www.spot-hit.fr/espace-client/parametres/api?ref=22158" target="_blank">{l s='Account settings' mod='tunisiesms'}</a></strong>{l s='or if you do not have an account you can' mod='tunisiesms'}<strong><a href="https://www.spot-hit.fr/inscription?ref=22158" target="_blank">{l s='register on the Spot-Hit platform' mod='tunisiesms'}</a></strong>.</div>
    {/if}
    <div class="row configuration">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <form method="POST" role="form" class="form-horizontal">
                        <div class="row row-margin-top">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="cle_api">{l s='API Key' mod='tunisiesms'}</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="cle_api" id="cle_api" value="{$config['cle_api']|escape:'htmlall':'UTF-8'}">
                                    </div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary" name="action" value="save_cle_api" type="submit">{l s='Save' mod='tunisiesms'}</button>
                                    </div>
                                </div>
                            </div>                                  
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
{/if}
