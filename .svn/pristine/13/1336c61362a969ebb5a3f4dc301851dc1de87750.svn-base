package app.fastdev.util;

import java.io.IOException;
import java.io.InputStream;

import ch.goco.config.Constants;

import android.content.Context;
import android.util.Log;

public class AssetsManagerUtils {

	public static InputStream getInputStream(Context context,String fileName){
		try {
			return context.getAssets().open(fileName);
		} catch (IOException e) {
			Log.w(Constants.LOG_TAG, e);
		}
		return null;
	}
}
