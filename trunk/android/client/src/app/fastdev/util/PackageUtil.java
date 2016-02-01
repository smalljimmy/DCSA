package app.fastdev.util;

import android.content.Context;

public class PackageUtil {

	public static String getCurrentPackageName(){
		return getPackageName(ContextHolder.context);
	}
	
	public static String getPackageName(Context context){
		return context.getApplicationInfo().packageName;
	}
}
