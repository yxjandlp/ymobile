<?php Yii::app()->clientScript->registerScriptFile('http://api.map.baidu.com/api?v=1.3');?>
<h2>商辅加盟:</h2>
<form action="<?php echo Yii::app()->createUrl('shop/add');?>" id="addForm">
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
        <td class="td_r">联系方式：</td><td><input name="Shop[contact]" /> </td>
    </tr>
	<tr>
		<td class="td_r">地址：</td>
		<td>
			<select name="Shop[address_1]">
				<option value="0">--省份--</option>
				<?php foreach ($fisrtDistrictArray as $district):?>
				<option value="<?php echo $district['id']?>"><?php echo $district['name']?></option>
				<?php endforeach;?>
			</select>
			<select name="Shop[address_2]">
				<option value="0">--地区--</option>
			</select>
			<select name="Shop[address_3]">
				<option value="0">--地区--</option>
			</select>
			<input name="Shop[address_4]" />
		</td>
	</tr>
	<tr>
		<td class="td_r">地图上的位置：</td>
		<td>
			经度：<input name="Shop[longitude]" id="longitude" size="10"/>
			纬度：<input name="Shop[latitude]" id="latitude" size="10"/>
			<br />
			<div id="l-map"></div>
		</td>
	</tr>
	<tr>
		<td class="td_r">简介：</td>
		<td><textarea cols="40" rows="5" name="Shop[intro]"></textarea></td>
	</tr>
	<tr>
		<td>&nbsp;</td><td><input type="submit" name="add_shop" value="提交" id="add_shop"/></td>
	</tr>
</table>
</form>
<script type="text/javascript">
	var map = new BMap.Map("l-map");
	map.centerAndZoom("厦门",12);
	map.enableScrollWheelZoom();
	map.addEventListener("click", function(e){
		document.getElementById("longitude").value = e.point.lng;
		document.getElementById("latitude").value = e.point.lat;
	});
    function clearOption(){
        var obj1 = $('select[name="Shop[address_2]"]');
        var obj2 = $('select[name="Shop[address_3]"]');
        var content = "<option value='0'>--地区--</option>";
        obj1.empty();
        obj2.empty();
        obj1.append(content);
        obj2.append(content);
    }
    function appendDistrict(obj1, obj2){
        var levelValue = obj1.val();
        if(levelValue == 0){
            clearOption();
        }else{
            var toUrl = 'ajaxGetDistrict';
            var data = "upId=" + levelValue;
            $.ajax({
                "type" : "POST",
                "url" : toUrl,
                "data" : data,
                'dataType' : 'json',
                "success" : function(data){
                    if(! data.error){
                        var length = data.district.length;
                        obj2.empty();
                        obj2.append("<option value='0'>--地区--</option>");
                        for(var i=0;i<length;i++){
                            var optionContent = "<option value='"+data.district[i]['id']+"'>"+data.district[i]['name']+"</option>";
                            console.log(optionContent);
                            obj2.append(optionContent);
                        }
                    }
                }
            });
        }
    }
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
            if($.trim($('input[name="Shop[contact]"]').val()) == ''){
                alert('请输入联系方式');
                $('input[name="Shop[contact]"]').focus();
                return false;
            }
            if($('select[name="Shop[address_1]"]').val() == 0 || $('select[name="Shop[address_2]"]').val() == 0 || $('select[name="Shop[address_3]"]').val() == 0 || $.trim($('input[name="Shop[address_4]"]').val()) == ''){
                alert('地址未填写完整');
                return false;
            }
            if($.trim( $('input[name="Shop[longitude]"]').val()) == ''){
                alert('请输入经度');
                $('input[name="Shop[longitude]"]').focus();
                return false;
            }
            if($.trim( $('input[name="Shop[latitude]"]').val()) == ''){
                alert('请输入纬度');
                $('input[name="Shop[latitude]"]').focus();
                return false;
            }
            if($.trim( $('textarea[name="Shop[intro]"]').val()) == ''){
                alert('请输入简介');
                $('textarea[name="Shop[intro]"]').focus();
                return false;
            }
            $('#addForm').submit();
		});
        $('select[name="Shop[address_1]"]').change(function(){
            appendDistrict($(this), $('select[name="Shop[address_2]"]'));
        });
        $('select[name="Shop[address_2]"]').change(function(){
            appendDistrict($(this), $('select[name="Shop[address_3]"]'));
        });
	});
</script>
