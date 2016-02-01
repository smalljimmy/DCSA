package ch.goco;

import java.io.File;
import java.io.FileWriter;
import java.io.PrintWriter;
import java.lang.Thread.UncaughtExceptionHandler;
import java.util.Date;





import ch.goco.config.Constants;

import com.umeng.analytics.MobclickAgent;

import android.content.Context;
import android.os.Environment;
import android.util.Log;
import app.fastdev.Setting;
import app.fastdev.util.DateUtils;

public class CrashExceptionHandler implements UncaughtExceptionHandler {

	//private Thread.UncaughtExceptionHandler lastDefaultHandler;
	private Context context;
	
	public CrashExceptionHandler(Context context){
		//lastDefaultHandler = Thread.getDefaultUncaughtExceptionHandler();
		this.context = context;
	}
	
	@Override
	public void uncaughtException(Thread thread, Throwable ex) {
		if(ex != null) ex.printStackTrace();
		MobclickAgent.reportError(context,ex);
		try {
			writeException(ex);
		} catch (Exception e) {
			e.printStackTrace();
		}
		MobclickAgent.onKillProcess(context);
		android.os.Process.killProcess(android.os.Process.myPid());
	}
	
	private void writeException(Throwable ex) throws Exception{
		String text = "==============="+DateUtils.formatDate(new Date(), "yyyy-MM-dd/HH:mm:ss")+"===============\r\n";
		File file = new File(Environment.getExternalStorageDirectory()+"/"+Setting.LOCAL_FILE_LOG+"/"+Setting.UNCAUGHT_EXCEPTION);
		if(!file.getParentFile().exists()) file.getParentFile().mkdirs();
		if(!file.exists() && !file.createNewFile()) {
			Log.e(Constants.LOG_TAG, "Create log file failed!");
			return;
		}
		
		PrintWriter pw = new PrintWriter(new FileWriter(file, true));
		pw.write(text);
		ex.printStackTrace(pw);
		pw.close();
	}

}
