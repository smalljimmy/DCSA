package ch.goco.ui;

import java.util.ArrayList;
import java.util.List;

import org.json.JSONArray;
import org.json.JSONObject;

import ch.goco.company.R;
import ch.goco.config.Constants;
import ch.goco.config.LocalDataManager;
import android.os.Bundle;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.PopupWindow;
import android.widget.Spinner;
import android.widget.TextView;
import app.fastdev.util.EmailUtils;
import app.fastdev.util.JSONUtils;
import app.fastdev.util.NetworkInfoUtils;
import app.fastdev.util.PopupWindowUtils;
import app.fastdev.util.ResourceUtils;
import app.fastdev.util.SharedPreferencesUtils;
import app.fastdev.util.StringUtils;
import app.fastdev.util.ThreadUtils;
import app.fastdev.util.ToastUtils;

public class ShopCartActivity extends BaseActivity {

	Spinner spinner;
	PopupWindow pw;
	
	String lastContent;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_shop_cart);
		
		spinner = findViewById(R.id.spinner, Spinner.class);
		spinner.setAdapter(new ArrayAdapter<String>(this, android.R.layout.simple_spinner_dropdown_item, getOfferSubject()));
		
		loadCustomConfig();
		bindEventListener();
	}
	
	@Override
	protected void bindEventListener() {
		super.bindEventListener();
		findViewById(R.id.btn_submit).setOnClickListener(this);
	}
	
	@Override
	public void onClick(View v) {
		super.onClick(v);
		switch (v.getId()) {
		case R.id.btn_submit:
			submitForm();
			break;
		default:
			break;
		}
	}
	
	private void submitForm(){
		if(!NetworkInfoUtils.isNetworkAvailable(this)) {
			ToastUtils.showMsg(this, R.string.no_network);
			return;
		}
		String email = findViewById(R.id.email, TextView.class).getText().toString();
		String content = findViewById(R.id.content, TextView.class).getText().toString();
		String title = (String)spinner.getSelectedItem();
		
		if(StringUtils.isBlank(email)){
			ToastUtils.showMsg(this, getResources().getString(R.string.email_is_empty));
			return;
		}
		if(StringUtils.isBlank(title)){
			ToastUtils.showMsg(this, getResources().getString(R.string.title_is_empty));
			return;
		}
		if(StringUtils.isBlank(content)){
			ToastUtils.showMsg(this, getResources().getString(R.string.content_is_empty));
			return;
		}
		
		if(lastContent != null && lastContent.equals(content)){
			ToastUtils.showMsg(this, R.string.submit_duplicate_content);
			return;
		}
		lastContent = content;

		pw = PopupWindowUtils.showLoadingView(this);
		
		final StringBuilder body = new StringBuilder();
		body.append(getResources().getString(R.string.label_email_address)+": \n").append(email).append("\n");
		body.append(getResources().getString(R.string.label_email_title)+": \n").append(title).append("\n");
		body.append(getResources().getString(R.string.label_content)+": \n").append(content);
		
		ThreadUtils.runOnNewThread(new Runnable() {
			@Override
			public void run() {
				EmailUtils.EmailEntry entry = new EmailUtils.EmailEntry();
				entry.host = SharedPreferencesUtils.getString(getApplicationContext(), Constants.SP_BACKEND_CONFIG_SMTP_SERVER, "");
				entry.sender = SharedPreferencesUtils.getString(getApplicationContext(), Constants.SP_BACKEND_CONFIG_SENDER_EMAIL, "");
				entry.recevier = SharedPreferencesUtils.getString(getApplicationContext(), Constants.SP_BACKEND_CONFIG_OFFER_EMAIL, "");
				entry.text = body.toString();
				entry.title = ResourceUtils.getString(getApplicationContext(), R.string.subject_line_request);
				
				String username = SharedPreferencesUtils.getString(getApplicationContext(), Constants.SP_BACKEND_CONFIG_SMTP_USERNAME, "");
				String password = SharedPreferencesUtils.getString(getApplicationContext(), Constants.SP_BACKEND_CONFIG_SMTP_PASSWORD, "");
				
				try {
					EmailUtils.sendTextEmail(username, password, entry);
				} catch (Exception e) {
					e.printStackTrace();
					submitComplete(false);
					return;
				}
				submitComplete(true);
			}
		});
	}

	private void submitComplete(final boolean success){
		closePopupWindow(pw);
		runOnUiThread(new Runnable() {
			@Override
			public void run() {
				if(success){
					PopupWindowUtils.showPopupTextView(ShopCartActivity.this, getSubmitMsg());
				}else{
					PopupWindowUtils.showPopupTextView(ShopCartActivity.this, ResourceUtils.getString(getApplicationContext(), R.string.submit_failed));
				}
			}
		});
	}
	
	private String getSubmitMsg(){
		String text = SharedPreferencesUtils.getString(this, Constants.SP_BACKEND_CONFIG_OFFER_SUBMIT_MSG, null);
		if(text == null) return "SUCCESS";
		
		JSONObject jo = JSONUtils.newJSONObject(text);
		if(jo == null) return "SUCCESS";
		
		JSONArray ja = jo.optJSONArray(LocalDataManager.getCurrentLangugeId()+"");
		if(ja == null){
			ja = jo.optJSONArray(LocalDataManager.getDefaultLangugeId()+"");
		}
		if(ja == null || ja.length() == 0) return "SUCCESS";
		return ja.optJSONObject(0).optString("content","SUCCESS");
	}
	
	private String[] getOfferSubject(){
		String text = SharedPreferencesUtils.getString(this, Constants.SP_BACKEND_CONFIG_OFFER_SUBJECT, null);
		if(text == null) return new String[]{""};
		JSONObject jo = JSONUtils.newJSONObject(text);
		if(jo == null) return new String[]{""};
		JSONArray ja = jo.optJSONArray(LocalDataManager.getCurrentLangugeId()+"");
		if(ja == null){
			ja = jo.optJSONArray(LocalDataManager.getDefaultLangugeId()+"");
		}
		if(ja == null || ja.length() == 0) return new String[]{""};
		List<String> itemList = new ArrayList<String>();
		for(int i=0,j=ja.length();i<j;i++){
			itemList.add(ja.optJSONObject(i).optString("title",""));
		}
		return itemList.toArray(new String[itemList.size()]);
	}
}
