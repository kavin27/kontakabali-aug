var app = angular.module('project', [
        'ngRoute', 
        'ngAnimate', 
        'toaster',
        'ngSanitize',
        'ui.select', 
        'ui.select2',
        'vAccordion', 
        'vcRecaptcha', 
        'ngMaterial', 
        'ngMask', 
        'angularFileUpload', 
        'ui.calendar', 
        'angularMoment',
        'ngScrollbar',
        'dndLists',
        'ui.bootstrap.contextMenu'
        ]);
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
            controller: 'authCtrl'
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
        .when('/HaveOwe',{
            templateUrl: BASE_URL+'account/view/have_owe',
            controller:'haveOwe'
        })
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
                    if($location.$$path=='/login' || $location.$$path=='/signup'){
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
                    if(nextUrl == '/signup'){
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
                    if(nextUrl == '/HaveOwe'){
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
app.controller('authCtrl', 
    function ($rootScope, $scope, $compile, $filter, $routeParams, $location, $http, Data, vcRecaptchaService, ContactTypesService, FileUploader, $mdDialog, moment, uiCalendarConfig, GoogleApi) {
    $rootScope.GetContactTypes = ContactTypesService.ContactTypes();
    $scope.today = new Date();
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
    $scope.loginerror = '';
    $scope.forgoterror = '';
    $scope.signup.noc_under_18 = '0';
    $scope.signup.cresponse = null;
    $scope.widgetId = null;
    $scope.formPosition = {i:0, j:0, k:0};
    $scope.uploadError = '';
    $scope.isSkip = false;
    $scope.skipNav = false;
    $scope.displayPop = false;
    $scope.profilePic = '3';
    $scope.noofdayeswithme = 0;
    $scope.noofdayeswithspouse = 0;
    $scope.eventTitle = '';
    $scope.eventTime= '';
    $scope.calendarDate = [];
    $scope.eventSources;
    $scope.events = [];

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

    $scope.doLogout = function(){
        $scope.logindisable =true;
        Data.get('logout').then(function (results) {
            if (results.status == "SUCCESS") {
                Data.toast(results);
                $location.path('login');    
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

    $scope.loadProfile = function(){
        Data.get('profilePic').then(function(results){
            $scope.profilePic = results.name;
        });
    };
    $scope.changeProfile = function(imgName){
        Data.post('changeProfile',{
            pic : imgName
        }).then(function(results){
            $scope.profilePic = imgName;
            Data.toast(results);
        });
    };
    $scope.welcomeStep = 0;
    $scope.nextStep = function(){
        if($scope.welcomeStep==2){
            $scope.welcomeStep = 0;
        }
        else{
            $scope.welcomeStep++;    
        }
    };
    $scope.previousStep = function(){
        if($scope.welcomeStep==0){
            $scope.welcomeStep = 2;
        }
        else{
            $scope.welcomeStep--;    
        }
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
    
    
    $scope.showPop = '';
    var element = angular.element(document.querySelector('.popevent'));
    element.hide();
    $scope.setCalDate = function(date, jsEvent, view){
        element.css({
          top: jsEvent.pageY-303 + "px", left: jsEvent.pageX-200 + "px", position: 'absolute',
        });
        element.show();
        $scope.startDate = date.format();
        $scope.showPop = 'popupForm';
    };
    $scope.eventClickCal = function(calEvent, jsEvent, view){
        $scope.eventId = calEvent.id;
        $scope.eventTitle = calEvent.title;
        $scope.startDate = calEvent.start.format();
        $scope.endDate = calEvent.end != null ? calEvent.end.format() : calEvent.start.format();
        element.css({
          top: jsEvent.pageY-303 + "px", left: jsEvent.pageX-200 + "px", position: 'absolute',
        });
        element.show();
        $scope.showPop = 'popupEventForm';
    };
    $scope.closeEventPop = function(){
        element.hide();
        $scope.showPop = '';
    }
    $scope.deleteEvent = function(eventId){
        GoogleApi.post('deleteEvent', {
            id : eventId
        }).then(function(response){
            element.hide();
            $scope.showPop = '';
            GoogleApi.toast(response);
            angular.forEach($scope.events, function(value, key){
                if(value.id == eventId){
                    $scope.events.splice(key,1);
                }
            });
          //  $scope.loadGoogleApi();
        }); 
    }
    $scope.addEvent = function(data){
        GoogleApi.post('addEvent', {
            data : data
        }).then(function(response){
            var bg = '';
            var txtColor = '';
            if(data.title == 'Petitioner (You)'){
                bg = '#a4bdfc';
                txtColor = '#000';
            }
            else{
                bg = '#7ae7bf';
                txtColor = '#000';
            }
            var start = moment(data.start);
            var end = moment(data.end);
            var formatedStart = start.format();
            var formatedEnd = end.add(1, 'days').format();
            
            $scope.events.push({
                    'id':response.result.id,
                    "title":data.title, 
                    "start":formatedStart, 
                    "end":formatedEnd,
                    'backgroundColor' : bg ,
                    'textColor' : txtColor
                });
            var me=0, spouse=0;
            if(data.title == 'Petitioner (You)'){
                var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
                var firstDate = new Date(data.start);
                var secondDate = new Date(data.end);

                var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
                me += diffDays;
            }
            else{
                var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
                var firstDate = new Date(data.start);
                var secondDate = new Date(data.end);

                var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
                spouse += diffDays;
            }
            $scope.noofdayeswithme += me;
            $scope.noofdayeswithspouse += spouse;

        });
        
        $scope.showPop = '';
        element.hide();
    }

    $scope.uiConfig = {
        calendar : {
            editable : false,
            header : {
                left : 'today prev,next title',
                center : '',
                right : 'agendaDay,agendaWeek,month,agendaFourDay,listWeek'
            },
            dayClick : $scope.setCalDate,
            eventClick : $scope.eventClickCal,
            views: {
                agendaFourDay: {
                    type: 'agenda',
                    duration: { days: 4 },
                    buttonText: '4 day'
                }
            },
        },
    };

    $scope.viewForm = function($page){
       $location.path('form/basic');
    }; 
    $scope.loadGoogleApi = function(){
        $scope.loadCalendarList();    
    }
    $scope.createCalendar = function(){
        GoogleApi.post('createCalendar', {
            data : 'Child Support'
        }).then(function(response){
        });
    };

    $scope.loadCalendarList = function(){
        $scope.loadingGoogleApi = true;
        GoogleApi.get('getCalendarAll').then(function(response){
            if(response.status == 'SUCCESS'){
                $scope.googleCalendar = true;
                $scope.loadEvents('tset', '#000');
            }
            else{
                $scope.loadingGoogleApi = false;
                $scope.googleCalendar = false;
            }
        });
    };
    $scope.loadEvents = function(data, eventColor){
        GoogleApi.post('getEventList', {
            data : data
        }).then(function(response){
            var me = 0;
            var spouse = 0; 
            $scope.events = response;
//            $scope.calendarDate.push({'events':response});
            angular.forEach(response, function(value, key){
                if(value.title == 'Petitioner (You)'){
                    var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
                    var firstDate = new Date(value.start);
                    var secondDate = new Date(value.end);

                    var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
                    me += diffDays;
                }
                else{
                    var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
                    var firstDate = new Date(value.start);
                    var secondDate = new Date(value.end);

                    var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
                    spouse += diffDays;
                }
            });
            
            $scope.noofdayeswithme = me;
            $scope.noofdayeswithspouse = spouse;
            $scope.eventSources = [$scope.events];
            $scope.loadingGoogleApi = false;
        });
        
    };

    $scope.updateEvent = function(temp){
        if(temp == '' || angular.isUndefined(temp)){
            GoogleApi.toast({'status':'ERROR', 'message':'Please Select any template'});
        }
        else{
            GoogleApi.post('updateEvent',{
                data : temp,
                start : $scope.today
            }).then(function(response){
                $scope.loadCalendarList();
            });    
        }
    };
    $scope.clearCal = function(){
        GoogleApi.post('ClearEvents', {
            data : 'yes'
        }).then(function(response){
            if(response.status == 'SUCCESS'){
                $scope.loadGoogleApi();
            }
        });
    };
    $scope.calClickFlag = false;
    $scope.calClick = function(calId, Flag){
        GoogleApi.post('selectCal', {
            data : calId,
            selected : Flag
        }).then(function(response){
            $scope.loadGoogleApi();
        });
        
    };
    $scope.eventSources = [$scope.events];
    $scope.holidayList = {
        'religiousholidays':{
            'title': 'Religious Holidays',
            'list':[
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Maha Shivaratri',
                    'date' : {
                        'month' : 'February',
                        'day' : ['25'],
                        'noofdays':1
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Ash Wednesday',
                    'date' : {
                        'month' : 'March',
                        'day' : ['01'],
                        'noofdays':1
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Purim',
                    'date' : {
                        'month' : 'March',
                        'day' : ['12'],
                        'noofdays':1
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Holi',
                    'date' : '02-25',
                    'date' : {
                        'month' : 'March',
                        'day' : ['13','14'],
                        'noofdays':2
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Ramanavami',
                    'date' : {
                        'month' : 'April',
                        'day' : ['05'],
                        'noofdays':1
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Passover',
                    'date' : {
                        'month' : 'April',
                        'day' : ['10','18'],
                        'noofdays':2
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Good Friday',
                    'date' : {
                        'month' : 'April',
                        'day' : ['14'],
                        'noofdays':1
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Easter',
                    'date' : {
                        'month' : 'April',
                        'day' : ['16'],
                        'noofdays':1
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Ramadan',
                    'date' : {
                        'month' : 'May',
                        'day' : ['27'],
                        'noofdays':1
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Eid al-Fitr (End of Ramadan)',
                    'date' : {
                        'month' : 'June',
                        'day' : ['25'],
                        'noofdays':1
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Eid al-Adha',
                    'date' : {
                        'month' : 'September',
                        'day' : ['01'],
                        'noofdays':1
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Muharram (Al Hijrah - New Year) ',
                    'date' : {
                        'month' : 'September',
                        'day' : ['21'],
                        'noofdays':1
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Rosh Hashanah',
                    'date' : {
                        'month' : 'September',
                        'day' : ['21', '22'],
                        'noofdays':2
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Yom Kippur',
                    'date' : {
                        'month' : 'September',
                        'day' : ['30'],
                        'noofdays':1
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Diwali',
                    'date' : {
                        'month' : 'October',
                        'day' : ['19'],
                        'noofdays':1
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Navaratri / Dassehra',
                    'date' : {
                        'month' : 'November ',
                        'day' : ['21','29'],
                        'noofdays':2
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Hanukkah',
                    'date' : {
                        'month' : 'December ',
                        'day' : ['13','20'],
                        'noofdays':2
                    }
                }
            ]
        },
        'standardholidays':{
            'title': 'Standard Holidays',
            'list':[
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Martin Luther King Jr Day (Observed)',
                    'date' : {
                        'month' : 'January',
                        'day' : ['16'],
                        'noofdays':1
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Valentine’s Day',
                    'date' : {
                        'month' : 'February',
                        'day' : ['14'],
                        'noofdays':1
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'President’s Day (Observed)',
                    'date' : {
                        'month' : 'February',
                        'day' : ['20'],
                        'noofdays':1
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'St. Patrick’s Day',
                    'date' : {
                        'month' : 'March',
                        'day' : ['17'],
                        'noofdays':1
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Mother’s Day',
                    'date' : {
                        'month' : 'May',
                        'day' : ['14'],
                        'noofdays':1
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Memorial Day',
                    'date' : {
                        'month' : 'May',
                        'day' : ['29'],
                        'noofdays':1
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Father’s Day',
                    'date' : {
                        'month' : 'June',
                        'day' : ['18'],
                        'noofdays':1
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Independence Day',
                    'date' : {
                        'month' : 'July',
                        'day' : ['04'],
                        'noofdays':1
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Labor Day',
                    'date' : {
                        'month' : 'September',
                        'day' : ['04'],
                        'noofdays':1
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Columbus Day',
                    'date' : {
                        'month' : 'October',
                        'day' : ['09'],
                        'noofdays':1
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Halloween',
                    'date' : {
                        'month' : 'October',
                        'day' : ['31'],
                        'noofdays':1
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Thanksgiving',
                    'date' : {
                        'month' : 'November',
                        'day' : ['23'],
                        'noofdays':1
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Veteran’s Day',
                    'date' : {
                        'month' : 'November ',
                        'day' : ['11'],
                        'noofdays':1
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Christmas Eve',
                    'date' : {
                        'month' : 'December',
                        'day' : ['24'],
                        'noofdays':1
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Christmas Day',
                    'date' : {
                        'month' : 'December ',
                        'day' : ['25'],
                        'noofdays':1
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Christmas Day (Observed)',
                    'date' : {
                        'month' : 'December',
                        'day' : ['26'],
                        'noofdays':1
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'New Year’s Eve',
                    'date' : {
                        'month' : 'December',
                        'day' : ['31'],
                        'noofdays':1
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'New Year’s Day',
                    'date' : {
                        'month' : 'January',
                        'day' : ['02'],
                        'noofdays':1
                    }
                }
            ]
        },
        'mybirthday':{
            'option':false,
            'value':'',
            'text':'Your Birth Day'
        },
        'kidsbirthday':{
            'option':false,
            'value':[],
            'text':'Kids Birth Day'
        }

    };
    $scope.noofholidayswithme = 0;
    $scope.submitHolidy = function(holidayList){
        Data.post('updateHoliday',{
            data : holidayList
        }).then(function(response){
            $scope.noofholidayswithme = 0;
            angular.forEach(holidayList.religiousholidays.list, function(key, value){
                if(key.odd || key.even || key.current){
                    $scope.noofholidayswithme += key.date.noofdays;
                }
            });
            angular.forEach(holidayList.standardholidays.list, function(key, value){
                if(key.odd || key.even || key.current){
                    $scope.noofholidayswithme += key.date.noofdays;
                }
            });
            $scope.addHoliday = false;
        });
    };
    $scope.addHoliday = false;
    $scope.initHolidayList = function(){
        Data.get('getHolidays').then(function(response){
            if(angular.isUndefined(response.status)){
                $scope.holidayList = response;
                $scope.noofholidayswithme = 0;
                angular.forEach($scope.holidayList.religiousholidays.list, function(key, value){
                    if(key.odd || key.even || key.current){
                        $scope.noofholidayswithme += key.date.noofdays;
                    }
                });
                angular.forEach($scope.holidayList.standardholidays.list, function(key, value){
                    if(key.odd || key.even || key.current){
                        $scope.noofholidayswithme += key.date.noofdays;
                    }
                });
                $scope.alreadyAddred = true;
            }
            else{
                $scope.alreadyAddred = false;
            }
        });
    }
    $scope.selectHolidays = function(){
        $scope.addHoliday = true;
    };
    $scope.holidaysPopupClose = function(){
        $scope.addHoliday = false;
    }

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
                title : 'My Info',
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
                title : 'Custody & Visitation',
                icon : 'static/img/icons/dashboard/kids/custody.png',
                status : 'incomplete',
                color : 'red'
            },
            {
                id:'pane-1a-2',
                title : 'Child Support',
                icon : 'static/img/icons/dashboard/kids/child_support.png',
                status : 'incomplete',
                color : ''
            },
            {
                id:'pane-1a-3',
                title : 'Final Details',
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
          url: '#/HaveOwe',
          content:[
            {
                id:'pane-1a-1',
                title : 'Add Asset / Debt',
                icon : 'static/img/icons/dashboard/have-owe/me.png',
                status : 'incomplete',
                color : 'red'
            },
            {
                id:'pane-1a-2',
                title : 'Review',
                icon : 'static/img/icons/dashboard/have-owe/spouse.png',
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
                title : 'Add Asset / Debt',
                icon : 'static/img/icons/dashboard/basic_info.png',
                status : 'incomplete',
                color : 'red'
            },
            {
                id:'pane-1a-2',
                title : 'Review',
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
            }
          ],
        }
    ];

    
    
    
    $scope.forgotPassword = function(email){
        Data.post('forgotPassword', {
            email: email
        }).then(function (results){
            Data.toast(results);
        });
    };
    //$scope.signup = {email:'',password:'',name:'',phone:'',address:''};
    
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
                    title:'Custody',
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
                        }
                    ]
                },
                {
                    id:'2',
                    status:'',
                    title:'Shedule',
                    forms:[
                        {
                            id:'Shedule1'
                        },
                        {
                            id:'Shedule2',
                        }
                    ]
                },
                {
                    id:'3',
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
                    id:'4',
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
            url : '#/HaveOwe',
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
        Data.get('loadFromData').then(function(response){
            if(response.data.bookmark != null){
                if($routeParams.id == 'kids'){
                    $scope.j = response.data.bookmark.forms.kids.j;
                    $scope.k = response.data.bookmark.forms.kids.k;
                    $scope.percent_t = response.data.bookmark.forms.kids.completedPercent;
                }    
            }
            $scope.data = response.data;
            $scope.currentStep = $scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id;
            $scope.form_icon_color = $scope.first_step[$scope.i].color;
            $scope.first_step[$scope.i].status = 'Started';
        });
    };
    //$scope.k = 1;
    $scope.bookmark ={
        forms:{
            basic : {
                    currentStep : '',
                    completedPercent : '',
                    i : 0,
                    j : 0,
                    k : 0
                },
            kids : {
                    currentStep : '',
                    completedPercent : '',
                    i : 0,
                    j : 0,
                    k : 0
                }
            }
        };
    $scope.continue = function(){
        $scope.conterror=false;
        $scope.skipNav = false;
        $scope.save($scope.data);
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
                        /*$scope.bookmark ={
                            forms : {
                                basic : {
                                    currentStep : '',
                                    completedPercent : '',
                                    i : 0,
                                    j : 0,
                                    k : 0
                                },
                                kids : {
                                    currentStep : '',
                                    completedPercent : '',
                                    i : '',
                                    j : '',
                                    k : ''
                                }
                            }
                        }; */
                        if($scope.i == 0){
                            $scope.bookmark.forms.basic.currentStep = $scope.currentStep;
                            $scope.bookmark.forms.basic.completedPercent = $scope.percent_t;
                            $scope.bookmark.forms.basic.i = $scope.i;
                            $scope.bookmark.forms.basic.j = $scope.j;
                            $scope.bookmark.forms.basic.k = $scope.k;
                        }
                        else if($scope.i == 1){
                            $scope.bookmark.forms.kids.currentStep = $scope.currentStep;
                            $scope.bookmark.forms.kids.completedPercent = $scope.percent_t;
                            $scope.bookmark.forms.kids.i = $scope.i;
                            $scope.bookmark.forms.kids.j = $scope.j;
                            $scope.bookmark.forms.kids.k = $scope.k;
                        }
                    }
                    $scope.updateBookmark($scope.bookmark);
                    //$scope.save($scope.data);
                }
                else{
                    $scope.ValidateStep($scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id);
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
    };
    $scope.continue2 = function(){
        $scope.conterror=true;
    }
  //  $scope.continue();
    $scope.goback = function(){
        if($scope.i < $scope.first_step.length-1 && $scope.i >= 0){
            if($scope.j < $scope.first_step[$scope.i].inner.length && $scope.j >= 0 ){
                if($scope.k < $scope.first_step[$scope.i].inner[$scope.j].forms.length && $scope.k > 0){
                    $scope.isSkip = false;
                    if($scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id == 'Custody3'){
                        $scope.isSkip = true;
                    } 
                    if($scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id == 'Custody5'){
                        $scope.isSkip = true;
                    }
                    if($scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id == 'Custody7'){
                        $scope.isSkip = true;
                    }
                    $scope.k--;
                    $scope.currentStep = $scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id;
                  //  $scope.percent_t = ($scope.k/$scope.first_step[$scope.i].inner[$scope.j].forms.length)*100;
                }
                else{
                    if($scope.j > 0){
                        $scope.j--;
                        $scope.k = $scope.first_step[$scope.i].inner[$scope.j].forms.length-1;
                        $scope.currentStep = $scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id;
                    }
                    
                }
                
            }
            else{

            }
        }
        /*if($scope.i < $scope.first_step.length-1 && $scope.i >= 0){
            if($scope.j < $scope.first_step[$scope.i].inner.length && $scope.j > 0 ){
                if($scope.k < $scope.first_step[$scope.i].inner[$scope.j].forms.length && $scope.k > 0){
                    $scope.k--;
                    $scope.currentStep = $scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id;
                    $scope.percent_t = ($scope.k/$scope.first_step[$scope.i].inner[$scope.j].forms.length)*100;
                }
                else{
                    $scope.k=0;
                    $scope.percent_t = 0;
                    $scope.first_step[$scope.i].inner[$scope.j].status = 'completed';
                    $scope.currentStep = $scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id;
                    $scope.j--;
                }
            }
            else{
                $scope.j=0;
                $scope.i--;
            }
        } */
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
        if(stepId == 'Custody8'){
            if($scope.data.kidsRelation != null && $scope.data.kidsRelation.custodySchedule == 'We will figure out a custody schedule on our own and come back to the court if needed'){
                //$scope.continue();
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
    $scope.updateBookmark = function(bookmarkData){
        Data.post('updateBookmark', {
            data : bookmarkData
        }).then(function(response){

        });
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
    var uploader = $scope.uploader = new FileUploader({
        url: BASE_URL+'api/auth/do_upload'
    });
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

app.factory("GoogleApi", ['$http', 'toaster',
    function ($http, toaster) { // This service connects to our REST API

        var serviceBase = BASE_URL+'api/googleApi/';

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
        return (angular.isUndefined(input) || input == null) ? null : new Date(input);
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
app.directive('numbers', function() {
  return {
    require: 'ngModel',
    link: function (scope, element, attr, ngModelCtrl) {
      function fromUser(text) {
        var transformedInput = text.replace(/[^0-9]/g, '');
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
app.controller('haveOwe', function($scope, uiSelect2Config, Data){

    $scope.menuOptions = [
        ['Delete', function ($itemScope, event, modelValue) {

            Data.post('delete',{
                type: modelValue.type,
                id: modelValue.id
            }).then(function(response){
                Data.toast(response);
                $scope.loadAssets();
                $scope.loadDebt();
            });
        }],
        ['Edit', function ($itemScope, event, modelValue) {
            Data.post('getSingle', {
                id : modelValue.id,
                type : modelValue.type
            }).then(function(response){
                if(response.status == 'SUCCESS'){
                    if(modelValue.type == 'assets'){
                        $scope.tempEdit = 'editPopUpAssets';
                        $scope.editAssetsData = response.data;
                    }
                    else if(modelValue.type == 'debt'){
                        $scope.tempEdit = 'editPopUpDebt';
                        $scope.editDebtValue = response.data;
                    }
                    
                    $scope.editPopUpSec = true;
                }
                else{
                    Data.toast(response);
                }
            });
        }],
    ];

    $scope.addAssets = function(data){

        Data.post('addAssets', {
            data : data
        }).then(function(response){
            $scope.loadAssets();
            Data.toast(response);
            $('.addNewAssetsForm').parent().removeClass('open');
            $scope.addAssetsData = {};
        });
    };
    $scope.addDebt = function(data){
        Data.post('addDebt', {
            data : data
        }).then(function(response){
            $scope.loadDebt();
            Data.toast(response);
        });
    };
    $scope.assetList = {
        'me':[{
            id:1
        }],
        'me1':[{
            id:1
        }],
        'me2':[{
            id:1
        }]
    };
    $scope.vegetables = ['Corn' ,'Onions' ,'Kale' ,'Arugula' ,'Peas', 'Zucchini'];

    $scope.assetsTypeList = [
        '',
        'Checking Account',
        'Savings Account',
        'Investment Account',
        'Qualified Retirement Account',
        'Non-Qualified retirement account',
        'Personal Item',
        'Vehicle',
        'Property',
        'Pets'
    ];
    $scope.debtTypeList = [
        '',
        'Credit card',
        'Past due child or spousal support',
        'Personal loans',
        'Student loans',
        'Taxes',
        'Property'

    ];

    $scope.models = {
        selected: null,
        listsAssets: {},
        listDebt: {}
    };  
    $scope.total = {
        assetsTotal :'',
        debtTotal : ''
    };

    $scope.loadHaveOwe = function(){
        $scope.loadAssets(); 
        $scope.loadDebt();   
    }
    $scope.loadAssets = function(){
        Data.get('loadAssets').then(function(response){
           // $scope.assetList = response.data;
          $scope.models.listsAssets = response.data;
          $scope.total.assetsTotal = response.total;
          $scope.loadHistory();
        });
    };
    $scope.loadDebt = function(){
        Data.get('loadDebt').then(function(response){
           // $scope.assetList = response.data;
          $scope.models.listDebt = response.data;
          $scope.total.debtTotal = response.total;
          $scope.loadHistory();
        });
    };

    $scope.loadHistory = function(){
        Data.get('loadHistory').then(function(response){
            $scope.history = response.data;
        });
    }
    $scope.dropCallback = function(event, index, item, external, type) {
        return item;
    };
    $scope.dropCallbackDebt = function(event, index, item, external, type) {
        return item;
    };
    $scope.logEvent = function(message, event) {
        Data.post('dragUpdate', {
            type : message,
            data : $scope.models
        }).then(function(response){
            $scope.loadHistory();
            $scope.loadHaveOwe();
        });
        
    };
    $scope.logEventDebt = function(message, event) {
        Data.post('dragUpdate', {
            type : message,
            data : $scope.models
        }).then(function(response){
            $scope.loadHistory();
            $scope.loadHaveOwe();
        });
        
    };
    $scope.$watch('models', function(model) {
    }, true);

    $scope.editPopUpSec = false;
    $scope.editDebtValue = '';
    $scope.edit = function(id, type){
        Data.post('getSingle', {
            id : id,
            type : type
        }).then(function(response){
            if(response.status == 'SUCCESS'){
                
                if(type == 'assets'){
                    $scope.tempEdit = 'editPopUpAssets';
                    $scope.editAssetsData = response.data;
                }
                else if(type == 'debt'){
                    $scope.tempEdit = 'editPopUpDebt';
                    $scope.editDebtValue = response.data;
                }
                
                $scope.editPopUpSec = true;
            }
            else{
                Data.toast(response);
            }
        });
    };
    $scope.editAssets = function(data){
        Data.post('editAssetsUpdate',{
            data : data
        }).then(function(response){
            $scope.loadHaveOwe();
            $scope.editPopUpSec = false; 
        });
    };
    $scope.editDebt = function(data){
        Data.post('editDebtUpdate',{
            data : data
        }).then(function(response){
            $scope.loadHaveOwe();
            $scope.editPopUpSec = false; 
        });
    };
    $scope.editPopUpClose = function(){
       $scope.editPopUpSec = false; 
    };

    $scope.ShowReview = false;
    $scope.complete = function(){
        $scope.ShowReview = true;
    }
    $scope.export = function(type){
        Data.get(type).then(function(){

        });
    };
    
});