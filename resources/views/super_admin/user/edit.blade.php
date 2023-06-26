@extends("wellow.layouts.app")
@section('content')
    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            overflow: auto;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice{
            background: #343a40 !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove{
            margin-right: -15px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__rendered li{
            padding-right: 20px;
        }
    </style>
    <div class="content-page">
        <div class="content">
            <div class="row">@include('super_admin.system_setting')</div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-sm-6 portlets">
                    <div class="widget">
                        <div class="widget-header transparent">
                            <h2><strong>Kullanıcı</strong> Düzenle</h2>
                        </div>
                        <div class="widget-content padding">
                            <div id="basic-form">
                                <form role="form" action="{{route('super_admin_user.update', $user->id)}}" method="POST">
                                    <input type="hidden" name="_method" value="patch">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email</label>
                                                <input type="email" class="form-control" name="email" value="@if($user->email!=null){{$user->email}}@endif{{$user->userEMailAddress}}"
                                                       placeholder="Email">
                                            </div>
                                            @if ($errors->has('email'))
                                                <div class="alert alert-danger nomargin">
                                                    {{ $errors->first('email') }}
                                                </div><br>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Kullanıcı Rolü</label>
                                                <select class="form-control" name="role" id="role">
                                                    <option value=""></option>
                                                    @if(count($user->getRoleNames()) == 0)
                                                        @foreach($roles as $key => $role)
                                                            <option @if($user->hasRole($role->name)) @endif value="{{$role->id}}">{{$role->name}}</option>
                                                        @endforeach
                                                    @endif
                                                    @if(count($user->getRoleNames()) == 1)
                                                        @foreach($roles as $key => $role)
                                                            <option @if($user->hasRole($role->name)) selected @endif value="{{$role->id}}">{{$role->name}}</option>
                                                        @endforeach
                                                    @endif
                                                    @if(count($user->getRoleNames()) == 2)
                                                        @foreach($roles as $key => $role)
                                                            <option @if($user->getRoleNames()[0] == $role->name) selected @endif value="{{$role->id}}">{{$role->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            @if ($errors->has('password_confirmation'))
                                                <div class="alert alert-danger nomargin">
                                                    {{ $errors->first('password_confirmation') }}
                                                </div><br>
                                            @endif
                                        </div>

                                        <div class="col-md-6">

                                            @if ($errors->has('password_confirmation'))
                                                <div class="alert alert-danger nomargin">
                                                    {{ $errors->first('password_confirmation') }}
                                                </div><br>
                                            @endif
                                        </div>
                                        <div class="col-md-6">

                                            @if ($errors->has('password_confirmation'))
                                                <div class="alert alert-danger nomargin">
                                                    {{ $errors->first('password_confirmation') }}
                                                </div><br>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <button type="submit" class="btn btn-block btn-secondary btn-lg">Kaydet</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $("#department").select2();
        $.fn.select2.defaults.set("theme", "classic");
        $("#department2").select2();
        $.fn.select2.defaults.set("theme", "classic");
    </script>

@endsection
