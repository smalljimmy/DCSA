package app.fastdev.util;

import ch.goco.company.R;
import android.app.Activity;
import android.graphics.drawable.BitmapDrawable;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup.LayoutParams;
import android.widget.PopupWindow;
import android.widget.TextView;

public class PopupWindowUtils {

	@SuppressWarnings("deprecation")
	public static PopupWindow showPopupView(Activity context,View contentView){
		PopupWindow popupWindow = new PopupWindow(contentView);
		popupWindow.setFocusable(true);
		popupWindow.setOutsideTouchable(true);
		popupWindow.setBackgroundDrawable(new BitmapDrawable(context.getResources()));
		popupWindow.setWidth(LayoutParams.MATCH_PARENT);
		popupWindow.setHeight(LayoutParams.MATCH_PARENT);
		popupWindow.showAtLocation(context.getWindow().getDecorView().getRootView(), Gravity.CENTER, 0, 0);
		return popupWindow;
	}
	
	public static PopupWindow showPopupTextView(Activity context,String text){
		try {
			View contentView = LayoutInflater.from(context).inflate(R.layout.popup_text, null);
			final PopupWindow popupWindow = showPopupView(context, contentView);
			((TextView)contentView.findViewById(R.id.text)).setText(text);
			contentView.findViewById(R.id.close).setOnClickListener(new View.OnClickListener() {
				@Override
				public void onClick(View v) {
					popupWindow.dismiss();
				}
			});
			return popupWindow;
		} catch (Exception e) {
			e.printStackTrace();
			return null;
		}
	}
	
	public static PopupWindow showLoadingView(Activity context){
		try {
			View contentView = LayoutInflater.from(context).inflate(R.layout.popup_loading, null);
			return showPopupView(context, contentView);
		} catch (Exception e) {
			e.printStackTrace();
			return null;
		}
	}
}
