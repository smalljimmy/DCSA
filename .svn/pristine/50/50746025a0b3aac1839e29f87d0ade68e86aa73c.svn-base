package app.fastdev.util;

import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;
import java.util.Locale;
import java.util.TimeZone;

public class DateUtils {

	public static Date parseDate(String val, String pattern){
		try {
			return new SimpleDateFormat(pattern, Locale.getDefault()).parse(val);
		} catch (Exception e) {
			return null;
		}
	}
	
	public static Date toTimeZone(Date date, TimeZone source, TimeZone target){
		Calendar cal1 = Calendar.getInstance(source);
		cal1.setTime(date);
		
		int[] dateSplit = splitDate(date);
		
		Calendar cal2 = Calendar.getInstance(target);
		cal2.set(dateSplit[0], dateSplit[1], dateSplit[2], dateSplit[3], dateSplit[4], dateSplit[5]);
		return cal2.getTime();
	}
	
	public static int[] splitDate(Calendar calendar){
		return new int[]{
				calendar.get(Calendar.YEAR),
				calendar.get(Calendar.MONTH),
				calendar.get(Calendar.DAY_OF_MONTH),
				calendar.get(Calendar.HOUR_OF_DAY),
				calendar.get(Calendar.MINUTE),
				calendar.get(Calendar.SECOND)
		};
	}
	
	public static int[] splitDate(Date date){
		Calendar calendar = Calendar.getInstance();
		calendar.setTime(date);
		return splitDate(calendar);
	}
	
	public static boolean between(Calendar date, Calendar date1, Calendar date2){
		if((compare(date, date1) == 0) && (compare(date, date2) == 0)){
			return true;
		}
		
		if((compare(date, date1) == -1) || (compare(date, date2) == 1)){
			return false;
		}
		return true;
	}
	
	public static boolean between(Date date, Date date1, Date date2){
		if(date.getTime() >= date1.getTime() && date.getTime() <= date2.getTime()){
			return true;
		}
		return false;
	}
	
	/**
	 * 
	 * @param date1
	 * @param date2
	 * @return  0 相等、1 date1大于date2、-1 date1小于date2
	 */
	public static int compare(Calendar date1, Calendar date2){
		int i = date1.get(Calendar.YEAR);
		int j = date2.get(Calendar.YEAR);
		
		if(i > j) return 1;
		if(i < j) return -1;
		
		i = date1.get(Calendar.MONTH);
		j = date2.get(Calendar.MONTH);
		if(i > j) return 1;
		if(i < j) return -1;
		
		i = date1.get(Calendar.DAY_OF_MONTH);
		j = date2.get(Calendar.DAY_OF_MONTH);
		if(i > j) return 1;
		if(i < j) return -1;
		
		i = date1.get(Calendar.HOUR_OF_DAY);
		j = date2.get(Calendar.HOUR_OF_DAY);
		if(i > j) return 1;
		if(i < j) return -1;
		
		i = date1.get(Calendar.MINUTE);
		j = date2.get(Calendar.MINUTE);
		if(i > j) return 1;
		if(i < j) return -1;
		
		i = date1.get(Calendar.SECOND);
		j = date2.get(Calendar.SECOND);
		if(i > j) return 1;
		if(i < j) return -1;
		
		return 0;
	}
	
	public static String formatDate(Date date, String pattern){
		return new SimpleDateFormat(pattern,Locale.getDefault()).format(date);
	}
}
