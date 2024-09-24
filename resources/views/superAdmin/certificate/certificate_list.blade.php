@extends('layout.mainlayout_admin', ['activePage' => 'certificate'])

@section('title', __('Medical Certificates'))
@section('content')

<section class="section">
    @include('layout.breadcrumb', [
        'title' => __('Medical Certificates'),
    ])
    @if (session('status'))
        @include('superAdmin.auth.status', [
            'status' => session('status')
        ])
    @endif
        <!-- Success Message -->
        @if(session('success'))
        <div class="alert alert-primary">{{ session('success') }}</div>
    @endif
    
    
    <div class="section_body">

        <div class="flex flex-col items-center justify-center min-h-screen space-y-6 mb-4">
     
            <!-- Form -->
            <form class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4"
                  action="{{ route('certificate.price.update') }}" method="POST">
                @csrf
                <!-- Number Input Field -->
                <input type="number" 
                       name="price"
                       value="{{ $price ? (int)$price->price : '' }}"
                       placeholder="Enter price" 
                       class="border border-gray-300 p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       required>
            
                <!-- Submit Button -->
                <button type="submit" 
                      class="btn btn-primary" > Submit
                </button>
            </form>
        </div>
        
        
 
        <div class="card">
           
            <div class="card-body">
                <div class="table-responsive">
                    <table class="datatable table table-hover table-center mb-0">
                        <thead>
                            <tr>
                                <th>
                                    <input name="select_all" value="1" id="master" type="checkbox" />
                                    <label for="master"></label>
                                </th>
                                <th>#</th>
                                <th>{{ __('Patient Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Medical Attention Days') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Prescription') }}</th>
                                @if (Gate::check('certificate_edit') || Gate::check('certificate_delete'))
                                    <th>{{ __('Actions') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($certificates as $certificate)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="id[]" value="{{ $certificate->id }}" id="{{ $certificate->id }}" data-id="{{ $certificate->id }}" class="sub_chk">
                                        <label for="{{ $certificate->id }}"></label>
                                    </td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $certificate->name }}</td>
                                    <td>
                                        <a href="mailto:{{ $certificate->email }}">
                                            <span class="text_transform_none">{{ $certificate->email }}</span>
                                        </a>
                                    </td>
                                    <td>{{ $certificate->medical_attention_days }}</td>
                                    <td>{{ $certificate->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        @if ($certificate->prescription)
                                            <a href="{{ asset($certificate->prescription) }}" target="_blank">
                                                <img src="{{ asset($certificate->prescription) }}" alt="Prescription" style="max-width: 100px;">
                                            </a>
                                        @else
                                            {{ __('No Image') }}
                                        @endif
                                    </td>
                                    @if (Gate::check('certificate_edit') || Gate::check('certificate_delete'))
                                    <td>
                                        @can('certificate_edit')
                                            <form action="{{ route('certificate.send', $certificate->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="text-success" style="border:none; background:none;">
                                                    <i class="fa fa-paper-plane"></i>
                                                </button>
                                            </form>
                                        @endcan
                                
                                        @can('certificate_delete')
                                            <form action="{{ route('certificate.delete', $certificate->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="text-danger" style="border:none; background:none;">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                @endif
                                
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card_footer">
                <input type="button" value="Delete Selected" onclick="deleteAll('certificate_all_delete')" class="btn btn-primary">
            </div>
        </div>
    </div>
</section>

@endsection
