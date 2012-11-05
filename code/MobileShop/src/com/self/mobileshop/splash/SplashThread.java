package com.self.mobileshop.splash;

import android.graphics.Canvas;
import android.view.SurfaceHolder;

public class SplashThread extends Thread{
	SurfaceHolder holder;
	SplashView spView; 
	boolean flag = false;
	int sleepSpan = 120;
	Canvas canvas = null;
	int characterCounter=0;
	int charNumber = 0;
	public SplashThread(SplashView view, SurfaceHolder holder){
		this.spView = view;
		this.holder = holder;
		flag = true;
	}
	@Override
	public void run() {
		// TODO Auto-generated method stub
		while(flag){
			try {
				canvas = holder.lockCanvas(null);
				synchronized (holder) {
					characterCounter++;
					if(characterCounter == 2){
						characterCounter = 0;
						spView.characterNumber++;//View中显示的字数加1
						charNumber++;//计数器加1
						if(charNumber == spView.str.length){
							this.flag = false;
						}					
					}
					spView.doDraw(canvas);
				}
			} catch (Exception e) {
				// TODO: handle exception
			}finally{
				if(canvas != null)
					holder.unlockCanvasAndPost(canvas);
			}
			try {
				Thread.sleep(sleepSpan);
			} catch (InterruptedException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}
	}
}
