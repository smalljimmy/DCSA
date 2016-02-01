package ch.goco.ui;

import java.util.Locale;

import ch.goco.company.R;
import ch.goco.config.Constants;
import ch.goco.config.LocalDataManager;
import android.app.Activity;
import android.content.Intent;
import android.content.res.Configuration;
import android.graphics.Color;
import android.graphics.drawable.Drawable;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.View;
import android.widget.ImageView;
import android.widget.PopupWindow;
import android.widget.TextView;
import app.fastdev.util.LocaleUtils;
import app.fastdev.util.QueueImageLoader;
import app.fastdev.util.SharedPreferencesUtils;
import app.fastdev.util.StringUtils;

public class BaseActivity extends Activity implements View.OnClickListener{

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		reBindCustomLanguage();
	}
	
	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		//if(menu != null) menu.clear();
		return false;
	}
	
	private void reBindCustomLanguage(){
		String code = SharedPreferencesUtils.getString(this, Constants.SP_LOCAL_LANGUAGE_CODE, null);
		if(code == null) return;
		Locale locale = LocaleUtils.getLocalFromLanguage(code);
		if(locale == null) return;
		Configuration conf = getResources().getConfiguration();
		conf.locale = locale;
		getResources().updateConfiguration(conf, getResources().getDisplayMetrics());
	}

	@SuppressWarnings("unchecked")
	public <T extends View> T findViewById(int resId, Class<T> cls){
		return (T)findViewById(resId);
	}
	
	public Activity startActivity(Class<? extends Activity> cls){
		return startActivity(cls,null,-1);
	}
	
	public Activity startActivity(Class<? extends Activity> cls, Bundle bundle){
		return startActivity(cls,bundle,-1);
	}
	
	public Activity startActivity(Class<? extends Activity> cls, Bundle bundle, int flag){
		final Intent intent = new Intent(this, cls);
		if(bundle != null) intent.putExtras(bundle);
		if(flag > -1) intent.setFlags(flag);
		runOnUiThread(new Runnable() {
			@Override
			public void run() {
				startActivity(intent);
			}
		});
		return this;
	}
	
	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.back:
			finish();
			break;
		default:
			break;
		}
	}
	
	protected void bindEventListener(){
		View view = findViewById(R.id.back);
		if(view != null) view.setOnClickListener(this);
	}
	
	protected void closePopupWindow(final PopupWindow pw){
		runOnUiThread(new Runnable() {
			@Override
			public void run() {
				if(pw != null) pw.dismiss();
			}
		});
	}
	
	protected void loadCustomConfig(){
		//load back icon
		String imageUrl = SharedPreferencesUtils.getString(this, Constants.SP_BACKEND_CONFIG_IMAGE_BACK, null);
		QueueImageLoader.getInstance().loadImageViewDrawable(this, (ImageView)findViewById(R.id.back), imageUrl);
		
		//load menu icon
		imageUrl = SharedPreferencesUtils.getString(this, Constants.SP_BACKEND_CONFIG_IMAGE_MENU, null);
		QueueImageLoader.getInstance().loadImageViewDrawable(this, (ImageView)findViewById(R.id.menu), imageUrl);
		
		//load logo icon
		imageUrl = SharedPreferencesUtils.getString(this, Constants.SP_BACKEND_CONFIG_IMAGE_LOGO, null);
		QueueImageLoader.getInstance().loadImageViewDrawable(this, (ImageView)findViewById(R.id.logo), imageUrl);
		
		//load header bg
		imageUrl = SharedPreferencesUtils.getString(this, Constants.SP_BACKEND_CONFIG_IMAGE_HEADER, null);
		QueueImageLoader.getInstance().loadDrawable(this, imageUrl, new QueueImageLoader.ImageCallback() {
			@SuppressWarnings("deprecation")
			@Override
			public void imageLoaded(Drawable d, String imageUrl) {
				if(d == null) return;
				View headView = findViewById(R.id.header);
				int transparency = SharedPreferencesUtils.getInt(getApplicationContext(), Constants.SP_BACKEND_CONFIG_TEXT_TRANSPARENCY_HEADER,-1);
				if(transparency >= 0) d.setAlpha(transparency);
				headView.setBackgroundDrawable(d);
			}
		});
		
		//set text color
		String textColor = SharedPreferencesUtils.getString(this, Constants.SP_BACKEND_CONFIG_TEXT_COLOR_HEADER, null);
		if(StringUtils.isNotBlank(textColor)){
			try {
				((TextView)findViewById(R.id.top_title_text)).setText(LocalDataManager.getLocalCompany().getName());
				((TextView)findViewById(R.id.top_title_text)).setTextColor(Color.parseColor(textColor));
			} catch (Exception e) {
				Log.i(Constants.LOG_TAG, "Error set title: "+e);
			}
		}
	}
}
