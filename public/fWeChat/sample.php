<?php
require_once "jssdk.php";
$jssdk = new JSSDK("wx68b360e27ec55883", "f063ecc66a063211912b42892b28701d");
$signPackage = $jssdk->GetSignPackage();
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>天气预报</title>
  <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css">
  <script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
  <script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>

</head>

<style>
  .ui-bar-f
  {
    color:red;  
    background-color:red;
  }
  .ui-body-f
  {
    color:white;
  }
</style>
  
<body>
  <meta charset="UTF-8">
  <div data-role="page" id="pageone" data-theme="a"  style="background:url(images/biz_plugin_weather_shenzhen_bg.jpg) 50% 0 no-repeat;background-size:cover">>
    <div data-role="content">
     <div class="ui-grid-a">
       <div class="ui-block-a" align="center">
         <p style="font-size:70px"><span id="city"></span></p>
         <p style="font-size:40px"><span id="district"></span> <span id="street"></span></p>
         <p style="font-size:50px">今天 <span id="update_time"></span> 发布</p>
         <p style="font-size:50px">湿度: <span id="shidu"></span></p>
       </div>
       <div class="ui-block-b" align="center">
         <br>
         <br>
         <a href="#"><img src="images/biz_plugin_weather_0_50.png"></a>
         <p style="font-size:50px">PM2.5: <span id="pm25"></span></p>
         <p style="font-size:50px">空气质量: <span id="quality"></span></p>
       </div>
     </div>
    </div>
    <div data-role="content">
     <div class="ui-grid-a">
       <div class="ui-block-a" align="right">
         <a href="#"><img src="images/biz_plugin_weather_qing.png"></a>
       </div>
       <div class="ui-block-b" align="left">
         <p style="font-size:50px"><span id="week"></span></p>
         <p style="font-size:50px"><span id="high1"></span>~<span id="low1"></span></p>
         <p style="font-size:45px"><span id="fx"></span> <span id="type"></span></p>
       </div>
     </div>
    </div>
    <div data-role="content">
      <div class="ui-grid-b">
       <div class="ui-block-a" align="center">
         <a href="#"><img src="images/biz_plugin_weather_qing.png"></a>
         <p style="font-size:45px"><span id="week_next1"></span></p>
         <p style="font-size:45px"><span id="high1_next1"></span>~<span id="low1_next1"></span></p>
         <p style="font-size:40px"><span id="fx_next1"></span> <span id="type_next1"></span></p>
       </div>
       <div class="ui-block-b" align="center">
         <a href="#"><img src="images/biz_plugin_weather_qing.png"></a>
         <p style="font-size:45px"><span id="week_next2"></span></p>
         <p style="font-size:45px"><span id="high1_next2"></span>~<span id="low1_next2"></span></p>
         <p style="font-size:40px"><span id="fx_next2"></span> <span id="type_next2"></span></p>
       </div>
       <div class="ui-block-c" align="center">
         <a href="#"><img src="images/biz_plugin_weather_qing.png"></a>
         <p style="font-size:45px"><span id="week_next3"></span></p>
         <p style="font-size:45px"><span id="high1_next3"></span>~<span id="low1_next3"></span></p>
         <p style="font-size:40px"><span id="fx_next3"></span> <span id="type_next3"></span></p>
       </div>
      </div>
    </div>
  </div> 
</body>
  
  
  
  
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
  /*
   * 注意：
   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
   *
   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
   * 邮箱地址：weixin-open@qq.com
   * 邮件主题：【微信JS-SDK反馈】具体问题
   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
   */
  wx.config({
    debug: false,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
      // 所有要调用的 API 都要加到这个列表中
      'openLocation',
      'getLocation'
    ]
  });
  wx.ready(function () {
    // 在这里调用 API
    wx.getLocation({
    type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
    success: function (res) {
    var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
    var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
    var speed = res.speed; // 速度，以米/每秒计
    var accuracy = res.accuracy; // 位置精度
    

    document.write(latitude);
    }
});
  });
</script>
</html>
