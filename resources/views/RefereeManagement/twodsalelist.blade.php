@extends('RefereeManagement.layout.app')

@section('title', 'Agent Data')

@section('content')
                  <!--main content start-->
        <div class="main-content-parent-container">

            <!--2d sale list start-->
            <div class="twod-sale-list-parent-container">
              <h1>{{__('msg.Sale List - 2D Sale List')}}</h1>

                <br>
                <a class="twod-sale-export-btn"
                       href="{{ route('export-2dList') }}">
                              Export 2D Data
                </a>

              <div class="twod-sale-list-details-parent-container">
                <div class="twod-sale-list-details-labels-container">
                  <p>{{__('msg.ID')}}</p>
                  <p>{{__('msg.Agent')}} {{__('msg.Name')}}</p>
                  <p>{{__('msg.Customer')}} {{__('msg.Name')}}</p>
                  <p>{{__('msg.Number')}}</p>
                  <p>{{__('msg.Amount')}}</p>
                </div>

                <div class="twod-sale-details-rows-container">
                    @if (count($twoDSaleList) ==0 || count($twoDSaleList) ==null)
                        <p style="text-align: center;">{{__('msg.Today is not sold any number')}}</p>
                    @else
                        <?php $i=1;?>
                        @foreach ($twoDSaleList as $twodsalelist)
                            <div class="twod-sale-details-row">
                                <p>{{$i++}}</p>
                                <p>{{$twodsalelist->name}}</p>
                                <p>{{$twodsalelist->customer_name}}</p>
                                <p>{{$twodsalelist->number}}</p>
                                <p>{{$twodsalelist->sale_amount}}</p>
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

@push('script')
    <script>

    </script>
@endpush
