<?php

namespace App\Http\Middleware;


use Closure;
use Session;
use DB;

class CheckWeixin
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $openid = Session::get('user','');
        if(!$openid){
            $get = $request->input('param', '');
            $code = $request->input('code', '');
          
            if($get == 'access_token' && !empty($code)){
                $json = $this->get_access_token($code);
                if(!empty($json)){
                    $userinfo = $this->get_user_info($json['access_token'],$json['openid']);
                    $data = DB::table('user')->where('openid',$userinfo['openid'])->first();
                    
                    if(empty($data)){

                        $input = array(
                            'nickname' => $userinfo['nickname'],
                            'header_img' => $userinfo['headimgurl'],
                            'addr' => $userinfo['country'].'-'.$userinfo['province'].'-'.$userinfo['city'],
                            'openid' => $userinfo['openid'],
                            'add_id' => 0,
                            'active' => 0
                        );

                        $uid = DB::table('user')->insertGetId($input);

                        $input['id'] = $uid;
                        Session::set('user',$input);
                    }else{
                        Session::set('user',json_decode(json_encode($data),true));
                    }

                    return $next($request);
                }
            }else{
                $this->get_authorize_url(config('wechat.app_uri').'?param=access_token','STATE');
            }
        }
        return $next($request);
    }

    /**
     * 获取授权token
     *
     * @param string $code 通过get_authorize_url获取到的code
     */
    private function get_access_token($code = '')
    {
        $token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".config('wechat.app_id')."&secret=".config('wechat.secret')."&code={$code}&grant_type=authorization_code";
        $token_data = $this->http($token_url);
        if(!empty($token_data[0]))
        {
            return json_decode($token_data[0], TRUE);
        }
        return FALSE;
    }


    /**
     * 获取授权后的微信用户信息
     * @param string $access_token
     * @param string $open_id
     */
    private function get_user_info($access_token = '', $open_id = '')
    {
        if($access_token && $open_id)
        {
            $access_url = "https://api.weixin.qq.com/sns/auth?access_token={$access_token}&openid={$open_id}";
            $access_data = $this->http($access_url);
            $access_info = json_decode($access_data[0], TRUE);
            if($access_info['errmsg']!='ok'){
                exit('页面过期');
            }
            $info_url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$open_id}&lang=zh_CN";
            $info_data = $this->http($info_url);
            if(!empty($info_data[0]))
            {
                return json_decode($info_data[0], TRUE);
            }
        }
        return FALSE;
    }


    /**
     * 获取微信授权链接
     *
     * @param string $redirect_uri 跳转地址
     * @param mixed $state 参数
     */
    private function get_authorize_url($redirect_uri = '', $state = '')
    {
        $redirect_uri = urlencode($redirect_uri);
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".config('wechat.app_id')."&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_userinfo&state={$state}#wechat_redirect";
        echo "<script language='javascript' type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
    }

    /**
     * Http方法 请求网络数据
     *
     */
    private function http($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $output = curl_exec($ch);//输出内容
        curl_close($ch);
        return array($output);
    }

}
