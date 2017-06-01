var app = angular.module('project', ['projectApi']);
  app.config(function($routeProvider) {
    
    $routeProvider.
      when('/', {controller:ListCtrl, templateUrl:BASE_URL+'home/homeView'}).
      when('/edit/:id', {controller:EditCtrl, templateUrl:BASE_URL+'projects/template_detail'}).
      when('/new', {controller:CreateCtrl, templateUrl:BASE_URL+'projects/template_detail'}).
      when('/login/', {controller:'loginCtrl', templateUrl:BASE_URL+'account/view/'}).
      when('/register/', {controller:CreateCtrl, templateUrl:BASE_URL+'account/view/register/'}).
      otherwise({redirectTo:'/'});
  });
app.controller('loginCtrl', function($scope){
  
});
function ListCtrl($scope, $location, Project) {

  $scope.projects = Project.query();

  $scope.destroy = function(Project) {
    Project.destroy(function() {
      $scope.projects.splice($scope.projects.indexOf(Project), 1);
    });
  };
}

function CreateCtrl($scope, $location, Project) {
  $scope.save = function() {
    Project.save($scope.project, function(project) {
      $location.path('/edit/' + project.id);
    });
  };
}

function EditCtrl($scope, $location, $routeParams, Project) {
  var self = this;

  Project.get({id: $routeParams.id}, function(project) {
    self.original = project;
    $scope.project = new Project(self.original);
  });

  $scope.isClean = function() {
    return angular.equals(self.original, $scope.project);
  };

  $scope.destroy = function() {
    self.original.destroy(function() {
      $location.path('/');
    });
  };

  $scope.save = function() {
    $scope.project.update(function() {
      $location.path('/');
    });
  };
}


angular.module('projectApi', ['ngResource']).
  factory('Project', function($resource) {
    var Project = $resource(BASE_URL+'api/projects/:method/:id', {}, {
      query: {method:'GET', params: {method:'index'}, isArray:true },
      save: {method:'POST', params: {method:'save'} },
      get: {method:'GET', params: {method:'edit'} },
      remove: {method:'DELETE', params: {method:'remove'} }
    });
console.log(Project);
    Project.prototype.update = function(cb) {
      console.log(this.id);
      return Project.save({id: this.id},
          angular.extend({}, this, {id:undefined}), cb);
    };

    Project.prototype.destroy = function(cb) {
      return Project.remove({id: this.id}, cb);
    };

    return Project;
  });