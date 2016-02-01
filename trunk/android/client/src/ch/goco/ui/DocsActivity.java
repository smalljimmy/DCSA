package ch.goco.ui;

import java.util.ArrayList;
import java.util.List;

import org.json.JSONArray;
import org.json.JSONObject;

import com.handmark.pulltorefresh.library.PullToRefreshBase;
import com.handmark.pulltorefresh.library.PullToRefreshListView;

import ch.goco.company.R;
import ch.goco.config.LocalDataManager;
import ch.goco.entity.Docs;
import ch.goco.ui.adapter.DocsAdapter;
import ch.goco.webservice.WebServiceUtils;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ListView;
import app.fastdev.util.DigestUtils;
import app.fastdev.util.NetworkInfoUtils;
import app.fastdev.util.PopupWindowUtils;
import app.fastdev.util.ThreadUtils;

public class DocsActivity extends BaseActivity implements OnItemClickListener{

	DocsAdapter adapter;
	PullToRefreshListView pullToRefreshView;
	
	List<Docs> docsList = new ArrayList<Docs>();
	String dataSign;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_docs);
		
		adapter = new DocsAdapter(this, docsList);
		
		pullToRefreshView = findViewById(R.id.refresh_listview, PullToRefreshListView.class);
		pullToRefreshView.setMode(PullToRefreshBase.Mode.PULL_FROM_START);
		pullToRefreshView.setAdapter(adapter);
		loadCustomConfig();
		bindEventListener();
		
		loadDataFromLocal();
	}
	
	@Override
	protected void onResume() {
		super.onResume();
		ThreadUtils.runOnUiThread(new Runnable() {
			@Override
			public void run() {
				if(!NetworkInfoUtils.isNetworkAvailable(getApplicationContext())) return;
				pullToRefreshView.setRefreshing();
				loadDataFromRemote();
			}
		}, 500);
	}
	
	public void bindEventListener(){
		super.bindEventListener();
		pullToRefreshView.setOnRefreshListener(new PullToRefreshListView.OnRefreshListener<ListView>() {
			@Override
			public void onRefresh(PullToRefreshBase<ListView> refreshView) {
				if(!NetworkInfoUtils.isNetworkAvailable(getApplicationContext())){
					pullToRefreshView.setMode(PullToRefreshBase.Mode.DISABLED);
					return;
				}
				loadDataFromRemote();
			}
		});
		pullToRefreshView.setOnItemClickListener(this);
	}
	
	@Override
	public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
		PopupWindowUtils.showPopupTextView(this, docsList.get(position-1).getDesc());
	}
	
	private void loadDataFromLocal(){
		List<Docs> itemList = LocalDataManager.getLocalDocsList();
		if(itemList == null) return;
		StringBuilder build = new StringBuilder();
		for(Docs item:itemList){
			build.append(item.getPath());
		}
		dataSign = DigestUtils.md5String(build.toString());
		docsList = itemList;
		pullToRefreshView.setAdapter(new DocsAdapter(this, docsList));
		adapter.notifyDataSetChanged();
	}
	
	private void loadDataFromRemote(){
		if(!NetworkInfoUtils.isNetworkAvailable(this)) return;
		ThreadUtils.runOnNewThread(new Runnable() {
			@Override
			public void run() {
				JSONArray ja = WebServiceUtils.getDocs();
				runOnUiThread(new Runnable() {
					public void run() {
						pullToRefreshView.onRefreshComplete();
					}
				});
				if(ja == null) return;
				List<Docs> itemList = new ArrayList<Docs>(ja.length());
				JSONObject obj;
				StringBuilder build = new StringBuilder();
				for(int i=0,j=ja.length();i<j;i++){
					obj = ja.optJSONObject(i);
					itemList.add(new Docs(obj.optInt("uid"),obj.optString("title"),obj.optString("content"),obj.optString("path")));
					build.append(obj.optString("path"));
				}
				LocalDataManager.setLocalDocsList(itemList);
				
				String newdataSign = DigestUtils.md5String(build.toString());
				if(newdataSign.equals(dataSign)) {
					return;
				}
				docsList = itemList;
				runOnUiThread(new Runnable() {
					@Override
					public void run() {
						pullToRefreshView.setAdapter(new DocsAdapter(DocsActivity.this, docsList));
					}
				});
			}
		});
	}
}
