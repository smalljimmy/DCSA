package app.fastdev.util;

import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.io.Serializable;

import ch.goco.config.Constants;

import android.os.Environment;
import android.util.Log;
import app.fastdev.Setting;

public class LocalFileManager {

	public static boolean isSdCardValid(){
		return Environment.MEDIA_MOUNTED.equals(Environment.getExternalStorageState());  
	}
	
	public static String getLocalImageFilePath(String imageUrl){
		String filename = DigestUtils.md5String(imageUrl);
		return getLocalFilePath(Setting.LOCAL_FILE_IMAGE, filename);
	}
	
	public static String getLocalTempFilePath(String url){
		String filename = DigestUtils.md5String(url);
		return getLocalFilePath(Setting.LOCAL_FILE_TEMP, filename);
	}
	
	public static String getLocalFilePath(String dir, String filename){
		if(isSdCardValid()){
			return Environment.getExternalStorageDirectory()+"/"+PackageUtil.getCurrentPackageName()+dir+"/"+filename;
		}else{
			//return ContextHolder.context.getFilesDir()+(dir+"_"+filename).replaceAll("/", "_");
			return ContextHolder.context.getFilesDir()+dir+"/"+filename;
		}
	}
	
	public static String getSerializationDataPath(String filename){
		return ContextHolder.context.getFilesDir()+"sd/"+filename;
	}
	
	@SuppressWarnings("unchecked")
	public static <T> T getSerializationData(String key, Class<T> target){
		ObjectInputStream input = null;
		try {
			input = new ObjectInputStream(new FileInputStream(getSerializationDataPath(key)));
			Object v = input.readObject();
			return (T)v;
		} catch (Exception e) {
			//nothing
		}finally{
			IOUtils.closeInputStreamQuiet(input);
		}
		return null;
	}
	
	public static void setSerializationData(String key, Serializable val){
		if(val == null) return;
		ObjectOutputStream output = null;
		try {
			output = new ObjectOutputStream(new FileOutputStream(getSerializationDataPath(key)));
			output.writeObject(val);
		}catch (IOException e) {
			Log.d(Constants.LOG_TAG, "Write SerializationData failed: "+e);
		}finally{
			IOUtils.closeOutputStreamQuiet(output);
		}
	}
}
