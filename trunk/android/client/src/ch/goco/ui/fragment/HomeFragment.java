package ch.goco.ui.fragment;

import java.util.ArrayList;
import java.util.List;

import org.json.JSONArray;
import org.json.JSONObject;

import ch.goco.company.R;
import ch.goco.config.Constants;
import ch.goco.config.LocalDataManager;
import ch.goco.entity.ActionIconSetup;
import ch.goco.entity.Banner;
import ch.goco.ui.AboutActivity;
import ch.goco.ui.DefaultInfoActivity;
import ch.goco.ui.DocsActivity;
import ch.goco.ui.FormActivity;
import ch.goco.ui.MapShowActivity;
import ch.goco.ui.NewsActivity;
import ch.goco.ui.PhotoActivity;
import ch.goco.ui.RSSActivity;
import ch.goco.ui.ShopCartActivity;
import ch.goco.ui.WebViewActivity;
import ch.goco.webservice.WebServiceUtils;
import android.content.Context;
import android.content.Intent;
import android.graphics.Color;
import android.graphics.drawable.Drawable;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.view.PagerAdapter;
import android.support.v4.view.ViewPager;
import android.util.Log;
import android.util.SparseArray;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.view.ViewGroup;
import android.view.ViewGroup.LayoutParams;
import android.widget.ImageView;
import android.widget.ImageView.ScaleType;
import android.widget.TextView;
import app.fastdev.util.JSONUtils;
import app.fastdev.util.QueueImageLoader;
import app.fastdev.util.SharedPreferencesUtils;
import app.fastdev.util.StringUtils;
import app.fastdev.util.ThreadUtils;

public class HomeFragment extends Fragment implements View.OnClickListener{

	SparseArray<ActionIconSetup> setupEntryArray = new SparseArray<ActionIconSetup>();
	
	Context context;
	View contentView;
	ViewPager viewPager;
	
	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {
		context = container.getContext();
		contentView = inflater.inflate(R.layout.fragment_home, null);
		viewPager = (ViewPager)contentView.findViewById(R.id.viewpager);
		loadCustomConfig(contentView);
		loadIconActionConfig(contentView);
		bindEvent(contentView);
		
		refreshBanners();
		getBannersFromRemote();
		return contentView;
	}
	
	@Override
	public void onClick(View v) {
		ActionIconSetup item = null;
		Intent intent = new Intent(context, DefaultInfoActivity.class);
		switch (v.getId()) {
		case R.id.menu:
		case R.id.back:
			if(onFragmentClickListener != null) onFragmentClickListener.onFragmentClick(v);
			return;
		case R.id.legal:
			item = setupEntryArray.get(5);
			intent.putExtra("data", item.getData());
			break;
		case R.id.action_form_parent:
			item = setupEntryArray.get(4);
			if(item.getSubtype() == 1)
				intent = new Intent(context, FormActivity.class);
			intent.putExtra("data", item.getData());
			break;
		case R.id.action_photo_parent:
			item = setupEntryArray.get(2);
			if(item.getSubtype() == 1)
				intent = new Intent(context, PhotoActivity.class);
			intent.putExtra("data", item.getData());
			break;
		case R.id.action_about_parent:
			item = setupEntryArray.get(3);
			if(item.getSubtype() == 1)
				intent = new Intent(context, AboutActivity.class);
			intent.putExtra("data", item.getData());
			break;			
		case R.id.action_docs_parent:
			item = setupEntryArray.get(1);
			if(item.getSubtype() == 1)
				intent = new Intent(context, DocsActivity.class);
			intent.putExtra("data", item.getData());
			break;	
		case R.id.action_news_parent:
			item = setupEntryArray.get(6);
			if(item.getSubtype() == 1)
				intent = new Intent(context, NewsActivity.class);
			if(item.getSubtype() == 0)
				intent = new Intent(context, RSSActivity.class);
			intent.putExtra("data", item.getData());
			break;		
		case R.id.action_map_parent:
			item = setupEntryArray.get(8);
			if(item.getSubtype() == 1)
				intent = new Intent(context, MapShowActivity.class);
			intent.putExtra("data", item.getData());
			break;				
		case R.id.action_shopcart_parent:
			item = setupEntryArray.get(9);
			if(item.getSubtype() == 1)
				intent = new Intent(context, ShopCartActivity.class);
			intent.putExtra("data", item.getData());
			break;
		default:
			break;
		}

		if(item != null && item.getSubtype() == 2){
			intent = new Intent(context, WebViewActivity.class);
			intent.putExtra("url", item.getData());
		}
		startActivity(intent);
	}
	
	private void loadIconActionConfig(View contentView){
		String setupText = SharedPreferencesUtils.getString(context, Constants.SP_BACKEND_CONFIG_SETUP, null);
		JSONArray ja = JSONUtils.newJSONArray(setupText);
		JSONObject jo;
		for(int i=0;i<ja.length();i++){
			jo = ja.optJSONObject(i);
			setupEntryArray.put(jo.optInt("type"), new ActionIconSetup(jo.optInt("type"), jo.optInt("subtype"), jo.optString("data")));
		}
		JSONObject itemNames = JSONUtils.newJSONObject(SharedPreferencesUtils.getString(context, Constants.SP_BACKEND_CONFIG_ICON_ITEM_NAME, null));
		String langCode = SharedPreferencesUtils.getString(context, Constants.SP_LOCAL_LANGUAGE_CODE, "en");
		int langId = SharedPreferencesUtils.getInt(context, Constants.SP_LOCAL_LANGUAGE_ID, 0);
		int defaultLangId = LocalDataManager.getCurrentLangugeId();
		JSONObject iconNames = itemNames.optJSONObject(""+langId);
		if(iconNames == null) iconNames = itemNames.optJSONObject(""+defaultLangId);
		if(iconNames == null) {
			iconNames = itemNames.optJSONObject(""+langId);
			langCode = SharedPreferencesUtils.getString(context, Constants.SP_LOCAL_LANGUAGE_CODE, "en");
			Log.i(Constants.LOG_TAG, "IconName error. langId: "+langId);
			return;
		}
	
		((TextView)contentView.findViewById(R.id.home_icon_text_1)).setText(iconNames.optString("1",""));
		((TextView)contentView.findViewById(R.id.home_icon_text_2)).setText(iconNames.optString("2",""));
		((TextView)contentView.findViewById(R.id.home_icon_text_3)).setText(iconNames.optString("3",""));
		((TextView)contentView.findViewById(R.id.home_icon_text_4)).setText(iconNames.optString("4",""));
		((TextView)contentView.findViewById(R.id.home_icon_text_5)).setText(iconNames.optString("6",""));
		((TextView)contentView.findViewById(R.id.home_icon_text_6)).setText(iconNames.optString("8",""));
		((TextView)contentView.findViewById(R.id.home_icon_text_7)).setText(iconNames.optString("9",""));
		
		loadIconImage((ImageView)contentView.findViewById(R.id.action_docs), LocalDataManager.getBaseUrl()+"icon_1_"+langCode+"_dis.jpg");
		loadIconImage((ImageView)contentView.findViewById(R.id.action_photo), LocalDataManager.getBaseUrl()+"icon_2_"+langCode+"_dis.jpg");
		loadIconImage((ImageView)contentView.findViewById(R.id.action_about), LocalDataManager.getBaseUrl()+"icon_3_"+langCode+"_dis.jpg");
		loadIconImage((ImageView)contentView.findViewById(R.id.action_form), LocalDataManager.getBaseUrl()+"icon_4_"+langCode+"_dis.jpg");
		loadIconImage((ImageView)contentView.findViewById(R.id.action_news), LocalDataManager.getBaseUrl()+"icon_6_"+langCode+"_dis.jpg");
		loadIconImage((ImageView)contentView.findViewById(R.id.action_map), LocalDataManager.getBaseUrl()+"icon_8_"+langCode+"_dis.jpg");
		loadIconImage((ImageView)contentView.findViewById(R.id.action_shopcart), LocalDataManager.getBaseUrl()+"icon_9_"+langCode+"_dis.jpg");
	}
	
	private void loadIconImage(ImageView imageView, String url){
		QueueImageLoader.getInstance().loadImageViewDrawable(context, imageView, url);
	}
	
	private void loadCustomConfig(final View contentView){
		String imageUrl = null;
		//load back icon
		imageUrl = SharedPreferencesUtils.getString(context, Constants.SP_BACKEND_CONFIG_IMAGE_BACK, null);
		QueueImageLoader.getInstance().loadImageViewDrawable(context, (ImageView)contentView.findViewById(R.id.back), imageUrl);
		
		//load menu icon
		imageUrl = SharedPreferencesUtils.getString(context, Constants.SP_BACKEND_CONFIG_IMAGE_MENU, null);
		QueueImageLoader.getInstance().loadImageViewDrawable(context, (ImageView)contentView.findViewById(R.id.menu), imageUrl);

		//load logo icon
		imageUrl = SharedPreferencesUtils.getString(context, Constants.SP_BACKEND_CONFIG_IMAGE_LOGO, null);
		QueueImageLoader.getInstance().loadImageViewDrawable(context, (ImageView)contentView.findViewById(R.id.logo), imageUrl);
		
		//load header bg
		imageUrl = SharedPreferencesUtils.getString(context, Constants.SP_BACKEND_CONFIG_IMAGE_HEADER, null);
		QueueImageLoader.getInstance().loadDrawable(context, imageUrl, new QueueImageLoader.ImageCallback() {
			@SuppressWarnings("deprecation")
			@Override
			public void imageLoaded(Drawable d, String imageUrl) {
				if(d == null) return;
				View headView = contentView.findViewById(R.id.header);
				int transparency = SharedPreferencesUtils.getInt(context, Constants.SP_BACKEND_CONFIG_TEXT_TRANSPARENCY_HEADER,-1);
				if(transparency < 0) transparency = 0;
				transparency *= 255/100.0;
				if(transparency > 255 ) transparency = 255;
				d.setAlpha(transparency);
				headView.setBackgroundDrawable(d);
			}
		});
		
		//set text color
		String textColor = SharedPreferencesUtils.getString(context, Constants.SP_BACKEND_CONFIG_TEXT_COLOR_HEADER, null);
		if(StringUtils.isNotBlank(textColor)){
			try {
				((TextView)contentView.findViewById(R.id.top_title_text)).setText(LocalDataManager.getLocalCompany().getName());
				((TextView)contentView.findViewById(R.id.top_title_text)).setTextColor(Color.parseColor(textColor));
			} catch (Exception e) {
				Log.i(Constants.LOG_TAG, "Error text color value: "+textColor);
			}
		}
	}
	
	private void bindEvent(View view){
		view.findViewById(R.id.legal).setVisibility(View.VISIBLE);
		// Support only German
		//view.findViewById(R.id.menu).setVisibility(View.VISIBLE);
		view.findViewById(R.id.menu).setOnClickListener(this);
		view.findViewById(R.id.legal).setOnClickListener(this);
		view.findViewById(R.id.action_form_parent).setOnClickListener(this);
		view.findViewById(R.id.action_photo_parent).setOnClickListener(this);
		view.findViewById(R.id.action_about_parent).setOnClickListener(this);
		view.findViewById(R.id.action_docs_parent).setOnClickListener(this);
		view.findViewById(R.id.action_news_parent).setOnClickListener(this);
		view.findViewById(R.id.action_map_parent).setOnClickListener(this);
		view.findViewById(R.id.action_shopcart_parent).setOnClickListener(this);
		view.findViewById(R.id.back).setVisibility(View.GONE);
		
		//阻止顶部标题栏被点击后把事件传递到后面的控件
		view.findViewById(R.id.header).setOnTouchListener(new View.OnTouchListener() {
			@Override
			public boolean onTouch(View v, MotionEvent event) {
				return true;
			}
		});
	}
	
	private void bannerClick(View view, Banner banner){
		Intent intent = new Intent(context, WebViewActivity.class);
		intent.putExtra("url", banner.getUrl());
		startActivity(intent);
	}
	
	private void refreshBanners(){
		List<Banner> itemList = LocalDataManager.getLocalBannerList();
		if(itemList == null) itemList = new ArrayList<Banner>();
		viewPager.setPageMargin(1);
		viewPager.setAdapter(getPagerAdapter(itemList));
	}
	
	private void getBannersFromRemote(){
		ThreadUtils.runOnNewThread(new Runnable() {
			@Override
			public void run() {
				JSONArray ja = WebServiceUtils.getBanners();
				if(ja == null) return;
				List<Banner> itemList = new ArrayList<Banner>(ja.length());
				Banner item = null;
				for(int i=0,j=ja.length();i<j;i++){
					item = new Banner();
					item.setPath(ja.optJSONObject(i).optString("path"));
					item.setUrl(ja.optJSONObject(i).optString("url"));
					itemList.add(item);
				}
				LocalDataManager.setLocalBannerList(itemList);
				ThreadUtils.runOnUiThread(new Runnable() {
					@Override
					public void run() {
						refreshBanners();
					}
				});
			}
		});
	}
	
	private PagerAdapter getPagerAdapter(final List<Banner> itemList){
		return new PagerAdapter() {
			@Override
			public boolean isViewFromObject(View view, Object obj) {
				return view == obj;
			}
			
			@Override
			public int getCount() {
				return itemList.size();
			}
			
			@Override
			public void destroyItem(ViewGroup container, int position, Object object) {
				container.removeView((View)object);
			}
			
			@Override
			public Object instantiateItem(ViewGroup container, int position) {
				ViewPager.LayoutParams lp = new ViewPager.LayoutParams();
				lp.width = LayoutParams.MATCH_PARENT;
				lp.height = LayoutParams.MATCH_PARENT;
				
				final Banner banner = itemList.get(position);
				
				final ImageView imageView = new ImageView(getActivity());
				imageView.setLayoutParams(lp);
				imageView.setScaleType(ScaleType.FIT_XY);
				imageView.setOnClickListener(new View.OnClickListener() {
					@Override
					public void onClick(View v) {
						bannerClick(imageView,banner);
					}
				});
				
				QueueImageLoader.getInstance().loadImageViewDrawable(context, imageView, itemList.get(position).getPath());
				
				container.addView(imageView);
				return imageView;
			}
		};
	}
	
	public void setOnFragmentClickListener(OnFragmentClickListener onFragmentClickListener) {
		this.onFragmentClickListener = onFragmentClickListener;
	}
	
	OnFragmentClickListener onFragmentClickListener;
}
