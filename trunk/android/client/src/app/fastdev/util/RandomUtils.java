package app.fastdev.util;

import java.util.Random;

/**
 * 随机数相关操作工具类
 */
public class RandomUtils {
	
	static Random random = new Random(System.currentTimeMillis()); 
	
	static String LETTER_NUMBER_LOWER = "abcdefghijklmnopqrstuvwxyz0123456789";
	
	public static String nextString(int length){
		StringBuilder vals = new StringBuilder();
		for(int i=0;i<length;i++){
			vals.append(LETTER_NUMBER_LOWER.charAt(random.nextInt(length)));
		}
		return vals.toString();
	}
	
}
