@extends('system_admin.layouts.app')

@section('title', 'Agent Data')

@section('content')

        <!--2d sale list start-->
        <div class="twod-sale-list-parent-container">
        <h1>{{__('msg.Sale List - 3D Sale List')}}</h1>
        {{-- <div class="twod-sale-list-filters-container"> --}}
            <!-- <div class="twod-sale-list-filter-refereename-container">
            <p>Referee Name</p>
            <input type="text" list="referee-names" placeholder="Enter Referee Name"/>
            <datalist id="referee-names">
                <option value="referee 01"></option>
                <option value="referee 02"></option>
                <option value="referee 03"></option>
            </datalist>
            </div> -->

            <a class="lonepyine-sale-export-btn"
                href="{{ route('export3DList') }}">
                   Export 3d Data
            </a>
        {{-- </div> --}}

        <table class="twod-sale-list-details-parent-container">
            <thead>
            <tr class="twod-sale-list-details-labels-container">
                <th>{{__('ID')}}</th>
                <th>{{__('msg.Agent')}} {{__('msg.Name')}}</th>
                <th>{{__('msg.Customer')}} {{__('msg.Name')}}</th>
                <th>{{__('msg.Number')}}</th>
                <th>{{__('msg.Amount')}}</th>
            </tr>
            </thead>

            <tbody class="twod-sale-details-rows-container">
                @if (count($threeDSaleList) ==0 || count($threeDSaleList) ==null)
                    <p style="text-align: center;">{{__('msg.Today is not sold any number')}}</p>
                @else
                    <?php $i=1;?>
                    @foreach ($threeDSaleList as $threedsalelist)
                        <tr class="twod-sale-details-row">
                            <td>{{$i++}}</td>
                            <td>{{$threedsalelist->name}}</td>
                            <td>{{$threedsalelist->customer_name}}</td>
                            <td>{{$threedsalelist->number}}</td>
                            <td>{{$threedsalelist->sale_amount}}ks</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        </div>
        <!--2d sale list end-->
@endsection
