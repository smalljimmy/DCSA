package app.fastdev.util;

import android.content.Context;

public class ResourceUtils {

	public static String getString(Context context,int textResId){
		return context.getResources().getString(textResId); 
	}
}
