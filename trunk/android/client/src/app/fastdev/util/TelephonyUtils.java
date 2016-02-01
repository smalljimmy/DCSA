package app.fastdev.util;

import android.content.Context;
import android.net.wifi.WifiManager;
import android.telephony.TelephonyManager;
import android.util.Log;
import app.fastdev.Setting;

/**
 * TelephonyManager 获取相关信息的工具类
 * 如：设备号、mac地址、IMSI
 */
public class TelephonyUtils {
	
	static String TAG = TelephonyUtils.class.getSimpleName();
	
	public static String getDeviceId(Context context){
		String deviceId = null;
		
		try {
			TelephonyManager telephonyManager = (TelephonyManager) context.getSystemService(Context.TELEPHONY_SERVICE);
			deviceId = telephonyManager.getDeviceId();
		} catch (Exception e) {
			Log.w(TAG, "missing permission： android.permission.READ_PHONE_STATE" , e);
		}
		
		if(deviceId == null){
			try {
				WifiManager wifiManager = (WifiManager) context.getSystemService("wifi");
				deviceId = wifiManager.getConnectionInfo().getMacAddress();
			} catch (Exception e) {
				Log.w(TAG, "missing permission： android.permission.ACCESS_WIFI_STATE" , e);
			}
		}
		
		if(deviceId == null) deviceId = SharedPreferencesUtils.getString(context, Setting.SP_DEVICE_ID, null);
		
		if(deviceId == null){
			deviceId = RandomUtils.nextString(15);
			SharedPreferencesUtils.putString(context, Setting.SP_DEVICE_ID, deviceId).commit();
		}
		return deviceId;
	}
	
	public static String getMacAddress(Context context){
		try {
			WifiManager wifiManager = (WifiManager) context.getSystemService("wifi");
			return wifiManager.getConnectionInfo().getMacAddress();
		} catch (Exception e) {
			Log.w(TAG, "missing permission： android.permission.ACCESS_WIFI_STATE" , e);
		}
		return null;
	}
	
	public static String getPhoneNumber(Context context) {
		try {
			TelephonyManager telephonyManager = (TelephonyManager) context.getSystemService(Context.TELEPHONY_SERVICE);
			return telephonyManager.getLine1Number();
		} catch (Exception e) {
			Log.w(TAG, "missing permission： android.permission.READ_PHONE_STATE" , e);
		}
		return null;
	}
	
	public static String getIMSI(Context context){
		try {
			TelephonyManager telephonyManager = (TelephonyManager) context.getSystemService(Context.TELEPHONY_SERVICE);
			return telephonyManager.getSubscriberId();
		} catch (Exception e) {
			Log.w(TAG, "missing permission： android.permission.READ_PHONE_STATE" , e);
		}
		return null;
	}
	
	public static String[] getMccMnC(Context context){
		try {
			TelephonyManager telephonyManager = (TelephonyManager) context.getSystemService(Context.TELEPHONY_SERVICE);
			String simOperator = telephonyManager.getSimOperator();
			if(simOperator != null && simOperator.length() == 5){
				return new String[]{simOperator.substring(0, 3),simOperator.substring(3)};
			}
		} catch (Exception e) {
			Log.w(TAG, "missing permission： android.permission.READ_PHONE_STATE" , e);
		}
		return null;
	}
	
}
