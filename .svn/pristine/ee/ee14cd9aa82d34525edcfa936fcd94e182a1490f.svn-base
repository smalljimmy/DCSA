package ch.goco.ui.adapter;

import java.io.File;
import java.util.List;

import ch.goco.company.R;
import ch.goco.config.Constants;
import ch.goco.config.LocalDataManager;
import ch.goco.entity.Docs;
import android.app.Notification;
import android.app.PendingIntent;
import android.content.Context;
import android.support.v4.app.NotificationCompat;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;
import app.fastdev.util.DownloadManager;
import app.fastdev.util.LocalFileManager;
import app.fastdev.util.NetworkInfoUtils;
import app.fastdev.util.NotificationUtils;
import app.fastdev.util.OpenUtils;
import app.fastdev.util.ToastUtils;
import app.fastdev.util.DownloadManager.DownLoadEntity;

public class DocsAdapter extends ArrayAdapter<Docs> {

	public DocsAdapter(Context context, List<Docs> itemList) {
		super(context, 0, itemList);
	}

	@Override
	public View getView(int position, View convertView, ViewGroup parent) {
		convertView = LayoutInflater.from(getContext()).inflate(R.layout.adapter_docs_list_item, null);
		((TextView)convertView.findViewById(R.id.text_title)).setText(getItem(position).getTitle());
		((TextView)convertView.findViewById(R.id.text_desc)).setText(getItem(position).getDesc());
		bindDownloadImageClick(convertView.findViewById(R.id.image), getItem(position));
		return convertView;
	}
	
	private void bindDownloadImageClick(View view, final Docs item){
		view.setOnClickListener(new View.OnClickListener() {
			@Override
			public void onClick(View v) {
				handlerImageClick(item);
			}
		});
	}
	
	private void handlerImageClick(final Docs item){
		File file = new File(LocalFileManager.getLocalFilePath(Constants.SDCARD_DIR_DOCS, item.getPath()));
		if(file.exists()){
			OpenUtils.openPDF(getContext(), file.getAbsolutePath());
			return;
		}
		
		if(!NetworkInfoUtils.isNetworkAvailable(getContext())){
			ToastUtils.showMsg(getContext(), R.string.no_network);
			return;
		}
		
		final int notifiId = (int)System.currentTimeMillis();
		String url = LocalDataManager.getBaseUrl()+item.getPath();
		DownloadManager.getInstance().addTask(new DownloadManager.DownLoadEntity(notifiId, item.getTitle(), url, file.getAbsolutePath()), new DownloadManager.DownloadCallback(){
			@Override
			public void doComplete(DownLoadEntity entity, boolean success) {
				super.doComplete(entity, success);
				if(success){
					NotificationUtils.clearNotification(getContext(), notifiId);
					Notification notification = new NotificationCompat.Builder(getContext())
					.setAutoCancel(true)
					.setTicker(item.getTitle())
					.setContentTitle(item.getTitle())
					.setContentText(getContext().getResources().getString(R.string.download_success))
					.setProgress(100, 100, false)
					.setSmallIcon(android.R.drawable.stat_sys_download)
					.setContentIntent(PendingIntent.getActivity(getContext(), 0, OpenUtils.getOpenPDFIntent(getContext(), entity.path), PendingIntent.FLAG_UPDATE_CURRENT))
					.build();
					NotificationUtils.updateNotification(getContext(), notifiId, notification);
				}
			}
		});
	}
}
