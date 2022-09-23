@extends('RefereeManagement.layout.app')

@section('title', 'Agent Data')

@section('content')
<!--main content start-->
<div class="main-content-parent-container">

    <!--2d sale list start-->
    <div class="twod-sale-list-parent-container">
        <h1>{{__('msg.Sale List - Lone Pyine Sale List')}}</h1>
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
                       href="{{ route('exportlonePyaingList') }}">
                              Export lonepyine Data
        </a>
        {{-- </div> --}}

        <div class="twod-sale-list-details-parent-container">
        <div class="twod-sale-list-details-labels-container">
            <p>{{__('msg.ID')}}</p>
            <p>{{__('msg.Agent')}} {{__('msg.Name')}}</p>
            <p>{{__('msg.Customer')}} {{__('msg.Name')}}</p>
            <p>{{__('msg.Number')}}</p>
            <p>{{__('msg.Amount')}}</p>
        </div>

        <div class="twod-sale-details-rows-container">
            @if (count($lonepyineSaleList) ==0 || count($lonepyineSaleList) ==null)
                <p style="text-align: center;">{{__('msg.Today is not sold any number')}}</p>
            @else
                <?php $i=1;?>
                @foreach ($lonepyineSaleList as $lonepyinesalelist)
                    <div class="twod-sale-details-row">
                        <p>{{$i++}}</p>
                        <p>{{$lonepyinesalelist->name}}</p>
                        <p>{{$lonepyinesalelist->customer_name}}</p>
                        <p>{{$lonepyinesalelist->number}}</p>
                        <p>{{$lonepyinesalelist->sale_amount}}</p>
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
