package app.fastdev.util;

import org.apache.http.HttpResponse;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.params.BasicHttpParams;
import org.apache.http.params.HttpConnectionParams;
import org.apache.http.params.HttpProtocolParams;
import org.apache.http.util.EntityUtils;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.util.Log;

import ch.goco.config.Constants;

public class HttpClientUtils {

	public static ResponseEntry get(String url){
		BasicHttpParams httpParams = new BasicHttpParams();  
	    HttpConnectionParams.setConnectionTimeout(httpParams, Constants.REQUEST_TIMEOUT);  
	    HttpConnectionParams.setSoTimeout(httpParams, Constants.REQUEST_TIMEOUT);
	    HttpProtocolParams.setContentCharset(httpParams, Constants.DEFAULT_CHARSET);
		DefaultHttpClient httpClient = new DefaultHttpClient(httpParams);
		
		ResponseEntry re = new ResponseEntry();
		try {
			Log.d(Constants.LOG_TAG, "HttpClientUtils.get, url: "+url);
			HttpResponse response = httpClient.execute(new HttpGet(url));
			re.statusCode = response.getStatusLine().getStatusCode();
			re.body = EntityUtils.toString(response.getEntity(), Constants.DEFAULT_CHARSET);
		}catch (Exception e) {
			Log.w(Constants.LOG_TAG, e);
			re.statusCode = 0;
		}
		Log.d(Constants.LOG_TAG, "HttpClientUtils.get, ResponseEntry: "+re);
		return re;
	}
	
	public static class ResponseEntry{
		public int statusCode;
		public String body;
		
		@Override
		public String toString() {
			StringBuilder builder = new StringBuilder();
			builder.append("{statusCode: ").append(statusCode).append(", ");
			builder.append("body: ").append(body).append("}");
			return builder.toString();
		}
		
		public JSONObject toJSONObject(){
			try {
				return new JSONObject(body);
			} catch (JSONException e) {
				Log.w(Constants.LOG_TAG, e);
				return null;
			}
		}
		
		public JSONArray toJSONArray(){
			try {
				return new JSONArray(body);
			} catch (JSONException e) {
				Log.w(Constants.LOG_TAG, e);
				return null;
			}
		}
	}
}
