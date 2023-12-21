@extends('layouts.app')
@section('content')
<div class="login-container">
    <div class="right" style="background-color: #2A3042">
        <div></div>
        <div class="middle" >
           <p style="text-align: left; margin-left: 15px">
             "We are family ,Although We are not bonded by blood but We shared laughter, dreams, and the unwavering support that turns ordinary moments into extraordinary memories."</p>
        </div>
        <div>
            {{-- <div class="bottom">
                <div class="icon">
                    <span class="bx bx-left-arrow-alt"></span>
                </div>
                <div class="icon">
                    <span class="bx bx-right-arrow-alt"></span>
                </div>
            </div> --}}
        </div>
    </div>
    <div class="left">
        <div class="top">
            <div class="img">
                <img style="width: 200px" src="{{ asset('assets/brotherhood.png')}}" alt="">
            </div>
            <div class="date">
                {{ date('d, M-Y')}}
            </div>
        </div>
        <div class="middle">
            <form id="user_auth">
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="">Username</label>
                        <input type="text" class="form-control" placeholder="write Username" name="username" required>
                    </div>
                    <div class="col-md-12" style="margin-top: 20px ">
                        <label for="">Password</label>
                        <div class="input-group auth-pass-inputgroup">
                            <input type="password" class="form-control" name="password"  placeholder="Enter password" aria-label="Password" aria-describedby="password-addon">
                            <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                        </div>
                    </div>
                </div>
                <div class="form-group row" style="margin-top: 20px ">
                    <div class="col-md-6">
                        <label class="container">Remember Me
                            <input type="checkbox" checked="checked">
                            <span class="checkmark"></span>
                          </label>
                    </div>
                    <div class="col-md-6">
                        <a href="#"> <span class="mdi mdi-lock me-1"></span> Forgot your Password </a>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12" id="user_auth_alert" style="margin-top: 10px">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="mt-3 d-grid">
                            <button class="btn btn-primary waves-effect waves-light"  id="user_btn" type="submit"> <span class="fas fa-sign-in-alt"></span> Sign In</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="bottom">
           <p>© <script>document.write(new Date().getFullYear())</script>Designed and Developed by <span id="tag">USK </span></p>
        </div>
    </div>
   

</div>
    
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $('#user_auth').on('submit',function(e){
            e.preventDefault();
         var dataz =$(this).serialize();
            $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
            });
  
        $.ajax({
        type:'POST',
        url:"{{ route('authenticate.user')}}",
        data:dataz,
        success:function(response){
            console.log(response);
            $.notify(response.message, "success");
          setTimeout(function(){
            window.location.href=response.url;
          },500);
         
        },
        error:function(response){
            console.log(response.responseText);
            if (jQuery.type(response.responseJSON.errors) == "object") {
              $('#user_auth_alert').html('');
            $.each(response.responseJSON.errors,function(key,value){
                $('#user_auth_alert').append('<div class="alert alert-danger">'+value+'</div>');
            });
            } else {
               $('#user_auth_alert').html('<div class="alert alert-danger">'+response.responseJSON.errors+'</div>');
            }
        },
        beforeSend : function(){
            $('#user_btn').html('<span class="fas fa-spinner fas-pulse fas-spin"></span> Authenticating ---');
            $('#user_btn').attr('disabled', true);
        },
       complete : function(){
            $('#user_btn').html('<span class="fas fa-sign-in-alt"></span> Sign In');
            $('#user_btn').attr('disabled', false);
        }
        });
    });
    });
  </script>
    
@endpush