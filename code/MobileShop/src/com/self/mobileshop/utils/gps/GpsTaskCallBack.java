package com.self.mobileshop.utils.gps;

import com.self.mobileshop.utils.gps.GpsTask.GpsData;


public interface GpsTaskCallBack {

	public void gpsConnected(GpsData gpsdata);
	
	public void gpsConnectedTimeOut();
	
}
