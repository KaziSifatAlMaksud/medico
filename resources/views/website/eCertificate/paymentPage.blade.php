@extends('layout.mainlayout', ['activePage' => 'payment'])

@section('content')

  <!-- Check if there is an error message and display it -->
  @if(isset($err) && !empty($err))
  <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
      <strong class="font-bold">Error:</strong>
      <span class="block sm:inline">{{ $err }}</span>
  </div>
@endif
<div class="xl:w-3/4 mx-auto">
    <div class="xsm:mx-4 xxsm:mx-5 pt-10 mb-10">
        <h1 class="font-fira-sans font-medium text-4xl text-left leading-10 pb-5">{{ __('Payment') }}</h1>
    </div>

    <div class="p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-xl font-semibold">{{ __('Amount to Pay: $') }}{{ $amount }}</h2>

        <form action="{{ route('confirm.payment') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @foreach($requestData as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach

            <h2 class="font-fira-sans font-medium mt-4 text-2xl">{{ __('Payment Method') }}</h2>
            <div class="grid grid-cols-1 gap-1 md:grid-cols-4 msm:grid-cols-2">
                <div>
                    <div class="border border-1 border-white-light font-fira-sans paymentDiv text-center p-5" data-attribute="stripe">
                        <img class="m-auto" width="48px" height="20px" src="{{ url('assets/image/logos_stripe.png') }}" alt="">
                        <p class="mt-3 overflow-hidden">{{ __('Stripe') }}</p>
                    </div>
                </div>
                <div>
                    <div class="border border-1 border-white-light font-fira-sans paymentDiv text-center p-4" data-attribute="razorpay">
                        <img class="m-auto" width="29px" height="29px" src="{{ url('assets/image/razorpay.png') }}" alt="">
                        <p class="mt-3 overflow-hidden">{{ __('Razorpay') }}</p>
                    </div>
                </div>
            </div>

            <div class="stripDiv hidden mt-6">
                <div class="form-group text-center">
                    <input type="button" class="btn-submit font-fira-sans text-white !bg-primary w-full text-sm font-normal py-3 cursor-pointer" value="{{ __('Pay with Stripe') }}" />
                </div>
            </div>

            <div class="razorpayDiv text-center mt-5 hidden">
                <input type="hidden" id="RAZORPAY_KEY" value="{{ config('services.razorpay.key') }}">
                <input type="button" id="paybtn" onclick="RazorPayPayment()" value="{{__('Pay with Razorpay')}}" class="font-fira-sans text-white !bg-primary p-3 text-sm font-normal py-3 cursor-pointer">
            </div>

            <div class="mt-6 text-center">
                <button type="submit" class="text-white bg-primary p-3 text-sm font-normal w-40 h-11">
                    {{ __('Confirm Payment') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script src="{{ url('payment/razorpay.js')}}"></script>
<script src="{{ url('payment/stripe.js')}}"></script>
