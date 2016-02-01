package app.fastdev.util;

import android.content.Context;
import android.widget.Toast;

public class ToastUtils {

	public static void showMsg(final Context context,final  String msg){
		ThreadUtils.runOnUiThread(new Runnable() {
			@Override
			public void run() {
				Toast.makeText(context, msg, Toast.LENGTH_SHORT).show();
			}
		});
	}
	
	public static void showMsg(Context context,int textResId){
		showMsg(context, context.getResources().getString(textResId));
	}
}
