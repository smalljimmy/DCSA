package ch.goco.webservice;

import org.json.JSONArray;
import org.json.JSONObject;

import ch.goco.config.Constants;
import ch.goco.config.LocalDataManager;
import app.fastdev.util.HttpClientUtils;

public class WebServiceUtils {

	public static JSONObject getConfig(){
		HttpClientUtils.ResponseEntry re = HttpClientUtils.get(Constants.WS_SERVER_URL_CONFIG.replace("#IDENTIFIER#", LocalDataManager.getIdentifier()));
		if(re.statusCode != 200){
			return null;
		}
		return re.toJSONObject();
	}
	
	public static JSONArray getImages(){
		StringBuilder url = new StringBuilder();
		url.append(Constants.WS_SERVER_URL_RESOURCES.replace("#IDENTIFIER#", LocalDataManager.getIdentifier()));
		url.append(Constants.WS_SERVER_RESOURCE_TYPE_IMAGE);
		url.append("/").append(LocalDataManager.getCurrentLangugeId());
		
		HttpClientUtils.ResponseEntry re = HttpClientUtils.get(url.toString());
		if(re.statusCode != 200){
			return null;
		}
		return re.toJSONArray();
	}
	
	public static JSONArray getDocs(){
		StringBuilder url = new StringBuilder();
		url.append(Constants.WS_SERVER_URL_RESOURCES.replace("#IDENTIFIER#", LocalDataManager.getIdentifier()));
		url.append(Constants.WS_SERVER_RESOURCE_TYPE_DOCUMENT);
		url.append("/").append(LocalDataManager.getCurrentLangugeId());
		
		HttpClientUtils.ResponseEntry re = HttpClientUtils.get(url.toString());
		if(re.statusCode != 200){
			return null;
		}
		return re.toJSONArray();
	}
	
	public static JSONArray getNews(){
		StringBuilder url = new StringBuilder();
		url.append(Constants.WS_SERVER_URL_MESSAGES.replace("#IDENTIFIER#", LocalDataManager.getIdentifier()));
		url.append(Constants.WS_SERVER_RESOURCE_TYPE_NEWS);
		url.append("/").append(LocalDataManager.getCurrentLangugeId());
		
		HttpClientUtils.ResponseEntry re = HttpClientUtils.get(url.toString());
		if(re.statusCode != 200){
			return null;
		}
		return re.toJSONArray();
	}
	
	public static JSONArray getMessages(){
		StringBuilder url = new StringBuilder();
		url.append(Constants.WS_SERVER_URL_MESSAGES.replace("#IDENTIFIER#", LocalDataManager.getIdentifier()));
		url.append(Constants.WS_SERVER_RESOURCE_TYPE_MESSAGES);
		url.append("/").append(LocalDataManager.getCurrentLangugeId());
		
		HttpClientUtils.ResponseEntry re = HttpClientUtils.get(url.toString());
		if(re.statusCode != 200){
			return null;
		}
		return re.toJSONArray();
	}
	
	public static JSONArray getInfo(){
		StringBuilder url = new StringBuilder();
		url.append(Constants.WS_SERVER_URL_RESOURCES.replace("#IDENTIFIER#", LocalDataManager.getIdentifier()));
		url.append(Constants.WS_SERVER_RESOURCE_TYPE_INFO);
		url.append("/").append(LocalDataManager.getCurrentLangugeId());
		
		HttpClientUtils.ResponseEntry re = HttpClientUtils.get(url.toString());
		if(re.statusCode != 200){
			return null;
		}
		return re.toJSONArray();
	}
	
	public static JSONArray getBanners(){
		StringBuilder url = new StringBuilder();
		url.append(Constants.WS_SERVER_URL_RESOURCES.replace("#IDENTIFIER#", LocalDataManager.getIdentifier()));
		url.append(Constants.WS_SERVER_RESOURCE_TYPE_BANNERS).append("/");
		
		HttpClientUtils.ResponseEntry re = HttpClientUtils.get(url.toString());
		if(re.statusCode != 200){
			return null;
		}
		return re.toJSONArray();
	}
	
	public static JSONArray getUrlContent(String url){
		HttpClientUtils.ResponseEntry re = HttpClientUtils.get(url.toString());
		if(re.statusCode != 200){
			return null;
		}
		return re.toJSONArray();
	}
}
