package ch.goco.ui.adapter;

import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.List;

import ch.goco.company.R;
import ch.goco.entity.RSS;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;

public class RSSAdapter extends ArrayAdapter<RSS> {

	DateFormat format = SimpleDateFormat.getDateTimeInstance(SimpleDateFormat.LONG,SimpleDateFormat.SHORT);
	
	public RSSAdapter(Context context, List<RSS> itemList) {
		super(context, 0, itemList);
	}

	@Override
	public View getView(int position, View convertView, ViewGroup parent) {
		final RSS item = getItem(position);
		convertView = LayoutInflater.from(getContext()).inflate(R.layout.adapter_rss_list_item, null);
		((TextView)convertView.findViewById(R.id.text_title)).setText(item.getTitle());
		((TextView)convertView.findViewById(R.id.text_subtitle)).setText(item.getDescription());
		((TextView)convertView.findViewById(R.id.text_time)).setText(format.format(item.getDate()));
		return convertView;
	}
}
