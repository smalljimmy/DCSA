package app.fastdev.util;

import ch.goco.company.R;
import android.app.Notification;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.Context;
import android.content.Intent;
import android.support.v4.app.NotificationCompat;

public class NotificationUtils {

	public static void updateNotification(Context context,int notifiId, Notification notification){
		NotificationManager manager = (NotificationManager) context.getSystemService(Context.NOTIFICATION_SERVICE);
		manager.notify(notifiId, notification);
	}
	
	public static void updateProgressNotification(Context context, int notifiId, String title, int progress){
		Notification notification = new NotificationCompat.Builder(context)
		.setAutoCancel(true)
		.setTicker(title)
		.setContentTitle(title)
		.setContentText("Downloading..."+progress+"%")
		.setProgress(100, progress, false)
		.setContentIntent(PendingIntent.getActivity(context, 0, new Intent(), PendingIntent.FLAG_UPDATE_CURRENT))
		.setSmallIcon(android.R.drawable.stat_sys_download)
		.build();
		updateNotification(context, notifiId, notification);
	}
	
	public static void updateTextNotification(Context context, int notifiId, String title, String content){
		Notification notification = new NotificationCompat.Builder(context)
		.setAutoCancel(true)
		.setTicker(title)
		.setContentTitle(title)
		.setContentText(content)
		.setContentIntent(PendingIntent.getActivity(context, 0, new Intent(), PendingIntent.FLAG_UPDATE_CURRENT))
		.setSmallIcon(R.drawable.icon)
		.build();
		updateNotification(context, notifiId, notification);
	}
	
	public static void updateIntentNotification(Context context, int notifiId, String title, Intent intent){
		Notification notification = new NotificationCompat.Builder(context)
		.setAutoCancel(true)
		.setTicker(title)
		.setContentTitle(title)
		.setContentIntent(PendingIntent.getActivity(context, 0, intent, PendingIntent.FLAG_UPDATE_CURRENT))
		.setSmallIcon(R.drawable.icon)
		.build();
		updateNotification(context, notifiId, notification);
	}
	
	public static void clearNotification(Context context, int id){
		((NotificationManager) context.getSystemService(Context.NOTIFICATION_SERVICE)).cancel(id);
	}
}
