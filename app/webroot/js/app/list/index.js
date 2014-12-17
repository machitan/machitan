$(function(){

  var lat = null;
  var lng = null;

	if (navigator.geolocation) {
    // 位置情報を取得する
		navigator.geolocation.getCurrentPosition(
	  	// 位置情報取得成功時
	  	function (pos) { 
	  			lat = pos.coords.latitude;
	  			lng = pos.coords.longitude;
	  	},
	  	// 位置情報取得失敗時
	  	function (pos){});
	} else {
    alert("GPSをOnにしてください");
  }

  $('a').click(function(){

    // リンクに現在地情報を付与
    var href = $(this).attr('href');
    href += "&lat=" + lat + "&lng=" + lng;
    $(this).attr('href', href);

    return true;
  });

});
	
