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
            margin-top: 10px;
            color: white;
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

        .closeBtn2 {
            color: #ddd;
            cursor: pointer;
            float: right;
        }
        .backBtn{
            color: white;
            background-color: #3C3C3C;
            padding: 7px;
            width: 60px;
            border-radius: 5px;
            text-align: center;
            border: 1px solid #3C3C3C;
            margin-bottom: 10px;

        }
        .backBtn:hover {
            background-color: #fff;
            color: #3C3C3C;
            border: 1px solid #3C3C3C;
        }
    </style>
@endsection

@section('title', 'Referee')
@section('content')
<a href="{{ url()->previous() }}" class="backBtn"><i class="fa-solid fa-left-long fa-2xl"></i></a>

    <!--cash in/cash out start-->
    <div class="cashinout-parent-container">
        <div class="cashinout-categories-container">
            <p class="cashinout-category cashinout-category-active" id="cash_in">{{ __('msg.Cash In') }}</p>
        </div>


        {{-- -------------------------------- Cash In-------------------------------- --}}
        <div class="cashin-parent-container">
            <form action="{{ route('cashin.update', $cashin->id) }}" method="POST"
                class="cashin-agent-inputs-parent-container">
                @csrf
                <div class="cashin-agent-name-ph-coin-container">
                    <div class="cashin-agent-name-container">
                        <p>{{ __('msg.Agent') }} {{ __('msg.Name') }}</p>
                        <input type="text" value="{{ $usr->name }}" name="name" disabled />
                        </select>
                    </div>
                    <div class="cashin-agent-phno-container">
                        <p>{{ __('msg.Phone Number') }}</p>
                        <input type="number" placeholder="Enter Agent Phone No" value="{{ $usr->phone }}" name="phone"
                            disabled />

                    </div>
                    <div class="cashin-agent-coin-container">
                        <p>{{ __('msg.Coin Amount') }}</p>
                        <input type="number" placeholder="Enter Coin Amount" value="{{ $cashin->coin_amount }}"
                            class="inputCoinAmount1 @error('coin_amount')
                            alert-border
                        @enderror"
                            name="coin_amount" disabled />

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
                        <p>Remaining Amount</p>
                        <input type="number" placeholder="" name="remaining_amount" class="inputRemainingAmount1"
                            value="{{ $cashin->remaining_amount }}" disabled />

                        @error('payment')
                            <small class="error-message">{{ $message }}</small>
                        @enderror

                    </div>

                </div>

                <div class="cashin-btn-container">
                    <button type="submit" class="cashin-confirm-btn">{{ __('msg.Confirm') }}</button>
                    <button type="reset" class="cashin-cancel-btn">{{ __('msg.Cancel') }}</button>
                </div>

                @if (Session::has('error'))
                    <div id="hide2">
                        <h4 class="error-alert"> {{ Session::get('error') }} <span class="closeBtn2">X</span> </h4>
                    </div>
                @endif

            </form>
        </div>


    </div>


    </div>

@endsection

@push('script')
    <script>
        $(document).ready(function() {

            $('.select2').select2();
            var closeBtn2 = document.querySelector(".closeBtn2");

            var hide2 = document.querySelector("#hide2");

            closeBtn2.addEventListener("click", function() {
                console.log("Hee Hee har harr");

                console.log(hide2);

                hide2.style.visibility = 'hidden';
            });
        });
    </script>
@endpush
