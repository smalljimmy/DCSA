package ch.goco;

import android.app.Application;

public class GocoApplication extends Application {

	@Override
	public void onCreate() {
		super.onCreate();
		Thread.setDefaultUncaughtExceptionHandler(new CrashExceptionHandler(getApplicationContext()));
	}
	
}
