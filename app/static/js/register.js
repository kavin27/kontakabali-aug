var app = angular.module('register', ['ui.select2','vcRecaptcha', 'ui.date']);
app.controller('regCtrl', function($scope, $http){
    $scope.signup = {};
    $scope.signup_error = '';
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
    $scope.currentTpl = 'one';
    $scope.signUp = function (customer) {
        if($scope.signup.cresponse == null){
            $scope.error = 'please validate captcha';
            return;
        }
        $http.post(BASE_URL+'register', {
            customer: customer
        }).then(function (results) {
            console.log(results);
            if (results.data.status == "SUCCESS") {
                $scope.currentTpl = 'nine';
               // $location.path('dashboard');
            }
            else{
                $scope.signup_error = results.data.message;
            }
        });
    }
    $scope.percent = 100/6;
    $(".progress-bar").css("width",$scope.percent+"%").html($scope.percent+"%");
    $scope.percent = 0;
    $scope.next = function(step){
        $scope.percent = $scope.percent + 100/6; 
        $(".progress-bar").css("width",$scope.percent+"%").html($scope.percent+"%");
        $scope.inputerror = false;
        $scope.currentTpl = step;
        if(step == 'five'){
            $scope.signup.noc_under_18 = '0';
        }
    }
    $scope.validate = function(){
        $scope.inputerror = true;
    }
});