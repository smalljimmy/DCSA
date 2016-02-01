package ch.goco.ui;

import java.util.ArrayList;
import java.util.Calendar;
import java.util.HashSet;
import java.util.List;
import java.util.Set;

import com.handmark.pulltorefresh.library.PullToRefreshBase;
import com.handmark.pulltorefresh.library.PullToRefreshListView;

import ch.goco.company.R;
import ch.goco.config.LocalDataManager;
import ch.goco.entity.Message;
import ch.goco.ui.adapter.MessageAdapter;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.PopupWindow;
import android.widget.AdapterView.OnItemClickListener;
import app.fastdev.util.DateUtils;
import app.fastdev.util.PopupWindowUtils;

public class MessageActivity extends BaseActivity implements OnItemClickListener{

	ListView listview;
	MessageAdapter adapter;
	PopupWindow pw;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_news);
		
		PullToRefreshListView pullToRefreshView = findViewById(R.id.refresh_listview, PullToRefreshListView.class);
		pullToRefreshView.setMode(PullToRefreshBase.Mode.DISABLED);
		listview = pullToRefreshView.getRefreshableView();
		
		loadCustomConfig();
		bindEventListener();
		
		loadDataFromLocal();
	}
	
	public void bindEventListener(){
		super.bindEventListener();
		listview.setOnItemClickListener(this);;
	}
	
	@Override
	public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
		PopupWindowUtils.showPopupTextView(this, adapter.getItem(position-1).getText());
	}
	
	private void loadDataFromLocal(){
		List<Message> itemList = LocalDataManager.getLocalMessageList();
		if(itemList == null) return;	
		itemList = filterValidList(itemList);
		adapter = new MessageAdapter(this, itemList);
		listview.setAdapter(adapter);
		
		Set<Integer> messageIds = LocalDataManager.getLocalMessageIds();
		if(messageIds == null) messageIds = new HashSet<Integer>();
		
		for(Message n:itemList){
			if(!messageIds.contains(n.getId())){
				messageIds.add(n.getId());
			}
		}
		LocalDataManager.setLocalMessageIds(messageIds);
	}
	
	private List<Message> filterValidList(List<Message> itemList){
		List<Message> validItemList = new ArrayList<Message>(itemList.size());
		Calendar now = Calendar.getInstance();
		for(Message n:itemList){
			if(DateUtils.between(now.getTime(), n.getStart(), n.getEnd())){
				validItemList.add(n);
			}
		}
		return validItemList;
	}
}
