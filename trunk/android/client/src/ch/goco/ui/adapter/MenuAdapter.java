package ch.goco.ui.adapter;


import ch.goco.company.R;
import ch.goco.config.LocalDataManager;
import ch.goco.entity.Language;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;

public class MenuAdapter extends ArrayAdapter<Language>{
	
	public MenuAdapter(Context context) {
		super(context, 0,LocalDataManager.getLanguageItemList(context));
	}
	
	@Override
	public View getView(int position, View convertView, ViewGroup parent) {
		Language item = (Language)getItem(position);
		convertView = LayoutInflater.from(getContext()).inflate(R.layout.adapter_menu_list_item, null);
		((ImageView)convertView.findViewById(R.id.image)).setImageResource(item.getResId());
		return convertView;
	}


}
