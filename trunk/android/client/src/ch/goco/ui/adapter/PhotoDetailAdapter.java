package ch.goco.ui.adapter;

import java.util.List;

import ch.goco.config.LocalDataManager;
import ch.goco.entity.Photo;
import android.content.Context;
import android.support.v4.view.PagerAdapter;
import android.view.View;
import android.view.ViewGroup;
import android.view.ViewGroup.LayoutParams;
import android.widget.AbsListView;
import android.widget.ImageView;
import android.widget.ImageView.ScaleType;
import app.fastdev.util.QueueImageLoader;

public class PhotoDetailAdapter extends PagerAdapter {

	Context context;
	List<Photo> itemList;
	public PhotoDetailAdapter(Context context, List<Photo> itemList){
		this.context = context;
		this.itemList = itemList;
	}
	
	@Override
	public int getCount() {
		return itemList.size();
	}

	@Override
	public boolean isViewFromObject(View view, Object obj) {
		return view == obj;
	}
	
	@Override
	public void destroyItem(ViewGroup container, int position, Object object) {
		container.removeView((View)object);
	}

	@Override
	public Object instantiateItem(ViewGroup container, int position) {
		//DragImageView imageView = new DragImageView(context);
		ImageView imageView = new ImageView(context);
		imageView.setLayoutParams(new AbsListView.LayoutParams(new LayoutParams(LayoutParams.MATCH_PARENT, LayoutParams.MATCH_PARENT)));
		imageView.setScaleType(ScaleType.FIT_CENTER);
		container.addView(imageView);

		QueueImageLoader.getInstance().loadImageViewDrawable(context, imageView, LocalDataManager.getBaseUrl()+itemList.get(position).getPath());
		return imageView;
	}
}
