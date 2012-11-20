<?php

/**
 * This is the model class for table "district".
 *
 * The followings are the available columns in table 'district':
 * @property integer $id
 * @property string $name
 * @property integer $level
 * @property integer $usetype
 * @property integer $upid
 * @property integer $displayorder
 */
class District extends CActiveRecord
{
	/**
	 * 省级
	 */
	const DISTRICT_FIRST_LEVEL = 1;
	
	/**
	 * 市级
	 */
	const DISTRICT_SECOND_LEVEL = 2;
	
	/**
	 * 县级
	 */
	const DISTRICT_THIRD_LEVEL = 3;
	
	/**
	 * 乡镇级
	 */
	const DISTRICT_FOURTH_LEVEL = 4;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return District the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'district';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('level, usetype, upid, displayorder', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, level, usetype, upid, displayorder', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'level' => 'Level',
			'usetype' => 'Usetype',
			'upid' => 'Upid',
			'displayorder' => 'Displayorder',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('level',$this->level);
		$criteria->compare('usetype',$this->usetype);
		$criteria->compare('upid',$this->upid);
		$criteria->compare('displayorder',$this->displayorder);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}