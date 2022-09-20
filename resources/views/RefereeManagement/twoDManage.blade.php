@extends('RefereeManagement.layout.app')

@section('title', '2D Manage')

@section('content')
  <!--2d manage start-->
  <div class="twod-manage-parent-container">
    <div class="twod-manage-header-container">
      <h1>{{__('msg.2D Manage')}}</h1>
      <div class="twod-manage-search-container">
        <iconify-icon icon="akar-icons:search" class="twod-manage-search-icon"></iconify-icon>
        <input type="number" placeholder="Search Number"/>
      </div>
    </div>

    <form class="twod-manage-numbers-parent-container">
        <div class="twod-manage-labels-container">
          <div class="twod-manage-numbers-labels-left-container">
            <p>{{__('msg.2D')}} {{__('msg.Number')}}</p>
            <p>{{__('msg.Current Rate')}}</p>
            <p>{{__('msg.Current Max Amount')}}</p>
            <p>{{__('msg.Sale')}}</p>
          </div>
          <div class="twod-manage-numbers-labels-right-container">
            <p>{{__('msg.Rate')}}</p>
            <p>{{__('msg.Max')}}</p>
          </div>
        </div>

        <div class="twod-manage-numbers-rows-container">
        </div>

        <div class="twod-manage-inserts-parent-container">
          <div class="twod-manage-rate-insert-container">
            <p>{{__('msg.Rate')}}:</p>
            <input id="twod-rate-insert-input" type="number"></p>
            <button type="button" id="twod-rate-insert-btn">Insert</button>
          </div>
          <div class="twod-manage-max-insert-container">
            <p>{{__('msg.Max Amount')}}:</p>
            <input id="twod-max-insert-input" type="number"></p>
            <button type="button" id="twod-max-insert-btn">Insert</button>
          </div>

          <div class="twod-manage-inserts-btns-container">
            {{-- <a href="{{route('2DManageCreate')}}"> <button type="button" class="twod-manage-confirm-btn">Confirm</button> </a>
            <a href="{{route('2DManageCreate')}}"> <button type="button" class="twod-manage-cancel-btn">Cancel</button></a> --}}
            <button type="button" class="twod-manage-confirm-btn" id='confirm'>{{__('msg.Confirm')}}</button>
            <button type="button" class="twod-manage-cancel-btn">{{__('msg.Cancel')}}</button>
          </div>

        </div>
    </form>
  </div>
  <!--2d manage end-->
  <script src="{{asset('js/refereemanage/2dmanage.js')}}"></script>
@endsection


