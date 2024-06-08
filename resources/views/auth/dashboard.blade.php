@extends('auth.layouts')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Dashboard</div>
            <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        {{ $message }}
                    </div>
                @else
                          
                @endif                
           
						<form id="logout-form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
						@csrf
                        <!-- First Name -->
                        <div class="mb-3 row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>
                            <div class="col-md-6">
                                <input id="first_name" type="text" onkeydown="return /[a-z]/i.test(event.key)" maxlength="50" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name', auth()->user()->first_name) }}" required autocomplete="first_name" autofocus>
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

												  <!-- Last Name -->
													<div class="mb-3 row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>
                            <div class="col-md-6">
                                <input id="last_name" type="text" onkeydown="return /[a-z]/i.test(event.key)" maxlength="50" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name', auth()->user()->last_name) }}" autocomplete="last_name">
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-3 row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" maxlength="50" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', auth()->user()->email) }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Mobile Number -->
                        <div class="mb-3 row">
                            <label for="mobile_number" class="col-md-4 col-form-label text-md-right">{{ __('Mobile Number') }}</label>
                            <div class="col-md-6">
                                <input id="mobile_number" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');" minlength="10" maxlength="10"  class="form-control @error('mobile_number') is-invalid @enderror" name="mobile_number" value="{{ old('mobile_number', auth()->user()->mobile_number) }}" required>
                                @error('mobile_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Date of Birth -->
                        <div class="mb-3 row">
                            <label for="date_of_birth" class="col-md-4 col-form-label text-md-right">{{ __('Date of Birth') }}</label>
                            <div class="col-md-6">
                                <input id="date_of_birth" type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth', auth()->user()->date_of_birth) }}" required>
                                @error('date_of_birth')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
												  <!-- Gender -->
													<div class="mb-3 row">
                            <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('Gender') }}</label>
                            <div class="col-md-6">
                                <select id="gender" class="form-control @error('gender') is-invalid @enderror" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ auth()->user()->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ auth()->user()->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="mb-3 row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>
                            <div class="col-md-6">
                                <textarea id="address" class="form-control @error('address') is-invalid @enderror" maxlength="200" name="address" rows="3">{{ old('address', auth()->user()->address) }}</textarea>
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
  <!-- Profile Image -->
	<!-- Display Profile Image -->
<div class="form-group mb-3 row">
    <label for="profile_image" class="col-md-4 col-form-label text-md-right">{{ __('Profile Image') }}</label>
    <div class="col-md-6">
        @if (auth()->user()->profile_image)
            <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Profile Image" class="img-thumbnail" width="100" height="100">
        @else
            <img  src="{{ asset('images/default-profile.png') }}" alt="Default Profile Image" class="img-thumbnail" width="100" height="100">
        @endif
    </div>
</div>

	<div class="mb-3 row">
                            <label for="profile_image" class="col-md-4 col-form-label text-md-right">{{ __('Profile Image') }}</label>
                            <div class="col-md-6">
                                <input id="profile_image" type="file" class="form-control @error('profile_image') is-invalid @enderror" name="profile_image" accept="image/*">
                                @error('profile_image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row mb-0">
                            <div class="col-md-6 offset-md-4">

														
														<div class="mb-3 row">
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="update">
                    </div>
                              
                            </div>
                        </div>
                    </form>
						</div>
        </div>
    </div>    
</div>
    
@endsection