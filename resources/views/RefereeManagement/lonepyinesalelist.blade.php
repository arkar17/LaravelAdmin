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

        <form class="twod-sale-list-filters-container" action="{{route('searchlonepyineagent')}}" method="post">
            @csrf

            <div class="twod-sale-list-filters-agentname-container">
                <p>{{__('msg.Agent')}} {{__('msg.Name')}}</p>
                <input type="text" name="searchagent" list="agent-names" placeholder="Enter Agent Name"/>
                <datalist id="agent-names">
                @foreach ($lonepyineSaleList as $agentname)
                    <option value="{{$agentname->customer_name}}"></option>
                @endforeach
                </datalist>
            </div>

            {{-- <div class="twod-sale-list-filters-date-parent-container">
                <p>Date</p>
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
            </div> --}}

            <button type="submit" class="twod-sale-list-filters-btn">
                <iconify-icon icon="akar-icons:search" class="twod-sale-list-filter-icon"></iconify-icon>
                <p>Filter</p>
            </button>
         </form>
         <a class="lonepyine-sale-export-btn"
                       href="{{ route('exportlonePyaingList') }}">
                              Export lonepyine Data
                    </a>
        {{-- </div> --}}

        <table class="twod-sale-list-details-parent-container">
            <thead>
            <tr class="twod-sale-list-details-labels-container">
                <th>{{__('msg.ID')}}</th>
                <th>{{__('msg.Agent')}} {{__('msg.Name')}}</th>
                <th>{{__('msg.Customer')}} {{__('msg.Name')}}</th>
                <th>{{__('msg.Number')}}</th>
                <th>{{__('msg.Amount')}}</th>
            </tr>
            </thead>

            <tbody class="twod-sale-details-rows-container">
                @foreach ($lonepyineSaleList as $lonepyinesalelist)
                    <tr class="twod-sale-details-row">
                        <td>{{$lonepyinesalelist->id}}</td>
                        <td>{{$lonepyinesalelist->name}}</td>
                        <td>{{$lonepyinesalelist->customer_name}}</td>
                        <td>{{$lonepyinesalelist->number}}</td>
                        <td>{{$lonepyinesalelist->sale_amount}}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <!--2d sale list end-->

</div>
<!--main content end-->

@endsection
