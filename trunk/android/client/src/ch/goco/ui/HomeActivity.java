package ch.goco.ui;

import java.util.Locale;

import ch.goco.company.R;
import ch.goco.config.Constants;
import ch.goco.entity.Language;
import ch.goco.ui.adapter.MenuAdapter;
import ch.goco.ui.fragment.HomeFragment;
import ch.goco.ui.fragment.OnFragmentClickListener;
import android.content.Intent;
import android.content.res.Configuration;
import android.os.Bundle;
import android.support.v4.app.FragmentActivity;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import app.fastdev.util.LocaleUtils;
import app.fastdev.util.SharedPreferencesUtils;
import app.fastdev.util.StringUtils;

public class HomeActivity extends FragmentActivity implements OnFragmentClickListener,AdapterView.OnItemClickListener{

	DrawerLayout mDrawerLayout;
	MenuAdapter adapter;
	String langCode;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_home);
		mDrawerLayout = (DrawerLayout)findViewById(R.id.drawer_layout);
		mDrawerLayout.setDrawerLockMode(DrawerLayout.LOCK_MODE_LOCKED_CLOSED);
		
		langCode = SharedPreferencesUtils.getString(this, Constants.SP_LOCAL_LANGUAGE_CODE, "en");
		
		adapter = new MenuAdapter(this);
		ListView mListView = (ListView)findViewById(R.id.left_drawer);
		mListView.setAdapter(adapter);
		mListView.setOnItemClickListener(this);
		
		HomeFragment fragment = new HomeFragment();
		fragment.setOnFragmentClickListener(this);
		getSupportFragmentManager().beginTransaction().add(R.id.content_frame, fragment).commit();
	}
	
	@Override
	protected void onNewIntent(Intent intent) {
		super.onNewIntent(intent);
		refreshUI();
	}
	
	public void refreshUI(){
		HomeFragment fragment = new HomeFragment();
		fragment.setOnFragmentClickListener(this);
		getSupportFragmentManager().beginTransaction().replace(R.id.content_frame, fragment).commit();
	}
	
	@Override
	public void onFragmentClick(View v) {
		switch (v.getId()) {
		case R.id.menu:
			mDrawerLayout.openDrawer(GravityCompat.END);
			break;
		case R.id.back:
			finish();
			break;
		default:
			break;
		}
	}
	
	@Override
	public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
		mDrawerLayout.closeDrawer(GravityCompat.END);
		
		Language language = adapter.getItem(position);
		if(language.getId() < 0) return;
		
		if(StringUtils.isBlank(language.getCode())) {
			Log.d(Constants.LOG_TAG, "Language code is empty");
			return;
		}
		
		String currentLangCode = SharedPreferencesUtils.getString(this, Constants.SP_LOCAL_LANGUAGE_CODE, null);
		if(language.getCode().equals(currentLangCode)){
			Log.d(Constants.LOG_TAG, "Language not change");
			return;
		}
		
		Locale locale = LocaleUtils.getLocalFromLanguage(language.getCode());
		if(locale == null){
			Log.d(Constants.LOG_TAG, "Language code error: "+language.getCode());
			return;
		}
		
		Log.i(Constants.LOG_TAG, "Language change: "+language.getCode());
		
		//Change Language and Saved to the local
		Configuration conf = getResources().getConfiguration();
		conf.locale = locale;
		getResources().updateConfiguration(conf, getResources().getDisplayMetrics());
		SharedPreferencesUtils.putString(this, Constants.SP_LOCAL_LANGUAGE_CODE, language.getCode())
							  .putInt(Constants.SP_LOCAL_LANGUAGE_ID, language.getId()).commit();
		langCode = language.getCode();
		refreshUI();
	}
}
