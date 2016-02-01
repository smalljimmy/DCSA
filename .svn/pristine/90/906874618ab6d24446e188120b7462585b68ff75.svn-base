package app.fastdev.util;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;
import java.util.Queue;
import java.util.concurrent.ConcurrentHashMap;
import java.util.concurrent.ConcurrentLinkedQueue;

import ch.goco.company.R;
import ch.goco.config.Constants;
import android.content.Context;
import android.os.Handler;
import android.util.Log;

public class DownloadManager {

	static DownloadManager dm;
	
	Map<String,DownloadThread> taskMap = new ConcurrentHashMap<String, DownloadManager.DownloadThread>();
	Context context;
	Handler handler;
	
	public static void init(Context context){
		dm = new DownloadManager(context);
	}
	
	public static DownloadManager getInstance(){
		if(dm == null) throw new RuntimeException("DownloadManager is not yet initialize");
		return dm;
	}
	
	private DownloadManager(Context context){
		this.context = context;
		this.handler = new Handler();
	}
	
	public boolean isDownloading(String url){
		return taskMap.containsKey(url);
	}
	
	public void addTask(DownLoadEntity entity, DownloadCallback callback){
		DownloadThread downloadThread = taskMap.get(entity.url);
		if(downloadThread == null){
			downloadThread = new DownloadThread(entity,callback);
			taskMap.put(entity.url, downloadThread);
			downloadThread.start();
		}else{
			downloadThread.addDownloadCallback(callback);
		}
	}
	
	public void removeTask(DownLoadEntity entity){
		taskMap.remove(entity.url);
	}
	
	class DownloadThread extends Thread{
		Queue<DownloadCallback> callbackQueue;
		DownLoadEntity entity;
		String path;
		
		long totalSize = 0;
		long currentSize = 0;
		int progress = 0;
		
		DownloadThread(DownLoadEntity entity, DownloadCallback callback){
			this.entity = entity;
			this.path = entity.path;
			callbackQueue = new ConcurrentLinkedQueue<DownloadManager.DownloadCallback>();
			addDownloadCallback(callback);
		}
		
		void addDownloadCallback(DownloadCallback callback){
			if(callback != null)
				callbackQueue.add(callback);
		}
		
		public void run(){
			try {
				doDownloading();
			} catch (Exception e) {
				e.printStackTrace();
			}
			removeTask(entity);
		}
		
		void doDownloading(){
			triggerDoStarting();
			File temp = new File(path+context.getPackageName()+".tmp");
			File saveFile = new File(path);
			
			FileOutputStream fos = null;
			HttpURLConnection conn = null;
			InputStream is = null;
			byte buffer[] = new byte[8192];
			boolean append = false;
			try {
				
				conn = (HttpURLConnection) new URL(entity.url).openConnection();
				conn.setConnectTimeout(5000);
				conn.setReadTimeout(5000);
				
				if(!temp.getParentFile().exists()){
					temp.getParentFile().mkdirs();
				}
				
				//文件尚未下载完成，继续下载
				if(temp.exists()){
					currentSize = temp.length();
					conn.setRequestProperty("Range", "bytes="+currentSize+"-");
					append = true;
				}
				
				conn.connect();
				
				int code = conn.getResponseCode();
				totalSize = conn.getContentLength();
				String contentType = conn.getContentType();
				Log.d(Constants.LOG_TAG, "download, code: "+code+", totalSize: "+totalSize+", contentType: "+contentType);
				
				/**
				Map<String, List<String>> headerMap = conn.getHeaderFields();
				Set<Entry<String, List<String>>> entryList = headerMap.entrySet();
				for(Entry<String, List<String>> entry:entryList){
					System.out.println(entry.getKey()+"="+StringUtil.join(entry.getValue(), ","));
				}
				**/
				
				//临时文件已经存在，但是不支持断点续传
				if(code == 200 && temp.exists()){
					temp.delete();
					currentSize = 0;
				}
				
				if(code == 206){
					Log.d(Constants.LOG_TAG, "start continue, already download: "+currentSize);
					totalSize += currentSize;
				}
				
				if(saveFile.exists() && saveFile.length() == totalSize){
					triggerDoComplete(true);
					return;
				}
				
				is = conn.getInputStream();
				fos = new FileOutputStream(temp,append);
				int len = 0;
				int rate = 0;
				while ((len = is.read(buffer)) != -1) {
					fos.write(buffer,0,len);
					currentSize += len;
					rate = (int)(currentSize * 100 / totalSize);
					if(rate > progress){
						progress = rate;
						triggerDoProgress(progress);
						Thread.sleep(100);
					}
				}
				
				temp.renameTo(saveFile);
				Runtime.getRuntime().exec("chmod 644 " + saveFile);  
				triggerDoComplete(true);
			} catch (Exception e) {
				e.printStackTrace();
				triggerDoComplete(false);
			}finally{
				if(fos != null){
					try {
						fos.close();
					} catch (IOException e) {
						e.printStackTrace();
					}
				}
				if(is != null){
					try {
						is.close();
					} catch (IOException e) {
						e.printStackTrace();
					}
				}
				if(conn != null){
					conn.disconnect();
				}
			}
		}
		
		void triggerDoStarting(){
			handler.post(new Runnable() {
				@Override
				public void run() {
					NotificationUtils.updateProgressNotification(context, entity.seriNum, entity.title, 0);
				}
			});
			
			List<DownloadCallback> callbackList = new ArrayList<DownloadCallback>(callbackQueue);
			for(DownloadCallback callback:callbackList){
				callback.doStarting(entity);
			}
		}
		
		void triggerDoComplete(final boolean success){
			handler.post(new Runnable() {
				@Override
				public void run() {
					if(!success){
						NotificationUtils.updateTextNotification(context, entity.seriNum, entity.title, ResourceUtils.getString(ContextHolder.context, R.string.download_failed));
					}else{
						NotificationUtils.updateTextNotification(context, entity.seriNum, entity.title, ResourceUtils.getString(ContextHolder.context, R.string.download_complete));
					}
				}
			});
			List<DownloadCallback> callbackList = new ArrayList<DownloadCallback>(callbackQueue);
			for(DownloadCallback callback:callbackList){
				callback.doComplete(entity, success);
			}
		}
		
		void triggerDoProgress(final int progress){
			handler.post(new Runnable() {
				@Override
				public void run() {
					NotificationUtils.updateProgressNotification(context, entity.seriNum, entity.title, progress);
				}
			});
			List<DownloadCallback> callbackList = new ArrayList<DownloadCallback>(callbackQueue);
			for(DownloadCallback callback:callbackList){
				callback.doProgress(entity,progress);
			}
		}
	}
	
	public static class DownloadCallback{
		
		/**
		 * 开始下载时的回调
		 * @param apkInfo
		 * @param path
		 */
		public void doStarting(DownLoadEntity entity){
		}
		
		/**
		 * 下载操作完成时的回调
		 * @param apkInfo
		 * @param path
		 * @param success true 下载成功， false 下载失败
		 */
		public void doComplete(DownLoadEntity entity, boolean success){
		}
		
		/**
		 * 下载进度回调
		 * @param apkInfo 应用信息
		 * @param rate 下载完成比率
		 * @param path  保存路径
		 */
		public void doProgress(DownLoadEntity entity, int progress){
		}
	}
	
	public static class DownLoadEntity{
		public int seriNum;
		public String title;
		public String url;
		public String path;
		
		public DownLoadEntity(int seriNum, String title, String url, String path) {
			super();
			this.seriNum = seriNum;
			this.title = title;
			this.url = url;
			this.path = path;
		}
	}
}
