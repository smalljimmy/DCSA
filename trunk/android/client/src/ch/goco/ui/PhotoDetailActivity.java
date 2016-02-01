package ch.goco.ui;

import java.util.List;

import ch.goco.company.R;
import ch.goco.config.LocalDataManager;
import ch.goco.entity.Photo;
import ch.goco.ui.adapter.PhotoDetailAdapter;
import android.os.Bundle;
import android.support.v4.view.ViewPager;
import android.support.v4.view.ViewPager.OnPageChangeListener;
import android.widget.TextView;

public class PhotoDetailActivity extends BaseActivity implements OnPageChangeListener{

	ViewPager viewPager;
	TextView text;
	
	List<Photo> itemList;
	int defaultIndex;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_photodetail);
		
		defaultIndex = getIntent().getIntExtra("index", 0);
		
		viewPager = findViewById(R.id.viewpager,ViewPager.class);
		viewPager.setPageMargin(2);
		text = findViewById(R.id.text,TextView.class);
		
		loadCustomConfig();
		bindEventListener();
		
		fillData();
	}
	
	public void bindEventListener(){
		super.bindEventListener();
		viewPager.setOnPageChangeListener(this);
	}
	
	
	@Override
	public void onPageScrollStateChanged(int i) { }
	@Override
	public void onPageScrolled(int arg0, float arg1, int arg2) { }
	@Override
	public void onPageSelected(int i) { 
		text.setText((i+1)+" of "+itemList.size());
	}

	private void fillData(){
		itemList = LocalDataManager.getLocalPhotoList();
		viewPager.setAdapter(new PhotoDetailAdapter(this, itemList));
		if(defaultIndex >= itemList.size()) defaultIndex = 0;
		viewPager.setCurrentItem(defaultIndex);
		text.setText((defaultIndex+1)+" of "+itemList.size());
	}
	
}
