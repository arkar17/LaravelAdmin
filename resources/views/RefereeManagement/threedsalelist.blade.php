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
            <form class="twod-sale-list-filters-container" action="{{route('searchthreeddagent')}}" method="post">
                @csrf

                <div class="twod-sale-list-filters-agentname-container">
                <p>{{__('msg.Agent')}} {{__('msg.Name')}}</p>
                <input type="text" name="searchagent" list="agent-names" placeholder="Enter Agent Name"/>
                <datalist id="agent-names">
                    @foreach ($threeDSaleList as $agentname)
                        <option value="{{$agentname->name}}"></option>
                    @endforeach
                </datalist>
                </div>

                <div class="twod-sale-list-filters-date-parent-container">
                <p>{{__('msg.Date')}}</p>
                <div class="twod-sale-list-filters-date-container">
                    <input type="date" placeholder="From Date"/>
                    <input type="date" placeholder="To Date"/>
                </div>
                </div>

                <div class="twod-sale-list-filters-round-container">
                <p>{{__('msg.Round')}}</p>

                <select>
                    <option value="">{{__('msg.Choose Round')}}</option>
                    <option value="Morning">Morning</option>
                    <option value="Evening">Evening</option>
                </select>
                </div>

                <button type="submit" class="twod-sale-list-filters-btn">
                <iconify-icon icon="akar-icons:search" class="twod-sale-list-filter-icon" ></iconify-icon>
                <p>Filter</p>
                </button>
            </form>
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
                @foreach ($threeDSaleList as $threedsalelist)
                    <div class="twod-sale-details-row">
                        <p>{{$threedsalelist->id}}</p>
                        <p>{{$threedsalelist->name}}</p>
                        <p>{{$threedsalelist->customer_name}}</p>
                        <p>{{$threedsalelist->number}}</p>
                        <p>{{$threedsalelist->sale_amount}}ks</p>
                    </div>
                @endforeach
            </div>
        </div>
        </div>
        <!--2d sale list end-->
@endsection
