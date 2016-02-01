package ch.goco.ui;

import ch.goco.company.R;
import android.annotation.SuppressLint;
import android.graphics.Bitmap;
import android.os.Bundle;
import android.webkit.WebChromeClient;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.PopupWindow;
import app.fastdev.util.NetworkInfoUtils;
import app.fastdev.util.PopupWindowUtils;
import app.fastdev.util.ToastUtils;

public class WebViewActivity extends BaseActivity {

	WebView webView;
	PopupWindow pw;
	
	String url;
	
	@SuppressLint("SetJavaScriptEnabled")
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_webview);
		
		if(!NetworkInfoUtils.isNetworkAvailable(this)) {
			ToastUtils.showMsg(this, R.string.no_network);
			finish();
			return;
		}
		
		loadCustomConfig();
		bindEventListener();
		
		url = getIntent().getStringExtra("url");
		webView = findViewById(R.id.webview, WebView.class);
		webView.getSettings().setBuiltInZoomControls(true);
		webView.getSettings().setSupportZoom(true);
		webView.getSettings().setJavaScriptEnabled(true);
		webView.getSettings().setUseWideViewPort(true);
		webView.getSettings().setLoadWithOverviewMode(true);
		webView.getSettings().setJavaScriptCanOpenWindowsAutomatically(true);
		webView.setHorizontalScrollBarEnabled(false);
		webView.setVerticalScrollBarEnabled(false);
		webView.setWebChromeClient(new WebChromeClient());
		webView.setWebViewClient(new WebViewClient(){
			@Override
			public void onPageStarted(WebView view, String url, Bitmap favicon) {
				super.onPageStarted(view, url, favicon);
				if(url.startsWith("http")){
					if(pw == null){
						pw = PopupWindowUtils.showLoadingView(WebViewActivity.this);
					}
					WebViewActivity.this.url = url;
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
	}
	
	@Override
	protected void onResume() {
		super.onResume();
		webView.loadUrl(url);
	}
	
	@Override
	public void onBackPressed() {
		if(webView.canGoBack()){
			webView.goBack();
			return;
		}
		super.onBackPressed();
	}
	
	@Override
	protected void onDestroy() {
		super.onDestroy();
		webView.stopLoading();
		webView.destroy();
	}
}
