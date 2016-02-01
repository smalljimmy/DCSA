package ch.goco.ui.adapter;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.List;

import ch.goco.company.R;
import ch.goco.config.LocalDataManager;
import ch.goco.entity.Message;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;

public class NewsAdapter extends ArrayAdapter<Message> {

	public NewsAdapter(Context context, List<Message> itemList) {
		super(context, 0, itemList);
	}

	@Override
	public View getView(int position, View convertView, ViewGroup parent) {
		final Message item = getItem(position);
		String date = SimpleDateFormat.getDateTimeInstance(SimpleDateFormat.LONG,SimpleDateFormat.SHORT).format(item.getStart().getTime());
		
		convertView = LayoutInflater.from(getContext()).inflate(R.layout.adapter_news_list_item, null);
		((TextView)convertView.findViewById(R.id.text_title)).setText(item.getTitle());
		((TextView)convertView.findViewById(R.id.text_subtitle)).setText(item.getSubtitle());
		((TextView)convertView.findViewById(R.id.text_time)).setText(date);
		
		convertView.findViewById(R.id.image).setOnClickListener(new View.OnClickListener() {
			@Override
			public void onClick(View v) {
				List<Integer> idList = LocalDataManager.getIgnoreNewsIdList();
				if(idList == null) idList = new ArrayList<Integer>();
				idList.add(item.getId());
				LocalDataManager.setIgnoreNewsList(idList);
				remove(item);
				notifyDataSetChanged();
			}
		});
		
		return convertView;
	}
}
