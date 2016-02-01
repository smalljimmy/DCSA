package ch.goco.ui;

import org.json.JSONArray;
import org.json.JSONObject;

import ch.goco.company.R;
import ch.goco.config.ConfigManager;
import ch.goco.config.Constants;
import ch.goco.config.LocalDataManager;
import ch.goco.entity.Company;
import ch.goco.service.MessageService;
import ch.goco.webservice.WebServiceUtils;
import android.content.Intent;
import android.graphics.drawable.Drawable;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageView;
import app.fastdev.util.AssetsManagerUtils;
import app.fastdev.util.ContextHolder;
import app.fastdev.util.DigestUtils;
import app.fastdev.util.DownloadManager;
import app.fastdev.util.NetworkInfoUtils;
import app.fastdev.util.QueueImageLoader;
import app.fastdev.util.SharedPreferencesUtils;
import app.fastdev.util.StringUtils;
import app.fastdev.util.ThreadUtils;
import app.fastdev.util.ToastUtils;

public class LoadingActivity extends BaseActivity {

	long start = 0;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_loading);
		
		start = System.currentTimeMillis();
		
		initUtilModule();
		initContentView();
		
		ThreadUtils.runOnNewThread(new Runnable() {
			@Override
			public void run() {
				loadBaseConfig();
				loadRemoteConfig();
				//第一次打开并且未初始化
				if(!SharedPreferencesUtils.getBoolean(getApplicationContext(), Constants.SP_BACKEND_CONFIG_INIT, false)){
					ToastUtils.showMsg(getApplicationContext(), R.string.app_init_failed);
					finish();
					return;
				}
				
				long sleep = System.currentTimeMillis() - start - 3000;
				if(sleep < 0) sleep = 0;
				
				ThreadUtils.sleep(sleep);
				runOnUiThread(new Runnable() {
					@Override
					public void run() {
						initComplete();
					}
				});
			}
		});
	}
	
	@Override
	public void onBackPressed() {
		//Not allowed to return to
		return;
	}
	
	private void initUtilModule(){
		ContextHolder.context = getApplicationContext();
		QueueImageLoader.init();
		ThreadUtils.init();
		DownloadManager.init(getApplicationContext());
	}
	
	private void initContentView(){
		String splash = SharedPreferencesUtils.getString(this, Constants.SP_BACKEND_CONFIG_IMAGE_SPLASH, null);
		if(splash != null){
			QueueImageLoader.getInstance().loadDrawable(this, splash, new QueueImageLoader.ImageCallback() {
				@Override
				public void imageLoaded(Drawable imageDrawable, String imageUrl) {
					if(imageDrawable != null){
						((ImageView)findViewById(R.id.image)).setImageDrawable(imageDrawable);
						findViewById(R.id.text).setVisibility(View.GONE);
					}
				}
			});
		}
	}
	
	private void loadBaseConfig(){
		ConfigManager.loadConfig(AssetsManagerUtils.getInputStream(this, Constants.BASE_CONFIG_NAME));
	}
	
	private void loadRemoteConfig(){
		if(!NetworkInfoUtils.isNetworkAvailable(getApplicationContext())){
			ToastUtils.showMsg(this, R.string.no_network);
			return;
		}
		JSONObject configObject = WebServiceUtils.getConfig();
		if(configObject == null) return;
		
		// refresh app setting
		SharedPreferencesUtils.putString(this, Constants.SP_BACKEND_CONFIG_VERSION, configObject.optString("version",""))
		.putInt(Constants.SP_BACKEND_CONFIG_STATUS, configObject.optInt("status", Constants.SP_BACKEND_CONFIG_STATUS_OFFLINE))
		.putString(Constants.SP_BACKEND_CONFIG_OFFER_EMAIL, configObject.optString("offerEmail",""))
		.putString(Constants.SP_BACKEND_CONFIG_SENDER_EMAIL, configObject.optString("senderEmail",""))
		.putFloat(Constants.SP_BACKEND_CONFIG_LONGITUDE, (float)configObject.optDouble("longitude"))
		.putFloat(Constants.SP_BACKEND_CONFIG_LATITUDE, (float)configObject.optDouble("latitude"))
		.putString(Constants.SP_BACKEND_CONFIG_TEXT_COLOR_HEADER, configObject.optString("txtColorHeader",""))
		.putInt(Constants.SP_BACKEND_CONFIG_TEXT_TRANSPARENCY_HEADER, configObject.optInt("txtTransparencyHeader",0))
		.putString(Constants.SP_BACKEND_CONFIG_BASE_URL, configObject.optString("baseURL",""))
		.putString(Constants.SP_BACKEND_CONFIG_SMTP_SERVER, configObject.optString("smtpServer",""))
		.putString(Constants.SP_BACKEND_CONFIG_SMTP_USERNAME, configObject.optString("smtpUsername",""))
		.putString(Constants.SP_BACKEND_CONFIG_SMTP_PASSWORD, parseSmtpPassword(configObject))
		.putInt(Constants.SP_BACKEND_CONFIG_LANGUAGE_DEFAULT_ID, configObject.optInt("langDefault", 0))
		.putString(Constants.SP_BACKEND_CONFIG_LANGUAGE_LIST, ""+configObject.optJSONArray("language"))
		.putString(Constants.SP_BACKEND_CONFIG_SETUP, ""+configObject.optJSONArray("setup"))
		.putString(Constants.SP_BACKEND_CONFIG_OFFER_SUBJECT, ""+configObject.optJSONObject("offerSubject"))
		.putString(Constants.SP_BACKEND_CONFIG_ICON_ITEM_NAME, ""+configObject.optJSONObject("itemName"))
		.putString(Constants.SP_BACKEND_CONFIG_CONTACT_SUBMIT_MSG, ""+configObject.optJSONObject("contactSubmitMsg"))
		.putString(Constants.SP_BACKEND_CONFIG_OFFER_SUBMIT_MSG, ""+configObject.optJSONObject("offerSubmitMsg"))
		.commit();
		
		SharedPreferencesUtils.putString(getApplicationContext(), Constants.SP_BACKEND_CONFIG_IMAGE_MENU, configObject.optString("baseURL","")+"bgMenu.png")
		.putString(Constants.SP_BACKEND_CONFIG_IMAGE_BACK, configObject.optString("baseURL","")+"bgBack.png")
		.putString(Constants.SP_BACKEND_CONFIG_IMAGE_HEADER, configObject.optString("baseURL","")+"bgHeader.png")
		.putString(Constants.SP_BACKEND_CONFIG_IMAGE_SPLASH, configObject.optString("baseURL","")+"bgSplash.png")
		.putString(Constants.SP_BACKEND_CONFIG_IMAGE_LOGO, configObject.optString("baseURL","")+"bgLogo.png")
		.commit();
		
		saveCompanyInfo(configObject);
		saveDefaultLanguage(configObject);
		
		SharedPreferencesUtils.putBoolean(getApplicationContext(), Constants.SP_BACKEND_CONFIG_INIT, true).commit();
	}
	
	private void initComplete(){
		if(SharedPreferencesUtils.getInt(this, Constants.SP_BACKEND_CONFIG_STATUS, Constants.SP_BACKEND_CONFIG_STATUS_ONLINE) == Constants.SP_BACKEND_CONFIG_STATUS_OFFLINE){
			//APP offline
			ToastUtils.showMsg(this, R.string.app_offline);
			finish();
			return;
		}
		
		startService(new Intent(this, MessageService.class));
		startActivity(HomeActivity.class).finish();
	}

	private void saveDefaultLanguage(JSONObject configObject){
		//如果尚未保存客户端自定义语言，则使用默认语言ID
		int langId = SharedPreferencesUtils.getInt(this, Constants.SP_LOCAL_LANGUAGE_ID, 0);
		if(langId <= 0){
			langId = SharedPreferencesUtils.getInt(this, Constants.SP_BACKEND_CONFIG_LANGUAGE_DEFAULT_ID, 0);
		}
		//查询语言ID对应的语言信息
		JSONArray language = configObject.optJSONArray("language");
		JSONObject obj = null;
		for(int i=0;i<language.length();i++){
			obj = language.optJSONObject(i);
			if(obj.optInt("uid", 0) != langId) obj = null;
		}
		//如果为空，则使用默认的语言信息
		if(obj == null){
			langId = SharedPreferencesUtils.getInt(this, Constants.SP_BACKEND_CONFIG_LANGUAGE_DEFAULT_ID, 0);
			for(int i=0;i<language.length();i++){
				obj = language.optJSONObject(i);
				if(obj.optInt("uid", 0) != langId) obj = null;
				else break;
			}
			
			//如果都为空，则默认使用第一个
			if(obj == null){
				obj = language.optJSONObject(0);
			}
		}
		SharedPreferencesUtils.putInt(getApplicationContext(), Constants.SP_LOCAL_LANGUAGE_ID, obj.optInt("uid"))
							  .putString(Constants.SP_LOCAL_LANGUAGE_CODE, obj.optString("code")).commit();
	}
	
	private void saveCompanyInfo(JSONObject configObject){
		Company company = new Company();
		company.setAddress(configObject.optString("address"));
		company.setCity(configObject.optString("city"));
		company.setFax(configObject.optString("fax"));
		company.setHrnumber(configObject.optString("hrNumber"));
		company.setMailbox(configObject.optString("mailbox"));
		company.setName(configObject.optString("name"));
		company.setTelephone(configObject.optString("telephone"));
		company.setZip(configObject.optString("zip"));
		company.setWww(configObject.optString("www"));
		LocalDataManager.setLocalCompany(company);
	}
	
	private String parseSmtpPassword(JSONObject configObject){
		String val = configObject.optString("smtpPassword","");
		return StringUtils.newString(DigestUtils.XORString(DigestUtils.decodeBase64String(val), Constants.EMAIL_XOR_KEY), "UTF-8") ;
	}
}
