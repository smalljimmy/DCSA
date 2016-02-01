package ch.goco.ui;


import java.util.ArrayList;
import java.util.Iterator;
import java.util.List;

import org.json.JSONArray;
import org.json.JSONObject;

import com.handmark.pulltorefresh.library.PullToRefreshBase;
import com.handmark.pulltorefresh.library.PullToRefreshScrollView;

import ch.goco.company.R;
import ch.goco.config.LocalDataManager;
import ch.goco.entity.Photo;
import ch.goco.webservice.WebServiceUtils;
import android.os.Bundle;
import android.os.Handler;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup.LayoutParams;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ScrollView;
import app.fastdev.util.DigestUtils;
import app.fastdev.util.DisplayUtils;
import app.fastdev.util.NetworkInfoUtils;
import app.fastdev.util.QueueImageLoader;
import app.fastdev.util.ThreadUtils;

public class PhotoActivity extends BaseActivity{

	List<Photo> photoList = new ArrayList<Photo>();
	String dataSign;
	
	LinearLayout container;
	PullToRefreshScrollView pullToRefreshScrollView;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_photo);
		
		pullToRefreshScrollView = findViewById(R.id.refresh_scroll_view, PullToRefreshScrollView.class);
		container = (LinearLayout)findViewById(R.id.content_container, PullToRefreshScrollView.class);
		
		loadCustomConfig();
		bindEventListener();
	
		loadDataFromLocal();
		refreshContentView();
	}
	
	@Override
	protected void onResume() {
		super.onResume();
		new Handler().postDelayed(new Runnable() {
			@Override
			public void run() {
				if(!NetworkInfoUtils.isNetworkAvailable(getApplicationContext())) return;
				pullToRefreshScrollView.setRefreshing();
				loadDataFromRemote();
			}
		}, 500);
	}
	
	private void bindImageClickEvent(ImageView view, final Photo photo){
		view.setOnClickListener(new View.OnClickListener() {
			@Override
			public void onClick(View v) {
				int index = photoList.indexOf(photo);
				if(index == -1) return;
				
				Bundle bundle = new Bundle();
				bundle.putInt("index", index);
				startActivity(PhotoDetailActivity.class, bundle);
			}
		});
		
		pullToRefreshScrollView.setOnRefreshListener(new PullToRefreshScrollView.OnRefreshListener<ScrollView>() {
			@Override
			public void onRefresh(PullToRefreshBase<ScrollView> refreshView) {
				loadDataFromRemote();
			}
		});
	}
	
	private void refreshContentView(){
		container.removeAllViews();
		boolean first = true;
		LinearLayout contentView;
		ImageView imageView;
		Iterator<Photo> iterator = photoList.iterator();
		Photo item;
		LinearLayout.LayoutParams lp;
		while(iterator.hasNext()){
			//第一列图片
			item = iterator.next();
			contentView = (LinearLayout)LayoutInflater.from(this).inflate(R.layout.adapter_photo_list_item, null);
			imageView = (ImageView)contentView.findViewById(R.id.image1);
			bindImageClickEvent(imageView,item);
			QueueImageLoader.getInstance().loadImageViewDrawable(this, imageView, LocalDataManager.getBaseUrl()+item.getPath());
			
			//第二列图片
			if(iterator.hasNext()){
				item = iterator.next();
				imageView = (ImageView)contentView.findViewById(R.id.image2);
				bindImageClickEvent(imageView,item);
				QueueImageLoader.getInstance().loadImageViewDrawable(this, imageView, LocalDataManager.getBaseUrl()+item.getPath());
			}else{
				contentView.findViewById(R.id.image2).setVisibility(View.INVISIBLE);
			}
			
			lp = new LinearLayout.LayoutParams(LayoutParams.MATCH_PARENT,LayoutParams.WRAP_CONTENT);
			lp.topMargin = DisplayUtils.dip2px(this, 10);
			//只有第一个不设置顶部间距
			if(first){
				lp.topMargin = 0;
				first = false;
			}
			
			container.addView(contentView, lp);
		}
		
		pullToRefreshScrollView.onRefreshComplete();
	}
	
	private void loadDataFromLocal(){
		List<Photo> itemList = LocalDataManager.getLocalPhotoList();
		if(itemList == null) return;
		StringBuilder build = new StringBuilder();
		for(Photo item:itemList){
			build.append(item.getPath());
		}
		dataSign = DigestUtils.md5String(build.toString());
		photoList = itemList;
	}
	
	private void loadDataFromRemote(){
		if(!NetworkInfoUtils.isNetworkAvailable(this)) return;
		ThreadUtils.runOnNewThread(new Runnable() {
			@Override
			public void run() {
				JSONArray ja = WebServiceUtils.getImages();
				runOnUiThread(new Runnable() {
					public void run() {
						pullToRefreshScrollView.onRefreshComplete();
					}
				});
				if(ja == null) return;
				List<Photo> itemList = new ArrayList<Photo>(ja.length());
				JSONObject obj;
				StringBuilder build = new StringBuilder();
				for(int i=0,j=ja.length();i<j;i++){
					obj = ja.optJSONObject(i);
					itemList.add(new Photo(obj.optInt("uid"),obj.optString("path")));
					build.append(obj.optString("path"));
				}
				LocalDataManager.setLocalPhotoList(itemList);
				String newdataSign = DigestUtils.md5String(build.toString());
				if(newdataSign.equals(dataSign)) return;
				photoList = itemList;
				runOnUiThread(new Runnable() {
					@Override
					public void run() {
						refreshContentView();
					}
				});
			}
		});
	}
}