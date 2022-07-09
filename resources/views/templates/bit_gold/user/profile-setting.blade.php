@extends($activeTemplate.'layouts.master')
@section('content')

    @include($activeTemplate.'partials.user-breadcrumb')
<section class="cmn-section">
    <div class="container">
            <div class="card">
                <form action="" method="post" enctype="multipart/form-data">
                        @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="avatar-upload">
                                <div class="avatar-edit">
                                    <input type='file' name="image" id="imageUpload" class="upload" accept=".png, .jpg, .jpeg" />
                                    <label for="imageUpload" class="imgUp"></label>
                                </div>
                                <div class="avatar-preview">
                                    <div class="imagePreview" style="background-image: url({{ get_image('assets/images/user/profile/'.$user->image) }})">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('First Name')</label>
                                        <input type="text" name="firstname" class="form-control form-control-lg" placeholder="@lang('First Name')" value="{{ __($user->firstname) }}">        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('Last Name')</label>
                                        <input type="text" name="lastname" class="form-control form-control-lg" placeholder="@lang('Last Name')" value="{{ __($user->lastname) }}">        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('Username')</label>
                                        <input type="text" name="username" class="form-control form-control-lg" placeholder="@lang('Username')" value="{{ __($user->username) }}" readonly>        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('Email')</label>
                                        <input type="text" name="email" class="form-control form-control-lg" placeholder="@lang('Email')" value="{{ __($user->email) }}" readonly>        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('Mobile')</label>
                                        <input type="text" name="mobile" class="form-control form-control-lg" placeholder="@lang('Mobile')" value="{{ __($user->mobile) }}">        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('Country')</label>
                                        <select class="form-control form-control-lg" name="country">
                                            <option value="">@lang('-- Select One --')</option>
                                            @include('partials.country')
                                        </select>       
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('Address')</label>
                                        <input type="text" name="address" class="form-control form-control-lg" placeholder="@lang('Address')" value="{{ __(@$user->address->address) }}">        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('State')</label>
                                        <input type="text" name="state" class="form-control form-control-lg" placeholder="@lang('State')" value="{{ __(@$user->address->state) }}">        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('Zip')</label>
                                        <input type="text" name="zip" class="form-control form-control-lg" placeholder="@lang('Zip')" value="{{ __(@$user->address->zip) }}">        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('City')</label>
                                        <input type="text" name="city" class="form-control form-control-lg" placeholder="@lang('City')" value="{{ __(@$user->address->city) }}">        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-md w-100 cmn-btn">@lang('Update')</button>
                </div>
                </form>
            </div>
        </div>
</section>
@endsection



@push('style')
<style type="text/css">
.avatar-upload {
    position: relative;
    max-width: 205px;
    margin: 20px auto;
}
.avatar-upload .avatar-edit {
    position: absolute;
    z-index: 1;
    bottom: 0px;
    right: 31px;
}
.avatar-upload .avatar-edit input {
    display: none;
}
.avatar-upload .avatar-edit label {
    display: inline-block;
    width: 34px;
    height: 34px;
    margin-bottom: 0;
    border-radius: 100%;
    background: #FFFFFF;
    border: 1px solid transparent;
    box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
    cursor: pointer;
    font-weight: normal;
    transition: all .2s ease-in-out;
}
.avatar-upload .avatar-edit label:hover {
    background: #F1F1F1;
    border-color: #D6D6D6;
}
.avatar-upload .avatar-edit label:after {
    content: "\f044";
    font-family: 'Font Awesome 5 Free';
    color: #757575;
    position: absolute;
    top: 5px;
    left: 1px;
    right: 0;
    text-align: center;
    margin: auto;
}
.avatar-preview {
    width: 192px;
    height: 192px;
    position: relative;
    border-radius: 50%;
    border: 6px solid #e4e4e4;
    box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
}
.avatar-preview div {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
}
.copytextDiv{
    cursor: pointer;
}
</style>
@endpush
@push('script')
<script>
    (function ($) {
        "use strict";
        $('.imgUp').click(function(){
            upload();
        });
        function upload(){
            $(".upload").change(function() {
                readURL(this);
            });
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    var preview = $(input).parents('.avatar-upload').find('.imagePreview');
                    $(preview).css('background-image', 'url('+e.target.result +')');
                    $(preview).hide();
                    $(preview).fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $('select[name=country]').val('{{ $user->address->country }}');
    })(jQuery);
</script>
@endpush
