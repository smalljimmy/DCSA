package app.fastdev.util;

import android.os.Handler;

public class ThreadUtils {
	
	static Handler handler;
	
	public static void init(){
		handler = new Handler();
	}
	
	public static void runOnNewThread(Runnable runnable){
		new Thread(runnable).start();
	}
	
	public static void runOnNewThread(Runnable runnable, String threadName){
		new Thread(runnable,threadName).start();
	}
	
	public static void runOnUiThread(Runnable runnable){
		handler.post(runnable);
	}
	
	public static void runOnUiThread(Runnable runnable, long delay){
		handler.postDelayed(runnable, delay);
	}
	
	public static void sleep(long time){
		try {
			Thread.sleep(time);
		} catch (InterruptedException e) {
			e.printStackTrace();
		}
	}
}
