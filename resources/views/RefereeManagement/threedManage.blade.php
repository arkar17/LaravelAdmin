@extends('RefereeManagement.layout.app')

@section('title', '2D Manage')

@section('content')
            <!--3dlonepyine manage start-->
            <div class="threed-manage-parent-container">
                <h1>{{__('msg.3D Manage')}}</h1>
                <div class="threed-manage-rate-parent-container">

                        @if($rate == [])
                            <p class="threed-manage-current-rate">{{__('msg.Current Rate')}} : 0</p>

                        @else
                            @foreach($rate as $rat)
                            <p class="threed-manage-current-rate">{{__('msg.Current Rate')}}  : {{$rat->compensation}}</p>
                            @endforeach
                        @endif


                    <div class="threed-manage-rate-insert-container">
                        <p>{{__('msg.Rate')}}:</p>
                        <form action="{{route('3D')}}" mehtod = 'post'>
                            @csrf
                            <input id="threed-rate-insert-input" type="number" name="number" />
                            <button type="submit" id="threed-rate-insert-btn">Insert</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="lonepyine-manage-parent-container">
                <div class="lonepyine-manage-header-container">
                    <h1>{{__('msg.Lone Pyine Manage')}}</h1>
                    <div class="lonepyine-manage-search-container">
                      <iconify-icon icon="akar-icons:search" class="lonepyine-manage-search-icon"></iconify-icon>
                      <input type="number" placeholder="Search Number"/>
                    </div>
                </div>

                <form class="lonepyine-manage-numbers-parent-container">
                    <div class="lonepyine-manage-labels-container">
                      <div class="lonepyine-manage-numbers-labels-left-container">
                        <p>{{__('msg.Lone Pyine')}} {{__('msg.Number')}}</p>
                        <p>{{__('msg.Current Rate')}}</p>
                        <p>{{__('msg.Current Max Amount')}}</p>
                        <p>{{__('msg.Sale')}}</p>
                      </div>
                      <div class="lonepyine-manage-numbers-labels-right-container">
                        <p>{{__('msg.Rate')}}</p>
                        <p>{{__('mgs.Max')}}</p>
                      </div>
                    </div>

                    <div class="lonepyine-manage-numbers-rows-container">
                        @if($lonepyaing_sale_lists == null)
                        @for ($i = 0; $i <= 9 ; $i++)
                        <div class="lonepyine-manage-numbers-row">
                            <div class="lonepyine-manage-numbers-attributes">
                            <p>{{$i}} &nbsp;&nbsp;<span>∞</span></p>
                            <p>0</p>
                            <p>0</p>
                            <p>0</p>
                            </div>

                            <div class="lonepyine-manage-numbers-inputs-container">
                                <input type="number" name="lonepyine-number-rate-input" id="lonepyine-number-rate" />
                                <input type="number" name="lonepyine-number-max-input" id="lonepyine-number-max"/>
                            </div>
                        </div>
                        @endfor
                        @for ($i = 0; $i <= 9 ; $i++)
                        <div class="lonepyine-manage-numbers-row">
                            <div class="lonepyine-manage-numbers-attributes">
                            <p><span>∞</span>&nbsp;&nbsp;{{$i}} </p>
                            <p>0</p>
                            <p>0</p>
                            <p>0</p>
                            </div>

                            <div class="lonepyine-manage-numbers-inputs-container">
                                <input type="number" name="lonepyine-number-rate-input" id="lonepyine-number-rate" />
                                <input type="number" name="lonepyine-number-max-input" id="lonepyine-number-max"/>
                            </div>
                        </div>
                        @endfor

                    @else
                        @foreach($lonepyaing_sale_lists as $lonePyaing)
                        <div class="lonepyine-manage-numbers-row">
                            <div class="lonepyine-manage-numbers-attributes">
                            <p>{{$lonePyaing->number}}</span></p>
                            <p>{{$lonePyaing->compensation}}</p>
                            <p>{{$lonePyaing->max_amount}}</p>
                            <p>{{$lonePyaing->sales}}</p>
                            </div>

                            <div class="lonepyine-manage-numbers-inputs-container">
                                <input type="number" name="lonepyine-number-rate-input" id="lonepyine-number-rate" />
                                <input type="number" name="lonepyine-number-max-input" id="lonepyine-number-max"/>
                            </div>
                        </div>
                        @endforeach

                    @endif
                </div>



                    <div class="lonepyine-manage-inserts-parent-container">
                      <div class="lonepyine-manage-rate-insert-container">
                        <p>{{__('msg.Rate')}}:</p>
                        <input id="lonepyine-rate-insert-input" type="number"/>
                        <button type="button" id="lonepyine-rate-insert-btn">Insert</button>
                      </div>
                      <div class="lonepyine-manage-max-insert-container">
                        <p>{{__('msg.Max Amount')}}:</p>
                        <input id="lonepyine-max-insert-input" type="number" />
                        <button type="button" id="lonepyine-max-insert-btn">Insert</button>
                      </div>

                      <div class="lonepyine-manage-inserts-btns-container">
                        <button type="button" class="lonepyine-manage-confirm-btn">{{__('msg.Confirm')}}</button>
                        <button type="button" class="lonepyine-manage-cancel-btn">{{__('msg.Cancel')}}</button>
                      </div>
                    </div>
                </form>
            </div>
            <!--3dlonepyine manage end-->

            <script src="{{asset('jquery/refereemanage/3d&lonepyingmanage.js')}}"></script>
@endsection


