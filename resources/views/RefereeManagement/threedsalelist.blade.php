@extends('RefereeManagement.layout.app')

@section('title', 'Agent Data')

@section('content')

    <!--main content start-->
    <div class="main-content-parent-container">

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

        <div class="twod-sale-list-details-parent-container">
            <div class="twod-sale-list-details-labels-container">
            <p>{{__('ID')}}</p>
            <p>{{__('msg.Agent')}} {{__('msg.Name')}}</p>
            <p>{{__('msg.Customer')}} {{__('msg.Name')}}</p>
            <p>{{__('msg.Number')}}</p>
            <p>{{__('msg.Amount')}}</p>
            </div>

            <div class="twod-sale-details-rows-container">
                @if (count($threeDSaleList) ==0 || count($threeDSaleList) ==null)
                    <p style="text-align: center;">{{__('msg.Today is not sold any number')}}</p>
                @else
                    <?php $i=1;?>
                    @foreach ($threeDSaleList as $threedsalelist)
                        <div class="twod-sale-details-row">
                            <p>{{$i++}}</p>
                            <p>{{$threedsalelist->name}}</p>
                            <p>{{$threedsalelist->customer_name}}</p>
                            <p>{{$threedsalelist->number}}</p>
                            <p>{{$threedsalelist->sale_amount}}ks</p>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        </div>
        <!--2d sale list end-->

    </div>
  <!--main content end-->
@endsection
