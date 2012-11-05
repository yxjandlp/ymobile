package com.self.mobileshop.splash;

import com.self.mobileshop.MainActivity;
import com.self.mobileshop.R;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.view.Window;
import android.view.WindowManager;

public class SplashActivity extends Activity{
	
	private SplashView spView ;
	private final static int GOMAIN = 2;
	Handler mHandler = new Handler(){
		public void handleMessage(android.os.Message msg) {
			switch (msg.what) {
			case GOMAIN:
				
				break;

			default:
				break;
			}
		};
	};
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
//		setContentView(R.layout.splash_layout);
		 getWindow().requestFeature(Window.FEATURE_NO_TITLE);
	        getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN, WindowManager.LayoutParams.FLAG_FULLSCREEN);
		int screenWidth = getWindowManager().getDefaultDisplay().getWidth();
		int screenHeight = getWindowManager().getDefaultDisplay().getHeight();
		spView = new SplashView(getApplicationContext(),screenWidth, screenHeight,this);
		setContentView(spView);
		
		new Handler().postDelayed(new Runnable() {
			
			public void run() {
				// TODO Auto-generated method stub
				Intent intent = new Intent(SplashActivity.this, MainActivity.class);
				startActivity(intent);
				finish();
			}
		}, 2000);
	}
	
	
}
