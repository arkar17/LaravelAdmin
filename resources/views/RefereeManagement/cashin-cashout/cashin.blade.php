@extends('system_admin.layouts.app')

@section('css')
    <style>
        .main-cash-container {
            padding: 20px;
            width: 75%;
        }

        .alert-border {
            border: 1px solid rgb(206, 6, 6) !important;
        }

        .mc-inp {
            width: 250px;
            padding: 3px;
            outline: none;
            border: 2px solid #D9DEED;
            border-radius: 4px;
            color: #777;
        }

        .mc-label {
            align-self: center;
            margin-bottom: 0px;
        }

        .error-message {
            color: red;
            display: block;
        }

        .add-main-cash {
            display: flex;
            justify-content: space-between;
        }

        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            height: 36px !important;
            user-select: none;
            -webkit-user-select: none;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 33px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 34px !important;
            position: absolute;
            top: 1px;
            right: 1px;
            width: 20px;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 2px solid #D9DEED;
            outline: none;
        }

        .main-cash-alert {
            color: white;
            margin-top: 10px;
            margin-left: 20px;
            background-color: rgb(12, 94, 12);
            border-radius: 5px;
            padding: 10px;
        }

        .error-alert {
            margin-top: 10px;
            color: white;
            margin-left: 20px;
            background-color: rgb(248, 61, 61);
            border-radius: 5px;
            padding: 10px;
        }

        #hide {
            margin-top: 10px;
        }

        .closeBtn {
            color: #ddd;
            cursor: pointer;
            float: right;
        }
    </style>
@endsection

@section('title', 'Referee')
@section('content')

    <div class="main-cash-container">
        <h1>{{ __('msg.Main Cash') }}</h1>
        <form action="{{ route('maincash.store') }}" method="POST">
            @csrf
            <div class="add-main-cash">
                <label for="main_cash" class="mc-label">{{ __('msg.Add Main Cash') }}</label>

                <div>
                    <input type="number"
                        class="mc-inp @error('main_cash')
                    alert-border
                @enderror"
                        id="main_cash" name="main_cash" placeholder="Enter your amount"> <br>
                    @error('main_cash')
                        <small class="error-message">{{ $message }}</small>
                    @enderror
                </div>


                <div class="">
                    <button type="submit" class="cashin-confirm-btn">{{ __('msg.Confirm') }}</button>
                    <button type="reset" class="cashin-cancel-btn">{{ __('msg.Cancel') }}</button>
                </div>
            </div>
            @if (Session::has('main-cash'))
                <div id="hide">
                    <h4 class="main-cash-alert"> {{ Session::get('main-cash') }} <span class="closeBtn">X</span> </h4>
                </div>
            @endif

        </form>

    </div>
    <hr>
    <!--cash in/cash out start-->
    <div class="cashinout-parent-container">
        <div class="cashinout-categories-container">
            <p class="cashinout-category cashinout-category-active" id="cash_in">{{ __('msg.Cash In') }}</p>
            <p class="cashinout-category" id="cash_out">{{ __('msg.Cash Out') }}</p>
        </div>


        {{-- -------------------------------- Cash In-------------------------------- --}}
        <div class="cashin-parent-container">
            <form action="{{ route('cashin.store') }}" method="POST" class="cashin-agent-inputs-parent-container">
                @csrf
                <div class="cashin-agent-name-ph-coin-container">
                    <div class="cashin-agent-name-container">
                        <p>{{ __('msg.Agent') }} {{ __('msg.Name') }}</p>
                        <select id="" class="select2 se1" style="width: 240px;" name="agent_id">
                            @foreach ($agents as $agent)
                                <option value="{{ $agent->id }}" data-id="{{ $agent->id }}">
                                    {{ $agent->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="cashin-agent-phno-container">
                        <p>{{ __('msg.Phone Number') }}</p>
                        <input type="number" placeholder="Enter Agent Phone No" class="inputPhone1" name="phone"
                            disabled />

                    </div>
                    <div class="cashin-agent-coin-container">
                        <p>{{ __('msg.Coin Amount') }}</p>
                        <input type="number" placeholder="Enter Coin Amount"
                            class="inputCoinAmount1 @error('coin_amount')
                            alert-border
                        @enderror"
                            name="coin_amount" />

                        @error('coin_amount')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="cashin-status-payment-remaining-container">
                    <div class="cashin-agent-status-container">
                        <p>{{ __('msg.Status') }}</p>

                        <select id="payment-status" name="status">
                            <option value="1">{{ __('msg.Fully Paid') }}</option>
                            <option value="2">{{ __('msg.Credit') }}</option>
                        </select>
                    </div>

                    <div class="cashin-agent-payment-container">
                        <p>{{ __('msg.Payment') }}</p>
                        <input type="number" placeholder="Enter Payment" name="payment"
                            class="@error('payment')
                          alert-border
                      @enderror" />

                        @error('payment')
                            <small class="error-message">{{ $message }}</small>
                        @enderror

                    </div>

                    <div class="cashin-agent-payment-container">
                        <p>{{ __('msg.Remaining Amount') }}</p>
                        <input type="number" placeholder="" name="remaining_amount" class="inputRemainingAmount1"
                            class="@error('payment')
                          alert-border
                      @enderror"
                            disabled />

                        @error('payment')
                            <small class="error-message">{{ $message }}</small>
                        @enderror

                    </div>

                </div>

                <div class="cashin-btn-container">
                    <button type="submit" class="cashin-confirm-btn">{{ __('msg.Confirm') }}</button>
                    <button type="reset" class="cashin-cancel-btn">{{ __('msg.Cancel') }}</button>
                </div>


                @if (Session::has('cash-in'))
                    <div id="hide">
                        <h4 class="main-cash-alert"> {{ Session::get('cash-in') }} <span class="closeBtn">X</span> </h4>
                    </div>
                @endif


                @if (Session::has('error'))
                    <div id="hide">
                        <h4 class="error-alert"> {{ Session::get('error') }} <span class="closeBtn">X</span> </h4>
                    </div>
                @endif


            </form>
            <div class="cashin-list-parent-container">
                <h1>{{ __('msg.Cash In List') }}</h1>
                <div class="cashin-list-container">
                    <div class="cashin-list-lables-container">
                        <p>{{ __('msg.ID') }}</p>
                        <p>{{ __('msg.Agent') }} {{ __('msg.Name') }}</p>
                        <p>{{ __('msg.Phone Number') }}</p>
                        <p>{{ __('msg.Coin Amount') }}</p>
                        <p>{{ __('msg.Status') }}</p>
                        <p>{{ __('msg.Payment') }}</p>
                        <p>{{ __('msg.Remaining Amount') }}</p>
                        {{-- <p>Action</p> --}}
                    </div>

                    <div class="cashin-list-rows-container">

                        @foreach ($cashin_cashouts as $cashin_cashout)
                            <div class="cashin-list-row">
                                <p>{{ $cashin_cashout->id }}</p>
                                <p>{{ $cashin_cashout->agent->user->name }}</p>
                                <p>{{ $cashin_cashout->agent->user->phone }}</p>
                                <p>{{ $cashin_cashout->coin_amount }}</p>
                                @if ($cashin_cashout->payment >= $cashin_cashout->coin_amount)
                                    <p style="color: rgb(107, 153, 37)">{{ __('msg.Fully Paid') }}</p>
                                @else
                                    <p style="color: red">{{ __('msg.Credit') }}</p>
                                @endif

                                <p>{{ $cashin_cashout->payment }}</p>
                                <p>{{ $cashin_cashout->remaining_amount }}</p>
                                <p><a href="{{ route('cashin.edit', $cashin_cashout->id) }}">Edit</a></p>

                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>





        <div class="cashout-parent-container">
            <form action="{{ route('cashout.store') }}" method="POST" class="cashin-agent-inputs-parent-container">
                @csrf
                <div class="cashin-agent-name-ph-coin-container">
                    <div class="cashin-agent-name-container">
                        <p>{{ __('msg.Agent') }} {{ __('msg.Name') }}</p>
                        <select id="" class="select2 se2" style="width: 240px;" name="agent_id">

                            @foreach ($agents as $agent)
                                <option value="{{ $agent->id }}" data-id="{{ $agent->id }}">
                                    {{ $agent->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="cashin-agent-phno-container">
                        <p>{{ __('msg.Phone Number') }}</p>
                        <input type="number" placeholder="Enter Agent Phone No"
                            class="inputPhone2 @error('phone')
                            alert-border
                        @enderror"
                            name="phone" disabled />

                    </div>
                    <div class="cashin-agent-coin-container">
                        <p>{{ __('msg.Coin Amount') }}</p>
                        <input type="number" placeholder="Enter Coin Amount" class="inputCoinAmount2"
                            name="coin_amount" disabled />
                    </div>
                </div>

                <div class="cashin-status-payment-remaining-container">
                    <div class="cashin-agent-phno-container">
                        <p>{{ __('msg.Withdraw') }}</p>
                        <input type="number" placeholder="Enter Withdraw amount" name="withdraw"
                            class="@error('withdraw')
                        alert-border
                    @enderror" />
                        @error('withdraw')
                            <small class="error-message">{{ $message }}</small>
                        @enderror

                    </div>
                </div>

                <div class="cashin-btn-container">
                    <button type="submit" class="cashin-confirm-btn">{{ __('msg.Confirm') }}</button>
                    <button type="reset" class="cashin-cancel-btn">{{ __('msg.Cancel') }}</button>
                </div>

                @if (Session::has('cash-out'))
                    <div id="hide">
                        <h4 class="main-cash-alert"> {{ Session::get('cash-out') }} <span class="closeBtn">X</span> </h4>
                    </div>
                @endif
                @if (Session::has('cashout-error'))
                    <div id="hide">
                        <h4 class="error-alert"> {{ Session::get('cashout-error') }} <span class="closeBtn">X</span>
                        </h4>
                    </div>
                @endif
            </form>


            <div class="cashin-list-parent-container">
                <h1>{{ __('msg.Cash Out List') }}</h1>
                <div class="cashin-list-container">
                    <div class="cashin-list-lables-container">
                        <p>{{ __('msg.ID') }}</p>
                        <p>{{ __('msg.Agent') }} {{ __('msg.Name') }}</p>
                        <p>{{ __('msg.Phone Number') }}</p>
                        <p>{{ __('msg.Coin Amount') }}</p>
                        <p>{{ __('msg.Withdraw') }} {{ __('msg.Amount') }}</p>

                    </div>

                    <div class="cashin-list-rows-container">
                        @foreach ($cashin_cashouts as $cashin_cashout)
                            <div class="cashin-list-row">
                                <p>{{ $cashin_cashout->id }}</p>
                                <p>{{ $cashin_cashout->agent->user->name }}</p>
                                <p>{{ $cashin_cashout->agent->user->phone }}</p>
                                <p>{{ $cashin_cashout->coin_amount }}</p>
                                <p>{{ $cashin_cashout->withdraw }}</p>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>


    </div>

    {{-- --------------------------------  Cash Out --------------------------------------- --}}

    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {

            $('.select2').select2();

            var agents = @json($agents);
            var cashin_cashouts = @json($cashin_cashouts);


            $('.inputPhone1').val(agents[0].user.phone);
            $('.inputPhone2').val(agents[0].user.phone);
            // if (cashin_cashouts.length != 0) {
            //     $('.inputRemainingAmount1').val(cashin_cashouts[0].remaining_amount == 0 ? "" : cashin_cashouts[0]
            //         .remaining_amount);
            //     $('.inputCoinAmount2').val(cashin_cashouts[0].coin_amount == 0 ? "" : cashin_cashouts[0]
            //         .coin_amount);
            // }

            $('.inputRemainingAmount1').val(cashin_cashouts[0].remaining_amount == 0 ? "" : cashin_cashouts[0]
                .remaining_amount);
            $('.inputCoinAmount2').val(cashin_cashouts[0].coin_amount == 0 ? "" : cashin_cashouts[0].coin_amount);

            $('.se1').on('change', function() {
                var id = $('.se1').val();
                console.log("Hee Hee");
                agents.forEach(agent => {
                    if (agent.id == id) {
                        $('.inputPhone1').val(agent.user.phone);
                    }
                });
            });
            /////////////////////////////////

            $('.se2').on('change', function() {
                var id = $('.se2').val();
                agents.forEach(agent => {
                    if (agent.id == id) {
                        $('.inputPhone2').val(agent.user.phone);
                    }
                });
            });

            $('.se2').on('change', function() {
                var id = $('.se2').val();
                ind = cashin_cashouts.findIndex(cashin_cashout => {
                    return cashin_cashout.agent_id == id;
                })
                ind != -1 ?  $('.inputCoinAmount2').val(cashin_cashouts[ind].coin_amount) : $('.inputCoinAmount2').val('0');
                console.log("Goad ",ind);

                });
            // });

            // to show remaining amount start
            $('.se1').on('change', function() {
                var id = $('.se1').val();
                ind = cashin_cashouts.findIndex(cashin_cashout => {
                    return cashin_cashout.agent_id == id;
                })
                ind != -1 ?  $('.inputRemainingAmount1').val(cashin_cashouts[ind].remaining_amount) : $('.inputRemainingAmount1').val('');
                console.log("Goad ",ind);

            });
            // to show remaining amount end

        });
    </script>
@endpush
