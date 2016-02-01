package app.fastdev.util;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.lang.ref.SoftReference;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.Queue;
import java.util.concurrent.ConcurrentHashMap;
import java.util.concurrent.ConcurrentLinkedQueue;
import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;

import android.annotation.SuppressLint;
import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.drawable.BitmapDrawable;
import android.graphics.drawable.Drawable;
import android.os.Handler;
import android.os.Message;
import android.view.View;
import android.widget.ImageView;

@SuppressWarnings("deprecation")
public class QueueImageLoader {
	
	private static QueueImageLoader imageLoader = null;
	
	public static void init(){
		imageLoader = new QueueImageLoader();
	}
	
	public static QueueImageLoader getInstance() {
		return imageLoader;
	}
	
	public interface ImageCallback {
		/**
		 * 图片加载完成后的回调函数
		 * @param imageDrawable 图片对象
		 * @param imageUrl 图片地址
		 */
		public void imageLoaded(Drawable imageDrawable, String imageUrl);
	}
	
	public Bitmap getBitmapFromLocalPath(String path) {
		if(!new File(path).exists()) return null;
		Bitmap bitmap = BitmapFactory.decodeFile(path);
		if(bitmap == null){
			new File(path).delete();
		}
		return bitmap;
	}
	
	public void loadImageViewDrawable(Context context,final ImageView imageView,final String imageUrl){
		Drawable d = loadDrawable(context, imageUrl, new ImageCallback() {
			@Override
			public void imageLoaded(Drawable d, String imageUrl) {
				if(d != null && imageView != null) imageView.setImageDrawable(d);
			}
		});
		if(d != null && imageView != null) imageView.setImageDrawable(d);
	}
	
	public void loadViewBackgroundDrawable(Context context,final View view,final String imageUrl){
		Drawable d = loadDrawable(context, imageUrl, new ImageCallback() {
			@Override
			public void imageLoaded(Drawable d, String imageUrl) {
				if(d != null && view != null) view.setBackgroundDrawable(d);
			}
		});
		if(d != null && view != null) view.setBackgroundDrawable(d);
	}
	
	public Drawable loadDrawable(Context context, final String imageUrl, ImageCallback callback){
		if(StringUtils.isBlank(imageUrl)) return null;
		Bitmap bitmap = null;
		SoftReference<Bitmap> softRefBitmap = bitmapCacheMap.get(imageUrl);
		if(softRefBitmap != null) bitmap = softRefBitmap.get();
		if(bitmap == null) bitmap = getBitmapFromLocalPath(LocalFileManager.getLocalImageFilePath(imageUrl));
		
		if(addQueue(imageUrl, callback)) {
			return null;
		}
		
		if(bitmap != null){
			addToCheckUrlCachePastDueQueue(imageUrl);
			handler.sendMessage(handler.obtainMessage(0, new Object[]{imageUrl,bitmap}));
			return new BitmapDrawable(bitmap);
		}
		
		executorService.submit(new Runnable() {
			@Override
			public void run() {
				saveImageToFileFromUrl(imageUrl);
				String path = LocalFileManager.getLocalImageFilePath(imageUrl);
				Bitmap bitmap = getBitmapFromLocalPath(path);
				handler.sendMessage(handler.obtainMessage(0, new Object[]{imageUrl,bitmap}));
			}
		});
		
		return null;
	}
	
	/**
	 * 保存图片文件到本地
	 * @param content
	 * @param imageUrl
	 * @return
	 */
	private void saveImageToFileFromUrl(String imageUrl){
		if(StringUtils.isBlank(imageUrl)) return;
		String path = LocalFileManager.getLocalImageFilePath(imageUrl);
		InputStream is = null;
		HttpURLConnection conn = null;
		FileOutputStream fos = null;
		File tempFile = new File(LocalFileManager.getLocalTempFilePath(imageUrl));
		File file = new File(path);
		if(!file.getParentFile().exists()) file.getParentFile().mkdirs();
		if(!tempFile.getParentFile().exists()) tempFile.getParentFile().mkdirs();
		if (!file.exists()) {
			try {
				conn = (HttpURLConnection) new URL(imageUrl).openConnection();
				conn.setConnectTimeout(5000);
				conn.setReadTimeout(5000);
				conn.setRequestMethod("GET");
				conn.connect();
				is = conn.getInputStream();
				fos = new FileOutputStream(tempFile);
				int size = 0;
				byte[] buffer = new byte[1024];
				while ((size = is.read(buffer)) != -1)
					fos.write(buffer, 0, size);
				fos.flush();
				fos.close();
				
				tempFile.renameTo(file);
			}catch (Exception e) {
				e.printStackTrace();
			} finally {
				try {
					if (fos != null) {
						fos.close();
						fos = null;
					}
					if (file != null)
						file = null;
					if (conn != null)
						conn.disconnect();
				} catch (IOException e) {
					e.printStackTrace();
				}
			}
		}
	}
	
	/**
	 * 添加到任务队列，如果已经存在相同的地址，则添加到对应的回调集合中
	 * @param imageUrl
	 * @param callback
	 * @return true 已存在相同地址，把回调添加到已存在的回调集合中，false 不存在相同地址
	 */
	private boolean addQueue(String imageUrl, ImageCallback callback){
		Queue<ImageCallback> callbackQueue = null;
		if(imageCallbackMap.containsKey(imageUrl)){
			callbackQueue = imageCallbackMap.get(imageUrl);
			if(callback != null) callbackQueue.add(callback);
			return true;
		}
		callbackQueue = new ConcurrentLinkedQueue<ImageCallback>();
		imageCallbackMap.put(imageUrl, callbackQueue);
		if(callback != null) callbackQueue.add(callback);
		return false;
	}
	
	private void addToCheckUrlCachePastDueQueue(String imageUrl){
		if(checkUrlCachePastDueResCache.containsKey(imageUrl)) return;
		checkUrlCachePastDueQueue.add(imageUrl);
		runCheckThread();
	}
	
	private Thread checkThread;
	private void runCheckThread(){
		if(checkThread != null) return;
		checkThread = new Thread(){
			public void run() {
				String image = checkUrlCachePastDueQueue.poll();
				HttpURLConnection conn = null;
				File file;
				while(image != null){
					try {
						conn = (HttpURLConnection) new URL(image).openConnection();
						conn.setConnectTimeout(5000);
						conn.setReadTimeout(5000);
						conn.setRequestMethod("GET");
						conn.connect();
						
						if(conn.getResponseCode() != 200){
							image = checkUrlCachePastDueQueue.poll();
							continue;
						}
						
						file = new File(LocalFileManager.getLocalImageFilePath(image));
						int length = conn.getContentLength();
						
						if(file.exists() && file.length() == length){
							checkUrlCachePastDueResCache.put(image, "true");
						}else if(file.exists() && file.length() != length){
							file.delete();
							saveImageToFileFromUrl(image);
						}
					} catch (Exception e) {
						//e.printStackTrace();
					}finally{
						if(conn != null) conn.disconnect();
					}
					image = checkUrlCachePastDueQueue.poll();
				}
				checkThread = null;
			};
		};
		checkThread.start();
	}
	
	@SuppressLint("HandlerLeak")
	private Handler handler = new Handler() {
		@Override
		public void handleMessage(Message msg) {
			if (msg.obj == null) return;
			Object[] objs = (Object[])msg.obj;
			String imageUrl = (String)objs[0];
			Bitmap bitmap = (Bitmap)objs[1];
			Drawable imageDrawable = null;
			if(bitmap != null){
				bitmapCacheMap.put(imageUrl, new SoftReference<Bitmap>(bitmap));
				imageDrawable = new BitmapDrawable(bitmap);
			}
			
			Queue<ImageCallback> callbackQueue = imageCallbackMap.remove(imageUrl);
			if(callbackQueue != null){
				for(ImageCallback callback:callbackQueue){
					callback.imageLoaded(imageDrawable, imageUrl);
				}
			}
		}
	};
	
	private ConcurrentHashMap<String, Queue<ImageCallback>> imageCallbackMap = new ConcurrentHashMap<String, Queue<ImageCallback>>();
	private ExecutorService executorService = Executors.newFixedThreadPool(5);
	private ConcurrentHashMap<String, SoftReference<Bitmap>> bitmapCacheMap = new ConcurrentHashMap<String, SoftReference<Bitmap>>();
	private Queue<String> checkUrlCachePastDueQueue = new ConcurrentLinkedQueue<String>();
	private ConcurrentHashMap<String, String> checkUrlCachePastDueResCache = new ConcurrentHashMap<String, String>();
}