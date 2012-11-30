package com.self.mobileshop.view.city;

import java.util.Comparator;

import com.self.mobileshop.entity.City;

public class PinyinComparator implements Comparator{

	public int compare(Object o1, Object o2) {
		 String str1 = ((City)o1).pinyin;
	     String str2 = ((City)o2).pinyin;
	     return str1.compareTo(str2);
	}

}
