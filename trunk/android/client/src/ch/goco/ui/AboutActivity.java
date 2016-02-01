package ch.goco.ui;

import org.json.JSONArray;

import ch.goco.company.R;
import ch.goco.config.LocalDataManager;
import ch.goco.webservice.WebServiceUtils;
import android.os.Bundle;
import android.widget.PopupWindow;
import android.widget.TextView;
import app.fastdev.util.JSONUtils;
import app.fastdev.util.NetworkInfoUtils;
import app.fastdev.util.PopupWindowUtils;
import app.fastdev.util.ThreadUtils;

public class AboutActivity extends BaseActivity {

	TextView textView;
	PopupWindow pw;
	
	String text;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_about);
		loadCustomConfig();
		
		textView = findViewById(R.id.text, TextView.class);
		
		bindEventListener();
		loadDataFromLocal();
	}
	
	@Override
	protected void onResume() {
		super.onResume();
		ThreadUtils.runOnUiThread(new Runnable() {
			@Override
			public void run() {
				loadDataFromRemote();
			}
		}, 500);
	}
	
	private void loadDataFromLocal(){
		JSONArray ja = JSONUtils.newJSONArray(LocalDataManager.getLocalInfo());
		if(ja == null || ja.length() == 0) return;
		text = ja.optJSONObject(0).optString("content", "");
		textView.setText(text);
	}
	
	private void loadDataFromRemote(){
		if(!NetworkInfoUtils.isNetworkAvailable(this)) return;
		if(text == null) pw = PopupWindowUtils.showLoadingView(this);
		ThreadUtils.runOnNewThread(new Runnable() {
			@Override
			public void run() {
				JSONArray ja = WebServiceUtils.getInfo();
				closePopupWindow(pw);
				if(ja == null) return;
				String val = ja.optJSONObject(0).optString("content", "");
				// same text
				if(text != null && text.length() == val.length()){
					return;
				}
				text = val;
				LocalDataManager.setLoaclInfo(ja.toString());
				runOnUiThread(new Runnable() {
					public void run() {
						textView.setText(text);
					}
				});
			}
		});
	}

}
