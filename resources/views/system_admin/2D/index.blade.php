@extends('system_admin.layouts.app')
@section('title', '2D')


@section('content')
<div class="container-fluid">

            <div class="refree-btns-parent-container">
                <div class="refree-btns-container"></div>

                <div class="refree-customer-infos-inputs-container">
                    <div class="refree-customer-name-phno-input-container">
                        <div class="refree-customer-name-input-container">
                            <p>Name:</p>
                            <input type="text"/>
                        </div>
                        <div class="refree-customer-phno-input-container">
                            <p>PhNo:</p>
                            <input type="tel"/>
                        </div>

                        {{-- <div class="refree-customer-type-container">
                            <p>Choose the type of customer</p>
                            <div class="customer-type-radios-container">
                                <input type="radio" name="customer type" value="guest"
                            </div>
                        </div> --}}

                        <button class="refree-customer-name-phno-submit-btn">Add</button>
                    </div>

                    <div class="refree-customer-number-amount-container">
                        <div class="refree-customer-number-input-container">
                            <p>Number:</p>
                            <input type="number"/>
                        </div>
                        <div class="refree-customer-amount-input-container">
                            <p>Amount:</p>
                            <div class="refree-customer-amount-input">
                                <button class="minus-btn">-</button>
                                <input type="number"/>
                                <button class="plus-btn">+</button>
                            </div>
                        </div>

                        <button class="refree-customer-number-amount-submit-btn">Add</button>
                    </div>
                </div>
            </div>


            <!-- MAIN CONTENT AREA ENDS -->


</div>


@endsection

@section("script")

<script src="{{asset('assets/js/refreesale.js')}}"></script>

@endsection
