var app = angular.module('project', [
        'ngRoute', 
        'ngAnimate', 
        'toaster', 
        'ui.select2', 
        'vAccordion', 
        'vcRecaptcha', 
        'ngMaterial', 
        'ngMask', 
        'angularFileUpload', 
        'ui.calendar', 
        'angularMoment',
        'angularGAPI'
        ]);
app.value('GoogleApp', {
    apiKey: 'AIzaSyCXUQ0nFdPH5r9ynAnT7mIdDFTBCwXXYzs',
    clientId: '147863786580-7p6eo3pdr0njcab86pmk72bvojsjpes1.apps.googleusercontent.com',
    scopes: [
      // whatever scopes you need for your app, for example:
      //'https://www.googleapis.com/auth/drive',
      //'https://www.googleapis.com/auth/youtube',
      //'https://www.googleapis.com/auth/userinfo.profile'
      'https://www.googleapis.com/auth/calendar.readonly'
      // ...
    ]
  });
app.config(['$routeProvider', '$mdDateLocaleProvider',
  function ($routeProvider, $mdDateLocaleProvider) {
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
       /* .when('/basic', {
            title: 'Basic Info',
            templateUrl: BASE_URL+'account/view/basic_info',
            controller: 'authCtrl'
        })  */
        .when('/form/:id',{
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
        .when('/404',{
            templateUrl: BASE_URL+'account/view/404',
            controller:'authCtrl'
        })
       /* .when('/', {
            title: 'Home',
            templateUrl:BASE_URL+'home/homeView',
            controller: 'authCtrl',
            role: '0'
        })*/
        .otherwise({
            redirectTo: '/login'
        });
          
          
  }])
    .run(function ($rootScope, $location, Data) {
        $rootScope.$on("$routeChangeStart", function (event, next, current) {
            $rootScope.authenticated = false;
            $rootScope.data = [];
            $rootScope.kidsList = [{}];
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
                    if(nextUrl == '/form/:id'){
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


app.controller('authCtrl', function ($rootScope, $scope, $compile, $filter, $routeParams, $location, $http, Data, vcRecaptchaService, ContactTypesService, FileUploader, $mdDialog, moment, uiCalendarConfig, GAPI, GoogleApp, Calendar) {
    //initially set those objects to null to avoid undefined error
    $rootScope.GetContactTypes = ContactTypesService.ContactTypes();
    if(angular.isUndefined(GoogleApp.oauthToken)){
        GAPI.init();
    }

    $scope.today = new Date();
    $scope.menu = '';
    $scope.currentTpl = 'one';
    $scope.login = {};
    $scope.logindisable = false;
    $scope.hidenav = false;
    $scope.signup = {};
    $scope.data = [
            {
                'myinfo':[],
                'spouseinfo':[],
                'ourProfile':[],
                'kids':[
                    {
                        'kidsaddress':[{}]
                    }
                ],
                'kidsRelation':[]
            }
        ];
    $scope.welcome_data = '';
    $scope.signup_error = '';
    $scope.datatest = 'test';
    $scope.loginerror = '';
    $scope.forgoterror = '';
    $scope.signup.noc_under_18 = '0';
    $scope.signup.cresponse = null;
    $scope.widgetId = null;
    $scope.menu =[];
    $scope.formPosition = {i:0, j:0, k:0};
    $scope.uploadError = '';
    $scope.isSkip = false;
    $scope.skipNav = false;
    $scope.displayPop = false;
    $scope.profilePic = '3';

    $scope.uiConfig = {
        calendar : {
            editable : false,
            header : {
                left : 'today prev,next title',
                center : '',
                right : 'agendaDay,agendaWeek,month,agendaFourDay,listWeek'
            },
            dayClick : $scope.setCalDate,
            views: {
                agendaFourDay: {
                    type: 'agenda',
                    duration: { days: 4 },
                    buttonText: '4 day'
                }
            },
            background: '#f26522',
        },
    };

    var uploader = $scope.uploader = new FileUploader({
        url: BASE_URL+'api/auth/do_upload'
    });


        // FILTERS
      
    uploader.filters.push({
        name: 'imageFilter',
        fn: function(item /*{File|FileLikeObject}*/, options) {
            var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
            return '|pdf|doc|docx|'.indexOf(type) !== -1;
        }
    });

  
    
    // CALLBACKS

    uploader.onWhenAddingFileFailed = function(item /*{File|FileLikeObject}*/, filter, options) {
        $scope.uploadError = 'Only Doc and Pdf allowed';
    };
    uploader.onAfterAddingFile = function(fileItem) {
        $("#upload_process").fadeIn();
    };
    uploader.onAfterAddingAll = function(addedFileItems) {
    };
    uploader.onBeforeUploadItem = function(item) {
    };
    uploader.onProgressItem = function(fileItem, progress) {
    };
    uploader.onProgressAll = function(progress) {
    };
    uploader.onSuccessItem = function(fileItem, response, status, headers) {
    };
    uploader.onErrorItem = function(fileItem, response, status, headers) {

    };
    uploader.onCancelItem = function(fileItem, response, status, headers) {
    };
    uploader.onCompleteItem = function(fileItem, response, status, headers) {
    };
    uploader.onCompleteAll = function() {
    };

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
    //add kids
    $scope.addKid = function(){
        $scope.data.kids.push({'kidsaddress':[{}], 'kidslegalissue':[{}], 'kidsprotective':[{}]});
    }
    $scope.kidsaddress = function(data){
        data.push({});
    }
    $scope.kidsprotective = function(data){
        data.push({});
    }
    $scope.AddContactTypeControl = function() {
        $scope.singleKid++;
        $scope.kidsList.push($scope.singleKid);
        //var divElement = angular.element(document.querySelector('#contactTypeDiv'));
        //var appendHtml = $compile('<contact-Type></contact-Type>')($scope);
        //divElement.append(appendHtml);
    }
    $scope.loadProfile = function(){
        Data.get('profilePic').then(function(results){
            $scope.profilePic = results.name;
        });
    }
    $scope.changeProfile = function(imgName){
        Data.post('changeProfile',{
            pic : imgName
        }).then(function(results){
            $scope.profilePic = imgName;
            Data.toast(results);
        });
    }
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
    };
    $scope.viewForm = function($page){
       $location.path('form/basic');
    }; 
    $scope.loadCalendar = function(){
        $scope.calendar = Calendar.CalendarsGet([{'calendarId':'qp773goe7nuuhhihaojrmlmb...oup.calendar.google.com'}]);
        console.log('asdf');
        console.log($scope.calendar);
    }
    $scope.loadUserData = function(formPosition){
        $scope.i = formPosition.i;
        $scope.j = formPosition.j;
        $scope.k = formPosition.k;
        if($routeParams.id == 'kids'){
            $scope.i = 1;
            $scope.j = formPosition.j;
            $scope.k = formPosition.k;    
        }
        
        $scope.percent_t = 0;
        $scope.currentStep = $scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id;
        $scope.form_icon_color = $scope.first_step[$scope.i].color;
        $scope.first_step[$scope.i].status = 'Started';
        Data.get('loadFromData').then(function(response){
            $scope.data = response.data;
        });
    };

    $scope.panesA = [
        {
          id: 'pane-1a',
          header: 'Getting Started',
          status: '0%',
          text: 'static/img/nl/step_process.png',
          url: '#/form/basic',
          content:[
            {
                id:'pane-1a-1',
                title : 'First Steps',
                icon : 'static/img/icons/dashboard/my_info.png',
                status : 'incomplete',
                color : '#25b7d3'
            },
            {
                id:'pane-1a-2',
                title : 'Spouse\'s Info',
                icon : 'static/img/icons/dashboard/spouuse_info.png',
                status : 'incomplete',
                color : '#24b23b'
            },
            {
                id:'pane-1a-3',
                title : 'Our Profile',
                icon : 'static/img/icons/dashboard/our_profile.png',
                status : 'incomplete',
                color : '#fabc3c'
            }
          ],
          isExpanded: true
        },
        {
          id: 'pane-2a',
          header: 'Kids',
          status: '0%',
          text: 'static/img/nl/step_process.png',
          url: '#/form/kids',
          content:[
            {
                id:'pane-1a-1',
                title : 'First Steps',
                icon : 'static/img/icons/dashboard/kids/custody.png',
                status : 'incomplete',
                color : 'red'
            },
            {
                id:'pane-1a-2',
                title : 'Spouse\'s Info',
                icon : 'static/img/icons/dashboard/kids/child_support.png',
                status : 'incomplete',
                color : ''
            },
            {
                id:'pane-1a-3',
                title : 'Our Profile',
                icon : 'static/img/icons/dashboard/kids/final_details.png',
                status : 'incomplete',
                color : ''
            }
          ],
        },
        {
          id: 'pane-3a',
          header: 'Have/Owe',
          status: '0%',
          text: 'static/img/nl/step_process.png',
          url: '#/dashboard',
          content:[
            {
                id:'pane-1a-1',
                title : 'First Steps',
                icon : 'static/img/icons/dashboard/have-owe/me.png',
                status : 'incomplete',
                color : 'red'
            },
            {
                id:'pane-1a-2',
                title : 'Spouse\'s Info',
                icon : 'static/img/icons/dashboard/have-owe/spouse.png',
                status : 'incomplete',
                color : ''
            },
            {
                id:'pane-1a-3',
                title : 'Our Profile',
                icon : 'static/img/icons/dashboard/have-owe/US.png',
                status : 'incomplete',
                color : ''
            },
            {
                id:'pane-1a-4',
                title : 'Our Kids',
                icon : 'static/img/icons/dashboard/have-owe/review.png',
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
          url: '#/dashboard',
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
            url : '#/form/basic',
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
            url : '#/form/kids',
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
                        }
                    ]
                },
                {
                    id:'2',
                    status:'',
                    title:'Child Support',
                    forms:[
                        {
                            id:'ChildSupport1'
                        },
                        {
                            id:'ChildSupport2',
                        }
                    ]
                },
                {
                    id:'3',
                    status:'',
                    title:'Final Details',
                    forms:[
                        {
                            id:'FinalDetails1'
                        },
                        {
                            id:'FinalDetails2',
                        },
                        {
                            id:'FinalDetails3'
                        },
                        {
                            id:'FinalDetails4'
                        },
                        {
                            id:'FinalDetails5'
                        },
                        {
                            id:'FinalDetails6'
                        },
                        {
                            id:'FinalDetails7'
                        },
                        {
                            id:'FinalDetails8'
                        }
                    ]
                }
            ]
        },
        {
            title:'Have/Owe',
            icon:'static/img/icons/dashboard/basic_info.png',
            color: '',
            url : '#/form/basic',
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
            url : '#/form/basic',
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
       
    //$scope.k = 1;
    $scope.continue = function(){
        $scope.conterror=false;
        $scope.skipNav = false;
        //$( "label:has(input:checked)" ).addClass( "checklabel" );
        if($scope.i <= $scope.first_step.length){
            $scope.form_icon_color[$scope.i] = $scope.first_step[$scope.i].color;
            if($scope.j < $scope.first_step[$scope.i].inner.length ){
                if($scope.k < $scope.first_step[$scope.i].inner[$scope.j].forms.length-1 && $scope.k >= -1){
                    $scope.isSkip = false;
                    if($scope.k != -1){
                        if($scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id == 'Custody3'){
                            $scope.isSkip = true;
                        } 
                        if($scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id == 'Custody5'){
                            $scope.isSkip = true;
                        }
                        if($scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id == 'Custody7'){
                            $scope.isSkip = true;
                        }
                        
                    }
                    
                    $scope.k++;
                    $scope.ValidateStep($scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id);
                    if(!angular.isUndefined($scope.first_step[$scope.i].inner[$scope.j])){
                        $scope.currentStep = $scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id;
                        $scope.percent_t = ($scope.k/$scope.first_step[$scope.i].inner[$scope.j].forms.length)*100;
                    }
                    //$scope.save($scope.data);
                }
                else{
                    $scope.k=0;
                    $scope.percent_t = 0;
                    $scope.first_step[$scope.i].inner[$scope.j].status = 'completed';
                    $scope.j++;
                    if($scope.j == $scope.first_step[$scope.i].inner.length){
                        if($scope.i==1){
                            $scope.currentStep = 'kidsReview';
                        }
                        else{
                            $scope.currentStep = 'basic_info_review';
                        }
                        //$scope.currentStep = 'basic_info_review';
                        $scope.hidenav = true;
                        //$scope.i++;
                        //$scope.j=0;
                        //$scope.k=-1;
                        //$scope.first_step[$scope.i].status = 'Started';
                    }
                    else{
                        
                        $scope.currentStep = $scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id;    
                    }
                }
            }
            else{
                $scope.j=0;
                $scope.k=-1;
                $scope.first_step[$scope.i].status = 'completed';
                $scope.i++;
                $scope.first_step[$scope.i].status = 'Started';
                $scope.continue();
            }
        }
        else{

        }
        $scope.save($scope.data);
    };
    $scope.continue2 = function(){
        $scope.conterror=true;
    }
  //  $scope.continue();
    $scope.goback = function(){
        if($scope.i < $scope.first_step.length-1 ){
            if($scope.j < $scope.first_step[$scope.i].inner.length ){
                if($scope.k < $scope.first_step[$scope.i].inner[$scope.j].forms.length && $scope.k > 0){
                    $scope.k--;
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

    $scope.ValidateStep = function(stepId){
        if(stepId == 'Custody5'){
            if($scope.data.kidsRelation != null && $scope.data.kidsRelation.legalCustody == 'Y'){
                $scope.k++;
            }
        }
        if(stepId == 'Custody7'){
            if($scope.data.kidsRelation != null && $scope.data.kidsRelation.physicalCustody == 'Y'){
                $scope.k++;
            }
        }
        if(stepId == 'Custody9'){
            if($scope.data.kidsRelation != null && $scope.data.kidsRelation.custodySchedule == 'We will figure out a custody schedule on our own and come back to the court if needed'){
                $scope.k = $scope.k+2;
                $scope.continue();
            }
            if($scope.data.kidsRelation != null && $scope.data.kidsRelation.custodySchedule == 'We would like to speak with a custody specialist'){
                $scope.displayPop = true;
                
            }
        }
        if(stepId == 'FinalDetails2'){
            if($scope.data.kidsRelation != null && $scope.data.kidsRelation.kidslivingSameAddress == 'Y'){
                $scope.k++;
            }
        }
        if(stepId == 'FinalDetails4'){
            if($scope.data.kidsRelation != null && $scope.data.kidsRelation.kidsLegalissue == 'N'){
                $scope.k++;
            }
        }
        if(stepId == 'FinalDetails6'){
            if($scope.data.kidsRelation != null && $scope.data.kidsRelation.protective == 'N'){
                $scope.k++;
            }
        }
        if(stepId == 'FinalDetails8'){
            if($scope.data.kidsRelation != null && $scope.data.kidsRelation.legalClaims == 'N'){
                $scope.k = $scope.k+2;
                $scope.continue();
            }
        }
    };
    $scope.custodySkip = function(data){
        if(data == 'Y'){
            $scope.k++;
            $scope.continue();
        }else{
            $scope.continue();
        }
    };
    $scope.skip = function(){
        $scope.k = $scope.k+2;
        $scope.basic_info_error = '';
        if($scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id == 'Custody8'){
            $scope.isSkip = false;
            $scope.skipNav = false;
        }
        $scope.currentStep = $scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id;
    };
    $scope.save = function(data){
        Data.post('save',{
            data : data
        }).then(function (results){
            $scope.data = results.data;
            Data.toast(results);
        });
    };
    $scope.GuideLine = function(){
        $scope.displayPop = true;
    };
    $scope.popupClose = function(){
        $('[data-popup="popup-1"]').fadeOut(350);
    };
    $scope.popupClose2 = function(){
        $('#upload_process').fadeOut(350);
    }
    $scope.popupClose3 = function(){
        $('.popup2').fadeOut(350);
    }
    
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
app.directive('routeLoadingIndicator', function($rootScope) {
  return {
    restrict: 'E',
    template: "<div ng-show='isRouteLoading' class='loading-indicator'>" +
    "<div class='loading-indicator-body'>" +
    '<div class="sk-spinner sk-spinner-double-bounce"><div class="sk-double-bounce1"></div><div class="sk-double-bounce2"></div></div>' +
    "</div>" +
    "</div>",
    replace: true,
    link: function(scope, elem, attrs) {
      scope.isRouteLoading = false;

      $rootScope.$on('$routeChangeStart', function() {
        scope.isRouteLoading = true;
      });
      $rootScope.$on('$routeChangeSuccess', function() {
        scope.isRouteLoading = false;
      });
    }
  };
});

app.directive('contactType', function() {
  return {
    restrict: "E",
    scope: {},
    template:'<div class="row"><div class="col-lg-12"><input class="fr_name" type="text" name="" ng-model="data.kids.fname[\'id\']" placeholder="First Name"><input class="mid_int" type="text" name="" ng-model="data.kids.mname" placeholder="Middle Initial"><input class="lst_name" ng-model="data.kids.lname" type="text" name="" placeholder="Last Name"><input class="st_birth" type="text" name="" ng-model="data.kids.birthPlace" placeholder="City, State of Birth"><input class="dob" type="text" name="" ng-model="data.kids.dob" placeholder="DOB mm/dd/yyyy"></div></div><div class="row">   <div class="col-lg-12 text-right"><br><md-radio-group ng-model="data.kids.gender"><md-radio-button class="md-primary" value="M">Male</md-radio-button><md-radio-button class="md-primary" value="F">Female</md-radio-button></md-radio-group></div></div>',
    controller: function($rootScope, $scope, $element) {
      $scope.contacts = $rootScope.GetContactTypes;
      $scope.Delete = function(e) {
        //remove element and also destoy the scope that element
        $element.remove();
        $scope.$destroy();
      }
    }
  }
});
app.service("ContactTypesService", [function() {
  var list = [];
  return {
    ContactTypes: function() {
      
      return list;
    }
  }
}]);
app.filter('toDate', function() {
    return function(input) {
        return (angular.isUndefined(input) || input == '') ? '' : new Date(input);
    }
});
/*
app.directive('ngSpinnerBar', ['$rootScope', '$state',
    function($rootScope, $state) {
        return {
            link: function(scope, element, attrs) {
                // by defult hide the spinner bar
                element.addClass('hide'); // hide spinner bar by default

                // display the spinner bar whenever the route changes(the content part started loading)
                $rootScope.$on('$stateChangeStart', function() {
                    element.removeClass('hide'); // show spinner bar
                });

                // hide the spinner bar on rounte change success(after the content loaded)
                $rootScope.$on('$stateChangeSuccess', function(event) {
                    element.addClass('hide'); // hide spinner bar
                    $('body').removeClass('page-on-load'); // remove page loading indicator
                    Layout.setAngularJsSidebarMenuActiveLink('match', null, event.currentScope.$state); // activate selected link in the sidebar menu
                   
                    // auto scorll to page top
                    setTimeout(function () {
                        App.scrollTop(); // scroll to the top on content load
                    }, $rootScope.settings.layout.pageAutoScrollOnLoad);     
                });

                // handle errors
                $rootScope.$on('$stateNotFound', function() {
                    element.addClass('hide'); // hide spinner bar
                });

                // handle errors
                $rootScope.$on('$stateChangeError', function() {
                    element.addClass('hide'); // hide spinner bar
                });
            }
        };
    }
]); */

app.directive('alphapet', function() {
  return {
    require: 'ngModel',
    link: function (scope, element, attr, ngModelCtrl) {
      function fromUser(text) {
        var transformedInput = text.replace(/[^A-Za-z ]/g, '');
        if(transformedInput !== text) {
            ngModelCtrl.$setViewValue(transformedInput);
            ngModelCtrl.$render();
        }
        return transformedInput;
      }
      ngModelCtrl.$parsers.push(fromUser);
    }
  }; 
});
app.directive('alphapetWithcomma', function() {
  return {
    require: 'ngModel',
    link: function (scope, element, attr, ngModelCtrl) {
      function fromUser(text) {
        var transformedInput = text.replace(/[^A-Za-z ,]/g, '');
        if(transformedInput !== text) {
            ngModelCtrl.$setViewValue(transformedInput);
            ngModelCtrl.$render();
        }
        return transformedInput;
      }
      ngModelCtrl.$parsers.push(fromUser);
    }
  }; 
});