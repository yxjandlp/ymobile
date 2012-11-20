<?php Yii::app()->clientScript->registerScriptFile('http://api.map.baidu.com/api?v=1.3');?>
<h2>商辅加盟:</h2>
<table>
	<tr>
		<td class="td_r">店辅名：</td><td><input name="Shop[name]" /></td>
	</tr>
	<tr>
		<td class="td_r">类别：</td>
		<td>
			<select name="Shop[category]">
			<option value="0">选择类别</option>
			<?php foreach ($categoryArray as $category):?>
			<option value="<?php echo $category['id'];?>"><?php echo $category['name']?></option>
			<?php endforeach;;?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="td_r">地址：</td>
		<td>
			<select name="Shop[address_1]">
				<option>--省份--</option>
				<?php foreach ($fisrtDistrictArray as $district):?>
				<option value="<?php echo $district['id']?>"><?php echo $district['name']?></option>
				<?php endforeach;?>
			</select>
			<select name="Shop[address_2">
				<option>--地区--</option>
			</select>
			<select name="Shop[address_3]">
				<option>--地区--</option>
			</select>
			<input name="Shop[address_4]" />
		</td>
	</tr>
	<tr>
		<td class="td_r">地图上的位置：</td>
		<td>
			经度：<input name="Shop[longitude]" id="longitude" size="10"/>
			纬度：<input name="Shop[latitude]|" id="latitude" size="10"/>
			<br />
			<div id="l-map"></div>
		</td>
	</tr>
	<tr>
		<td class="td_r">简介：</td>
		<td><textarea cols="40" rows="5"></textarea></td>
	</tr>
	<tr>
		<td>&nbsp;</td><td><input type="submit" name="add_shop" value="提交" id="add_shop"/></td>
	</tr>
</table>
<script type="text/javascript">
	var map = new BMap.Map("l-map");
	map.centerAndZoom("厦门",12);
	map.enableScrollWheelZoom();
	map.addEventListener("click", function(e){
		document.getElementById("longitude").value = e.point.lng;
		document.getElementById("latitude").value = e.point.lat;
	});
	$(document).ready(function(){
		$('#add_shop').click(function(){
			if($.trim($('input[name="Shop[name]"]').val()) == ''){
				alert('请输入店辅名');
				$('input[name="Shop[name]"]').focus();
				return false;
			}
			if($('select[name="Shop[category]"]').val() == 0){
				alert('请选择类别');
				$('input[name="Shop[category]"]').focus();
				return false;
			}
		});
	});
</script>
