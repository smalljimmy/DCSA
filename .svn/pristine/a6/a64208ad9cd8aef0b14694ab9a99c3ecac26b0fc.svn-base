package app.fastdev.util;

import java.security.MessageDigest;
import java.util.Locale;

import android.util.Base64;

public class DigestUtils {
	
	public static byte[] XORString(byte[] bs, String key){
		try {
			byte[] k = key.getBytes("UTF-8");
			byte[] out = new byte[bs.length];
			for (int i = 0; i < bs.length; i++) {
			    out[i] = (byte) (bs[i] ^ k[i%k.length]);
			}
			return out;
		} catch (Exception e) {
			return null;
		}
	}
	
	public static byte[] decodeBase64String(String input){
		return Base64.decode(input, Base64.DEFAULT);
	}
	
	public static String md5String(String val){
		if(val == null) return null;
		byte[] resBytes;
		try {
			MessageDigest md = MessageDigest.getInstance("MD5");
			md.update(val.getBytes("UTF-8"));
			resBytes = md.digest();
			return hexString(resBytes);
		} catch (Exception e) {
			return null;
		}
	}
	
	public static String hexString(byte[] bytes){
		StringBuilder val = new StringBuilder();
		for(byte b:bytes){
			if(b <= 15) val.append("0");
			val.append(Integer.toHexString(b&0xFF));
		}
		return val.toString().toLowerCase(Locale.US);
	}
}
