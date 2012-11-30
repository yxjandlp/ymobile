package com.self.mobileshop.view.city;

import java.util.Arrays;
import java.util.Iterator;
import java.util.List;

import com.self.mobileshop.R;
import com.self.mobileshop.entity.City;
import com.self.mobileshop.utils.db.DBUtils;


import android.app.Activity;
import android.content.Context;
import android.graphics.PixelFormat;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.WindowManager;
import android.widget.BaseAdapter;
import android.widget.ListView;
import android.widget.SectionIndexer;
import android.widget.TextView;
import android.widget.LinearLayout.LayoutParams;

public class CitySelectActivity extends Activity{
	
	private ListView cityListView;
	private SlideBar indexBar;
	private WindowManager mWindowManager;
	private TextView mDialogText;
	private static List<City> allCities;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.city_select_main_layout);
        mWindowManager = (WindowManager)getSystemService(Context.WINDOW_SERVICE);
        
        checkAndGetCities();
        findView();
    }
    
    public void checkAndGetCities(){
    	boolean hasDB = DBUtils.checkDataBase();
    	Log.d("hasDb__", hasDB+"");
    	if(!hasDB){
    		DBUtils.createDataBase(CitySelectActivity.this);
    	}
    	allCities = DBUtils.getAllCities();
    }
    
    private void findView(){
    	cityListView = (ListView)this.findViewById(R.id.cityList);
    	cityListView.setAdapter(new ContactAdapter(this));
    	indexBar = (SlideBar) findViewById(R.id.rightCityListView);  
        indexBar.setListView(cityListView); 
        mDialogText = (TextView) LayoutInflater.from(this).inflate(R.layout.list_position, null);
        mDialogText.setVisibility(View.INVISIBLE);
        WindowManager.LayoutParams lp = new WindowManager.LayoutParams(
                LayoutParams.WRAP_CONTENT, LayoutParams.WRAP_CONTENT,
                WindowManager.LayoutParams.TYPE_APPLICATION,
                WindowManager.LayoutParams.FLAG_NOT_TOUCHABLE
                        | WindowManager.LayoutParams.FLAG_NOT_FOCUSABLE,
                PixelFormat.TRANSLUCENT);
        mWindowManager.addView(mDialogText, lp);
        indexBar.setTextView(mDialogText);
    }
    
    static class ContactAdapter extends BaseAdapter implements SectionIndexer {  
    	private Context mContext;
    	private City[] mCities = new City[allCities.size()];
		@SuppressWarnings("unchecked")
		public ContactAdapter(Context mContext){
    		this.mContext = mContext;
    		Log.d("CitySelect__allcities", allCities.toString());
    		Iterator<City> iterator = allCities.iterator();
    		int i=0;
    		while(iterator.hasNext()){
    			mCities[i++] = iterator.next();
    		}
    		 
    		//排序(实现了中英文混排)
    		Arrays.sort(mCities, new PinyinComparator());
    	}
		public int getCount() {
			return mCities.length;
		}

		public Object getItem(int position) {
			return mCities[position].name;
		}

		public long getItemId(int position) {
			return position;
		}

		public View getView(int position, View convertView, ViewGroup parent) {
			final String cityName = mCities[position].name;
			ViewHolder viewHolder = null;
			if(convertView == null){
				convertView = LayoutInflater.from(mContext).inflate(R.layout.city_select_list_item, null);
				viewHolder = new ViewHolder();
				viewHolder.tvCatalog = (TextView)convertView.findViewById(R.id.contactitem_catalog);
				viewHolder.tvNick = (TextView)convertView.findViewById(R.id.contactitem_nick);
				convertView.setTag(viewHolder);
			}else{
				viewHolder = (ViewHolder)convertView.getTag();
			}
			String catalog = mCities[position].pinyin.substring(0,1).toUpperCase();
			if(position == 0){
				viewHolder.tvCatalog.setVisibility(View.VISIBLE);
				viewHolder.tvCatalog.setText(catalog);
			}else{
				String lastCatalog = mCities[position - 1].pinyin.substring(0,1).toUpperCase();
				if(catalog.equals(lastCatalog)){
					viewHolder.tvCatalog.setVisibility(View.GONE);
				}else{
					viewHolder.tvCatalog.setVisibility(View.VISIBLE);
					viewHolder.tvCatalog.setText(catalog);
				}
			}
			
			viewHolder.tvNick.setText(cityName);
			return convertView;
		}
    	
		static class ViewHolder{
			TextView tvCatalog;//目录
			TextView tvNick;//昵称
		}
 
		public int getPositionForSection(int section) {
			for (int i = 0; i < mCities.length; i++) {  
	            String l = mCities[i].pinyin;  
	            char firstChar = l.toUpperCase().charAt(0);  
	            if (firstChar == section) {  
	                return i;  
	            }  
	        } 
			return -1;
		}
		public int getSectionForPosition(int position) {
			return 0;
		}
		public Object[] getSections() {
			return null;
		}
    }
    
     
}

