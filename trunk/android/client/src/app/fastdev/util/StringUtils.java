package app.fastdev.util;

import java.util.Collection;

/**
 * 字符串相关处理工具类
 */
public class StringUtils {

	public static boolean isNotBlank(String val){
		if(val == null) return false;
		if(val.trim().length() == 0) return false;
		return true;
	}
	
	public static boolean isBlank(String val){
		if(val == null) return true;
		if(val.trim().length() == 0) return true;
		return false;
	}
	
	public static String join(Collection<?> items, String separate){
		if(items == null || items.size() == 0) return "";
		StringBuilder b = new StringBuilder();
		boolean first = true;
		for(Object o: items){
			if(first) first = false;
			else b .append(separate);
			b.append(o+"");
		}
		return b.toString();
	}
	
	public static String join(int[] items, String separate){
		if(items == null || items.length == 0) return "";
		StringBuilder b = new StringBuilder();
		boolean first = true;
		for(Object o: items){
			if(first) first = false;
			else b .append(separate);
			b.append(o);
		}
		return b.toString();
	}
	
	public static byte[] getBytes(String val,String charset){
		try {
			return val.getBytes(charset);
		} catch (Exception e) {
			return null;
		}
	}
	
	public static String newString(byte[] b,String charset){
		try {
			return new String(b, charset);
		} catch (Exception e) {
			return null;
		}
	}
}
