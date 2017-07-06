<?php

class WxPayConf_pub{
    //微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看
    const APPID = 'wx3498304dda39c5a1';
    //受理商ID，身份标识
    const MCHID = '1236745702';
    //商户支付密钥Key。审核通过后，在微信发送的邮件中查看
    const KEY = 'aeeifj389ej23f8j472evf34ur6dn8di';
    //JSAPI接口中获取openid，审核后在公众平台开启开发模式后可查看
    const APPSECRET = 'a1307fab0a5f2380086a7c636f7339ea';
    
    //=======【JSAPI路径设置】===================================
    //获取access_token过程中的跳转uri，通过跳转将code传入jsapi支付页面
    const JS_API_CALL_URL = 'http://ticket.zhengzai.tv/wxjspay/demo/js_api_call.php';
    
    //=======【证书路径设置】=====================================
    //证书路径,注意应该填写绝对路径
    const SSLCERT_PATH = app_path().'/Tool/wxjspay/cacert/apiclient_cert.pem';
    const SSLKEY_PATH = app_path().'/Tool/wxjspay/cacert/apiclient_key.pem';



}
?>