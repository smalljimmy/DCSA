package app.fastdev.util;

import android.content.Context;

public class DisplayUtils {
	
	/**
	 * 返回屏幕的宽度，单位像素
	 * @param context
	 * @return
	 */
	public static int getScreenWidth(Context context){
		return context.getResources().getDisplayMetrics().widthPixels;
	}
	
	/**
	 * 返回屏幕的宽度，单位dp
	 * @param context
	 * @return
	 */
	public static int getscreenWidthDp(Context context){
		int widthPx = context.getResources().getDisplayMetrics().widthPixels;
		return px2dip(context,widthPx);//widthPx/oneDpToPx;
	}
	
	/**
	 * 根据手机的分辨率从 dp 的单位 转成为 px(像素)
	 */
	public static int dip2px(Context context, float dpValue) {
		final float scale = context.getResources().getDisplayMetrics().density;
		return (int) (dpValue * scale + 0.5f);
	}
	 
	/**
	 * 根据手机的分辨率从 px(像素) 的单位 转成为 dp
	 */
	public static int px2dip(Context context, float pxValue) {
		final float scale = context.getResources().getDisplayMetrics().density;
		return (int) (pxValue / scale + 0.5f);
	}
}
