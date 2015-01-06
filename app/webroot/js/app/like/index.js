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
	  	function (pos){
        alert("GPSをOnにしてください");
      });
	} else {
    alert("GPSをOnにしてください");
  }


  $('p').click(function(){
    // リンクに現在地情報を付与

    var action = $('#add').attr('action');
    action += "?lat=" + lat + "&lng=" + lng;
    $('#add').attr('action', action);
    return true;
  });


});
	
