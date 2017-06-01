var app = angular.module('project', ['ngRoute', 'ngAnimate', 'toaster', 'ui.select2', 'vAccordion', 'vcRecaptcha', 'ngMaterial', 'ngMask']);

app.config(['$routeProvider',
  function ($routeProvider) {
        $routeProvider.
        when('/login', {
            title: 'Login',
            templateUrl:BASE_URL+'account/view/',
            controller: 'authCtrl'
        })
        .when('/logout', {
            title: 'Logout',
            templateUrl: 'api/auth/logout',
            controller: 'logoutCtrl'
        })
        .when('/signup', {
            title: 'Signup',
            templateUrl:BASE_URL+'account/view/register/',
            controller: 'authCtrl'
        })
        .when('/dashboard', {
            title: 'Dashboard',
            templateUrl: 'account/view/dashboard/',
            controller: 'authCtrl'
        })
        .when('/forgot_password', {
            title : 'ForgotPassword',
            templateUrl : BASE_URL+'account/view/forgot_password',
            controller : 'authCtrl'
        })
        .when('/basic', {
            title: 'Basic Info',
            templateUrl: BASE_URL+'account/view/basic_info',
            controller: 'authCtrl'
        })   
        .when('/welcome', {
            title:'welcome',
            templateUrl: BASE_URL+'account/view/welcome_process',
            controller: 'authCtrl'
        })
        .when('/priceComparison',{
            title:'Price Comparison',
            templateUrl: BASE_URL+'account/view/price_comparison',
            controller: 'authCtrl'
        })
       /* .when('/', {
            title: 'Home',
            templateUrl:BASE_URL+'home/homeView',
            controller: 'authCtrl',
            role: '0'
        })*/
        .otherwise({
            redirectTo: '/'
        });
  }])
    .run(function ($rootScope, $location, Data) {
        $rootScope.$on("$routeChangeStart", function (event, next, current) {
            $rootScope.authenticated = false;
            $rootScope.menu2 = [];
            var testmenu;
            Data.get('session').then(function (results) {
                if (results.uid) {
                    
                    $rootScope.authenticated = true;
                    $rootScope.welcome = results.welcome;
                    $rootScope.uid = results.uid;
                    $rootScope.email = results.email;
                    $rootScope.formdata = results.data;
                    if($location.$$path=='/login'){
                        $location.path("/dashboard");   
                    }
                    if($location.$$path=='/welcome'){
                        if($rootScope.welcome){
                            $location.path("/welcome");   
                        }
                        else{
                            $location.path("/dashboard");   
                        }
                    }
                } else {
                    var nextUrl = next.$$route.originalPath;
                    if(nextUrl == '/dashboard'){
                        $location.path('/login');
                    }
                    if(nextUrl == '/welcome'){
                        $location.path('/login');   
                    }
                    if(nextUrl == '/logout'){
                        $location.path('/login');
                    }
                    else if (nextUrl == '/signup' || nextUrl == '/login') {
                        $location.path(nextUrl);
                    } else {
                      //  $location.path("/");
                    }
                }
            });
            
        });
    });


app.controller('authCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, vcRecaptchaService) {
    //initially set those objects to null to avoid undefined error
    $scope.menu = '';
    $scope.currentTpl = 'one';
    $scope.login = {};
    $scope.logindisable = false;
    $scope.signup = {};
    $scope.data = {};
    $scope.welcome_data = '';
    $scope.signup_error = '';
    $scope.datatest = 'test';
    $scope.loginerror = '';
    $scope.forgoterror = '';
    $scope.signup.noc_under_18 = '0';
    $scope.signup.cresponse = null;
    $scope.widgetId = null;
    $scope.menu =[];
    


    $scope.model = {
        key: '6Le6Bw4UAAAAAOXP5umlJ4CqlIdCVgR5L6qdsovj'
        //key: '6LcpCQ4UAAAAAOMWLL2xC2LOvoJIFGlp75aWUrd2'
    };
    $scope.setResponse = function (response) {
        $scope.signup.cresponse = response;
    };

    $scope.setWidgetId = function (widgetId) {
        $scope.widgetId = widgetId;
    };

    $scope.cbExpiration = function() {
        vcRecaptchaService.reload($scope.widgetId);
        $scope.signup.cresponse = null;
    };
    $scope.welcomeStep = 0;
    $scope.nextStep = function(){
        if($scope.welcomeStep==2){
            $scope.welcomeStep = 0;
        }
        else{
            $scope.welcomeStep++;    
        }
    }
    $scope.previousStep = function(){
        if($scope.welcomeStep==0){
            $scope.welcomeStep = 2;
        }
        else{
            $scope.welcomeStep--;    
        }
    }
    $scope.doLogin = function (customer) {
        $scope.logindisable =true;
        Data.post('login', {
            customer: customer
        }).then(function (results) {
            if (results.status == "SUCCESS") {
                Data.toast(results);
                if(results.welcome){
                    $location.path('welcome');    
                }
                else{
                    $location.path('dashboard');
                }
            }
            else{
                $scope.logindisable = false;
                Data.toast(results);
                $scope.loginerror = results.message;
            }
        });
    };

    $scope.saveWelcome = function (data){
        Data.post('welcomeData', {
            welcomecontent : data
        }).then(function (results){
            if (results.status == "SUCCESS") {
                Data.toast(results);
                $location.path('priceComparison');
            }
            else{
                $scope.logindisable = false;
                Data.toast(results);
                $scope.loginerror = results.message;
            }
        });
    }

    $scope.panesA = [
        {
          id: 'pane-1a',
          header: 'Getting Started',
          status: '100%',
          text: 'static/img/nl/step_process.png',
          url: '#',
          content:[
            {
                id:'pane-1a-1',
                title : 'First Steps',
                icon : 'static/img/icons/dashboard/my_info.png',
                status : 'completed',
                color : '#25b7d3'
            },
            {
                id:'pane-1a-2',
                title : 'Spouse\'s Info',
                icon : 'static/img/icons/dashboard/spouseinfo.png',
                status : 'completed',
                color : '#24b23b'
            },
            {
                id:'pane-1a-3',
                title : 'Our Profile',
                icon : 'static/img/icons/dashboard/ourprofile.png',
                status : 'completed',
                color : '#fabc3c'
            },
            {
                id:'pane-1a-4',
                title : 'Our Kids',
                icon : 'static/img/icons/dashboard/ourkids.png',
                status : 'completed',
                color : '#e04f5f'
            },
            {
                id:'pane-1a-5',
                title : 'My Documents',
                icon : 'static/img/icons/dashboard/mydocument.png',
                status : 'completed',
                color : '#a269b7'
            }
          ],
          isExpanded: true
        },
        {
          id: 'pane-2a',
          header: 'Kids',
          status: '70%',
          text: 'static/img/nl/step_process.png',
          url: '#',
          content:[
            {
                id:'pane-1a-1',
                title : 'First Steps',
                icon : 'static/img/icons/dashboard/basic_info.png',
                status : 'completed',
                color : 'red'
            },
            {
                id:'pane-1a-2',
                title : 'Spouse\'s Info',
                icon : 'static/img/icons/dashboard/basic_info.png',
                status : 'completed',
                color : ''
            },
            {
                id:'pane-1a-3',
                title : 'Our Profile',
                icon : 'static/img/icons/dashboard/basic_info.png',
                status : 'completed',
                color : ''
            },
            {
                id:'pane-1a-4',
                title : 'Our Kids',
                icon : 'static/img/icons/dashboard/basic_info.png',
                status : 'incomplete',
                color : ''
            },
            {
                id:'pane-1a-5',
                title : 'My Documents',
                icon : 'static/img/icons/dashboard/basic_info.png',
                status : 'incomplete',
                color : ''
            }
          ],
        },
        {
          id: 'pane-3a',
          header: 'Have/Owe',
          status: '20%',
          text: 'static/img/nl/step_process.png',
          url: '#',
          content:[
            {
                id:'pane-1a-1',
                title : 'First Steps',
                icon : 'static/img/icons/dashboard/basic_info.png',
                status : 'completed',
                color : 'red'
            },
            {
                id:'pane-1a-2',
                title : 'Spouse\'s Info',
                icon : 'static/img/icons/dashboard/basic_info.png',
                status : 'completed',
                color : ''
            },
            {
                id:'pane-1a-3',
                title : 'Our Profile',
                icon : 'static/img/icons/dashboard/basic_info.png',
                status : 'incomplete',
                color : ''
            },
            {
                id:'pane-1a-4',
                title : 'Our Kids',
                icon : 'static/img/icons/dashboard/basic_info.png',
                status : 'incomplete',
                color : ''
            },
            {
                id:'pane-1a-5',
                title : 'My Documents',
                icon : 'static/img/icons/dashboard/basic_info.png',
                status : 'incomplete',
                color : ''
            }
          ],
        },
        {
          id: 'pane-4a',
          header: 'Make/ Spend',
          status: '0%',
          text: 'static/img/nl/step_process.png',
          url: '#',
          content:[
            {
                id:'pane-1a-1',
                title : 'First Steps',
                icon : 'static/img/icons/dashboard/basic_info.png',
                status : 'incomplete',
                color : 'red'
            },
            {
                id:'pane-1a-2',
                title : 'Spouse\'s Info',
                icon : 'static/img/icons/dashboard/basic_info.png',
                status : 'incomplete',
                color : ''
            },
            {
                id:'pane-1a-3',
                title : 'Our Profile',
                icon : 'static/img/icons/dashboard/basic_info.png',
                status : 'incomplete',
                color : ''
            },
            {
                id:'pane-1a-4',
                title : 'Our Kids',
                icon : 'static/img/icons/dashboard/basic_info.png',
                status : 'incomplete',
                color : ''
            },
            {
                id:'pane-1a-5',
                title : 'My Documents',
                icon : 'static/img/icons/dashboard/basic_info.png',
                status : 'incomplete',
                color : ''
            }
          ],
        },
        {
          id: 'pane-5a',
          header: 'The Deal',
          status: '0%',
          text: 'static/img/nl/step_process.png',
          url: '#',
          content:[
            {
                id:'pane-1a-1',
                title : 'First Steps',
                icon : 'static/img/icons/dashboard/basic_info.png',
                status : 'incomplete',
                color : 'red'
            },
            {
                id:'pane-1a-2',
                title : 'Spouse\'s Info',
                icon : 'static/img/icons/dashboard/basic_info.png',
                status : 'incomplete',
                color : ''
            },
            {
                id:'pane-1a-3',
                title : 'Our Profile',
                icon : 'static/img/icons/dashboard/basic_info.png',
                status : 'incomplete',
                color : ''
            },
            {
                id:'pane-1a-4',
                title : 'Our Kids',
                icon : 'static/img/icons/dashboard/basic_info.png',
                status : 'incomplete',
                color : ''
            },
            {
                id:'pane-1a-5',
                title : 'My Documents',
                icon : 'static/img/icons/dashboard/basic_info.png',
                status : 'incomplete',
                color : ''
            }
          ],
        }
    ];

    $scope.percent = 100/6;
    $(".progress-bar").css("width",$scope.percent+"%").html($scope.percent+"%");
    $scope.percent = 0;
    $scope.next_step = function(step){
        $scope.error ='';
        if(step == 'two'){
            if(!$scope.signup.name){
                $scope.error = 'Enter your First and Last Name';
                return;
            }
        }
        else if(step == 'four'){
            if(!$scope.signup.process_status){
                $scope.error = 'Please Select any option';
                return;
            }
        }
        else if(step == 'six'){
            if(!$scope.signup.noc_under_18){
                $scope.error = 'Please Select any option';
                return;
            }
        }
        $scope.percent = $scope.percent + 100/6; 
        $(".progress-bar").css("width",$scope.percent+"%").html($scope.percent+"%");
        $scope.currentTpl = step;
    };
    
    
    $scope.forgotPassword = function(email){
        Data.post('forgotPassword', {
            email: email
        }).then(function (results){
            Data.toast(results);
        });
    };
    //$scope.signup = {email:'',password:'',name:'',phone:'',address:''};
    $scope.signUp = function (customer) {
        if($scope.signup.cresponse == null){
            $scope.error = 'please validate captch';
            return;
        }
        
        if(angular.isUndefined(customer.username)){
            $scope.error = 'Enter Your Username';
            return;
        }
        if(angular.isUndefined(customer.password)){
            $scope.error = 'Enter Your password';
            return;   
        }
        Data.post('signUp', {
            customer: customer
        }).then(function (results) {
            Data.toast(results);
            if (results.status == "SUCCESS") {
                $scope.currentTpl = 'eight';
               // $location.path('dashboard');
            }
            else{
                $scope.signup_error = results.message;
            }
        });
    };
    $scope.logout = function () {
        Data.get('logout').then(function (results) {
            Data.toast(results);
            $location.path('login');
        });
    };

    $scope.first_step = [
        {
            title:'Basic Info',
            icon:'static/img/icons/dashboard/basic_info_icon.png',
            color: '#25b7d3',
            status:'incomplete',
            inner:[
                {
                    id:'1',
                    status:'',
                    title:'My Info',
                    forms:[
                        {
                            id:'myInfo1',
                        },
                        {
                            id:'myInfo2',
                        },
                        {
                            id:'myInfo3'
                        },
                        {
                            id:'myInfo4'
                        }
                    ]
                },
                {
                    id:'2',
                    status:'',
                    title:'Spouse\’s Info',
                    forms:[
                        {
                            id:'spouseInfo1'
                        },
                        {
                            id:'spouseInfo2',
                        },
                        {
                            id:'spouseInfo3'
                        }
                    ]
                },
                {
                    id:'3',
                    status:'',
                    title:'Our Profile',
                    forms:[
                        {
                            id:'ourProfile1'
                        },
                        {
                            id:'ourProfile2',
                        },
                        {
                            id:'ourProfile3'
                        },
                        {
                            id:'ourProfile4'
                        },
                        {
                            id:'ourProfile5'
                        }
                    ]
                }
            ]
        },
        {
            title:'Kids',
            icon:'static/img/icons/dashboard/ourkids.png',
            color: '#e04f5f',
            status:'incomplete',
            inner:[
                {
                    id:'1',
                    status:'',
                    title:'Custody & Visitation',
                    forms:[
                        {
                            id:'Custody1'
                        },
                        {
                            id:'Custody2',
                        },
                        {
                            id:'Custody3'
                        },
                        {
                            id:'Custody4'
                        },
                        {
                            id:'Custody5'
                        },
                        {
                            id:'Custody6'
                        },
                        {
                            id:'Custody7'
                        },
                        {
                            id:'Custody8'
                        },
                        {
                            id:'Custody9'
                        },
                        {
                            id:'Custody10'
                        },
                        {
                            id:'Custody11'
                        },
                        {
                            id:'Custody12'
                        },
                        {
                            id:'Custody13'
                        },
                        {
                            id:'Custody14'
                        },
                        {
                            id:'Custody15'
                        },
                        {
                            id:'Custody16'
                        },
                        {
                            id:'Custody17'
                        },
                        {
                            id:'Custody18'
                        }
                    ]
                },
                {
                    id:'2',
                    status:'',
                    title:'Child Support',
                    forms:[
                        {
                            id:'21'
                        },
                        {
                            id:'22',
                        },
                        {
                            id:'23'
                        }
                    ]
                },
                {
                    id:'3',
                    status:'',
                    title:'Final Details',
                    forms:[
                        {
                            id:'31'
                        },
                        {
                            id:'32',
                        },
                        {
                            id:'33'
                        }
                    ]
                }
            ]
        },
        {
            title:'Have/Owe',
            icon:'static/img/icons/dashboard/basic_info.png',
            color: '',
            status:'incomplete',
            inner:[
                {
                    id:'1',
                    title:'Our Profile',
                    status:'',
                    forms:[
                        {
                            id:'11',

                        },
                        {
                            id:'12',
                        },
                        {
                            id:'13'
                        }
                    ]
                },
                {
                    id:'2',
                    status:'',
                    title:'Our Profile',
                    forms:[
                        {
                            id:'21'
                        },
                        {
                            id:'22',
                        },
                        {
                            id:'23'
                        }
                    ]
                },
                {
                    id:'3',
                    status:'',
                    title:'Our Profile',
                    forms:[
                        {
                            id:'31'
                        },
                        {
                            id:'32',
                        },
                        {
                            id:'33'
                        }
                    ]
                }
            ]
        },
        {
            title:'Make/Spend',
            icon:'static/img/icons/dashboard/basic_info.png',
            color: '',
            status:'incomplete',
            inner:[
                {
                    id:'1',
                    status:'',
                    title:'Our Profile',
                    forms:[
                        {
                            id:'11'
                        },
                        {
                            id:'12',
                        },
                        {
                            id:'13'
                        }
                    ]
                },
                {
                    id:'2',
                    status:'',
                    title:'Our Profile',
                    forms:[
                        {
                            id:'21'
                        },
                        {
                            id:'22',
                        },
                        {
                            id:'23'
                        }
                    ]
                },
                {
                    id:'3',
                    status:'',
                    title:'Our Profile',
                    forms:[
                        {
                            id:'31'
                        },
                        {
                            id:'32',
                        },
                        {
                            id:'33'
                        }
                    ]
                }
            ]
        },
        {
            title:'The Deal',
            icon:'static/img/icons/dashboard/basic_info.png',
            color: '',
            status:'incomplete',
            inner:[
                
            ]
        },

    ];
        
    $scope.i = 0;
    $scope.j = 0;
    $scope.k = 0;
    $scope.percent_t = 0;
    $scope.currentStep = $scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id;
    $scope.form_icon_color = $scope.first_step[$scope.i].color;
    $scope.first_step[$scope.i].status = 'Started';
    //$scope.k = 1;

    $scope.continue = function(){
        //$( "label:has(input:checked)" ).addClass( "checklabel" );
        if($scope.i <= $scope.first_step.length){
            $scope.form_icon_color[$scope.i] = $scope.first_step[$scope.i].color;
            if($scope.j < $scope.first_step[$scope.i].inner.length ){
                if($scope.k < $scope.first_step[$scope.i].inner[$scope.j].forms.length-1 && $scope.k >= 0){
                    /*if($scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id == 'myInfo1'){
                        if(angular.isUndefined($scope.data.myinfo.why)){
                            $scope.basic_info_error = "Please select any option";
                            return;
                        }
                        else{
                            $scope.basic_info_error = "";
                        }
                    }
                    if($scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id == 'myInfo2'){
                        if(angular.isUndefined($scope.data.myinfo.fname) || angular.isUndefined($scope.data.myinfo.lname) || angular.isUndefined($scope.data.myinfo.dob.month) || angular.isUndefined($scope.data.myinfo.dob.date) || angular.isUndefined($scope.data.myinfo.dob.year) || angular.isUndefined($scope.data.myinfo.gender)){
                            $scope.basic_info_error = "Please fill the fields";
                            return;
                        }
                        else{
                            $scope.basic_info_error = "";
                        }
                    }
                    if($scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id == 'myInfo3'){
                        if(angular.isUndefined($scope.data.myinfo.street) || angular.isUndefined($scope.data.myinfo.city) || angular.isUndefined($scope.data.myinfo.zip) || angular.isUndefined($scope.data.myinfo.phone)){
                            $scope.basic_info_error = "Please fill the fields";
                            return;
                        }
                        else{
                            $scope.basic_info_error = "";
                        }
                    }
                    if($scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id == 'myInfo4'){
                        if(angular.isUndefined($scope.data.myinfo.job) || angular.isUndefined($scope.data.myinfo.income)){
                            $scope.basic_info_error = "Please fill the fields";
                            return;
                        }
                        else{
                            $scope.basic_info_error = "";
                        }
                    }
                    if($scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id == 'spouseInfo1'){
                        if(angular.isUndefined($scope.data.spouseinfo.fname) || angular.isUndefined($scope.data.spouseinfo.lname) || angular.isUndefined($scope.data.spouseinfo.dob.month) || angular.isUndefined($scope.data.spouseinfo.dob.date) || angular.isUndefined($scope.data.spouseinfo.dob.date) || angular.isUndefined($scope.data.spouseinfo.gender)){
                            $scope.basic_info_error = "Please fill the fields";
                            return;
                        }
                        else{
                            $scope.basic_info_error = "";
                        }
                    }
                    if($scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id == 'spouseInfo2'){
                        if(angular.isUndefined($scope.data.spouseinfo.street) || angular.isUndefined($scope.data.spouseinfo.state) || angular.isUndefined($scope.data.spouseinfo.city) || angular.isUndefined($scope.data.spouseinfo.zip) || angular.isUndefined($scope.data.spouseinfo.phone)){
                            $scope.basic_info_error = "Please fill the fields";
                            return;
                        }
                        else{
                            $scope.basic_info_error = "";
                        }
                    }
                    if($scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id == 'spouseInfo3'){
                        if(angular.isUndefined($scope.data.spouseinfo.job) || angular.isUndefined($scope.data.spouseinfo.income)){
                            $scope.basic_info_error = "Please fill the fields";
                            return;
                        }
                        else{
                            $scope.basic_info_error = "";
                        }
                    }
                    if($scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id == 'ourProfile1'){
                        if(angular.isUndefined($scope.data.ourProfile.dom.month) || angular.isUndefined($scope.data.ourProfile.dom.date) || angular.isUndefined($scope.data.ourProfile.dom.year)){
                            $scope.basic_info_error = "Please fill the fields";
                            return;
                        }
                        else{
                            $scope.basic_info_error = "";
                        }
                    }
                    if($scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id == 'ourProfile2'){
                        if(angular.isUndefined($scope.data.ourProfile.living_status) ){
                            $scope.basic_info_error = "Please fill the fields";
                            return;
                        }
                        else{
                            $scope.basic_info_error = "";
                        }
                    }
                    if($scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id == 'ourProfile3'){
                        if(angular.isUndefined($scope.data.ourProfile.assets)){
                            $scope.basic_info_error = "Please fill the fields";
                            return;
                        }
                        else{
                            $scope.basic_info_error = "";
                        }
                    }
                    if($scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id == 'ourProfile4'){
                        if(angular.isUndefined($scope.data.ourProfile.debts)){
                            $scope.basic_info_error = "Please fill the fields";
                            return;
                        }
                        else{
                            $scope.basic_info_error = "";
                        }
                    }
                    if($scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id == 'ourProfile5'){
                        if(angular.isUndefined($scope.data.ourProfile.fin_support)){
                            $scope.basic_info_error = "Please fill the fields";
                            return;
                        }
                        else{
                            $scope.basic_info_error = "";
                        }
                    } */
                    console.log($scope.i+' '+$scope.j+' '+$scope.k);
                    $scope.k++;

                    $scope.currentStep = $scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id;
                    $scope.percent_t = ($scope.k/$scope.first_step[$scope.i].inner[$scope.j].forms.length)*100;
                   // $scope.save($scope.data);
                }
                else{
                    $scope.k=0;
                    $scope.percent_t = 0;
                    $scope.first_step[$scope.i].inner[$scope.j].status = 'completed';
                    $scope.j++;
                    if($scope.j == $scope.first_step[$scope.i].inner.length){
                        $scope.currentStep = 'basic_info_review';
                    }
                    else{
                        $scope.currentStep = $scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id;    
                    }
                }
            }
            else{

                $scope.j=0;
                $scope.first_step[$scope.i].status = 'completed';
                $scope.i++;
                $scope.first_step[$scope.i].status = 'Started';

            }
        }
        else{

        }
    };
  //  $scope.continue();
    $scope.goback = function(){
        if($scope.i < $scope.first_step.length-1 ){
            if($scope.j < $scope.first_step[$scope.i].inner.length ){
                if($scope.k < $scope.first_step[$scope.i].inner[$scope.j].forms.length && $scope.k > 0){



                    $scope.k--;
                    console.log($scope.k);
                    $scope.currentStep = $scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id;
                    $scope.percent_t = ($scope.k/$scope.first_step[$scope.i].inner[$scope.j].forms.length)*100;
                }
                else{
                    $scope.k=0;
                    $scope.percent_t = 0;
                    $scope.first_step[$scope.i].inner[$scope.j].status = 'completed';
                    $scope.j--;
                    $scope.currentStep = $scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id;
                }
            }
            else{
                $scope.j=0;
                $scope.i--;
            }
        }
    }


    $scope.save = function(data){
        console.log(data);
        Data.post('save',{
            data : data
        }).then(function (results){
            Data.toast(results);
            console.log(results);
        });
    };

    
});

app.factory("Data", ['$http', 'toaster',
    function ($http, toaster) { // This service connects to our REST API

        var serviceBase = BASE_URL+'api/auth/';

        var obj = {};
        obj.toast = function (data) {
            toaster.pop(data.status.toLowerCase(), "", data.message, 10000, 'trustedHtml');
        }
        obj.get = function (q) {
            return $http.get(serviceBase + q).then(function (results) {
                return results.data;
            });
        };
        obj.post = function (q, object) {
            return $http.post(serviceBase + q, object).then(function (response) {
                return response.data;
            });
        };
        obj.put = function (q, object) {
            return $http.put(serviceBase + q, object).then(function (results) {
                return results.data;
            });
        };
        obj.delete = function (q) {
            return $http.delete(serviceBase + q).then(function (results) {
                return results.data;
            });
        };

        return obj;
}]);

app.directive('focus', function() {
    return function(scope, element) {
        element[0].focus();
    }      
});

app.directive('passwordMatch', [function () {
    return {
        restrict: 'A',
        scope:true,
        require: 'ngModel',
        link: function (scope, elem , attrs,control) {
            var checker = function () {
 
                //get the value of the first password
                var e1 = scope.$eval(attrs.ngModel); 
 
                //get the value of the other password  
                var e2 = scope.$eval(attrs.passwordMatch);
                if(e2!=null)
                return e1 == e2;
            };
            scope.$watch(checker, function (n) {
 
                //set the form control to valid if both 
                //passwords are the same, else invalid
                control.$setValidity("passwordNoMatch", n);
            });
        }
    };
}]);

app.directive('notEmpty', function(){
    return {
        require: 'ngModel',
        link: function(scope, element, attr, mCtrl) {
            function myValidation(value) {
                if (value.indexOf("e") > -1) {
                    mCtrl.$setValidity('charE', true);
                } else {
                    mCtrl.$setValidity('charE', false);
                }
                return value;
            }
            mCtrl.$parsers.push(myValidation);
        }
    };
});
