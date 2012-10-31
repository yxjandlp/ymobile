<?php Yii::app()->clientScript->registerScriptFile('http://api.map.baidu.com/api?v=1.3');?>
<div id="l-map"></div>
<div id="r-result">
<p>点击获取坐标</p>
经度：<input id="longitude" size="10"/><br />
纬度：<input id="latitude" size="10"/>
</div>
<script type="text/javascript">
var map = new BMap.Map("l-map");
map.centerAndZoom("厦门",12);
map.enableScrollWheelZoom();

map.addEventListener("click", function(e){
	document.getElementById("longitude").value = e.point.lng;
	document.getElementById("latitude").value = e.point.lat;
});
</script>
