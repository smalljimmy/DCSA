package app.fastdev.util;

import java.util.Locale;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class LocaleUtils {

	public static Locale getLocal(String lang){
		if(StringUtils.isBlank(lang)) return null;
		Matcher matcher = Pattern.compile("^(\\w+)_(\\w+)$").matcher(lang);
		if(!matcher.find()) {
			return null;
		}
		return new Locale(matcher.group(1), matcher.group(2));
	}
	
	public static Locale getLocalFromLanguage(String language){
		if(StringUtils.isBlank(language)) return null;
		return new Locale(language);
	}
}
