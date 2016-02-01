package ch.goco.ui;

import java.io.ByteArrayInputStream;
import java.io.InputStream;
import java.util.HashMap;
import java.util.Map;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;

import org.json.JSONArray;
import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.NodeList;

import ch.goco.company.R;
import ch.goco.config.LocalDataManager;
import ch.goco.entity.Company;
import ch.goco.webservice.WebServiceUtils;
import android.os.Bundle;
import android.text.Html;
import android.widget.PopupWindow;
import android.widget.TextView;
import app.fastdev.util.PopupWindowUtils;
import app.fastdev.util.ResourceUtils;
import app.fastdev.util.StringUtils;
import app.fastdev.util.ThreadUtils;

public class DefaultInfoActivity extends BaseActivity {

	String data;
	PopupWindow pw;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_default_info);
		
		loadCustomConfig();
		bindEventListener();
		
		data = getIntent().getStringExtra("data");
	}
	
	@Override
	protected void onResume() {
		super.onResume();
		// TEXT
		if(StringUtils.isNotBlank(data) && data.startsWith("<?xml")){
			initContentView(data);
		}else if(StringUtils.isNotBlank(data) && data.startsWith("http")){
		// HTTP
			ThreadUtils.runOnUiThread(new Runnable() {
				@Override
				public void run() {
					setUrlContentText(data);
				}
			}, 500);
		}else{
		// XML
			findViewById(R.id.text, TextView.class).setText(data);
		}
	}
	
	private void initContentView(String data){
		if(StringUtils.isBlank(data)){
			showCompanyInfo(LocalDataManager.getLocalCompany());
			return;
		}
		
		try {
			Map<String,Company> companyMap = parseCompanyList(data);
			Company company = companyMap.get(LocalDataManager.getCurrentLangugeId()+"");
			if(company == null && !companyMap.isEmpty()){
				company = companyMap.get(LocalDataManager.getDefaultLangugeId()+"");
			}
			if(company == null && !companyMap.isEmpty()){
				company = companyMap.entrySet().iterator().next().getValue();
			}
			showCompanyInfo(company);
		} catch (Exception e) {
			e.printStackTrace();
			showCompanyInfo(LocalDataManager.getLocalCompany());
		}
	}
	
	private Map<String,Company> parseCompanyList(String data) throws Exception{
		data = data.replace("<zip<", "<zip>");
		Map<String,Company> companyMap = new HashMap<String, Company>();
		InputStream ins = new ByteArrayInputStream(data.getBytes("UTF-8"));
		DocumentBuilder builder = DocumentBuilderFactory.newInstance().newDocumentBuilder();
		Document document = builder.parse(ins);
		NodeList itemNodeList = document.getElementsByTagName("item");
		Element itemNode,attrNode;
		Company company;
		for(int i=0,j=itemNodeList.getLength();i<j;i++){
			company = new Company();
			itemNode = (Element)itemNodeList.item(i);
			attrNode = (Element)itemNode.getElementsByTagName("language").item(0);
			company.setLanguage(Integer.parseInt(attrNode.getTextContent()));
			
			attrNode = (Element)itemNode.getElementsByTagName("name").item(0);
			company.setName(attrNode.getTextContent());
			
			attrNode = (Element)itemNode.getElementsByTagName("address").item(0);
			company.setAddress(attrNode.getTextContent());
			
			attrNode = (Element)itemNode.getElementsByTagName("zip").item(0);
			company.setZip(attrNode.getTextContent());
			
			attrNode = (Element)itemNode.getElementsByTagName("city").item(0);
			company.setCity(attrNode.getTextContent());
			
			attrNode = (Element)itemNode.getElementsByTagName("telephone").item(0);
			company.setTelephone(attrNode.getTextContent());
			
			attrNode = (Element)itemNode.getElementsByTagName("fax").item(0);
			company.setFax(attrNode.getTextContent());
			
			attrNode = (Element)itemNode.getElementsByTagName("hrnumber").item(0);
			company.setHrnumber(attrNode.getTextContent());
			
			attrNode = (Element)itemNode.getElementsByTagName("mailbox").item(0);
			company.setMailbox(attrNode.getTextContent());
			
			attrNode = (Element)itemNode.getElementsByTagName("www").item(0);
			company.setWww(attrNode.getTextContent());
			companyMap.put(""+company.getLanguage(), company);
		}
		
		ins.close();
		return companyMap;
	}
	
	private void showCompanyInfo(Company company){
		StringBuilder text = new StringBuilder();
		text.append("<b>").append(company.getName()).append("</b><br>");
		text.append(company.getAddress()).append("<br>");
		text.append(company.getZip()).append(" ").append(company.getCity()).append("<br>");
		text.append("<br>");
		text.append(ResourceUtils.getString(this, R.string.telephone)).append(". ").append(company.getTelephone()).append("<br>");
		text.append(ResourceUtils.getString(this, R.string.fax)).append(". ").append(company.getFax()).append("<br>");
		text.append(ResourceUtils.getString(this, R.string.email)).append(". ").append(company.getMailbox()).append("<br>");
		text.append(ResourceUtils.getString(this, R.string.hr_number)).append(". ").append(company.getHrnumber()).append("<br>");
		text.append(ResourceUtils.getString(this, R.string.web_site)).append(". ").append(company.getWww()).append("<br>");
		findViewById(R.id.text, TextView.class).setText(Html.fromHtml(text.toString()));
	}
	
	private void setUrlContentText(final String url){
		pw = PopupWindowUtils.showLoadingView(this);
		ThreadUtils.runOnNewThread(new Runnable() {
			@Override
			public void run() {
				final JSONArray ja = WebServiceUtils.getUrlContent(url);
				runOnUiThread(new Runnable() {
					public void run() {
						handlerUrlContent(ja);
					}
				});
			}
		}, "DefaultInfoActivity->getUrlContentText");
	}
	
	private void handlerUrlContent(JSONArray ja){
		if(pw != null) {
			pw.dismiss();
			pw = null;
		}
		// response empty
		if(ja == null || ja.length() == 0){
			showCompanyInfo(LocalDataManager.getLocalCompany());
			return;
		}
		String data = ja.optJSONObject(0).optString("content");
		if(data == null){
			showCompanyInfo(LocalDataManager.getLocalCompany());
			return;
		}
		if(!data.startsWith("<?xml")){
			findViewById(R.id.text, TextView.class).setText(data);
		}else{
			initContentView(data);
		}
	}
}
