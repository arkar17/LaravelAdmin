@extends('system_admin.layouts.app')

@section('title', 'Agent Data')

@section('content')

            <!--2d sale list start-->
            <div class="twod-sale-list-parent-container">
                <h1>{{$cusname}}</h1>

                <br>
              {{-- </div> --}}

              <div class="twod-sale-list-details-parent-container">
                <div class="twod-sale-list-details-labels-container">
                  <p>{{__('msg.ID')}}</p>
                  <p>{{__('msg.Agent')}} {{__('msg.Name')}}</p>

                  <p>{{__('msg.Number')}}</p>
                  <p>{{__('msg.Compensation')}}</p>
                  <p>{{__('msg.Amount')}}</p>
                </div>

                <div class="twod-sale-details-rows-container">
                        <?php $i=1;?>
                        @if ($twods ==null && $threeds ==null && $lonepyines ==null)
                                    <p style="text-align: center;">{{__('msg.You not have customer')}}</p>
                        @else
                        @foreach ($twods as $twod)
                            <div class="twod-sale-details-row">
                                <p>{{$i++}}</p>
                                <p>{{$twod->agent->user->name}}</p>
                                <p>{{$twod->twod->number}}</p>
                                <p>{{$twod->twod->compensation}}</p>
                                <p>{{$twod->sale_amount}}</p>
                            </div>
                        @endforeach
                        @foreach ($threeds as $threed)
                            <div class="twod-sale-details-row">
                                <p>{{$i++}}</p>
                                <p>{{$threed->agent->user->name}}</p>
                                <p>{{$threed->threed->number}}</p>
                                <p>{{$threed->threed->compensation}}</p>
                                <p>{{$threed->sale_amount}}</p>
                            </div>
                        @endforeach
                        @foreach ($lonepyines as $lonepyine)
                            <div class="twod-sale-details-row">
                                <p>{{$i++}}</p>
                                <p>{{$lonepyine->agent->user->name}}</p>
                                <p>{{$lonepyine->lonepyine->number}}</p>
                                <p>{{$lonepyine->lonepyine->compensation}}</p>
                                <p>{{$lonepyine->sale_amount}}</p>
                            </div>
                        @endforeach
                            @endif


                </div>
              </div>
            </div>
            <!--2d sale list end-->

@endsection

@push('script')
    <script>

    </script>
@endpush
