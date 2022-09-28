@extends('system_admin.layouts.app')

@section('title', 'Agent Data')

@section('content')

            <!--2d sale list start-->
            <div class="twod-sale-list-parent-container">
              <h1>{{__('msg.Sale List - 2D Sale List')}}</h1>

                <br>
                <a class="twod-sale-export-btn"
                       href="{{ route('export-2dList') }}">
                              Export 2D Data
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
                    @if (count($twoDSaleList) ==0 || count($twoDSaleList) ==null)
                        <p style="text-align: center;">{{__('msg.Today is not sold any number')}}</p>
                    @else
                        <?php $i=1;?>
                        @foreach ($twoDSaleList as $twodsalelist)
                            <tr class="twod-sale-details-row">
                                <td>{{$i++}}</td>
                                <td>{{$twodsalelist->name}}</td>
                                <td>{{$twodsalelist->customer_name}}</td>
                                <td>{{$twodsalelist->number}}</td>
                                <td>{{$twodsalelist->sale_amount}}</td>
                            </tr>
                        @endforeach
                    @endif

                </tbody>
              </table>
            </div>
            <!--2d sale list end-->

@endsection

@push('script')
    <script>

    </script>
@endpush
