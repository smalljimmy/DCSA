package app.fastdev.util;

import android.content.Context;
import android.content.SharedPreferences;
import app.fastdev.Setting;

/**
 * SharedPreferences 快捷操作工具类
 */
public class SharedPreferencesUtils {

	/**
	 * 获取内容
	 * @param context	上下文
	 * @param fileName	文件名
	 * @param name		属性名
	 * @return
	 * 			返回内容
	 */
	public static String getString(Context context,String name,String defaultValue){
		SharedPreferences sharedPreferences = context.getSharedPreferences(Setting.SP_FILE_NAME, Context.MODE_PRIVATE);
		String result = sharedPreferences.getString(name, defaultValue);
		sharedPreferences = null;
		return result;
	}
	
	/**
	 * 获取boolean类型的值
	 * @param context
	 * @param fileName
	 * @param name
	 * @param defaultValue
	 * @return
	 */
	public static boolean getBoolean(Context context,String name,boolean defaultValue){
		SharedPreferences sharedPreferences = context.getSharedPreferences(Setting.SP_FILE_NAME, Context.MODE_PRIVATE);
		boolean result = sharedPreferences.getBoolean(name, defaultValue);
		sharedPreferences = null;
		return result;
	}
	
	/**
	 * 获取int类型的值
	 * @param context
	 * @param fileName
	 * @param name
	 * @param defaultValue
	 * @return
	 */
	public static int getInt(Context context,String name,int defaultValue){
		SharedPreferences sharedPreferences = context.getSharedPreferences(Setting.SP_FILE_NAME, Context.MODE_PRIVATE);
		int result = sharedPreferences.getInt(name, defaultValue);
		sharedPreferences = null;
		return result;
	}
	
	/**
	 * 获取long类型的值
	 * @param context
	 * @param fileName
	 * @param name
	 * @param defaultValue
	 * @return
	 */
	public static long getLong(Context context,String name,long defaultValue){
		SharedPreferences sharedPreferences = context.getSharedPreferences(Setting.SP_FILE_NAME, Context.MODE_PRIVATE);
		long result = sharedPreferences.getLong(name, defaultValue);
		sharedPreferences = null;
		return result;
	}
	
	/**
	 * 获取float类型的值
	 * @param context
	 * @param fileName
	 * @param name
	 * @param defaultValue
	 * @return
	 */
	public static float getFloat(Context context,String name,float defaultValue){
		SharedPreferences sharedPreferences = context.getSharedPreferences(Setting.SP_FILE_NAME, Context.MODE_PRIVATE);
		float result = sharedPreferences.getFloat(name, defaultValue);
		sharedPreferences = null;
		return result;
	}
	
	/**
	 * 设置boolean类型的内容
	 * @param context
	 * @param fileName
	 * @param name
	 * @param content
	 */
	public static SharedPreferences.Editor putBoolean(Context context,String name,boolean content){
		SharedPreferences sharedPreferences = context.getSharedPreferences(Setting.SP_FILE_NAME, Context.MODE_PRIVATE);
		return sharedPreferences.edit().putBoolean(name,content);
	}
	
	/**
	 * 设置int类型的内容
	 * @param context
	 * @param fileName
	 * @param name
	 * @param content
	 */
	public static SharedPreferences.Editor putInt(Context context,String name,int content){
		SharedPreferences sharedPreferences = context.getSharedPreferences(Setting.SP_FILE_NAME, Context.MODE_PRIVATE);
		return sharedPreferences.edit().putInt(name,content);
	}
	
	/**
	 * 设置long类型的内容
	 * @param context
	 * @param fileName
	 * @param name
	 * @param content
	 */
	public static SharedPreferences.Editor putLong(Context context,String name,long content){
		SharedPreferences sharedPreferences = context.getSharedPreferences(Setting.SP_FILE_NAME, Context.MODE_PRIVATE);
		return sharedPreferences.edit().putLong(name,content);
	}
	
	/**
	 * 设置String类型的内容
	 * @param context
	 * @param fileName
	 * @param name
	 * @param content
	 */
	public static SharedPreferences.Editor putString(Context context,String name,String content){
		SharedPreferences sharedPreferences = context.getSharedPreferences(Setting.SP_FILE_NAME, Context.MODE_PRIVATE);
		return sharedPreferences.edit().putString(name,content);
	}
	
	/**
	 * 设置Float类型的内容
	 * @param context
	 * @param fileName
	 * @param name
	 * @param content
	 */
	public static SharedPreferences.Editor putFloat(Context context,String name,float content){
		SharedPreferences sharedPreferences = context.getSharedPreferences(Setting.SP_FILE_NAME, Context.MODE_PRIVATE);
		return sharedPreferences.edit().putFloat(name,content);
	}
	
	/**
	 * 删除记录
	 * @param context
	 * @param fileName	文件名
	 * @param name		字段名
	 */
	public static SharedPreferences.Editor remove(Context context,String fileName,String name){
		SharedPreferences sharedPreferences = context.getSharedPreferences(fileName, Context.MODE_PRIVATE);
		return sharedPreferences.edit().remove(name);
	}
}
