package ch.goco.ui;

import org.json.JSONArray;
import org.json.JSONObject;

import ch.goco.company.R;
import ch.goco.config.Constants;
import ch.goco.config.LocalDataManager;
import ch.goco.entity.Company;
import android.os.Bundle;
import android.text.Html;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.PopupWindow;
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

public class FormActivity extends BaseActivity{

	Button submit;
	EditText editTitle,editContent;
	PopupWindow pw;
	
	String lastContent;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_form);
		
		submit = findViewById(R.id.btn_submit,Button.class);
		editTitle = findViewById(R.id.editTitle, EditText.class);
		editContent = findViewById(R.id.editContent, EditText.class);
		
		Company company = LocalDataManager.getLocalCompany();
		StringBuilder text = new StringBuilder();
		text.append(company.getName()).append("<br>");
		text.append(company.getAddress()).append("<br>");
		text.append(company.getZip()).append(" ").append(company.getCity()).append("<br>");
		text.append("<br>");
		text.append(ResourceUtils.getString(this, R.string.telephone)).append(". ").append(company.getTelephone()).append("<br>");
		text.append(ResourceUtils.getString(this, R.string.fax)).append(". ").append(company.getFax()).append("<br>");
		text.append(ResourceUtils.getString(this, R.string.email)).append(". ").append(company.getMailbox()).append("<br>");
		findViewById(R.id.companyInfo, TextView.class).setText(Html.fromHtml(text.toString()));
		
		loadCustomConfig();
		bindEventListener();
	}
	
	public void bindEventListener(){
		super.bindEventListener();
		submit.setOnClickListener(this);
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
		
		String title = editTitle.getText().toString().trim();
		String content = editContent.getText().toString().trim();
		
		if(StringUtils.isBlank(title)){
			ToastUtils.showMsg(this, getResources().getString(R.string.email_is_empty));
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
		
		final StringBuilder body = new StringBuilder();
		body.append(getResources().getString(R.string.label_email_address)+": \n").append(title).append("\n");
		body.append(getResources().getString(R.string.label_content)+": \n").append(content);
		
		pw = PopupWindowUtils.showLoadingView(this);
		
		ThreadUtils.runOnNewThread(new Runnable() {
			@Override
			public void run() {
				EmailUtils.EmailEntry entry = new EmailUtils.EmailEntry();
				entry.host = SharedPreferencesUtils.getString(getApplicationContext(), Constants.SP_BACKEND_CONFIG_SMTP_SERVER, "");
				entry.sender = SharedPreferencesUtils.getString(getApplicationContext(), Constants.SP_BACKEND_CONFIG_SENDER_EMAIL, "");
				entry.recevier = SharedPreferencesUtils.getString(getApplicationContext(), Constants.SP_BACKEND_CONFIG_OFFER_EMAIL, "");
				entry.text = body.toString();
				entry.title = ResourceUtils.getString(getApplicationContext(), R.string.subject_line_contact);
				
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
					PopupWindowUtils.showPopupTextView(FormActivity.this, getSubmitMsg());
				}else{
					PopupWindowUtils.showPopupTextView(FormActivity.this, ResourceUtils.getString(getApplicationContext(), R.string.submit_failed));
				}
			}
		});
	}
	
	private String getSubmitMsg(){
		String text = SharedPreferencesUtils.getString(this, Constants.SP_BACKEND_CONFIG_CONTACT_SUBMIT_MSG, null);
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
}
