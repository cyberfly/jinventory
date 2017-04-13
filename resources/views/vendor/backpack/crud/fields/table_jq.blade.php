<!-- array input -->

<?php
    $max = isset($field['max']) && (int) $field['max'] > 0 ? $field['max'] : -1;
    $min = isset($field['min']) && (int) $field['min'] > 0 ? $field['min'] : -1;
    $item_name = strtolower(isset($field['entity_singular']) && !empty($field['entity_singular']) ? $field['entity_singular'] : $field['label']);

    $items = old($field['name']) ? (old($field['name'])) : (isset($field['value']) ? ($field['value']) : (isset($field['default']) ? ($field['default']) : '' ));

    // make sure not matter the attribute casting
    // the $items variable contains a properly defined JSON
    if (is_array($items)) {
        if (count($items)) {
            $items = json_encode($items);
        } else {
            $items = '[]';
        }
    } elseif (is_string($items) && !is_array(json_decode($items))) {
        $items = '[]';
    }

?>
<div ng-app="backPackTableApp" ng-controller="tableController" @include('crud::inc.field_wrapper_attributes') >

    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')

    <input class="array-json" type="hidden" id="{{ $field['name'] }}" name="{{ $field['name'] }}">

    <div class="array-container form-group">

        <table class="table table-bordered table-striped m-b-0" ng-init="field = '#{{ $field['name'] }}'; items = {{ $items }}; max = {{$max}}; min = {{$min}}; maxErrorTitle = '{{trans('backpack::crud.table_cant_add', ['entity' => $item_name])}}'; maxErrorMessage = '{{trans('backpack::crud.table_max_reached', ['max' => $max])}}'">

            <thead>
                <tr>

                    @foreach( $field['columns'] as $prop )
                    <th style="font-weight: 600!important;">
                        {{ $prop }}
                    </th>
                    @endforeach
                    <th class="text-center" ng-if="max == -1 || max > 1"> {{-- <i class="fa fa-sort"></i> --}} </th>
                    <th class="text-center" ng-if="max == -1 || max > 1"> {{-- <i class="fa fa-trash"></i> --}} </th>
                </tr>
            </thead>

            <tbody ui-sortable="sortableOptions" ng-model="items" class="table-striped">

                @for($i=0;$i<$min;$i++)
                <tr class="array-row">

                    @foreach( $field['columns'] as $prop => $label)
                    <td>
                        <input class="form-control input-sm {{ $prop }}" type="text" >
                        <input type="hidden" name="item_id[]" class="item_id" value="" />
                    </td>
                    @endforeach
                    <td>
                        <span class="btn btn-sm btn-default sort-handle"><span class="sr-only">sort item</span><i class="fa fa-sort" role="presentation" aria-hidden="true"></i></span>
                    </td>
                    <td>
                        <button ng-hide="min > -1 && $index < min" class="btn btn-sm btn-default" type="button" ng-click="removeItem(item);"><span class="sr-only">delete item</span><i class="fa fa-trash" role="presentation" aria-hidden="true"></i></button>
                    </td>
                </tr>
                @endfor

            </tbody>

        </table>

        <div class="array-controls btn-group m-t-10">
            <button ng-if="max == -1 || items.length < max" class="btn btn-sm btn-default" type="button" ng-click="addItem()"><i class="fa fa-plus"></i> {{trans('backpack::crud.add')}} {{ $item_name }}</button>
        </div>

    </div>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
    {{-- @push('crud_fields_styles')
        {{-- YOUR CSS HERE --}}
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        {{-- YOUR JS HERE --}}
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.8/angular.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-sortable/0.14.3/sortable.min.js"></script>
        <script>
            var typingTimer;                //timer identifier
            var doneTypingInterval = 1000;  //time in ms, 5 second for example
            var $input = $('.barcode_no');

            //on keyup, start the countdown
            $input.keyup(function(){

                var barcode_no = $( this).val();
                var $current_input = $( this );

                clearTimeout(typingTimer);

                if (barcode_no.length) {
                    typingTimer = setTimeout(function(){
                        getAssetInfo(barcode_no, $current_input);
                    }, doneTypingInterval);
                }
            });

            function getAssetInfo(barcode_no, current_input)
            {
//                console.log(barcode_no);
                $.ajax({
                    method: "GET",
                    url: "/admin/assign/asset/",
                    dataType: 'json',
                    data: { barcode_no: barcode_no }
                }).done(function( response ) {
//                    console.log(response);
                    current_input.prop('readonly', true);

                    var $item_id = current_input.closest('tr').find('.item_id');
                    $item_id.val(response.data.id);
                    $item_id.prop('readonly', true);

                    var $asset_name = current_input.closest('tr').find('.asset_name');
                    $asset_name.val(response.data.asset_name);
                    $asset_name.prop('readonly', true);

                    var $brand_name = current_input.closest('tr').find('.brand_name');
                    $brand_name.val(response.data.brand.brand_name);
                    $brand_name.prop('readonly', true);

                    var $category_name = current_input.closest('tr').find('.category_name');
                    $category_name.val(response.data.category.category_name);
                    $category_name.prop('readonly', true);

                });
            }

            //alert(1);

//            $( '.barcode_no' ).on( "keypress", function() {
//                getAssetInfo($(this).val());
//            });
//
//            var typed_into = false;
//
//            $('.barcode_no').on({
//                keyup: function() { typed_into = true; },
//                change: function() {
//                    if (typed_into) {
//                        getAssetInfo($(this).val());
//                        typed_into = false; //reset type listener
//                    } else {
//
//                    }
//                }
//            });




            window.angularApp = window.angularApp || angular.module('backPackTableApp', ['ui.sortable'], function($interpolateProvider){
                $interpolateProvider.startSymbol('<%');
                $interpolateProvider.endSymbol('%>');
            });

            window.angularApp.controller('tableController', function($scope){

                $scope.sortableOptions = {
                    handle: '.sort-handle'
                };

                $scope.addItem = function(){

                    if( $scope.max > -1 ){
                        if( $scope.items.length < $scope.max ){
                            var item = {};
                            $scope.items.push(item);
                        } else {
                            new PNotify({
                                title: $scope.maxErrorTitle,
                                text: $scope.maxErrorMessage,
                                type: 'error'
                            });
                        }
                    }
                    else {
                        var item = {};
                        $scope.items.push(item);
                    }
                }

                $scope.removeItem = function(item){
                    var index = $scope.items.indexOf(item);
                    $scope.items.splice(index, 1);
                }

                $scope.$watch('items', function(a, b){

                    if( $scope.min > -1 ){
                        while($scope.items.length < $scope.min){
                            $scope.addItem();
                        }
                    }

                    if( typeof $scope.items != 'undefined' && $scope.items.length ){

                        if( typeof $scope.field != 'undefined'){
                            if( typeof $scope.field == 'string' ){
                                $scope.field = $($scope.field);
                            }
                            $scope.field.val( angular.toJson($scope.items) );
                        }
                    }
                }, true);

                if( $scope.min > -1 ){
                    for(var i = 0; i < $scope.min; i++){
                        $scope.addItem();
                    }
                }
            });

            angular.element(document).ready(function(){
                angular.forEach(angular.element('[ng-app]'), function(ctrl){
                    var ctrlDom = angular.element(ctrl);
                    if( !ctrlDom.hasClass('ng-scope') ){
                        angular.bootstrap(ctrl, [ctrlDom.attr('ng-app')]);
                    }
                });
            })

//            for barcode_no only
            angular.module('myDirective', [])
                    .directive('myDirective', function () {
                        return {
                            restrict: 'A',
                            link: function (scope, element, attrs) {
                                scope.$watch(attrs.ngModel, function (v) {
                                    //console.log('value changed, new value is: ' + v);
                                    console.log(scope.item.barcode_no);
                                    alert('value change: ' + scope.item.barcode_no);
                                });
                            }
                        };
                    });

//            function x($scope) {
//                //$scope.test = 'value here';
//                $scope.item = {
//                    barcode_no: 'value here'
//                }
//            }

        </script>

    @endpush
@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
