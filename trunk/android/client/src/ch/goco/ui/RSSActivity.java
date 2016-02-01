package ch.goco.ui;

import java.io.ByteArrayInputStream;
import java.io.InputStream;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Collections;
import java.util.Comparator;
import java.util.List;
import java.util.Locale;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;

import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.NodeList;

import com.handmark.pulltorefresh.library.PullToRefreshBase;
import com.handmark.pulltorefresh.library.PullToRefreshListView;

import ch.goco.company.R;
import ch.goco.entity.RSS;
import ch.goco.ui.adapter.RSSAdapter;
import android.os.Bundle;
import android.os.Handler;
import android.view.View;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ListView;
import app.fastdev.util.HttpClientUtils;
import app.fastdev.util.HttpClientUtils.ResponseEntry;
import app.fastdev.util.NetworkInfoUtils;
import app.fastdev.util.ThreadUtils;
import app.fastdev.util.ToastUtils;

public class RSSActivity extends BaseActivity {

	ListView listView;
	PullToRefreshListView pullToRefreshView;
	
	String url;
	List<RSS> itemList = new ArrayList<RSS>();
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_rss);
		
		pullToRefreshView = findViewById(R.id.refresh_listview, PullToRefreshListView.class);
		pullToRefreshView.setMode(PullToRefreshBase.Mode.PULL_FROM_START);
		listView = pullToRefreshView.getRefreshableView();
		
		url = getIntent().getStringExtra("data");
		
		if(!NetworkInfoUtils.isNetworkAvailable(this)) {
			ToastUtils.showMsg(this, R.string.no_network);
			finish();
			return;
		}
		
		loadCustomConfig();
		bindEventListener();
	}
	
	@Override
	protected void onResume() {
		super.onResume();
		new Handler().postDelayed(new Runnable() {
			@Override
			public void run() {
				if(!NetworkInfoUtils.isNetworkAvailable(getApplicationContext())) return;
				pullToRefreshView.setRefreshing();
				getRssItemList();
			}
		}, 500);
	}
	
	@Override
	protected void bindEventListener() {
		super.bindEventListener();
		listView.setOnItemClickListener(new OnItemClickListener() {
			@Override
			public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
				RSS rss = itemList.get(position-1);
				Bundle bundle = new Bundle();
				bundle.putString("url", rss.getLink());;
				startActivity(WebViewActivity.class, bundle);
			}
		});
		
		pullToRefreshView.setOnRefreshListener(new PullToRefreshListView.OnRefreshListener<ListView>() {
			@Override
			public void onRefresh(PullToRefreshBase<ListView> refreshView) {
				if(!NetworkInfoUtils.isNetworkAvailable(getApplicationContext())){
					pullToRefreshView.setMode(PullToRefreshBase.Mode.DISABLED);
					return;
				}
				getRssItemList();
			}
		});
	}
	
	private void getRssItemList(){
		//pw = PopupWindowUtils.showLoadingView(this);
		ThreadUtils.runOnNewThread(new Runnable() {
			@Override
			public void run() {
				ResponseEntry responseEntry = HttpClientUtils.get(url);
				if(responseEntry.statusCode != 200){
					showFaildMsgAndFinish();
					return;
				}
				
				try {
					parseRssData(responseEntry.body);
					showListViewContent();
				} catch (Exception e) {
					e.printStackTrace();
					showFaildMsgAndFinish();
				}
			}
		});
	}
	
	private void parseRssData(String data)throws Exception{
		InputStream ins = new ByteArrayInputStream(data.getBytes("UTF-8"));
		DocumentBuilder builder = DocumentBuilderFactory.newInstance().newDocumentBuilder();
		Document document = builder.parse(ins);
		NodeList itemNodeList = document.getElementsByTagName("item");
		Element itemNode,attrNode;
		RSS rss;
		SimpleDateFormat format = new SimpleDateFormat("EEE, dd MMM yyyy HH:mm:ss zzz", Locale.ENGLISH);
		List<RSS> list = new ArrayList<RSS>();
		for(int i=0,j=itemNodeList.getLength();i<j;i++){
			rss = new RSS();
			itemNode = (Element)itemNodeList.item(i);
			attrNode = (Element)itemNode.getElementsByTagName("title").item(0);
			rss.setTitle(attrNode.getTextContent());
			
			attrNode = (Element)itemNode.getElementsByTagName("description").item(0);
			rss.setDescription(attrNode.getTextContent());
			
			attrNode = (Element)itemNode.getElementsByTagName("link").item(0);
			rss.setLink(attrNode.getTextContent());
			
			attrNode = (Element)itemNode.getElementsByTagName("image").item(0);
			rss.setImage(attrNode.getTextContent());
			
			attrNode = (Element)itemNode.getElementsByTagName("image_big").item(0);
			rss.setImageBig(attrNode.getTextContent());
			
			attrNode = (Element)itemNode.getElementsByTagName("pubDate").item(0);
			rss.setDate(format.parse(attrNode.getTextContent()));
			
			list.add(rss);
		}
		
		itemList = list;
	}
	
	private void showListViewContent(){
		runOnUiThread(new Runnable() {
			@Override
			public void run() {
				orderByDate(itemList);
				listView.setAdapter(new RSSAdapter(getApplicationContext(), itemList));
				pullToRefreshView.onRefreshComplete();
			}
		});
	}
	
	private void showFaildMsgAndFinish(){
		ThreadUtils.runOnUiThread(new Runnable() {
			@Override
			public void run() {
				ToastUtils.showMsg(RSSActivity.this, R.string.get_rss_data_failed);
				finish();
			}
		});
	}
	
	private void orderByDate(List<RSS> itemList){
		Collections.sort(itemList, new Comparator<RSS>() {
			@Override
			public int compare(RSS lhs, RSS rhs) {
				return (int)(lhs.getDate().getTime() - rhs.getDate().getTime());
			}
		});
		Collections.reverse(itemList);
	}
}
