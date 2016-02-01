package ch.goco.ui;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Collections;
import java.util.Comparator;
import java.util.List;
import java.util.Locale;
import java.util.TimeZone;

import org.json.JSONArray;
import org.json.JSONObject;

import com.handmark.pulltorefresh.library.PullToRefreshBase;
import com.handmark.pulltorefresh.library.PullToRefreshListView;

import ch.goco.company.R;
import ch.goco.config.LocalDataManager;
import ch.goco.entity.Message;
import ch.goco.ui.adapter.NewsAdapter;
import ch.goco.webservice.WebServiceUtils;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.AdapterView.OnItemClickListener;
import app.fastdev.util.DateUtils;
import app.fastdev.util.DigestUtils;
import app.fastdev.util.NetworkInfoUtils;
import app.fastdev.util.PopupWindowUtils;
import app.fastdev.util.ThreadUtils;
import app.fastdev.util.ToastUtils;

public class NewsActivity extends BaseActivity implements OnItemClickListener{

	ListView listview;
	NewsAdapter adapter;
	PullToRefreshListView pullToRefreshView;
	
	String dataSign;
	List<Integer> ignoreIdList;
	List<Message> newsList = new ArrayList<Message>();
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_news);
		
		pullToRefreshView = findViewById(R.id.refresh_listview, PullToRefreshListView.class);
		pullToRefreshView.setMode(PullToRefreshBase.Mode.PULL_FROM_START);
		listview = pullToRefreshView.getRefreshableView();
		
		loadCustomConfig();
		bindEventListener();
		
		ignoreIdList = LocalDataManager.getIgnoreNewsIdList();
		if(ignoreIdList == null) ignoreIdList = new ArrayList<Integer>();
		loadDataFromLocal();
	}
	
	@Override
	protected void onResume() {
		super.onResume();
		ThreadUtils.runOnUiThread(new Runnable() {
			@Override
			public void run() {
				if(!NetworkInfoUtils.isNetworkAvailable(getApplicationContext())){
					return;
				}
				pullToRefreshView.setRefreshing();
				loadDataFromRemote();
			}
		}, 500);
	}
	
	public void bindEventListener(){
		super.bindEventListener();
		listview.setOnItemClickListener(this);
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
	}
	
	@Override
	public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
		PopupWindowUtils.showPopupTextView(this, adapter.getItem(position-1).getText());
	}
	
	private void refreshAdapter(){
		orderByDate(newsList);
		adapter = new NewsAdapter(NewsActivity.this, newsList);
		listview.setAdapter(adapter);
		pullToRefreshView.onRefreshComplete();
	}
	
	private void loadDataFromLocal(){
		List<Message> itemList = LocalDataManager.getLocalNewsList();
		if(itemList == null) return;
		StringBuilder build = new StringBuilder();
		for(Message item:itemList){
			build.append(item.getTitle());
		}
		dataSign = DigestUtils.md5String(build.toString());
		
		newsList = filterValidList(itemList);
		refreshAdapter();
	}
	
	private void loadDataFromRemote(){
		if(!NetworkInfoUtils.isNetworkAvailable(this)) return;
		ThreadUtils.runOnNewThread(new Runnable() {
			@Override
			public void run() {
				JSONArray ja = WebServiceUtils.getNews();
				runOnUiThread(new Runnable() {
					public void run() {
						pullToRefreshView.onRefreshComplete();
					}
				});
				if(ja == null) return;
				List<Message> itemList = new ArrayList<Message>(ja.length());
				JSONObject obj;
				StringBuilder build = new StringBuilder();
				Message news;
				String date;
				String timezone;
				SimpleDateFormat format = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss", Locale.getDefault());
				for(int i=0,j=ja.length();i<j;i++){
					obj = ja.optJSONObject(i);
					news = new Message();
					news.setId(obj.optInt("uid"));
					news.setTitle(obj.optString("title"));
					news.setSubtitle(obj.optString("subtitle"));
					news.setText(obj.optString("text"));
					
					date = obj.optJSONObject("start").optString("date");
					timezone = obj.optJSONObject("start").optString("timezone");
					format.setTimeZone(TimeZone.getTimeZone("GMT"+timezone));
					try {
						news.setStart(format.parse(date));
					} catch (ParseException e) {
						e.printStackTrace();
						continue;
					}
					
					date = obj.optJSONObject("end").optString("date");
					timezone = obj.optJSONObject("end").optString("timezone");
					format.setTimeZone(TimeZone.getTimeZone("GMT"+timezone));
					try {
						news.setEnd(format.parse(date));
					} catch (ParseException e) {
						e.printStackTrace();
						continue;
					}
					
					itemList.add(news);
					build.append(news.getText());
				}
				LocalDataManager.setLocalNewsList(itemList);
				
				String newdataSign = DigestUtils.md5String(build.toString());
				if(newdataSign.equals(dataSign)) return;
				itemList = filterValidList(itemList);
				
				newsList = itemList;
				runOnUiThread(new Runnable() {
					@Override
					public void run() {
						if(newsList.isEmpty()){
							ToastUtils.showMsg(getApplicationContext(), R.string.no_content);
							return;
						}
						refreshAdapter();
					}
				});
			}
		});
	}
	
	private List<Message> filterValidList(List<Message> itemList){
		List<Message> validItemList = new ArrayList<Message>(itemList.size());
		Calendar now = Calendar.getInstance();
		for(Message n:itemList){
			if(DateUtils.between(now.getTime(), n.getStart(), n.getEnd())
				|| !ignoreIdList.contains(n.getId())){
				validItemList.add(n);
			}
		}
		return validItemList;
	}
	
	private void orderByDate(List<Message> itemList){
		Collections.sort(itemList, new Comparator<Message>() {
			@Override
			public int compare(Message lhs, Message rhs) {
				return (int)(lhs.getStart().getTime() - rhs.getStart().getTime());
			}
		});
		Collections.reverse(itemList);
	}
}
