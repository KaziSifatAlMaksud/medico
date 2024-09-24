<!-- resources/views/certificate_index.blade.php -->

@extends('layout.mainlayout', ['activePage' => 'user'])

@section('css')
    <link rel="stylesheet" href="{{ url('assets/css/intlTelInput.css') }}" />
    <style>
        /* Your existing styles */
    </style>
@endsection

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

    <div class="xl:w-3/4 mx-auto">
        <div class="xxsm:mx-5 xl:mx-0 2xl:mx-0 pt-10">
            <div class="flex h-full mb-20 xxsm:flex-col sm:flex-col xmd:flex-row xmd:space-x-5">
                <div class="w-full md:w-full xxmd:w-full xmd:w-80 lg:w-2/3 xlg:w-2/3 1xl:w-full 2xl:w-full sm:ml-0 xxsm:ml-0 shadow-lg overflow-hidden p-5 mt-10 2xl:mt-0 xmd:mt-0">
                    <form action="{{ route('store.certificate') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Name Field -->
                        <div class="flex xxsm:flex-col sm:flex-row justify-center w-full">
                            <div class="mb-3 sm:w-1/2 xxsm:w-full">
                                <label for="name" class="form-label inline-block mb-2 text-gray font-fira-sans">{{ __('Name') }}</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control block w-full font-fira-sans px-3 py-1.5 text-base font-normal text-gray bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray focus:outline-none" id="name" placeholder="{{ __('Name') }}" readonly />
                                @error('name')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                    
                            <!-- Email Field -->
                            <div class="mb-3 sm:w-1/2 xxsm:w-full sm:ml-2 xxsm:ml-0">
                                <label for="email" class="form-label inline-block mb-2 text-gray font-fira-sans">{{ __('Email') }}</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray focus:outline-none" id="email" placeholder="{{ __('Email') }}" readonly />
                                @error('email')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    
                        <!-- Phone and Gender Fields -->
                        <div class="flex xxsm:flex-col sm:flex-row justify-center w-full">
                            <div class="mb-3 sm:w-1/2 xxsm:w-full sm:ml-2 xxsm:ml-0">
                                <label for="phone" class="form-label inline-block mb-2 text-gray font-fira-sans">{{ __('Phone Number') }}</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone_code . ' ' . $user->phone) }}" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray focus:outline-none" id="phone" placeholder="{{ __('Phone Number') }}" readonly />
                                @error('phone')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                    
                            <div class="mb-3 sm:w-1/2 xxsm:w-full sm:ml-2 xxsm:ml-0">
                                <label for="gender" class="form-label inline-block mb-2 text-gray font-fira-sans">{{ __('Gender') }}</label>
                                <input type="text" name="gender" value="{{ old('gender', $user->gender) }}" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray focus:outline-none" id="gender" placeholder="{{ __('Gender') }}" readonly />
                                @error('gender')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    
                        <!-- Language and Prescription Fields -->
                        <div class="flex xxsm:flex-col sm:flex-row justify-center w-full">
                            <div class="mb-3 sm:w-1/2 xxsm:w-full sm:ml-2 xxsm:ml-0">
                                <label for="language" class="form-label inline-block mb-2 text-gray font-fira-sans">{{ __('Language') }}</label>
                                <select name="language" class="form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray bg-clip-padding bg-no-repeat border border-solid border-gray-light rounded transition ease-in-out m-0 focus:text-gray focus:outline-none" aria-label="Default select example" disabled>
                                    @foreach ($languages as $language)
                                        <option class="font-fira-sans" value="{{ $language->name }}" {{ $language->name == $user->language ? 'selected' : '' }}>{{ $language->name }}</option>
                                    @endforeach
                                </select>
                                @error('language')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 sm:w-1/2 xxsm:w-full sm:ml-2 xxsm:ml-0">
                                <label for="medical_attention_days" class="form-label inline-block mb-2 text-gray font-fira-sans">{{ __('Medical Attention Days') }}</label>
                                <input type="number" name="medical_attention_days" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray focus:outline-none" id="medical_attention_days" placeholder="{{ __('Medical Attention Days') }}" required />
                                @error('medical_attention_days')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                    
                            <div class="mb-3 sm:w-1/2 xxsm:w-full sm:ml-2 xxsm:ml-0">
                                <label for="prescription" class="form-label inline-block mb-2 text-gray font-fira-sans">{{ __('Upload Prescription') }}</label>
                                <input type="file" name="prescription" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray focus:outline-none" id="prescription" />
                                @error('prescription')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                                   <!-- Issues Field -->
                                   <div class="flex w-full">
                                    <div class="mb-1 w-full">
                                        <label for="gender" class="form-label inline-block mb-2 text-gray font-fira-sans">{{ __('Address') }}</label>
                                <input type="text" name="address" value="{{ old('address', $user->address) }}" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray focus:outline-none" id="gender" placeholder="{{ __('address') }}" />
                                @error('gender')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                                    </div>
                                </div>

                        <!-- Issues Field -->
                        <div class="flex w-full">
                            <div class="mb-1 w-full">
                                <label for="issues" class="form-label inline-block mb-2 text-gray font-fira-sans">{{ __('Issues') }}</label>
                                <textarea name="issues" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray focus:outline-none" id="issues" rows="4" placeholder="{{ __('Enter your issues here...') }}">{{ old('issues') }}</textarea>
                                @error('issues')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    
                        <!-- Submit Button -->
                        <div class="flex justify-between w-full xxsm:flex-col msm:flex-row">
                            <div class="w-full mb-4 flex msm:justify-end xxsm:justify-start">
                                <button class="px-6 py-3 font-fira-sans border border-primary text-white bg-primary rounded-md font-medium text-xs leading-tight uppercase focus:outline-none focus:ring-0 transition duration-150 ease-in-out" type="submit" id="button-addon3">
                                    {{ __('Generate') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="{{ url('assets/js/intlTelInput.min.js') }}"></script>
<script>
    const phoneInputField = document.querySelector(".phone");
    const phoneInput = window.intlTelInput(phoneInputField, {
        preferredCountries: ["us", "co", "in", "de"],
        initialCountry: "in",
        separateDialCode: true,
        utilsScript: "{{url('assets/js/utils.js')}}",
    });
    phoneInputField.addEventListener("countrychange", function() {
        var phone_code = $('.phone').find('.iti__selected-dial-code').text();
        $('input[name=phone_code]').val('+' + phoneInput.getSelectedCountryData().dialCode);
    });

    $(document).ready(function() {
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var type = $('#imagePreview').attr('data-id');
                    var fileName = document.getElementById("image").value;
                    var idxDot = fileName.lastIndexOf(".") + 1;
                    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
                    if (extFile == "jpg" || extFile == "jpeg" || extFile == "png") {
                        $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                        $('#imagePreview').hide();
                        $('#imagePreview').fadeIn(650);
                    } else {
                        $('input[type=file]').val('');
                        alert("Only jpg/jpeg and png files are allowed!");
                        if (type == 'add') {
                            $('#imagePreview').css('background-image', 'url()');
                            $('#imagePreview').hide();
                            $('#imagePreview').fadeIn(650);
                        }
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#image").change(function() {
            readURL(this);
        });
    });
</script>
@endsection
