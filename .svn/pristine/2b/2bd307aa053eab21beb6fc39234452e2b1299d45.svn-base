package ch.goco.config;

import java.io.InputStream;
import java.util.HashMap;
import java.util.Map;
import javax.xml.parsers.SAXParser;
import javax.xml.parsers.SAXParserFactory;

import org.xml.sax.Attributes;
import org.xml.sax.SAXException;
import org.xml.sax.helpers.DefaultHandler;

/**
 * 配置文件解析类
 */
public class XmlParse extends DefaultHandler {

	private Map<String, String> dataMap;  
	// 标签名
	private String tag;
	// 键名
	private String key;
	// 对应的值
	private String value;
	
	private XmlParse(InputStream input){
		dataMap = new HashMap<String, String>();
		try {
			SAXParser sax = SAXParserFactory.newInstance().newSAXParser();  
			sax.parse(input, this);  
			input.close();
		} catch (Exception e) {
			throw new RuntimeException(e);
		}
	}
	
	@Override
	public void characters(char[] ch, int start, int length)
			throws SAXException {
		// 如果标签包含内容，则优先使用标签内容作为值
		if(length > 0){
			if(this.value == null) this.value = "";
			this.value += new String(ch,start,length);
		}
	}

	@Override
	public void endElement(String uri, String localName, String qName)
			throws SAXException {
		// 标签异常结束
		if(tag == null || !tag.equals(localName)) return;
		// 标签存在key和value
		if(key != null && value != null){
			dataMap.put(key, value.trim().replaceAll("\\s+", " "));
		}
		this.tag = null;
		this.key = null;
		this.value = null;
	}
	
	@Override
	public void startElement(String uri, String localName, String qName,
			Attributes attributes) throws SAXException {
		this.tag = localName;
		// 标签key属性值
		this.key = attributes.getValue("", "name");
		// 标签value属性值
		this.value = attributes.getValue("", "value");
	}
	
	/**
	 * 传入配置文件的文件流
	 * @param input
	 * @return 返回解析好的key-value对象
	 */
	public static Map<String,String> parse(InputStream input){
		return new XmlParse(input).dataMap;
	}
}
