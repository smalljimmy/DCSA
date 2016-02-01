package ch.goco.ui;

import ch.goco.company.R;
import ch.goco.config.Constants;
import ch.goco.config.LocalDataManager;
import android.annotation.SuppressLint;
import android.graphics.Bitmap;
import android.os.Bundle;
import android.util.Log;
import android.webkit.WebChromeClient;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.PopupWindow;
import app.fastdev.util.NetworkInfoUtils;
import app.fastdev.util.PopupWindowUtils;
import app.fastdev.util.ToastUtils;

public class MapShowActivity extends BaseActivity {

	WebView webView;
	PopupWindow pw;
	
	float[] lnglat;
	
	@SuppressLint("SetJavaScriptEnabled")
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_map_show);
		
		webView = findViewById(R.id.webview, WebView.class);
		webView.getSettings().setJavaScriptEnabled(true);
		webView.setWebChromeClient(new WebChromeClient());
		webView.setWebViewClient(new WebViewClient(){
			@Override
			public void onPageStarted(WebView view, String url, Bitmap favicon) {
				super.onPageStarted(view, url, favicon);
				if(pw == null || !pw.isShowing()){
					pw = PopupWindowUtils.showLoadingView(MapShowActivity.this);
				}
			}
			
			@Override
			public void onPageFinished(WebView view, String url) {
				super.onPageFinished(view, url);
				if(pw != null){
					pw.dismiss();
					pw = null;
				}
			}
		});
		
		loadCustomConfig();
		bindEventListener();
	}
	
	@Override
	protected void onResume() {
		super.onResume();
		fillData();
	}
	
	@Override
	protected void onDestroy() {
		super.onDestroy();
		webView.stopLoading();
		webView.destroy();
	}
	
	@Override
	public void onBackPressed() {
		if(webView != null && webView.canGoBack()){
			webView.goBack();
			return;
		}
		super.onBackPressed();
	}
	
	private void fillData(){
		if(!NetworkInfoUtils.isNetworkAvailable(this)) {
			ToastUtils.showMsg(this, R.string.no_network);
			return;
		}
		
		lnglat = LocalDataManager.getLngLat();
		//t=地图类型。m=>常规地图，k=>卫星地图，h=>混合地图，p=>地域地图，e=>GoogleEarth
		//z=缩放级别。取值范围1~20。1比例尺最大，20比例尺最小。
		String mapUrl = "https://maps.google.com/maps?z=8&t=m&q=loc:"+lnglat[0]+","+lnglat[1];
		webView.loadUrl(mapUrl);
		Log.i(Constants.LOG_TAG, mapUrl);
	}
}
