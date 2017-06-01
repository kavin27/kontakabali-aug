<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html ng-app="register">
<head>
    <title>It's Over Easy</title>
    <link rel="shortcut icon" href="static/img/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="static/img/apple-touch-icon.png">
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- Web Fonts  -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css"> 
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="static/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="static/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="static/css/jquery-ui.min.css">
    <link rel="stylesheet" href="static/vendor/animate/animate.min.css">
    <link rel="stylesheet" href="static/vendor/simple-line-icons/css/simple-line-icons.min.css">
    <link rel="stylesheet" href="static/css/theme.css">
    <link rel="stylesheet" href="static/css/v-accordion.css">
    <link rel="stylesheet" href="static/css/toaster.css">
    <link rel="stylesheet" href="static/css/select2.css">
    <link rel="stylesheet" href="static/css/select.css">
    <link rel="stylesheet" href="static/css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="static/css/angular-material.min.css">
    <link rel="stylesheet" href="static/js/scroll/ng-scrollbar.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/css/selectize.default.css">
    <!-- Current Page CSS -->
    <!-- <link rel="stylesheet" href="static/vendor/rs-plugin/css/settings.css">
    <link rel="stylesheet" href="static/vendor/rs-plugin/css/layers.css">
    <link rel="stylesheet" href="static/vendor/rs-plugin/css/navigation.css">
    <link rel="stylesheet" href="static/vendor/circle-flip-slideshow/css/component.css"> -->
    <link rel="stylesheet" type="text/css" href="static/js/fullcalendar/dist/fullcalendar.css">
    <link rel="stylesheet" type="text/css" href="static/css/date-picker/angular-datepicker.css">
    <!-- Skin CSS -->
    <!-- <link rel="stylesheet" href="static/css/skins/default.css">
    <link rel="stylesheet" href="static/css/style.css"> -->
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="static/css/custom.css">
    <!-- Head Libs -->
    <!-- <script src="static/vendor/modernizr/modernizr.min.js"></script> -->
    <script src="//www.google.com/recaptcha/api.js?render=explicit&onload=vcRecaptchaApiLoaded" async defer></script>
    <script>
    var BASE_URL = "<?php echo base_url(); ?>";
    </script>
</head>
<body ng-controller="regCtrl">
        <header id="header" class="header-narrow header-full-width" data-plugin-options='{"stickyEnabled": true, "stickyEnableOnBoxed": true, "stickyEnableOnMobile": true, "stickyStartAt": 0, "stickySetTop": "0"}' style="min-height: 68px;" >
            <div class="header-body">
                <div class="header-container container">
                    <div class="header-row">
                        <div class="header-column">
                            <div class="header-logo">
                                <a href="/">
                                    <img alt="Porto" width="auto" src="static/img/logo.png">
                                </a>
                            </div>
                        </div>
                        <div class="header-column">
                            <div class="header-row">
                                <div class="header-nav">
                                    <button class="btn header-btn-collapse-nav" data-toggle="collapse" data-target=".header-nav-main">
                                        <i class="fa fa-bars"></i>
                                    </button>
                                    <!--<ul class="header-social-icons social-icons hidden-xs">
                                        <li class="social-icons-facebook"><a href="http://www.facebook.com/" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                                        <li class="social-icons-twitter"><a href="http://www.twitter.com/" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                                        <li class="social-icons-linkedin"><a href="http://www.linkedin.com/" target="_blank" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
                                    </ul>-->
                                    
                                    <div class="header-nav-main header-nav-main-effect-1 header-nav-main-sub-effect-1 collapse">
                                        <nav>
                                            <ul class="nav nav-pills" id="mainNav">
                                                <!--<li ng-repeat="menua in menu" class="dropdown {{ ::menua.class}}">
                                                    <a href="#">{{ ::menua.title}}</a>
                                                </li> -->
                                                <li class="dropdown"><a href="/">Home</a></li>
                                                <!-- <li class="dropdown"><a href="#!/priceComparison">Our Process</a></li> -->
                                                <li class="dropdown"><a href="home/ourProcess">Our Process</a></li>
                                                <li class="dropdown"><a href="#">Help</a></li>
                                                <li class="dropdown ble"><a href="/app">Sign In</a></li>     
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
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
<form name="register_form" id="register">
    <ng-include src="currentTpl">
        
    </ng-include>

    <div class="g-recaptcha" data-sitekey="6LcpCQ4UAAAAAOMWLL2xC2LOvoJIFGlp75aWUrd2"></div>
</form>
</div>
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
                            placeholder="Last Name" 
                            maxlength="50" 
                            alphapet
                            required 
                        />
                        <label ng-if="inputerror" class="error">First name and last name is required</label>
                        <input 
                            type="button" 
                            class="ioe_btn" 
                            name="continue" 
                            value="Continue" 
                            ng-if="register_form.$valid" 
                            ng-click="next('two')"/>
                        <input 
                            type="button" 
                            class="ioe_btn" 
                            name="continue" 
                            value="Continue" 
                            ng-if="register_form.$invalid" 
                            ng-click="validate()"/>
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
                    <label class="yes_btn">
                        <input 
                            type="radio" 
                            name="" 
                            ng-model="signup.living_status" 
                            value="yes" 
                            ng-change="next('three')" />
                        </label>
                    <label class="no_btn">
                        <input 
                            type="radio" 
                            name="" 
                            ng-model="signup.living_status" 
                            value="no" 
                            ng-change="next('three')" />
                        </label>
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
                        <select ui-select2 class="input_field" ng-model="signup.process_status" required>
                            <option value="">Select</option>
                            <option value="I'm just thinking about it.">I'm just thinking about it.</option>
                            <option value="I am starting the process now.">I am starting the process now.</option>                                 
                            <option value="I've already filed.">I've already filed.</option>                            
                        </select>
                        <label ng-if="inputerror" class="error">Please select any option</label>
                        <input type="button" class="ioe_btn" name="continue" ng-if="register_form.$valid" value="Continue" ng-click="next('four')"/>
                        <input type="button" class="ioe_btn" name="continue" ng-if="register_form.$invalid" value="Continue" ng-click="validate()" />
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
                    <label class="yes_btn">
                        <input type="radio" name="" ng-model="signup.prenuptial" value="yes" ng-change="next('five')"></label>
                    <label class="no_btn">
                        <input type="radio" name="" ng-model="signup.prenuptial" value="no" ng-change="next('five')">
                    </label>
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
                    <h2 class="reg_form_title reg_form_title_lg">What date did your separation begin?</h2>
                </div>
                <div class="col-md-6 col-md-offset-3 reg_form">                 
                <div class="margin_40"></div>
                    <div class="form_section">
                        <input type="text" name="" ng-model="signup.dateSperation" ui-date="{dateFormat: 'mm/dd/yy'}" class="input_field"  required placeholder="Date of sparation" />
<!--                        <input type="button" class="yes_btn" name="yes" placeholder="yes" />
                        <input type="button" class="no_btn" name="no" placeholder="no" /> -->
                        <label ng-if="inputerror" class="error">Please fill the date of sparation</label>
                        <input type="button" class="ioe_btn" name="continue" ng-if="register_form.$valid" value="Continue" ng-click="next('six')"/>
                        <input type="button" class="ioe_btn" name="continue" ng-if="register_form.$invalid" value="Continue" ng-click="validate()" />
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
                    <h2 class="reg_form_title">Alright! We’ll make it as painless as possible.</h2>
                    <h2 class="reg_form_title reg_form_title_lg">How many children under the age of 18 do you have?</h2>
                    
                </div>

                <div class="col-md-12 reg_form">                 
                <div class="margin_40"></div>
                    <div class="form_section">
                        <select ui-select2 class="input_field" ng-model="signup.noc_under_18" required>
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
                        <input type="button" class="ioe_btn" name="continue" ng-if="register_form.$valid" value="Continue" ng-click="next('seven')" />
                        <input type="button" class="ioe_btn" name="continue" ng-if="register_form.$invalid" value="Continue" ng-click="validate()" />
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
<script type="text/ng-template" id="seven">
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
                    <label class="yes_btn">
                        <input type="radio" name="" ng-model="signup.settlement_status" value="yes" ng-change="next('eight')">
                    </label>
                    <label class="no_btn">
                        <input type="radio" name="" ng-model="signup.settlement_status" value="no" ng-change="next('eight')">
                    </label>
                    <label class="not_sure_btn">
                        <input type="radio" name="" ng-model="signup.settlement_status" value="notsure" ng-change="next('eight')">
                    </label>
                  <!--  <input type="button" class="yes_btn" name="yes" placeholder="yes" />
                    <input type="button" class="no_btn" name="no" placeholder="no" />
                    <input type="button" class="not_sure_btn" name="notsure" placeholder="notsure" /> -->
                </div>
            </div>                  
        </div>
    </div>
</script>
<script type="text/ng-template" id="eight">
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
                        <input type="email" class="input_field" name="username" ng-model="signup.username" placeholder="Email Address" required />
                        <input type="password" class="input_field" name="password" ng-model="signup.password" placeholder="Password" required />
                        <div class="google_captcha" 
                            vc-recaptcha
                            theme="'light'"
                            key="model.key"
                            on-create="setWidgetId(widgetId)"
                            on-success="setResponse(response)"
                            on-expire="cbExpiration()"
                        ></div>
                        <label ng-if="inputerror" class="error">Please fill the required fields</label>
                        <label class="error">{{signup_error}}</label>
                        <input type="submit" ng-if="register_form.$invalid" class="ioe_btn" name="continue" ng-click="validate()" value="Continue" />
                        <input type="submit" ng-if="register_form.$valid" class="ioe_btn" name="continue" ng-click="signUp(signup)" value="Continue" />
                    </div>
                        
                </div>
            </div>                  
        </div>
    </div>
</script>
<script type="text/ng-template" id="custom-datepicker.html">
    <div class="enhanced-datepicker">
        <div class="proxied-field-wrap">
            <input type="text" ui-date-format="mm/dd/yy" ng-model="ngModel" ui-date="dateOptions"/>
        </div>
    </div>
</script>
<script type="text/ng-template" id="nine">
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
<script src="static/js/jquery.min.js"></script>
<script src="static/js/jquery-ui.min.js"></script>
<script src="static/js/select2.js"></script>
<script src="static/js/angular.js"></script>
<script src="static/js/angular-ui-select2/select2.js" ></script>
<script src="static/js/angular-recaptcha.js" ></script>
<script src="static/js/date.js"></script>
<script src="static/js/register.js"></script>
<script type="text/javascript">
    var APP_ID = "wck7ioip";
    window.intercomSettings = {
        app_id: APP_ID
    };
    (function(){
        var w=window;
        var ic=w.Intercom;
        if(typeof ic==="function"){
            ic('reattach_activator');
            ic('update',intercomSettings);
        }else{
            var d=document;
            var i=function(){
                i.c(arguments)};
                i.q=[];
                i.c=function(args){
                    i.q.push(args)
                };
                w.Intercom=i;
                function l(){
                    var s=d.createElement('script');
                    s.type='text/javascript';
                    s.async=true;
                    s.src='https://widget.intercom.io/widget/' + APP_ID;
                    var x=d.getElementsByTagName('script')[0];
                    x.parentNode.insertBefore(s,x);
                }
                if(w.attachEvent){
                    w.attachEvent('onload',l);
                }else{
                    w.addEventListener('load',l,false);
                }
            }
        })()
  </script>
    <style type="text/css">
        #intercom-container .intercom-launcher-frame{
            bottom: 75px !important;
            right: 35px !important;
        }
        #intercom-container .intercom-app-launcher-enabled .intercom-messenger-frame{
            bottom: 145px !important;
        }
    </style>
</body>
</html>