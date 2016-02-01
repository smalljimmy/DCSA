package app.fastdev.util;

import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;

public class IOUtils {

	public static void closeInputStreamQuiet(InputStream input){
		if(input == null) return;
		try {
			input.close();
		} catch (IOException e) {}
	}
	
	public static void closeOutputStreamQuiet(OutputStream output){
		if(output == null) return;
		try {
			output.close();
		} catch (IOException e) {}
	}
}
