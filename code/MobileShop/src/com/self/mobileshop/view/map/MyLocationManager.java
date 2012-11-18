package com.self.mobileshop.view.map;

import android.content.Context;
import android.location.Criteria;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.util.Log;

public class MyLocationManager {
	private final String TAG = "MyLocationManager";

	private static final int MINTIME = 2000;
	private static final int MININSTANCE = 2;
	private static Context mContext;
	private static LocationListener mListener;
	private static MyLocationManager instance;

	private LocationManager gpsLocationManager;
	private LocationManager networkLocationManager;

	private Location lastLocation = null;

	public static void init() {
	}

	private MyLocationManager() {
		
		gpsLocationManager = (LocationManager) mContext.getSystemService(Context.LOCATION_SERVICE);
		Location gpsLocation = gpsLocationManager.getLastKnownLocation(LocationManager.GPS_PROVIDER);
		gpsLocationManager.requestLocationUpdates(LocationManager.GPS_PROVIDER, MINTIME, MININSTANCE, mListener);
		
		networkLocationManager = (LocationManager) mContext.getSystemService(Context.LOCATION_SERVICE);
		Location networkLocation = gpsLocationManager.getLastKnownLocation(LocationManager.GPS_PROVIDER);
		networkLocationManager.requestLocationUpdates(LocationManager.NETWORK_PROVIDER, MINTIME, MININSTANCE, mListener);
		
		Criteria criteria = new Criteria();
		criteria.setAccuracy(Criteria.ACCURACY_FINE); // 高精度
		criteria.setAltitudeRequired(false);
		criteria.setBearingRequired(false);
		criteria.setCostAllowed(true);
		criteria.setPowerRequirement(Criteria.POWER_LOW); // 低功耗
		
		if (gpsLocation != null) {
			Log.d(TAG, "gpslocation is not null");
			String provider = gpsLocationManager.getBestProvider(criteria, true); // 获取GPS信息
			gpsLocation = gpsLocationManager.getLastKnownLocation(provider); // 通过GPS获取位置
			lastLocation = gpsLocation;
		}else if(networkLocation != null){
			Log.d(TAG, "newworklocation is not null");
			String provider = networkLocationManager.getBestProvider(criteria, true); 
			networkLocation = networkLocationManager.getLastKnownLocation(provider); 
			lastLocation = networkLocation;
		}
	}
	
	public static MyLocationManager getInstance(Context context){
		if(instance == null){
			mContext = context;
			instance = new MyLocationManager();
		}
		return instance;
	}
	
	public static MyLocationManager getInstance(Context c, LocationListener listener) {
		if (null == instance) {
			mContext = c;
			mListener = listener;
			instance = new MyLocationManager();
		}
		return instance;
	}

	public Location getMyLocation() {
		return lastLocation;
	}

	public void destoryLocationManager() {
		Log.d(TAG, "destoryLocationManager");
		gpsLocationManager.removeUpdates(mListener);
		networkLocationManager.removeUpdates(mListener);
	}
}
