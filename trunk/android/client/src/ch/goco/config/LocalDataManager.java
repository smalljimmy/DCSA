package ch.goco.config;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.io.Serializable;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.HashSet;
import java.util.List;
import java.util.Set;

import org.json.JSONArray;
import org.json.JSONObject;

import ch.goco.company.R;
import ch.goco.entity.Banner;
import ch.goco.entity.Company;
import ch.goco.entity.Docs;
import ch.goco.entity.Language;
import ch.goco.entity.Message;
import ch.goco.entity.Photo;
import android.content.Context;
import android.util.Log;
import app.fastdev.util.ContextHolder;
import app.fastdev.util.IOUtils;
import app.fastdev.util.JSONUtils;
import app.fastdev.util.LocalFileManager;
import app.fastdev.util.SharedPreferencesUtils;

public class LocalDataManager {

	public static float[] getLngLat(){
		return new float[]{
			SharedPreferencesUtils.getFloat(ContextHolder.context, Constants.SP_BACKEND_CONFIG_LONGITUDE, 0),
			SharedPreferencesUtils.getFloat(ContextHolder.context, Constants.SP_BACKEND_CONFIG_LATITUDE, 0),
		};
	}
	
	public static String getIdentifier(){
		return ConfigManager.getValue(Constants.BASE_CONFIG_KEY_IDENTIFIER);
	}
	
	public static String getBaseUrl(){
		return SharedPreferencesUtils.getString(ContextHolder.context, Constants.SP_BACKEND_CONFIG_BASE_URL, "");
	}
	
	public static int getCurrentLangugeId(){
		return SharedPreferencesUtils.getInt(ContextHolder.context, Constants.SP_LOCAL_LANGUAGE_ID, 0);
	}
	
	public static int getDefaultLangugeId(){
		return SharedPreferencesUtils.getInt(ContextHolder.context, Constants.SP_BACKEND_CONFIG_LANGUAGE_DEFAULT_ID, 0);
	}
	
	public static Company getLocalCompany(){
		return (Company)getSerializableObject(Constants.SER_KEY_DIR+"/"+Constants.SER_KEY_COMPANY);
	}
	
	public static void setLocalCompany(Company company){
		setSerializableObject(Constants.SER_KEY_DIR+"/"+Constants.SER_KEY_COMPANY, company);
	}
	
	public static String getLocalInfo(){
		return (String)getSerializableObject(Constants.SER_KEY_DIR+"/"+Constants.SER_KEY_INFO);
	}
	
	public static void setLoaclInfo(String val){
		setSerializableObject(Constants.SER_KEY_DIR+"/"+Constants.SER_KEY_INFO, val);
	}
	
	public static Set<Integer> getLocalMessageIds(){
		Object obj = getSerializableObject(Constants.SER_KEY_DIR+"/"+Constants.SER_KEY_MESSAGE_ID);
		try {
			if(obj != null)
				return new HashSet<Integer>(Arrays.asList((Integer[])obj));
		} catch (Exception e) {
			//e.printStackTrace();
		}
		return null;
	}
	
	public static void setLocalMessageIds(Set<Integer> itemList){
		setSerializableObject(Constants.SER_KEY_DIR+"/"+Constants.SER_KEY_MESSAGE_ID, itemList.toArray(new Integer[0]));
	}
	
	public static List<Photo> getLocalPhotoList(){
		Object obj = getSerializableObject(Constants.SER_KEY_DIR+"/"+Constants.SER_KEY_PHOTO);
		try {
			if(obj != null)
				return new ArrayList<Photo>(Arrays.asList((Photo[])obj));
		} catch (Exception e) {
			//e.printStackTrace();
		}
		return null;
	}
	
	public static void setLocalPhotoList(List<Photo> itemList){
		setSerializableObject(Constants.SER_KEY_DIR+"/"+Constants.SER_KEY_PHOTO, itemList.toArray(new Photo[0]));
	}
	
	public static List<Banner> getLocalBannerList(){
		Object obj = getSerializableObject(Constants.SER_KEY_DIR+"/"+Constants.SER_KEY_BANNER);
		try {
			if(obj != null)
				return new ArrayList<Banner>(Arrays.asList((Banner[])obj));
		} catch (Exception e) {
			//e.printStackTrace();
		}
		return null;
	}
	
	public static void setLocalBannerList(List<Banner> itemList){
		setSerializableObject(Constants.SER_KEY_DIR+"/"+Constants.SER_KEY_BANNER, itemList.toArray(new Banner[0]));
	}
	
	public static List<Docs> getLocalDocsList(){
		Object obj = getSerializableObject(Constants.SER_KEY_DIR+"/"+Constants.SER_KEY_DOCS);
		try {
			if(obj != null)
				return new ArrayList<Docs>(Arrays.asList((Docs[])obj));
		} catch (Exception e) {
			e.printStackTrace();
		}
		return null;
	}
	
	public static void setLocalDocsList(List<Docs> itemList){
		setSerializableObject(Constants.SER_KEY_DIR+"/"+Constants.SER_KEY_DOCS, itemList.toArray(new Docs[0]));
	}
	
	public static List<Message> getLocalNewsList(){
		Object obj = getSerializableObject(Constants.SER_KEY_DIR+"/"+Constants.SER_KEY_NEWS);
		try {
			if(obj != null)
				return new ArrayList<Message>(Arrays.asList((Message[])obj));
		} catch (Exception e) {
			//e.printStackTrace();
		}
		return null;
	}
	
	public static void setLocalMessageList(List<Message> itemList){
		setSerializableObject(Constants.SER_KEY_DIR+"/"+Constants.SER_KEY_MESSAGE, itemList.toArray(new Message[0]));
	}
	
	public static List<Message> getLocalMessageList(){
		Object obj = getSerializableObject(Constants.SER_KEY_DIR+"/"+Constants.SER_KEY_MESSAGE);
		try {
			if(obj != null)
				return new ArrayList<Message>(Arrays.asList((Message[])obj));
		} catch (Exception e) {
			//e.printStackTrace();
		}
		return null;
	}
	
	public static void setLocalNewsList(List<Message> itemList){
		setSerializableObject(Constants.SER_KEY_DIR+"/"+Constants.SER_KEY_NEWS, itemList.toArray(new Message[0]));
	}
	
	public static List<Integer> getIgnoreNewsIdList(){
		Object obj = getSerializableObject(Constants.SER_KEY_DIR+"/"+Constants.SER_KEY_NEWS_IGNORE_IDS);
		try {
			if(obj != null)
				return new ArrayList<Integer>(Arrays.asList((Integer[])obj));
		} catch (Exception e) {
			//e.printStackTrace();
		}
		return null;
	}
	
	public static void setIgnoreNewsList(List<Integer> itemList){
		setSerializableObject(Constants.SER_KEY_DIR+"/"+Constants.SER_KEY_NEWS_IGNORE_IDS, itemList.toArray(new Integer[0]));
	}
	
	public static Object getSerializableObject(String path){
		ObjectInputStream input = null;
		try {
			input = new ObjectInputStream(new FileInputStream(LocalFileManager.getLocalFilePath("", path)));
			return input.readObject();
		} catch (Exception e) {
			//e.printStackTrace();
		}finally{
			if(input != null) IOUtils.closeInputStreamQuiet(input);
		}
		return null;
	}
	
	public static void setSerializableObject(String path, Serializable obj){
		ObjectOutputStream out = null;
		try {
			File file = new File(LocalFileManager.getLocalFilePath("", path));
			if(!file.getParentFile().exists()) file.getParentFile().mkdirs();
			out = new ObjectOutputStream(new FileOutputStream(file));
			out.writeObject(obj);
		} catch (Exception e) {
			e.printStackTrace();
			Log.w(Constants.LOG_TAG, "Fail set Serializable Object: "+e);
		}finally{
			if(out != null) IOUtils.closeOutputStreamQuiet(out);
		}
	}
	
	/**
	 * 解析本地保存的语言列表
	 * @param context
	 * @return
	 */
	public static List<Language> getLanguageItemList(Context context){
		List<Language> itemList = new ArrayList<Language>();
		String languageText = SharedPreferencesUtils.getString(context, Constants.SP_BACKEND_CONFIG_LANGUAGE_LIST, null);
		if(languageText == null) return itemList;
		
		JSONArray ja = JSONUtils.newJSONArray(languageText);
		JSONObject obj;
		Language item;
		for(int i=0,j=ja.length();i<j;i++){
			obj = ja.optJSONObject(i);
			if(obj == null) continue;
			item = new Language();
			item.setId(obj.optInt("uid"));
			item.setName(obj.optString("name"));
			item.setCode(obj.optString("code"));
			if("en".equalsIgnoreCase(item.getCode())){
				item.setResId(R.drawable.icon_lang1);
			}else if("de".equalsIgnoreCase(item.getCode())){
				item.setResId(R.drawable.icon_lang2);
			}else if("it".equalsIgnoreCase(item.getCode())){
				item.setResId(R.drawable.icon_lang3);
			}else if("fr".equalsIgnoreCase(item.getCode())){
				item.setResId(R.drawable.icon_lang4);
			}else{
				//不存在对应的图标则忽略
				continue;
			}
			itemList.add(item);
		}
		
		//添加主页的图标
		item = new Language();
		item.setId(-1);
		item.setName("Home");
		item.setCode("");
		item.setResId(R.drawable.icon_home);
		itemList.add(0, item);
		return itemList;
	}
}
