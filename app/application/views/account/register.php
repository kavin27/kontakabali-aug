<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
    <div class="row">                   
        <div class="margin_40"></div>
        <div class="progress progress-no-border-radius reg_form_progress">
            <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
            <span class="sr-only">60% Complete</span>
            </div>

        </div>
    </div>
</div>
<form name="register_form">
    <ng-include src="currentTpl">
        
    </ng-include>
    <div class="g-recaptcha" data-sitekey="6LcpCQ4UAAAAAOMWLL2xC2LOvoJIFGlp75aWUrd2"></div>
</form>
<script type="text/ng-template" id='one'>
    <div class="step well">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="margin_40"></div>
                    <h2 class="reg_form_title">Hey there!</h2>
                    <h2 class="reg_form_title reg_form_title_lg">What’s your name?</h2>                 
                </div>
                <div class="col-md-12 reg_form">                 
                    <div class="form_section">
                        <input 
                            type="text" 
                            class="input_field" 
                            name="fandlname" 
                            ng-model="signup.name" 
                            ng-change="validate(this)" 
                            placeholder="First Name" 
                            maxlength="50" 
                            alphapet
                            required 
                        />
                        <input 
                            type="text" 
                            class="input_field" 
                            name="fandlname" 
                            ng-model="signup.lname" 
                            ng-change="validate(this)" 
                            placeholder="Last Name" 
                            maxlength="50" 
                            alphapet
                            required 
                        />
                        <label class="error">{{error}}</label>
                        <input type="button" class="ioe_btn" name="continue" value="Continue" ng-click="next_step('two')"/>
                    </div>
                </div>
            </div>                  
        </div>
        <img src="static/img/nl/3guys_new.png" style =" position: absolute; bottom: 0; left: 50%; margin-left: -600px;">
    </div>
</script>
<script type="text/ng-template" id="two">
    <div class="step well">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="margin_40"></div>
                    <h2 class="reg_form_title">Nice to meet you {{signup.name}} !</h2>
                    <h2 class="reg_form_title reg_form_title_lg">Have you or your spouse lived in<br /> California for at least six months?</h2>                    
                </div>

                <div class="col-md-12 reg_form">                 
                <div class="margin_40"></div>
                    <label class="yes_btn"><input type="radio" name="" ng-model="signup.living_status" value="yes" ng-change="next_step('three')"></label>
                    <label class="no_btn"><input type="radio" name="" ng-model="signup.living_status" value="no" ng-change="next_step('three')"></label>
                       <!-- <input type="button" class="yes_btn" value="Yes" ng-model="signup.spouse" ng-change="next_step('third_step')" placeholder="yes" />
                        <input type="button" class="no_btn" name="no" value="no" ng-model="signup.spouse" placeholder="no" ng-change="next_step('third_step')" /> -->
                </div>
            </div>                  
        </div>
    </div>
</script>
<script type="text/ng-template" id="three">
    <div class="step well">
        <div class="container">
            <div class="row">
                <div class="col-md-12">                 
                    <div class="margin_40"></div>
                    <h2 class="reg_form_title">Great! We specialize in California divorce law.</h2>
                    <h2 class="reg_form_title reg_form_title_lg">Where are you in your process?</h2>                    
                </div>

                <div class="col-md-12 reg_form">                 
                    <div class="form_section">
                        <select ui-select2 class="input_field" ng-model="signup.process_status">
                            <option value="">Select</option>
                            <option value="I'm just thinking about it.">I'm just thinking about it.</option>
                            <option value="I am starting the process now.">I am starting the process now.</option>                                 
                            <option value="I've already filed.">I've already filed.</option>                            
                        </select>
                        <label class="error">{{error}}</label>
                        <input type="button" class="ioe_btn" name="continue" value="Continue" ng-click="next_step('four')"/>
                    </div>
                </div>
            </div>                  
        </div>
    </div>
</script>
<script type="text/ng-template" id="four">
    <div class="step well">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                
                    <div class="margin_40"></div>               
                    <h2 class="reg_form_title reg_form_title_lg">Did you and your spouse sign a <br /> prenuptial agreement?</h2>
                    
                </div>

                <div class="col-md-6 col-md-offset-3 reg_form">                 
                <div class="margin_40"></div>
                    <label class="yes_btn"><input type="radio" name="" ng-model="signup.prenuptial" value="yes" ng-change="next_step('five')"></label>
                    <label class="no_btn"><input type="radio" name="" ng-model="signup.prenuptial" value="no" ng-change="next_step('five')"></label>
<!--                        <input type="button" class="yes_btn" name="yes" placeholder="yes" />
                        <input type="button" class="no_btn" name="no" placeholder="no" /> -->
                </div>
            </div>                  
        </div>
    </div>
</script>
<script type="text/ng-template" id="five">
    <div class="step well">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                
                    <div class="margin_40"></div>
                    <h2 class="reg_form_title">Alright! We’ll make it as painless as possible.</h2>
                    <h2 class="reg_form_title reg_form_title_lg">How many children under the age of 18 do you have?</h2>
                    
                </div>

                <div class="col-md-12 reg_form">                 
                <div class="margin_40"></div>
                    <div class="form_section">
                        <select ui-select2 class="input_field" ng-model="signup.noc_under_18">
                            <option value="0">None</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8+">8+</option>                      
                        </select>
                        <label class="error">{{error}}</label>
                        <input type="button" class="ioe_btn" name="continue" value="Continue" ng-click="next_step('six')" />
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                    </div>
                </div>
            </div>                  
        </div>
    </div>
</script>
<script type="text/ng-template" id="six">
    <div class="step well">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                
                    <div class="margin_40"></div>   
                    <h2 class="reg_form_title">{{signup.noc_under_18 == 0 ? 'Alright no kids.' : ''}}</h2>
                    <h2 class="reg_form_title reg_form_title_lg">Do you think you and your spouse can <br> work together to reach a settlement?</h2>
                    
                </div>

                <div class="col-md-6 col-md-offset-3 reg_form">                 
                <div class="margin_40"></div>
                    <label class="yes_btn"><input type="radio" name="" ng-model="signup.settlement_status" value="yes" ng-change="next_step('seven')"></label>
                    <label class="no_btn"><input type="radio" name="" ng-model="signup.settlement_status" value="no" ng-change="next_step('seven')"></label>
                    <label class="not_sure_btn"><input type="radio" name="" ng-model="signup.settlement_status" value="notsure" ng-change="next_step('seven')"></label>
                  <!--  <input type="button" class="yes_btn" name="yes" placeholder="yes" />
                    <input type="button" class="no_btn" name="no" placeholder="no" />
                    <input type="button" class="not_sure_btn" name="notsure" placeholder="notsure" /> -->
                </div>
            </div>                  
        </div>
    </div>
</script>
<script type="text/ng-template" id="seven">
    <div class="step well">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                
                    <div class="margin_40"></div>                   
                    <h2 class="reg_form_title reg_form_title_lg">You qualify for an online divorce! <br />Create an account to continue.</h2>
                    
                </div>

                <div class="col-md-12 reg_form">                 
                <div class="margin_40"></div>
                    <div class="form_section no_margin">
                        <input type="email" class="input_field" name="username" ng-model="signup.username" placeholder="Email Address" />
                        <input type="password" class="input_field" name="password" ng-model="signup.password" placeholder="Password" />
                        <div class="google_captcha" 
                            vc-recaptcha
                            theme="'light'"
                            key="model.key"
                            on-create="setWidgetId(widgetId)"
                            on-success="setResponse(response)"
                            on-expire="cbExpiration()"
                        ></div>
                        <label class="error">{{error}}</label>
                        <label class="error">{{signup_error}}</label>
                        <input type="submit" class="ioe_btn" name="continue" ng-click="signUp(signup)" value="Continue" />
                    </div>
                        
                </div>
            </div>                  
        </div>
    </div>
</script>
<script type="text/ng-template" id="eight">
    <div class="step well">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                
                    <div class="margin_40"></div>                   
                    <div class="margin_40"></div>                   
                    <div class="margin_40"></div>                   
                    <h5 style="font-family: 'Lato', sans-serif; text-transform: none;">Thank you for registering! Please check your email for a confirmation.</h5>
                    
                </div>
            </div>                  
        </div>
    </div>
</script>
