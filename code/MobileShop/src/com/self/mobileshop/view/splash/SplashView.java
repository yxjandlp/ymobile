package com.self.mobileshop.view.splash;

import android.content.Context;
import android.graphics.Canvas;
import android.graphics.Color;
import android.graphics.Paint;
import android.graphics.Typeface;
import android.view.SurfaceHolder;
import android.view.SurfaceView;

public class SplashView extends SurfaceView implements SurfaceHolder.Callback{
	SplashThread splashThread;
	SplashActivity splashActivity;
	char [] str={'最','眩','民','族','风'};
	int textStartX = 0;
	int textStartY = 0;
	float textSize = 23f;
	int textSpanX = 25;
	int characterNumber=-1;
	public SplashView(Context context, int screenWidth, int screenHeight,SplashActivity spActivity) {
		super(context);
		// TODO Auto-generated constructor stub
		getHolder().addCallback(this);
		textStartX = (screenWidth-(str.length*textSpanX))/2;
		textStartY = screenHeight/2;
		this.splashActivity = spActivity;
		splashThread = new SplashThread(this, this.getHolder());
	}

	public void surfaceChanged(SurfaceHolder holder, int format, int width,
			int height) {
		// TODO Auto-generated method stub
		
	}

	public void surfaceCreated(SurfaceHolder holder) {
		// TODO Auto-generated method stub
		splashThread.flag = true;
		if(!splashThread.isAlive()){
			splashThread.start();
			
		}
	}
	
	public void doDraw(Canvas canvas){
		Paint paint = new Paint();	
		paint.setColor(Color.RED);
		paint.setTextSize(textSize);
		paint.setTypeface(Typeface.DEFAULT_BOLD);
		paint.setAntiAlias(true);
		
		canvas.drawText(str[characterNumber]+"", textStartX+characterNumber*textSize, textStartY, paint);
			
		
	}

	public void surfaceDestroyed(SurfaceHolder holder) {
		// TODO Auto-generated method stub
		
	}

}
