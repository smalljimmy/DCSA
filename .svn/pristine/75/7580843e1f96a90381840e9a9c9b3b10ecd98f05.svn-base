package ch.goco.config;

import java.io.InputStream;
import java.util.Map;
import java.util.Map.Entry;
import java.util.Set;

import android.util.Log;

public class ConfigManager {
	
	static Map<String,String> valueMap;

	public static void loadConfig(InputStream input){
		valueMap = XmlParse.parse(input);
		
		Set<Entry<String, String>> entryList = valueMap.entrySet();
		StringBuilder builder = new StringBuilder();
		builder.append("{");
		boolean first = true;
		for(Entry<String, String> entry:entryList){
			if(!first) builder.append(", ");
			builder.append(entry.getKey()).append(": ").append(entry.getValue());
			first = false;
		}
		builder.append("}");
		Log.d(Constants.LOG_TAG, "LoadConfig: "+builder.toString());
	}
	
	/**
	 * 获取配置好的信息字符串
	 * 
	 * @param key 字符串对应的键值
	 * @return 信息字符串 或 null
	 */
	public static int getValue(String key,int defaultValue){
		String value = valueMap.get(key);
		if(value == null) return defaultValue;
		try {
			return Integer.parseInt(value.trim());
		} catch (NumberFormatException e) {
			return defaultValue;
		}
	}
	
	/**
	 * 获取配置好的信息字符串
	 * 
	 * @param key 字符串对应的键值
	 * @return 信息字符串 或 null
	 */
	public static float getValue(String key,float defaultValue){
		String value = valueMap.get(key);
		if(value == null) return defaultValue;
		try {
			return Float.parseFloat(value.trim());
		} catch (NumberFormatException e) {
			return defaultValue;
		}
	}
	
	/**
	 * 获取配置好的信息字符串
	 * 
	 * @param key 字符串对应的键值
	 * @return 信息字符串 或 null
	 */
	public static String getValue(String key,String defaultValue){
		String value = valueMap.get(key);
		if(value == null) value = defaultValue;
		return value;
	}
	
	public static String getValue(String key){
		return getValue(key, null);
	}
	
	/**
	 * 获取进行格式化后的结果字符串<br>
	 * 使用String.format 对内容进行格式化
	 * @param key 字符串对应的键值
	 * @param args 格式化值参数列表
	 * @return 结果字符串
	 */
	public static String getMessageFormat(String key,Object... args){
		return String.format(getValue(key), args);
	};
	
}
