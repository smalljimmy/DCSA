package app.fastdev.util;

import java.util.Date;
import java.util.Properties;

import javax.mail.Authenticator;
import javax.mail.Message;
import javax.mail.MessagingException;
import javax.mail.PasswordAuthentication;
import javax.mail.Session;
import javax.mail.Transport;
import javax.mail.internet.AddressException;
import javax.mail.internet.InternetAddress;
import javax.mail.internet.MimeMessage;

public class EmailUtils {

	public static void sendTextEmail(final String username, final String password, EmailEntry entry) throws AddressException, MessagingException{
		Properties props = new Properties();
	    props.put("mail.smtp.host", entry.host);
	    props.put("mail.smtp.auth","true");
	    
	    Session session = Session.getInstance(props, new Authenticator() {
			@Override
			protected PasswordAuthentication getPasswordAuthentication() {
				return new PasswordAuthentication(username, password);
			}
		});
	    
        MimeMessage msg = new MimeMessage(session);
        msg.setFrom(new InternetAddress(entry.sender));
        msg.setRecipients(Message.RecipientType.TO, entry.recevier);
        msg.setSubject(entry.title);
        msg.setSentDate(new Date());
        msg.setText(entry.text);
        Transport.send(msg);
	}
	
	public static class EmailEntry{
		public String host;
		public String sender;
		public String recevier;
		public String title;
		public String text;
	}
}
