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
        'ngScrollbar',
        'dndLists',
        'ui.bootstrap.contextMenu',
        '720kb.datepicker',
        'png.timeinput',
        'ui.bootstrap',
        'ngScrollbar',
        ]);
app.config(['$routeProvider', '$mdDateLocaleProvider',
  function ($routeProvider, $mdDateLocaleProvider) {
        $routeProvider.
        when('/login', {
            title: 'Login',
            templateUrl:BASE_URL+'account/view/',
            controller: 'login'
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
            controller: 'dashboard'
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
        .when('/Deal',{
            templateUrl: BASE_URL+'account/view/deal',
            controller: 'DealCtrl'
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
        .when('/MakeSpend',{
            templateUrl: BASE_URL+'account/view/make_spend',
            controller:'makeSpend'
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
                    var nextUrl = angular.isUndefined(next.$$route) ? '/login' : next.$$route.originalPath;
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
                    if(nextUrl == '/form/:id' || nextUrl == '/HaveOwe' || nextUrl == '/MakeSpend' || nextUrl == '/Deal'){
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
    function ($rootScope, $scope, $window, $compile, $filter, $routeParams, $location, $http, Data, vcRecaptchaService, ContactTypesService, FileUploader, $mdDialog, moment, uiCalendarConfig, GoogleApi) {
    $rootScope.GetContactTypes = ContactTypesService.ContactTypes();
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
    $scope.isloading = false;
    $scope.skipNav = true;
    $scope.displayPop = false;
    $scope.profilePic = '3';
    $scope.noofdayeswithme = 0;
    $scope.noofdayeswithspouse = 0;
    $scope.eventTitle = '';
    $scope.eventTime= '';
    $scope.calendarDate = [{events:[]}];
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
        key: '6Ldt0xgUAAAAAMH5mp_ywrY_u8CkMkJIbQcbiX5F'
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
    $scope.birthDayHoliday = function(data){
        data.push({'date':{'start':['','12:00 AM'], 'end':['','12:00 PM']}});
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
    

    $scope.doLogout = function(){
        $scope.logindisable =true;
        $scope.save();
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
        $scope.eventUpdateFlag = false;
        $scope.showPop = '';
    }
    $scope.deleteEvent = function(eventId){
        if(!angular.isUndefined(eventId)){
            GoogleApi.post('deleteEvent', {
                id : eventId
            }).then(function(response){
                element.hide();
                $scope.showPop = '';
                angular.forEach($scope.calendarDate[0].events, function(value, key){
                    if(value.id == eventId){
                        $scope.calendarDate[0].events.slice(key, 1);
                    }
                })
                $window.location.reload();
                GoogleApi.toast(response);
            });
        }
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
            var start = moment(new Date(data.start));
            var end = moment(new Date(data.end));
            var formatedStart = start.format();
            var formatedEnd = end.add(1, 'days').format();
            // $scope.calendarDate[0].events.push({
            //         "title":data.title, 
            //         "start":formatedStart, 
            //         "end":formatedEnd ,
            //         'backgroundColor' : bg ,
            //         'textColor' : txtColor
            //     });
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
        $window.location.reload();
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
            background: '#f26522',
            
        },
    };
    $scope.createCalendarForm = false;
    $scope.createNewCal = function(){
        $scope.createCalendarForm = true;
    }
    $scope.closeCalFrom = function(){
        $scope.createCalendarForm = false;   
    }

    $scope.createCustomCal = function(calName){
        $scope.calInputError = false;
        if(calName !='' && !angular.isUndefined(calName)){
            $scope.calInputError = false;
            GoogleApi.post('createCustomCal',{
                name : calName
            }).then(function(response){
                $scope.createCalendarForm = false;   
                $scope.loadCalendarList();
            });
        }
        else{
            $scope.calInputError = true;
        }
    }
    $scope.loadGoogleApi = function(){
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
                background: '#f26522',
            },
        };
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
                $scope.uiConfig.calendar.events = [];
                $scope.calenderlist = response.data;
                $scope.tempSelecter = response.data[0].eventType;
               // $scope.calClickFlag = response.data.selected;
               console.log(response.data);
                $scope.loadEvents(response.data[0].id, response.data[0].backgroundColor);    
                angular.forEach(response.data[0], function(value, key) {
                    if(value.selected == 1){
                        $scope.loadEvents(value.id, value.backgroundColor);    
                    }
                    else{
                        $scope.uiConfig.calendar.events = [];
                        $scope.loadingGoogleApi = false;
                    }
                });
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
            console.log(response);
            var me = 0;
            var spouse = 0; 
            //$scope.uiConfig.calendar.events = response;

            $scope.calendarDate.push({'events':response});
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
                $window.location.reload();
            });    
        }
    };
    $scope.clearCal = function(){
        GoogleApi.post('ClearEvents', {
            data : 'yes'
        }).then(function(response){
            if(response.status == 'SUCCESS'){
                $scope.loadGoogleApi();
                $window.location.reload();
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
            $window.location.reload();
        });
       
    }
    $scope.editEV = {};
    $scope.eventUpdateFlag = false;
    $scope.editEventPopUp = function(){
        $scope.eventUpdateFlag = true;
        $scope.editEV.title = $scope.eventTitle;
        $scope.editEV.start = $scope.startDate;
        $scope.editEV.end = $scope.endDate;
    };
    
    $scope.updateEventSingle = function(data){
        GoogleApi.post('updateSingleEvent', {
            id : $scope.eventId,
            data : data
        }).then(function(response){
            GoogleApi.toast(response);
            $window.location.reload();
        });
    }
    $scope.holidayList = {
        'standardholidays':{
            'title': 'Standard Holidays',
            'dynamic':false,
            'list':[
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Martin Luther King Jr Day (Observed)',
                    'date' : {
                        'start':['01/16/17', '12:00 AM'],
                        'end':['01/16/17', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Valentine’s Day',
                    'date' : {
                        'start':['02/14/17', '12:00 AM'],
                        'end':['02/14/17', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'President’s Day (Observed)',
                    'date' : {
                        'start':['02/20/17', '12:00 AM'],
                        'end':['02/20/17', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'St. Patrick’s Day',
                    'date' : {
                        'start':['03/17/17', '12:00 AM'],
                        'end':['03/17/17', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Mother’s Day',
                    'date' : {
                        'start':['05/14/17', '12:00 AM'],
                        'end':['05/14/17', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Memorial Day',
                    'date' : {
                        'start':['05/29/17', '12:00 AM'],
                        'end':['05/29/17', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Father’s Day',
                    'date' : {
                        'start':['06/18/17', '12:00 AM'],
                        'end':['06/18/17', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Independence Day',
                    'date' : {
                        'start':['07/04/17', '12:00 AM'],
                        'end':['07/04/17', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Labor Day',
                    'date' : {
                        'start':['09/04/17', '12:00 AM'],
                        'end':['09/04/17', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Columbus Day',
                    'date' : {
                        'start':['10/09/17', '12:00 AM'],
                        'end':['10/09/17', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Halloween',
                    'date' : {
                        'start':['10/31/17', '12:00 AM'],
                        'end':['10/31/17', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Thanksgiving',
                    'date' : {
                        'start':['11/23/17', '12:00 AM'],
                        'end':['11/23/17', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Veteran’s Day',
                    'date' : {
                        'start':['11/11/17', '12:00 AM'],
                        'end':['11/11/17', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Christmas Eve',
                    'date' : {
                        'start':['12/24/17', '12:00 AM'],
                        'end':['12/24/17', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Christmas Day',
                    'date' : {
                        'start':['12/25/17', '12:00 AM'],
                        'end':['12/25/17', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Christmas Day (Observed)',
                    'date' : {
                        'start':['12/25/17', '12:00 AM'],
                        'end':['12/25/17', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'New Year’s Eve',
                    'date' : {
                        'start':['12/31/17', '12:00 AM'],
                        'end':['12/31/17', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'New Year’s Day',
                    'date' : {
                        'start':['01/01/17', '12:00 AM'],
                        'end':['01/01/17', '12:00 PM'],
                    }
                }
            ]
        },
        'religiousholidays':{
            'title': 'Religious Holidays',
            'dynamic':false,
            'list':[
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Maha Shivaratri',
                    'date' : {
                        'start':['02/24/17', '12:00 AM'],
                        'end':['02/24/17', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Ash Wednesday',
                    'date' : {
                        'start':['03/01/17', '12:00 AM'],
                        'end':['03/01/17', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Purim',
                    'date' : {
                        'start':['03/09/2017', '12:00 AM'],
                        'end':['03/12/2017', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Holi',
                    'date' : '02-25',
                    'date' : {
                        'start':['03/13/2017', '12:00 AM'],
                        'end':['03/13/2017', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Ramanavami',
                    'date' : {
                        'start':['04/05/2017', '12:00 AM'],
                        'end':['04/05/2017', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Passover',
                    'date' : {
                        'start':['04/10/2017', '12:00 AM'],
                        'end':['04/18/2017', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Good Friday',
                    'date' : {
                        'start':['04/14/2017', '12:00 AM'],
                        'end':['04/14/2017', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Easter',
                    'date' : {
                        'start':['04/16/2017', '12:00 AM'],
                        'end':['04/16/2017', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Ramadan',
                    'date' : {
                        'start':['05/26/2017', '12:00 AM'],
                        'end':['05/26/2017', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Eid al-Fitr (End of Ramadan)',
                    'date' : {
                        'start':['06/25/2017', '12:00 AM'],
                        'end':['06/25/2017', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Eid al-Adha',
                    'date' : {
                        'start':['08/31/2017', '12:00 AM'],
                        'end':['08/31/2017', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Muharram (Al Hijrah - New Year) ',
                    'date' : {
                        'start':['09/22/2017', '12:00 AM'],
                        'end':['09/22/2017', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Rosh Hashanah',
                    'date' : {
                        'start':['09/20/2017', '12:00 AM'],
                        'end':['09/20/2017', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Yom Kippur',
                    'date' : {
                        'start':['09/29/2017', '12:00 AM'],
                        'end':['09/29/2017', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Diwali',
                    'date' : {
                        'start':['10/19/2017', '12:00 AM'],
                        'end':['10/19/2017', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Navaratri / Dassehra',
                    'date' : {
                        'start':['09/21/2017', '12:00 AM'],
                        'end':['09/21/2017', '12:00 PM'],
                    }
                },
                {
                    'odd':false,
                    'even':false,
                    'current':false,
                    'text' : 'Hanukkah',
                    'date' : {
                        'start':['12/12/2017', '12:00 AM'],
                        'end':['12/20/2017', '12:00 PM'],
                    }
                }
            ]
        },
        'mybirthday':{
            'title': 'Birthdays',
            'option':false,
            'value':'',
            'text':'Your Birth Day',
            'dynamic':true,
            'list':[
                {
                    'date' : {
                        'start':['','12:00 AM'],
                        'end':['','12:00 PM']
                    }
                },
            ]
        },
    };
    $scope.holidaySortme = true;
    $scope.holidaySortspouse = false;
    $scope.noofholidayswithme = 0;
    $scope.noofholidayswithspouse = 0;
    $scope.alreadyAdded = false;
    $scope.submitHolidy = function(holidayList){
        Data.post('updateHoliday',{
            data : holidayList
        }).then(function(response){
            $scope.alreadyAdded = false;
            $scope.noofholidayswithme = 0;
            $scope.noofholidayswithspouse = 0;
            angular.forEach(holidayList.religiousholidays.list, function(key, value){
                var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
                var firstDate = new Date(key.date.start);
                var secondDate = new Date(key.date.end);
                var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
                if(key.odd == 'Petitioner' || key.even == 'Petitioner' || key.current == 'Petitioner'){
                    $scope.noofholidayswithme += diffDays;
                }
                if(key.odd == 'Respondent' || key.even == 'Respondent' || key.current == 'Respondent'){
                    $scope.noofholidayswithspouse += diffDays;
                }
                $scope.alreadyAdded = true;
            });
            angular.forEach(holidayList.standardholidays.list, function(key, value){
                var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
                var firstDate = new Date(key.date.start);
                var secondDate = new Date(key.date.end);
                var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
                if(key.odd == 'Petitioner' || key.even == 'Petitioner' || key.current == 'Petitioner'){
                    $scope.noofholidayswithme += diffDays;
                }
                if(key.odd == 'Respondent' || key.even == 'Respondent' || key.current == 'Respondent'){
                    $scope.noofholidayswithspouse += diffDays;
                }
                $scope.alreadyAdded = true;
            });
            //$scope.addHoliday = false;
            $("body, html").css('overflow','auto');
        //$scope.PopUpTemp = 'holidayPop';
            $scope.openPopUp = false;
        });
    };
    $scope.addHoliday = false;
    $scope.initHolidayList = function(){
        Data.get('getHolidays').then(function(response){
            if(angular.isUndefined(response.status)){
                $scope.holidayList = response;
                $scope.noofholidayswithme = 0;
                $scope.noofholidayswithspouse = 0;
                angular.forEach($scope.holidayList.religiousholidays.list, function(key, value){
                    var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
                    var firstDate = new Date(key.date.start);
                    var secondDate = new Date(key.date.end);
                    var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
                    if(key.odd == 'Petitioner' || key.even == 'Petitioner' || key.current == 'Petitioner'){
                        $scope.noofholidayswithme += diffDays;
                    }
                    if(key.odd == 'Respondent' || key.even == 'Respondent' || key.current == 'Respondent'){
                        $scope.noofholidayswithspouse += diffDays;
                    }
                });
                angular.forEach($scope.holidayList.standardholidays.list, function(key, value){
                    var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
                    var firstDate = new Date(key.date.start);
                    var secondDate = new Date(key.date.end);
                    var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
                    if(key.odd == 'Petitioner' || key.even == 'Petitioner' || key.current == 'Petitioner'){
                        $scope.noofholidayswithme += diffDays;
                    }
                    if(key.odd == 'Respondent' || key.even == 'Respondent' || key.current == 'Respondent'){
                        $scope.noofholidayswithspouse += diffDays;
                    }
                });
                $scope.alreadyAdded = true;
            }
            else{
                $scope.alreadyAdded = false;
            }
        });
    }
    $scope.openPopUp = false;
    $scope.PopUpShow = function(temp){
        $scope.openPopUp = true;
        $("body, html").css('overflow','hidden');
        $scope.PopUpTemp = temp;
    }
    $scope.PopUpHide = function(){
        $scope.openPopUp = false;
        $("body, html").css('overflow','auto');
        $scope.PopUpTemp = 'holidayPop';
    }
    $scope.openPopUp2 = false;
    $scope.PopUpHide2 = function(){
        $scope.openPopUp2 = false;
        $("body, html").css('overflow','auto');
        $scope.PopUpTemp2 = 'holidayPop';
        $location.path('dashboard');
    }
    $scope.holidaysPopupClose = function(){
        $scope.addHoliday = false;
    }

    

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
          //  $scope.error = 'please validate captcha';
            //return;
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
            icon:'static/img/icons/progressBar/basic.png',
            color: '#25b7d3',
            url : '#/form/basic',
            status:'incomplete',
            inner:[
                {
                    id:'1',
                    status:'incomplete',
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
                    status:'incomplete',
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
                    status:'incomplete',
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
            icon:'static/img/icons/progressBar/kids.png',
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
            icon:'static/img/icons/progressBar/haveOwe.png',
            color: '#f8bc3c',
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
            icon:'static/img/icons/progressBar/makeSpend.png',
            color: '#52b74a',
            url : '#/MakeSpend',
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
            icon:'static/img/icons/progressBar/deal.png',
            color: '#9f6aac',
            url : '#/MakeSpend',
            status:'incomplete',
            inner:[
            ]
        },
    ];
    $scope.bookmark ={
        forms:{
            basic : {
                    currentStep : '',
                    completedPercent : '',
                    i:0,
                    j:0,
                    k:0
                },
            kids : {
                    currentStep : '',
                    completedPercent : '',
                    i:1,
                    j:0,
                    k:0  
                }
            },
        basic: 'incomplete',
        kids: 'incomplete',
    };
    $scope.calendarSchedule = false;
    $scope.loadUserData = function(){
        $scope.isloading = true;
        Data.get('loadFromData').then(function(response){
            if(response.data.bookmark != null){
                $scope.first_step[0].status = (angular.isUndefined(response.data.bookmark.basic) || response.data.bookmark.basic == '') ? 'incomplete' : response.data.bookmark.basic;
                $scope.first_step[1].status = (angular.isUndefined(response.data.bookmark.kids) || response.data.bookmark.kids == '') ? 'incomplete' : response.data.bookmark.kids;
                $scope.first_step[2].status = (angular.isUndefined(response.data.bookmark.haveOwe) || response.data.bookmark.haveOwe == '') ? 'incomplete' : response.data.bookmark.haveOwe;
                $scope.first_step[3].status = (angular.isUndefined(response.data.bookmark.makeSpend) || response.data.bookmark.makeSpend == '') ? 'incomplete' : response.data.bookmark.makeSpend;
                $scope.bookmark = response.data.bookmark;
                if(angular.isUndefined(response.data.bookmark.forms) || !response.data.bookmark.forms){
                    if($routeParams.id == 'kids'){
                        $scope.i = 1;
                        $scope.j = 0;
                        $scope.k = 0;
                    }
                    if($routeParams.id == 'basic'){
                        $scope.i = 0;
                        $scope.j = 0;
                        $scope.k = 0;
                    }
                }
                else{
                    if($routeParams.id == 'calendar'){
                        $scope.calendarSchedule = true;
                        $scope.i = 1;
                        $scope.j = 1;
                        $scope.k = 1;
                        if(response.data.bookmark.kids == 'completed'){
                            $scope.isCompleted = true;

                        for(var i=0; i<3; i++){
                            $scope.first_step[$scope.i].inner[i].status = 'completed';
                        }
                        }
                        else{
                            $scope.isCompleted = false;
                            for(var i=0; i<$scope.j; i++){
                                $scope.first_step[$scope.i].inner[i].status = 'completed';
                            }
                        }
                        $scope.percent_t = ($scope.k/$scope.first_step[$scope.i].inner[$scope.j].forms.length)*100;  
                    }  
                    if($routeParams.id == 'kids'){
                        $scope.i = 1;
                        $scope.bookmark = response.data.bookmark;
                        $scope.j = response.data.bookmark.forms.kids.j;
                        if(response.data.bookmark.kids == 'completed'){
                            $scope.j = 3;
                        }
                        for(var i=0; i<$scope.j; i++){
                            $scope.first_step[$scope.i].inner[i].status = 'completed';
                        }
                        $scope.k = response.data.bookmark.forms.kids.k;
                        if(!angular.isUndefined($scope.first_step[$scope.i].inner[$scope.j])){
                            $scope.percent_t = ($scope.k/$scope.first_step[$scope.i].inner[$scope.j].forms.length)*100;  
                        }
                    }  
                    if($routeParams.id == 'basic'){
                        $scope.i = 0;
                        $scope.bookmark = response.data.bookmark;
                        $scope.j = angular.isUndefined(response.data.bookmark.forms.basic.j) ? 0 : response.data.bookmark.forms.basic.j;
                        if(response.data.bookmark.basic == 'completed'){
                            $scope.j = 3;
                        }
                        for(var i=0; i<$scope.j; i++){
                            $scope.first_step[$scope.i].inner[i].status = 'completed';
                        }
                        if(!angular.isUndefined($scope.first_step[$scope.i].inner[$scope.j])){
                            $scope.first_step[$scope.i].inner[$scope.j].status = 'started';
                        }
                        $scope.k = response.data.bookmark.forms.basic.k;
                        if(!angular.isUndefined($scope.first_step[$scope.i].inner[$scope.j])){
                            $scope.percent_t = ($scope.k/$scope.first_step[$scope.i].inner[$scope.j].forms.length)*100;  
                        }
                    }
                        
                }
            }
            $scope.data = response.data;
            if(!angular.isUndefined($scope.first_step[$scope.i].inner[$scope.j])){
                $scope.currentStep = $scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id;
                $scope.first_step[$scope.i].status = 'Started';
            }
            else{
                if($scope.i == 0){
                    $scope.skipNav = false;
                    $scope.currentStep = 'basic_info_review';
                }
                else{
                    $scope.skipNav = false;
                    $scope.currentStep = 'kidsReview';
                }
            }
            $scope.form_icon_color = $scope.first_step[$scope.i].color;
            $scope.isloading = false;
        });
    
    };
    //$scope.k = 1;
   // $scope.loadUserData($scope.formPosition);
    $scope.basicBM = {
        'myinfo':'',
        'spouseinfo':'',
        'ourprofile':''
    }
    $scope.continue = function(){
        $scope.conterror=false;
        $scope.skipNav = true;
    //    $scope.save($scope.data);
        //$( "label:has(input:checked)" ).addClass( "checklabel" );
        if($scope.i <= $scope.first_step.length){
            $scope.form_icon_color[$scope.i] = $scope.first_step[$scope.i].color;
            if($scope.j < $scope.first_step[$scope.i].inner.length ){
                $scope.k++;
                if($scope.k < $scope.first_step[$scope.i].inner[$scope.j].forms.length){
                    $scope.first_step[$scope.i].inner[$scope.j].status = 'started';
                    $scope.ValidateStep($scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id);
                    if(!angular.isUndefined($scope.first_step[$scope.i].inner[$scope.j])){
                        $scope.percent_t = ($scope.k/$scope.first_step[$scope.i].inner[$scope.j].forms.length)*100;  
                        if($scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id == 'Shedule2'){
                            $location.path('/form/calendar');
                        }
                        else{
                            $scope.currentStep = $scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id;    
                        }
                    }
                    else{
                        $scope.continue(); 
                    }
                }
                else{
                    $scope.k=0;
                    $scope.first_step[$scope.i].inner[$scope.j].status = 'completed';
                    $scope.j++;
                    if(!angular.isUndefined($scope.first_step[$scope.i].inner[$scope.j])){
                        $scope.percent_t = ($scope.k/$scope.first_step[$scope.i].inner[$scope.j].forms.length)*100;  
                        $scope.currentStep = $scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id;  
                    }
                    else{
                        $scope.continue(); 
                    }
                }
                if($scope.i == 0){
                    $scope.bookmark.forms.basic.j = $scope.j;
                    $scope.bookmark.forms.basic.k = $scope.k;
                }
                if($scope.i == 1){
                    $scope.bookmark.forms.kids.j = $scope.j;
                    $scope.bookmark.forms.kids.k = $scope.k;
                }
            }
            else{
                $scope.first_step[$scope.i].status = 'completed';
                if($scope.i == 0){
                    $scope.skipNav = false;
                    $scope.bookmark.forms.basic.j = $scope.j;
                    $scope.bookmark.forms.basic.k = $scope.k;
                    $scope.bookmark.basic = 'completed';
                    $scope.currentStep = 'basic_info_review';
                }
                else if($scope.i == 1){
                    $scope.skipNav = false;
                    $scope.bookmark.forms.kids.j = $scope.j;
                    $scope.bookmark.forms.kids.k = $scope.k;
                    $scope.bookmark.kids = 'completed';
                    $scope.currentStep = 'kidsReview';
                }
                $scope.j=0;
                $scope.k=0;
            }
        }
        else{

        }
        $scope.save($scope.data);
        $scope.updateBookmark($scope.bookmark);
    };
    $scope.calendarContinue = function(){
        $scope.bookmark.forms.kids.j = $scope.j+1;
        $scope.bookmark.forms.kids.k = 0;
        $scope.updateBookmark($scope.bookmark);
        $location.path('form/kids');
    }
    $scope.backToReview2 = function(){
        $location.path('form/kids');   
    }
    $scope.continue2 = function(){
        $scope.conterror=true;
    }
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
                    $scope.ValidateStep2($scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id);
                    $scope.currentStep = $scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id;    
                }
                else{
                    if($scope.j > 0){
                        $scope.j--;
                        $scope.k = $scope.first_step[$scope.i].inner[$scope.j].forms.length-1;
                        if($scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id == 'Shedule2'){
                            $location.path('/form/calendar');
                        }
                        else{
                            $scope.currentStep = $scope.first_step[$scope.i].inner[$scope.j].forms[$scope.k].id;    
                        }
                    }
                }
            }
            else{
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
                $scope.k = $scope.k+1;
             //   $scope.continue();
            }
        }
    };
    $scope.ValidateStep2 = function(stepId){
        if(stepId == 'Custody5'){
            if($scope.data.kidsRelation != null && $scope.data.kidsRelation.legalCustody == 'Y'){
                $scope.k--;
            }
        }
        if(stepId == 'Custody7'){
            if($scope.data.kidsRelation != null && $scope.data.kidsRelation.physicalCustody == 'Y'){
                $scope.k--;
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
                $scope.k--;
            }
        }
        if(stepId == 'FinalDetails4'){
            if($scope.data.kidsRelation != null && $scope.data.kidsRelation.kidsLegalissue == 'N'){
                $scope.k--;
            }
        }
        if(stepId == 'FinalDetails6'){
            if($scope.data.kidsRelation != null && $scope.data.kidsRelation.protective == 'N'){
                $scope.k--;
            }
        }
        if(stepId == 'FinalDetails8'){
            if($scope.data.kidsRelation != null && $scope.data.kidsRelation.legalClaims == 'N'){
                $scope.k = $scope.k-1;
             //   $scope.continue();
            }
        }
    }
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
        $scope.isloading = true;
        Data.post('save',{
            data : data
        }).then(function (results){
          //  $scope.data = results.data;
          //  Data.toast(results);
          $scope.loadUserData();

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
    $scope.enableBackToReview = false;
    $scope.reviewEdit = function(j, k){
        $scope.enableBackToReview = true;
        $scope.currentStep = $scope.first_step[$scope.i].inner[j].forms[k].id;
        //$scope.skipNav = true;
        
        if($scope.i == 0){
            $scope.BackToReviewValue = 'basic_info_review';
        }
        else if($scope.i == 1){
            $scope.BackToReviewValue = 'kidsReview';
        }
    }
    $scope.backToReview = function(){
        $scope.save($scope.data);
        $scope.enableBackToReview = false;
        $scope.currentStep = $scope.BackToReviewValue;
    }
    $scope.showInviteForm = false;
    $scope.invited = false;
    $scope.initInvite = function(){
        Data.get('initInvite').then(function(response){
            if(response.result){
                $scope.invited = true;
            }
        });
    }
    $scope.errorMsg = '';
    $scope.invite = function(){
        if($scope.showInviteForm){
            $scope.showInviteForm = false;
        }
        else{
            $scope.showInviteForm = true;    
        }
    }
    $scope.submitInvite = function(email){
        var regexp = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if(angular.isUndefined(email) || email == '')
        {
            $scope.errorMsg = 'Email is required';    
        }
        else if(!regexp.test(email)){
            $scope.errorMsg = 'Enter correct email format';
        }
        else{
            Data.post('invite', {
                email: email
            }).then(function(response){
                Data.toast(response);
                if(response.status=="SUCCESS"){
                    $scope.showInviteForm = false;
                    $scope.invited = true;
                }
            })
        }
    }
    $scope.afterKidsComplete = function(){
        $scope.openPopUp2 = true;
        $("body, html").css('overflow','hidden');
        $scope.PopUpTemp2 = 'afterKidPopup';
    }
    $scope.generateForms = function(){
        $window.location.href = 'http://yourdemo.site/app/api/gov';
    }
    $scope.skipgenerateForm = function(){

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
app.filter('strLimit', ['$filter', function($filter) {
   return function(input, limit) {
     if (! input) return;
     if (input.length <= limit) {
          return input;
      }
    
      return $filter('limitTo')(input, limit) + '...';
   };
}]);



String.prototype.splice = function(idx, rem, s) {
    return (this.slice(0, idx) + s + this.slice(idx + Math.abs(rem)));
};

app.directive('currencyInput', function() {
    return {
        restrict: 'A',
        scope: {
            field: '='
        },
        replace: true,
        template: '<span><input type="text" ng-model="field"></input></span>',
        link: function(scope, element, attrs) {

            $(element).bind('keyup', function(e) {
                var input = element.find('input');
                var inputVal = input.val();

                //clearing left side zeros
                while (scope.field.charAt(0) == '0') {
                    scope.field = scope.field.substr(1);
                }

                scope.field = scope.field.replace(/[^\d.\',']/g, '');

                var point = scope.field.indexOf(".");
                if (point >= 0) {
                    scope.field = scope.field.slice(0, point + 3);
                }

                var decimalSplit = scope.field.split(".");
                var intPart = decimalSplit[0];
                var decPart = decimalSplit[1];
                intPart = intPart.replace(/[^\d]/g, '');
                if (intPart.length > 3) {
                    var intDiv = Math.floor(intPart.length / 3);
                    while (intDiv > 0) {
                        var lastComma = intPart.indexOf(",");
                        if (lastComma < 0) {
                            lastComma = intPart.length;
                        }

                        if (lastComma - 3 > 0) {
                            intPart = intPart.splice(lastComma - 3, 0, ",");
                        }
                        intDiv--;
                    }
                }

                if (decPart === undefined) {
                    decPart = "";
                }
                else {
                    decPart = "." + decPart;
                }
                var res = '$' + intPart + decPart;

                scope.$apply(function() {scope.field = res});

            });

        }
    };
});

app.directive('customSelect', function(){
    return{
        restrict:'A',
        require: 'ngModel',
        link:function(scope, el, atr, ctrl){
            var id = el[0];
            id.style.display="none";
            //ctrl.$setViewValue(ctrl.$modelValue);
            ctrl.$valid = false;
            ctrl.$render();
            Element.prototype.appendAfter = function (element) {
                element.parentNode.insertBefore(this, element.nextSibling);
            }, false;

            Element.prototype.addClass = function(element){
                this.classList.add(element);
            };
            Element.prototype.removeClass = function(element){
                this.classList.remove(element);
            };
            Element.prototype.hasClass = function(className){
                return this.classList.contains(className);
            }
            var custom = document.createElement('div')
            custom.addClass('select');

            var div = document.createElement('div');
            div.addClass('select-styled');
            var spanVal = document.createElement('span');
            var imgVal = document.createElement('img');
            scope.$watch(atr.ngModel, function(newVal){
               // if new value is not null do your all computation
               if(newVal != null && newVal.length > 0 ){
                    spanVal.innerHTML = id.options[newVal].text;
                    imgVal.src = id.options[newVal].getAttribute('src');    
               }
               else{
                    spanVal.innerHTML = id.options[0].text;
                    imgVal.style.display = 'none';
                   // imgVal.src = id.options[0].getAttribute('src');    
               }
            });

            
            var ul = document.createElement('ul');
            ul.addClass('select-options');
            div.addEventListener('click', function(event){
                if(!ul.hasClass('active-select')){
                    ul.addClass('active-select');  
                    div.addClass('isOpen');
                }
                else{
                    ul.removeClass('active-select');
                    div.removeClass('isOpen');
                }
                event.stopPropagation();
            });

             for(var i=1; i<id.length; i++){
                var li = document.createElement('li');
                var img = document.createElement('img');
                var span = document.createElement('span');
                span.innerHTML = id.options[i].text;
                li.setAttribute('rel', id.options[i].value);
                if(id.options[i].getAttribute('src') != null || id.options[i].getAttribute('src') != 'undefined'){
                    img.src = id.options[i].getAttribute('src');
                }
                li.addEventListener('click',function(e){
                    console.log(this);
                    spanVal.innerHTML = this.children[1].innerHTML;
                    imgVal.src = this.children[0].src;
                    imgVal.style.display = 'block';
                    ctrl.$setViewValue(this.getAttribute('rel'));
                    ctrl.$render();
                    ul.removeClass('active-select');
                    div.removeClass('isOpen');
                });
                li.appendChild(img);
                li.appendChild(span);
                ul.appendChild(li);
            }
            div.appendChild(imgVal);        
            div.appendChild(spanVal);
            custom.appendChild(div);
            custom.appendChild(ul);
            
            custom.appendAfter(id);
            
            document.body.addEventListener('click', function(){
                ul.removeClass('active-select');
                div.removeClass('isOpen');
            });
        }
    }
});

app.controller('login', function($scope, Data, $location){
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

});
app.controller('dashboard', function($scope, $location, Data){
    $scope.panesA = [
        {
          id: 'pane-1a',
          header: 'Basic Info',
          status: 0,
          text: 'static/img/nl/step_process.png',
          url: 'form/basic',
          content:[
            {
                id:'pane-1a-1',
                title : 'My Info',
                icon : 'static/img/icons/dashboard/basic/my_info.png',
                status : 'incomplete',
                color : '#25b7d3'
            },
            {
                id:'pane-1a-2',
                title : 'Spouse\'s Info',
                icon : 'static/img/icons/dashboard/basic/spouse_info.png',
                status : 'incomplete',
                color : '#fabc3d'
            },
            {
                id:'pane-1a-3',
                title : 'Our Profile',
                icon : 'static/img/icons/dashboard/basic/our_profile.png',
                status : 'incomplete',
                color : '#24b23b'
            }
          ],
          isExpanded: true
        },
        {
          id: 'pane-2a',
          header: 'Kids',
          status: 0,
          text: 'static/img/nl/step_process.png',
          url: 'form/kids',
          content:[
            {
                id:'pane-1a-1',
                title : 'Custody & Visitation',
                icon : 'static/img/icons/dashboard/kids/custody.png',
                status : 'incomplete',
                color : '#32bea6'
            },
            {
                id:'pane-1a-2',
                title : 'Child Support',
                icon : 'static/img/icons/dashboard/kids/child_support.png',
                status : 'incomplete',
                color : '#b665e5'
            },
            {
                id:'pane-1a-3',
                title : 'Final Details',
                icon : 'static/img/icons/dashboard/kids/final_details.png',
                status : 'incomplete',
                color : '#e04f5f'
            }
          ],
        },
        {
          id: 'pane-3a',
          header: 'Have/Owe',
          status: 0,
          text: 'static/img/nl/step_process.png',
          url: 'HaveOwe',
          content:[
            {
                id:'pane-1a-1',
                title : 'Add Asset / Debt',
                icon : 'static/img/icons/dashboard/haveOwe/US.png',
                status : 'incomplete',
                color : '#fabc3d'
            },
            {
                id:'pane-1a-2',
                title : 'Review',
                icon : 'static/img/icons/dashboard/haveOwe/review.png',
                status : 'incomplete',
                color : '#24b23b'
            }
          ],
        },
        {
          id: 'pane-4a',
          header: 'Make/ Spend',
          status: 0,
          text: 'static/img/nl/step_process.png',
          url: 'MakeSpend',
          content:[
            {
                id:'pane-1a-1',
                title:'Job',
                icon:'static/img/icons/dashboard/makeSpend/1.png',
                status:'incomplete',
                color:'#df4f5f'
            },
            {
                id:'pane-1a-2',
                title : 'Income/Expense',
                icon : 'static/img/icons/dashboard/makeSpend/2.png',
                status : 'incomplete',
                color : '#24b7d2'
            },
            {
                id:'pane-1a-3',
                title : 'Review',
                icon : 'static/img/icons/dashboard/makeSpend/3.png',
                status : 'incomplete',
                color : '#8f56c8'
            }
          ],
        },
        {
          id: 'pane-5a',
          header: 'The Deal',
          status: 0,
          text: 'static/img/nl/step_process.png',
          url: 'Deal',
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

    $scope.basic = {j:[4,3,5]};
    $scope.kids = {j:[8,2,8]};
    $scope.initProcess = function(){
        Data.get('loadFromData').then(function(response){
           if(response.data.bookmark.basic == 'completed'){
                for(var a=0; a<$scope.basic.j.length; a++){
                    $scope.panesA[0].content[a].status = 'completed';
                }
                $scope.panesA[0].status = 100;    
            }
            else{
                var j = angular.isUndefined(response.data.bookmark.forms.basic) ? 0 : response.data.bookmark.forms.basic.j;
                var k = angular.isUndefined(response.data.bookmark.forms.basic) ? 0 : response.data.bookmark.forms.basic.k;
                for(var a=0; a<j; a++){
                    $scope.panesA[0].content[a].status = 'completed';
                }
                $scope.panesA[0].status = (j/$scope.basic.j.length)*100 + ((k/$scope.basic.j[j])*100)/$scope.basic.j.length;
            }

            if(response.data.bookmark.kids == 'completed'){
                for(var a=0; a<$scope.basic.j.length; a++){
                    $scope.panesA[1].content[a].status = 'completed';
                }
                $scope.panesA[1].status = 100;
            }
            else{
                var j = angular.isUndefined(response.data.bookmark.forms.kids) ? 0 : response.data.bookmark.forms.kids.j;
                var k = angular.isUndefined(response.data.bookmark.forms.kids) ? 0 : response.data.bookmark.forms.kids.k;
                for(var a=0; a<j; a++){
                    $scope.panesA[1].content[a].status = 'completed';
                }
                $scope.panesA[1].status = (j/$scope.kids.j.length)*100 + ((k/$scope.kids.j[j])*100)/$scope.kids.j.length;    
            }
            if(response.data.bookmark.haveOwe == 'completed'){
                for(var a=0; a<2; a++){
                    $scope.panesA[2].content[a].status = 'completed';
                }
                $scope.panesA[2].status = 100;
            }
            else{
                Data.get('loadAssets').then(function(response){
                    angular.forEach(response.data, function(val, key){
                        if(val.length){
                            $scope.panesA[2].status = 50;
                            $scope.panesA[2].content[0].status = 'completed';
                        }
                    });
                });
                Data.get('loadDebt').then(function(response){
                    angular.forEach(response.data, function(val, key){
                        if(val.length){
                            $scope.panesA[2].status = 50;
                            $scope.panesA[2].content[0].status = 'completed';
                        }
                    });
                });
            }
            if(response.data.bookmark.makeSpend == 'completed'){
                for(var a=0; a<2; a++){
                    $scope.panesA[3].content[a].status = 'completed';
                }
                $scope.panesA[3].status = 100;
            }
            else{
                Data.get('loadCurrentJob').then(function(response){
                    if(response.result){
                        $scope.panesA[3].status = 25;
                        $scope.panesA[3].content[0].status = 'completed';
                    }
                });
                Data.get('loadData').then(function(response){
                    angular.forEach(response.data, function(val, key){
                        angular.forEach(val, function(val2, key2){
                            if(val2.length){
                                $scope.panesA[3].status = 50;
                                $scope.panesA[3].content[1].status = 'completed';
                            }
                        });
                    });
                });
            }
        }, function(pr){
            angular.forEach($scope.panesA, function(val, key){
            //    console.log(val.status);
            });
        });

        
            
        

        
    };
    $scope.overlayEnable = false;
    $scope.overlayShow = function(){
        for(var a=0; a<$scope.panesA.length; a++){
            $scope.panesA[a].isExpanded = false;    
        }
        $('v-accordion').css('margin-bottom',0);
        $scope.overlayEnable = true;
    }
    $scope.closeOverlay = function(){
        $scope.panesA[0].isExpanded = true;
        $scope.overlayEnable = false;
    };
    $scope.viewForm = function($page){
       $location.path($page);
    };
});

app.controller('haveOwe', function($scope, uiSelect2Config, Data, $window){
    $scope.isloading = false;
    $scope.assetsnewshow = false;
    $scope.debtnewshow = false;
    $scope.addAssetsValidate = false;
    $scope.addDebtValidate = false;
    $scope.addNewToggle = function(id){
        $scope.addAssetsValidate = false;
        $scope.addDebtValidate = false;
        if(id == 'assets'){
            $scope.assetsnewshow = !$scope.assetsnewshow;
        }
        else if(id == 'debt'){
            $scope.debtnewshow = !$scope.debtnewshow;
        }
    }
    $scope.addNewClose = function(id){
        if(id == 'assets'){
            $scope.assetsnewshow = false;
        }
        else if(id == 'debt'){
            $scope.debtnewshow = false;
        }
    }
    $scope.addForm = function($event){
        if($scope.showAddForm){
            $scope.showAddForm = false;
        }
        else{
            $scope.showAddForm = true;
        }
     //   $event.stopPropagation();
    }
    $window.onclick = function(){
        if($scope.showAddForm){
            $scope.showAddForm = false;
        }
    }
    $scope.validateAddAssets = function(){
        $scope.addAssetsValidate = true;
    }
    $scope.validateAddDebt = function(){
        $scope.addDebtValidate = true;
    }
    $scope.overlayEnable = true;
    $scope.closeOverlay = function(){
        $scope.overlayEnable = false;
    };
    $scope.history = [];
    $scope.openPopUp = false;
    $scope.PopUpShow = function(temp){
        $scope.openPopUp = true;
        $("body, html").css('overflow','hidden');
        $scope.PopUpTemp = temp;
    }
    $scope.PopUpHide = function(){
        $scope.openPopUp = false;
        $("body, html").css('overflow','auto');
        $scope.PopUpTemp = 'holidayPop';
    }

    $scope.dalete = function(type, id){
        Data.post('delete',{
            type: type,
            id: id
        }).then(function(response){
            Data.toast(response);
            $scope.loadAssets();
            $scope.loadDebt();
        });
    }
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
                        $scope.PopUpShow('editPopUpAssets');
                        //$scope.tempEdit = 'editPopUpDebt';
                        $scope.editAssetsData = response.data;
                    }
                    else if(modelValue.type == 'debt'){
                        $scope.PopUpShow('editPopUpDebt');
                       // $scope.tempEdit = 'editPopUpDebt';
                        $scope.editDebtValue = response.data;
                    }
                    
                  //  $scope.editPopUpSec = true;
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
            $scope.addAssetsValidate = false;
            Data.toast(response);
            $scope.addNewClose('assets');
        });
    };
    $scope.addDebt = function(data){
        Data.post('addDebt', {
            data : data
        }).then(function(response){
            $scope.loadDebt();
            Data.toast(response);
            $scope.addNewClose('debt');
        });
    };
    
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
        $scope.isloading = true;
        $scope.loadAssets(); 
        $scope.loadDebt();   
        Data.get('loadFromData').then(function(response){
            if(response.data.bookmark.haveOwe == 'completed'){
                $scope.ShowReview = true;
                $scope.closeOverlay();
            }
            $scope.isloading = false;
        });
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
                    //$scope.PopUpTemp = 'editPopUpAssets';
                    $scope.PopUpShow('editPopUpAssets');
                    $scope.editAssetsData = response.data;
                }
                else if(type == 'debt'){
                    $scope.PopUpShow('editPopUpDebt');
                    //$scope.tempEdit = 'editPopUpDebt';
                    $scope.editDebtValue = response.data;
                }
                
               // $scope.editPopUpSec = true;
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
            $scope.PopUpHide();
        });
    };
    $scope.editDebt = function(data){
        Data.post('editDebtUpdate',{
            data : data
        }).then(function(response){
            $scope.loadHaveOwe();
            $scope.editPopUpSec = false; 
            $scope.PopUpHide();
        });
    };
    $scope.editPopUpClose = function(){
       $scope.editPopUpSec = false; 
    };
    
    $scope.ShowReview = false;
    $scope.complete = function(){
        $scope.ShowReview = true;
        Data.post('updateBookmark', {
            data : {haveOwe:'completed'}
        }).then(function(response){

        });
    }
    $scope.gobackHaveOwe = function(){
        Data.post('updateBookmark', {
            data : {haveOwe:'incomplete'}
        }).then(function(response){

        });
        $scope.ShowReview = false;
    }
});

app.controller('makeSpend', function($scope, Data){
    $scope.isloading = false;
    $scope.incomenewshow = false;
    $scope.expensenewshow = false;
    $scope.who;
    $scope.saveCurrentJoberror = false;
    $scope.addIncomeValidate = false;
    $scope.addExpenseValidate = false;
    $scope.addNewToggle = function(id, who){
        $scope.addIncomeValidate = false;
        $scope.addExpenseValidate = false;
        if(id == 'income'){
            $scope.who = who;
            $scope.incomenewshow = !$scope.incomenewshow;
        }
        else if(id == 'expense'){
            $scope.who = who;
            $scope.expensenewshow = !$scope.expensenewshow;
        }
    }
    $scope.addNewClose = function(id){
        if(id == 'income'){
            $scope.incomenewshow = false;
        }
        else if(id == 'expense'){
            $scope.expensenewshow = false;
        }
    }
    
    $scope.validateAddIncome = function(){
        $scope.addIncomeValidate = true;
    }
    
    $scope.validateAddExpense = function(){
        $scope.addExpenseValidate = true;
    }
    
    $scope.invalid = function(){
        $scope.saveCurrentJoberror = true;
    }
    $scope.overlayEnable = false;
    $scope.closeOverlay = function(){
        $scope.overlayEnable = false;
    };
    $scope.formHide = false;
    $scope.saveCurrentJob = function(data){
        Data.post('saveCurrentJob',{
            data : data
        }).then(function(response){
            Data.toast(response);
            $scope.overlayEnable = true;
            $scope.formHide = true;

        });
    };

    $scope.loadCurrentJob = function(){
        $scope.isloading = true;
        Data.get('loadCurrentJob').then(function(response){
            if(response.result){
                $scope.overlayEnable = true;
                $scope.formHide = true;
            }
            $scope.isloading = false;
        });
    }
    $scope.history = [];
    $scope.incomeTypeList = [
        {},
        {
            'title':'Salary or wages',
            'subtitle':'gross, before taxes'
        },
        {
            'title':'Overtime',
            'subtitle':'gross, before taxes'
        },
        {
            'title':'Commissions or bonus',
            'subtitle':''
        },
        {
            'title':'Public assistance',
            'subtitle':'for example: TANF,SSI,GA/GR'
        },
        {
            'title':'Spousal support',
            'subtitle':'from different marriage'
        },
        {
            'title':'Pension/retirement fund payments',
            'subtitle':''
        },
        {
            'title':'Social security retirement',
            'subtitle':'not SSI'
        },
        {
            'title':'Disability',
            'subtitle':''
        },
        {
            'title':'Unemployment compensation',
            'subtitle':''
        },
        {
            'title':'Workers\' compensation',
            'subtitle':''
        },
        {
            'title':'Other',
            'subtitle':'military BAQ, royalty payments, etc.'
        },
        {
            'title':'Self-employment',
            'subtitle':''
        },
    ];
    $scope.expenseTypeList = [
        {},
        {
            'title':'Auto',
            'subtitle':''
        },
        {
            'title':'Charitable contributions',
            'subtitle':''
        },
        {
            'title':'Child care',
            'subtitle':''
        },
        {   
            'title':'Clothes',
            'subtitle':''
        },
        {
            'title':'Education',
            'subtitle':''
        },
        {
            'title':'Groceries/household',
            'subtitle':'not SSI'
        },
        {
            'title':'Home',
            'subtitle':''
        },
        {
            'title':'Health-care cost not paid insurance',
            'subtitle':''
        },
        {
            'title':'Homeowner\'s insurance',
            'subtitle':''
        },
        {
            'title':'Installment payments',
            'subtitle':''
        },
        {
            'title':'Insurance',
            'subtitle':''
        },
        {
            'title':'Laundry/cleaning',
            'subtitle':''
        },
        {
            'title':'Maintenance and Repair',
            'subtitle':''
        },
        {
            'title':'Other',
            'subtitle':''
        },
        {
            'title':'Property taxes',
            'subtitle':''
        },
        {
            'title':'Recreational',
            'subtitle':''
        },
        {
            'title':'Savings/investment',
            'subtitle':''
        },
        {
            'title':'Telephone',
            'subtitle':''
        },
        {
            'title':'Utilities',
            'subtitle':''
        },
    ];
    $scope.delete = function(type, id){
        Data.post('delete',{
            type: type,
            id: id
        }).then(function(response){
            Data.toast(response);
            $scope.loadData();
        });
    }
    $scope.menuOptions = [
        ['Delete', function ($itemScope, event, modelValue) {
            Data.post('delete',{
                type: modelValue.type,
                id: modelValue.id
            }).then(function(response){
                Data.toast(response);
                $scope.loadData();
            });
        }],
        ['Edit', function ($itemScope, event, modelValue) {
            $scope.edit(modelValue.id, modelValue.type)
            
        }],
    ];
    $scope.models = {
        selected: null,
        listsIncome: {},
        listExpense: {}
    };  
    $scope.total = {
        incomeTotal :'',
        expenseTotal : ''
    };
    $scope.loadData = function(){
        Data.get('loadData').then(function(response){
            $scope.models.listsIncome = response.data.income;
            $scope.models.listExpense = response.data.expense;
            $scope.total.incomeTotal = response.total.income;
            $scope.total.expenseTotal = response.total.expense;
            $scope.loadHistory();
            Data.get('loadFromData').then(function(response){
                if(response.data.bookmark.makeSpend == 'completed'){
                    $scope.ShowReview = true;
                    $scope.closeOverlay();
                }
                $scope.isloading = false;
            });
        });
    };
    $scope.loadHistory = function(){
        Data.get('loadHistoryMS').then(function(response){
            $scope.history = response.data;
        });
    };
    $scope.addIncome = function(data){
        data.incomeBelongto = $scope.who;
        Data.post('addIncome',{
            data : data
        }).then(function(response){
            Data.toast(response);
            $scope.addNewClose('income');
            $scope.loadData();
        });
    };
    $scope.addExpense = function(data){
        data.belongTo = $scope.who;
        Data.post('addExpense',{
            data : data
        }).then(function(response){
            Data.toast(response);
            $scope.loadData();
            $scope.addNewClose('expense');
        });
    };
    $scope.edit = function(id, type){
        Data.post('getSingle', {
            id : id,
            type : type
        }).then(function(response){
            if(response.status == 'SUCCESS'){
                if(type == 'income'){
                    //$scope.PopUpTemp = 'editPopUpAssets';
                    $scope.PopUpShow('editPopUpIncome');
                    $scope.editIncomeData = response.data;
                }
                else if(type == 'expense'){
                    $scope.PopUpShow('editPopUpExpense');
                    //$scope.tempEdit = 'editPopUpDebt';
                    $scope.editExpenseData = response.data;
                }
               // $scope.editPopUpSec = true;
            }
            else{
                Data.toast(response);
            }
        });
    };
    $scope.editIncome = function(data){
        Data.post('editIncomeUpdate',{
            data : data
        }).then(function(response){
            $scope.loadData();
            //$scope.editPopUpSec = false; 
            $scope.PopUpHide();
        });
    };
    $scope.editExpense = function(data){
        Data.post('editExpenseUpdate',{
            data : data
        }).then(function(response){
            $scope.loadData();
            //$scope.editPopUpSec = false; 
            $scope.PopUpHide();
        });
    };
    $scope.PopUpShow = function(temp){
        $scope.openPopUp = true;
        $("body, html").css('overflow','hidden');
        $scope.PopUpTemp = temp;
    }
    $scope.PopUpHide = function(){
        $scope.openPopUp = false;
        $("body, html").css('overflow','auto');
        $scope.PopUpTemp = 'holidayPop';
    }
    $scope.ShowReview = false;
    $scope.complete = function(){
        $scope.ShowReview = true;
        Data.post('updateBookmark', {
            data : {makeSpend:'completed'}
        }).then(function(response){

        });
    }
    $scope.gobackMakeSpend = function(){
        Data.post('updateBookmark', {
            data : {makeSpend:'incomplete'}
        }).then(function(response){

        });
        $scope.ShowReview = false;   
    }
});
app.controller('DealCtrl', function($scope, Data, GoogleApi){
    $scope.panesA = [
        {
          id: 'pane-1a',
          header: 'Getting Started',
          status: 'completed',
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
          status: 'completed',
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
          status: 'completed',
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
          url: '#/MakeSpend',
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
          status: 'completed',
          text: 'static/img/nl/step_process.png',
          url: '#/Deal',
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

    $scope.dealData = [];
    $scope.skipNav = false;
    $scope.currentStep = 'Deal';
    
    $scope.loadDeal = function(){
        Data.get('getDealData').then(function(response){
            $scope.dealData = response.data;
            $scope.initHolidayList();      
            $scope.loadCalendarList();  
        });
    }
    $scope.noofdayeswithme = 0;
    $scope.noofdayeswithspouse = 0;
    $scope.loadEvents = function(data, eventColor){
        GoogleApi.post('getEventList', {
            data : data
        }).then(function(response){
            var me = 0;
            var spouse = 0; 
            //$scope.uiConfig.calendar.events = response;
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
            $scope.loadingGoogleApi = false;
        });
    };
    $scope.loadCalendarList = function(){
        $scope.loadingGoogleApi = true;
        GoogleApi.get('getCalendarAll').then(function(response){
            if(response.status == 'SUCCESS'){
                angular.forEach(response.data[0], function(value, key) {
                    $scope.loadEvents(value.id, value.backgroundColor);    
                });
            }
        });
    };
    

    $scope.noofholidayswithme = 0;
    $scope.noofholidayswithspouse = 0;
    $scope.initHolidayList = function(){
        Data.get('getHolidays').then(function(response){
            if(angular.isUndefined(response.status)){
                $scope.holidayList = response;
                angular.forEach($scope.holidayList.religiousholidays.list, function(key, value){
                    var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
                    var firstDate = new Date(key.date.start);
                    var secondDate = new Date(key.date.end);
                    var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
                    if(key.odd == 'Petitioner' || key.even == 'Petitioner' || key.current == 'Petitioner'){
                        $scope.noofholidayswithme += diffDays;
                    }
                    if(key.odd == 'Respondent' || key.even == 'Respondent' || key.current == 'Respondent'){
                        $scope.noofholidayswithspouse += diffDays;
                    }
                });
                angular.forEach($scope.holidayList.standardholidays.list, function(key, value){
                    var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
                    var firstDate = new Date(key.date.start);
                    var secondDate = new Date(key.date.end);
                    var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
                    if(key.odd == 'Petitioner' || key.even == 'Petitioner' || key.current == 'Petitioner'){
                        $scope.noofholidayswithme += diffDays;
                    }
                    if(key.odd == 'Respondent' || key.even == 'Respondent' || key.current == 'Respondent'){
                        $scope.noofholidayswithspouse += diffDays;
                    }
                });
                $scope.alreadyAdded = true;
            }
            else{
                $scope.alreadyAdded = false;
            }
        });
        $scope.assetsTotal = {"me":0,"shared":0,"spouse":0};
        $scope.debtTotal = {"me":0,"shared":0,"spouse":0};
        Data.get('loadAssets').then(function(response){
            $scope.assetsTotal = response.total;
        });
        Data.get('loadDebt').then(function(response){
            $scope.debtTotal = response.total;

        });
        $scope.expenseTotal = 0;
        $scope.incomeTotal = 0;
        Data.get('loadData').then(function(response){
            $scope.incomeTotal = response.total.income;
            $scope.expenseTotal = response.total.expense;
        });
        Data.get('loadCurrentJobData').then(function(response){
            $scope.empName = response.result[0].name;
            $scope.taxStatus = response.result[0].taxStatus;
        });
    }
});