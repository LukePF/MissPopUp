var app = angular.module('missPopup', ['ngDialog','ui.bootstrap']);


         app.controller('MainCtrl', function ($scope, $rootScope, ngDialog, $timeout) {
             $scope.open = function($event) {
                 $event.preventDefault();
                 $event.stopPropagation();

                 $scope.opened = true;
             };
            $scope.login = function () {
                ngDialog.open({
                    template: 'loginDialogId',
                    controller: 'LoginCtrl',
                    className: 'ngdialog-theme-default'
                });
            }; 
            $scope.register = function () {

                ngDialog.open({
                    template: 'registerDialogId',
                    controller: 'RegisterCtrl',
                    className: 'ngdialog-theme-default'
                });
            };    

            $scope.newpopup = function () {
                ngDialog.open({
                    template: 'newpopupDialogId',
                    className: 'ngdialog-theme-default'
                });
            };    
        });

         app.controller('LoginCtrl', function ($scope, ngDialog) {
      
            $scope.register = function () {
   
                ngDialog.open({
                    template: 'registerDialogId',
                    className: 'ngdialog-theme-default'
                });
            };
        });
        
        app.controller('RegisterCtrl', function ($scope, ngDialog) {
      
            $scope.login = function () {
                ngDialog.open({
                    template: 'loginDialogId',
                    className: 'ngdialog-theme-default'
                });
            };
        });


    app.controller('DatepickerDemoCtrl', function ($scope) {
        $scope.today = function() {
            $scope.dt = new Date();
        };
        $scope.today();

        $scope.clear = function () {
            $scope.dt = null;
        };

        // Disable weekend selection
        $scope.disabled = function(date, mode) {
            return ( mode === 'day' && ( date.getDay() === 0 || date.getDay() === 6 ) );
        };

        $scope.toggleMin = function() {
            $scope.minDate = $scope.minDate ? null : new Date();
        };
        $scope.toggleMin();

        $scope.open = function($event) {
            $event.preventDefault();
            $event.stopPropagation();

            $scope.opened = true;
        };

        $scope.dateOptions = {
            formatYear: 'yy',
            startingDay: 1
        };

        $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
        $scope.format = $scope.formats[0];

        var tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        var afterTomorrow = new Date();
        afterTomorrow.setDate(tomorrow.getDate() + 2);
        $scope.events =
                [
                    {
                        date: tomorrow,
                        status: 'full'
                    },
                    {
                        date: afterTomorrow,
                        status: 'partially'
                    }
                ];

        $scope.getDayClass = function(date, mode) {
            if (mode === 'day') {
                var dayToCheck = new Date(date).setHours(0,0,0,0);

                for (var i=0;i<$scope.events.length;i++){
                    var currentDay = new Date($scope.events[i].date).setHours(0,0,0,0);

                    if (dayToCheck === currentDay) {
                        return $scope.events[i].status;
                    }
                }
            }

            return '';
        };
    });

//  result.html


app.factory("Item", function() {

  var items = [
              "item1.jpg",
              "item2.jpg",
              "item3.jpg",
              "item4.jpg",
              "item5.jpg",
              "item6.jpg",
              "item7.jpg"
              ];
  return {
    get: function(offset, limit) {
      return items.slice(offset, offset+limit);
    },
    total: function() {
      return items.length;
    }
  };
});

app.controller("PaginationCtrl", function($scope, Item) {

  $scope.itemsPerPage = 6;
  $scope.currentPage = 0;
  $scope.total = Item.total();
  $scope.pagedItems = Item.get($scope.currentPage*$scope.itemsPerPage, $scope.itemsPerPage);

  $scope.loadMore = function() {
    $scope.currentPage++;
    var newItems = Item.get($scope.currentPage*$scope.itemsPerPage, $scope.itemsPerPage);
    $scope.pagedItems = $scope.pagedItems.concat(newItems);
  };

  $scope.nextPageDisabledClass = function() {
    return $scope.currentPage === $scope.pageCount()-1 ? "disabled" : "";
  };

  $scope.pageCount = function() {
    return Math.ceil($scope.total/$scope.itemsPerPage);
  };

});
