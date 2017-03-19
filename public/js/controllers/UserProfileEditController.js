/* Setup general page controller */
angular.module('MetronicApp').controller('UserProfileEditController', [
    '$rootScope', '$scope', 'Restful', '$state', 'uploadManager',
    function($rootScope, $scope, restful, $state, uploadManager) {
        var vm = this;
        vm.model = $scope.userProfile;

        vm.upload = {
            photo : null,
            percentage : 0,
            is_completed : false,
            in_progress : false
        };
        vm.genders = [{
            code: 'M',
            name: 'Male'
        },
        {
            code: 'F',
            name: 'Female'
        }];
        vm.directions = [{
            code: 'L',
            name: 'Left'
        },
        {
            code: 'R',
            name: 'Right'
        }];
        $scope.$on('$viewContentLoaded', function() {
            // initialize core components
            App.initAjax();
        });

        vm.getInit = function(){
            restful.get('getCountry').success(function(result){
                vm.countries = result;
            });
            restful.get('user/getProfile').success(function(result){
                vm.model = result;
            });
        };
        vm.getInit();

        vm.save = function(){
            if($scope.profileForm.$invalid){
                return;
            }
            vm.loading= true;
            restful.put('/api/user/updateProfile', vm.model).success(function(response){
                // call from parent scope function in main.js
                $rootScope.$emit("InitSettingMethod", {});
                $state.go('user_profile');
            }).finally(function () {
                vm.loading= false;
            });
        };

        vm.changeTab = function(id){
            $(id).siblings().removeClass('active');
            $(id).addClass('active');
        };

        vm.initialConfigUpload = function(){
            $rootScope.$on('fileAdded', function (e, call) {
                $scope.vm.upload.percentage = 0;
                uploadManager.upload();

                // Clear uploaded files.
                $("#bankslip-file").val('');
                $scope.$apply();
            });

            $rootScope.$on('uploadProgress', function (e, call) {
                $scope.vm.upload.percentage = call;
                $scope.vm.upload.in_progress = true;
                $scope.$apply();
            });

            $rootScope.$on('uploadResponseResult', function (e, result) {
                $scope.vm.upload.photo = result;
                vm.model.image = result;
                
                console.log(result);
                setTimeout(function(){
                    $scope.vm.upload.is_completed = true;
                    $scope.vm.upload.in_progress = false;
                    $scope.$apply();
                }, 200);
                $scope.$apply();
            });


            var previewImage =  function(input) {
                //$('#preview').find('img').remove();

                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        // var image = new Image();
                        // image.title = e.target.name;
                        // image.src = e.target.result;
                        // $('#preview').append( image );
                        console.log(e);
                        //$('#preview #blah').attr('src', e.target.result);
                        vm.src_upload = e.target.result;//true;
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            };

            $("#bankslip-file").change(function(){
                previewImage(this);
            });
        };

        vm.initialConfigUpload();

    }
]);
