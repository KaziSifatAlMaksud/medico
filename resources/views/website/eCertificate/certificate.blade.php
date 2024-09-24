@extends('layout.mainlayout', ['activePage' => 'Medical Certificate'])

@section('content')

@if(session('success'))
    <div class="bg-green-500 text-white p-4 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if(session('err'))
    <div class="bg-red-500 text-white p-4 rounded mb-4">
        {{ session('err') }}
    </div>
@endif


@if(!$certificate)
<div class="pt-14 border-b border-white-light mb-10 pb-10 m-4">
    <h1 class="font-fira-sans font-semibold text-5xl text-center leading-10 mb-8">
        {{ __('Conditions for Issuing a Digital Leave Certificate') }}
    </h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 ">
        <!-- Card 1 -->
        <div class="border border-gray-300 rounded-lg shadow-md p-6">
            <div class="flex items-center justify-center mb-4">
                
            </div>
            <h2 class="font-fira-sans font-semibold text-xl text-center mb-4">{{ __('Current Day Prescription') }}</h2>
            <p class="font-fira-sans font-normal text-gray-700 text-center">
                {{ __('The leave certificate will only be issued if a valid prescription is provided from a consultation that took place on the present day.') }}
            </p>
        </div>
    
        <!-- Card 2 -->
        <div class="border border-gray-300 rounded-lg shadow-md p-6">
            <div class="flex items-center justify-center mb-4">
               
            </div>
            <h2 class="font-fira-sans font-semibold text-xl text-center mb-4">{{ __('Mandatory Prescription Upload') }}</h2>
            <p class="font-fira-sans font-normal text-gray-700 text-center">
                {{ __('Uploading the prescription is a mandatory requirement for the issuance of the leave certificate. Without it, the request cannot be processed.') }}
            </p>
        </div>
    
        <!-- Card 3 -->
        <div class="border border-gray-300 rounded-lg shadow-md p-6">
            <div class="flex items-center justify-center mb-4">
             
            </div>
            <h2 class="font-fira-sans font-semibold text-xl text-center mb-4">{{ __('Processing Time and Refunds') }}</h2>
            <p class="font-fira-sans font-normal text-gray-700 text-center">
                {{ __('The digital leave certificate will be available for download within 1-2 hours of submission. If your request is rejected, a refund will be initiated promptly.') }}
            </p>
        </div>
    </div>
    
</div>  

<div class="xl:w-3/4 mx-auto disBlog mb-20">
    <div class="flex justify-center mt-20 font-fira-sans font-normal text-base text-gray">
        <div class="btn-appointment mx-0 mt-3 absolute xxsm:relative xsm:relative sm:absolute">
            <a class="btn btn-link text-center mt-0 rounded-none bg-primary text-white font-normal font-fira-sans text-md py-3.5 px-7" href="{{ url('/certificate-generate') }}" role="button">
                {{ __('Create Certificate') }}
            </a>
        </div>
    </div>
</div>
@elseif($certificate->status == '0')
    <div class="pt-14 border-b border-white-light mb-10 pb-10">
        <h1 class="font-fira-sans font-semibold text-5xl text-center leading-10">
            {{ __('Your request has been sent') }}
        </h1>
        <div class="p-5">
            <p class="font-fira-sans font-normal text-lg text-center leading-5 text-gray">
                {{ __('You will receive Certificate soon') }}
            </p>
        </div>
    </div>
@elseif($certificate->status == 'delete')
    <div class="pt-14 border-b border-white-light mb-10 pb-10">
        <h1 class="font-fira-sans font-semibold text-5xl text-center leading-10">
            {{ __('Sorry') }}
        </h1>
        <div class="p-5">
            <p class="font-fira-sans font-normal text-lg text-center leading-5 text-gray">
                {{ __('Your request has been deleted.') }}
            </p>
        </div>
    </div>
@else


<div class="pt-14 border-b border-white-light mb-10 pb-10">
    <h1 class="font-fira-sans font-semibold text-5xl text-center leading-10">
        {{ __('Your Certificate') }}
    </h1>
    <div class="xl:w-3/4 mx-auto disBlog mb-20">
        <div class="flex justify-center mt-10 font-fira-sans font-normal text-base text-gray">
            <div class="btn-appointment mx-0 mt-3 absolute xxsm:relative xsm:relative sm:absolute">
                <a class="btn btn-link text-center mt-0 rounded-none bg-primary text-white font-normal font-fira-sans text-md py-3.5 px-7" href="{{ url('/download-certificate', ['id' => Auth::user()->id]) }}" role="button">
                    {{ __('Download') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@section('js')
@endsection
