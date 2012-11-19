package com.self.mobileshop.view.main;

import android.annotation.SuppressLint;
import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Handler;
import android.util.Log;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.RelativeLayout;
import android.widget.Toast;

import com.self.mobileshop.R;
import com.self.mobileshop.utils.gps.AddressTask;
import com.self.mobileshop.utils.gps.GpsTask;
import com.self.mobileshop.utils.gps.GpsTaskCallBack;
import com.self.mobileshop.utils.gps.GpsTask.GpsData;
import com.self.mobileshop.utils.gps.IAddressTask.MLocation;
import com.self.mobileshop.utils.view.MyAnimations;

public class MainActivity extends Activity {
	private String TAG = "MainActivity";
	private final static int WIFI_LOCATION = 111;
	private final static int GPS_LOCATION = 222;
	private final static int APN_LOCATION = 333;
	
	Button cityChooseBtn;
	private static MLocation location;
	private AlertDialog dialog = null;

	private boolean areButtonsShowing;
	private RelativeLayout composerButtonsWrapper;
	private ImageView composerButtonsShowHideButtonIcon;
	private RelativeLayout composerButtonsShowHideButton;

	private Handler mHandler = new Handler(){
		@SuppressLint("HandlerLeak")
		@SuppressWarnings("unchecked")
		public void handleMessage(android.os.Message msg) {
			switch (msg.what) {
			case GPS_LOCATION:
				GpsTask gpstask = new GpsTask(MainActivity.this,
						new GpsTaskCallBack() {

							public void gpsConnectedTimeOut() {
								if(location == null){
									
									mHandler.sendEmptyMessage(WIFI_LOCATION);
								}
							}

							public void gpsConnected(GpsData gpsdata) {
								do_gps(gpsdata);
							}

						}, 3000);
				gpstask.execute();
				if(location == null){
					mHandler.sendEmptyMessage(WIFI_LOCATION);
				}
				break;
			case WIFI_LOCATION:
				do_wifi();
				if(location == null){
					mHandler.sendEmptyMessage(GPS_LOCATION);
				}else{
					dialog.dismiss();
				}
				break;
			case APN_LOCATION:
				do_apn();
				if(location == null){
					if(dialog.isShowing())
						dialog.dismiss();
					Toast.makeText(MainActivity.this, "定位失败", Toast.LENGTH_LONG).show();
					cityChooseBtn.setText(".城市选择.");
				}
				break;
			default:
				break;
			}
		};
	};
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.view_main_layout);
		
		dialog = new ProgressDialog(MainActivity.this);
		dialog.setTitle("请稍等...");
		dialog.setMessage("正在定位...");
		
		MyAnimations.initOffset(MainActivity.this);
		
		
		composerButtonsWrapper = (RelativeLayout) findViewById(R.id.composer_buttons_wrapper);
		composerButtonsShowHideButton = (RelativeLayout) findViewById(R.id.composer_buttons_show_hide_button);
		composerButtonsShowHideButtonIcon = (ImageView) findViewById(R.id.composer_buttons_show_hide_button_icon);

		composerButtonsShowHideButton.setOnClickListener(new OnClickListener() {
			public void onClick(View v) {
				if (!areButtonsShowing) {
					MyAnimations.startAnimationsIn(composerButtonsWrapper, 200);
					composerButtonsShowHideButtonIcon
							.startAnimation(MyAnimations.getRotateAnimation(0,
									-270, 200));
				} else {
					MyAnimations
							.startAnimationsOut(composerButtonsWrapper, 200);
					composerButtonsShowHideButtonIcon
							.startAnimation(MyAnimations.getRotateAnimation(
									-270, 0, 200));
				}
				areButtonsShowing = !areButtonsShowing;
			}
		});
		for (int i = 0; i < composerButtonsWrapper.getChildCount(); i++) {
			composerButtonsWrapper.getChildAt(i).setOnClickListener(
					new View.OnClickListener() {
						public void onClick(View arg0) {
						}
					});
		}

		composerButtonsShowHideButton.startAnimation(MyAnimations
				.getRotateAnimation(0, 360, 150));
		
		
		Log.d(TAG, "begin location");
		
		cityChooseBtn = (Button)findViewById(R.id.cityChooseBtn);
		
		mHandler.sendEmptyMessage(WIFI_LOCATION);
	}


	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		getMenuInflater().inflate(R.menu.activity_main, menu);
		return true;
	}

	
	public void do_wifi() {
		new AsyncTask<Void, Void, MLocation>() {

			@Override
			protected MLocation doInBackground(Void... params) {
				
				try {
					
					location = new AddressTask(MainActivity.this, AddressTask.DO_WIFI).doWifiPost();
				} catch (Exception e) {
					
					e.printStackTrace();
				}
				return location;
			}

			@Override
			protected void onPreExecute() {
				dialog.show();
				super.onPreExecute();
			}

			protected void onPostExecute(MLocation result) {
				if(location != null){
					cityChooseBtn.setText(location.City);
				}
				super.onPostExecute(result);
			}
			
		}.execute();
	}
	
	public  void do_gps(final GpsData gpsdata) {
		new AsyncTask<Void, Void, MLocation>() {
			
			@Override
			protected MLocation doInBackground(Void... params) {
				try {
					Log.i("do_gpspost", "经纬度：" + gpsdata.getLatitude() + "----" + gpsdata.getLongitude());
					location = new AddressTask(MainActivity.this,
							AddressTask.DO_GPS).doGpsPost(gpsdata.getLatitude(),
									gpsdata.getLongitude());
				} catch (Exception e) {
					e.printStackTrace();
				}
				
				return location;
			}

			@Override
			protected void onPreExecute() {
				
				super.onPreExecute();
			}

			protected void onPostExecute(MLocation result) {
				if(result != null){
					cityChooseBtn.setText(result.City);
					dialog.dismiss();
				}
				super.onPostExecute(result);
			}
			
		}.execute();
	}

	public void do_apn() {
		new AsyncTask<Void, Void, MLocation>() {

			@Override
			protected MLocation doInBackground(Void... params) {
				
				try {
					location = new AddressTask(MainActivity.this,
							AddressTask.DO_APN).doApnPost();
				} catch (Exception e) {
					e.printStackTrace();
				}
				
				return location;
			}

			@Override
			protected void onPreExecute() {
				
				super.onPreExecute();
			}

			@Override
			protected void onPostExecute(MLocation result) {
				if(result != null){
					cityChooseBtn.setText(result.City);
					dialog.dismiss();
				}
				super.onPostExecute(result);
			}
			
		}.execute();
	}


	
	@Override
	protected void onDestroy() {
		// TODO Auto-generated method stub
		super.onDestroy();

	}

}
