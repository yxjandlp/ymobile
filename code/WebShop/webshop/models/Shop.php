<?php

/**
 * This is the model class for table "shop".
 *
 * The followings are the available columns in table 'shop':
 * @property string $id
 * @property string $name
 * @property string $intro
 * @property string $contact
 * @property string $address_1
 * @property string $address_2
 * @property string $address_3
 * @property string $address_4
 * @property double $longitude
 * @property double $latitude
 * @property string $category
 * @property string $ctime
 */
class Shop extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Shop the static model class
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
		return 'shop';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, intro, contact, address_1, address_2, address_3, address_4, longitude, latitude, category, ctime', 'required'),
			array('longitude, latitude', 'numerical'),
			array('name, address_4', 'length', 'max'=>100),
			array('contact, address_1, address_2, address_3', 'length', 'max'=>20),
			array('category, ctime', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, intro, contact, address_1, address_2, address_3, address_4, longitude, latitude, category, ctime', 'safe', 'on'=>'search'),
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
			'intro' => 'Intro',
			'contact' => 'Contact',
			'address_1' => 'Address 1',
			'address_2' => 'Address 2',
			'address_3' => 'Address 3',
			'address_4' => 'Address 4',
			'longitude' => 'Longitude',
			'latitude' => 'Latitude',
			'category' => 'Category',
			'ctime' => 'Ctime',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('intro',$this->intro,true);
		$criteria->compare('contact',$this->contact,true);
		$criteria->compare('address_1',$this->address_1,true);
		$criteria->compare('address_2',$this->address_2,true);
		$criteria->compare('address_3',$this->address_3,true);
		$criteria->compare('address_4',$this->address_4,true);
		$criteria->compare('longitude',$this->longitude);
		$criteria->compare('latitude',$this->latitude);
		$criteria->compare('category',$this->category,true);
		$criteria->compare('ctime',$this->ctime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}