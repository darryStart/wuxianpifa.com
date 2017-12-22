@extends('admin.master')

@section('content')
    <link href="{{URL::asset('/admin/css/H-ui.login.css')}}" rel="stylesheet" type="text/css" />
    <div class="header"></div>
    <div class="loginWraper">
        <div id="loginform" class="loginBox">
            <form class="form form-horizontal" action="" method="post">
                <div class="row cl">
                  <label class="form-label col-3"><i class="Hui-iconfont">&#xe60d;</i></label>
                  <div class="formControls col-8">
                    <input id="" name="username" type="text" placeholder="账户" class="input-text size-L">
                  </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-3"><i class="Hui-iconfont">&#xe60e;</i></label>
                    <div class="formControls col-8">
                        <input id="" name="password" type="password" placeholder="密码" class="input-text size-L">
                    </div>
                </div>


                <div class="row cl">
                    <div class="formControls col-8 col-offset-3">
                        <input class="input-text size-L" type="text" name="code" placeholder="验证码" value="" style="width:150px;">
                        <img src="{{url('/service/validate_code/create')}}" class="captcha ml-30" height="41px" onclick="javascript:re_captcha();">
                    </div>
                </div>
                <div class="row">
                    <div class="formControls col-8 col-offset-3">
                        <input onclick="onLogin();" name="" type="button" class="btn btn-success radius size-L" value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">
                        <input name="" type="reset" class="btn btn-default radius size-L" value="&nbsp;取&nbsp;&nbsp;&nbsp;&nbsp;消&nbsp;">
                    </div>
                </div>
            </form>
        </div>
    </div>
  <div class="footer">微商城后台管理系统</div>
@endsection

@section('my-js')
<script type="text/javascript">
    function onLogin() {
        var username = $('input[name=username]').val();
        var password = $('input[name=password]').val();
        var code = $('input[name=code]').val();
        $.ajax({
            type: 'post', // 提交方式 get/post
            url: '{{url('/admin/service/login')}}', // 需要提交的 url
            dataType: 'json',
            data: {
              username: username,
              password: password,
              code:code,
              _token: "{{csrf_token()}}"
            },
            success: function(data) {
              if(data == null) {
                layer.msg('服务端错误', {icon:2, time:2000});
                return;
              }
              if(data.status != 0) {
                layer.msg(data.message, {icon:2, time:2000});
                return;
              }

              location.href = '{{url('/admin/index')}}';
            },
            error: function(xhr, status, error) {
              layer.msg('ajax error', {icon:2, time:2000});
            },
            beforeSend: function(xhr){
              layer.load(0, {shade: false});
            }
        });
    }

    function re_captcha() {
        var url = "{{url('/service/validate_code/create')}}" + "?" + Math.random();
        $('.captcha').attr('src',url);
    }
</script>
@endsection
