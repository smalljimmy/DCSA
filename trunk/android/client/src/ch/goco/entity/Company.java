package ch.goco.entity;

import java.io.Serializable;

public class Company implements Serializable{

	private static final long serialVersionUID = 1L;

	private int language;
	private String name;
	private String address;
	private String zip;
	private String city;
	private String telephone;
	private String fax;
	private String hrnumber;
	private String mailbox;
	private String www;
	public int getLanguage() {
		return language;
	}
	public void setLanguage(int language) {
		this.language = language;
	}
	public String getName() {
		return name;
	}
	public void setName(String name) {
		this.name = name;
	}
	public String getAddress() {
		return address;
	}
	public void setAddress(String address) {
		this.address = address;
	}
	public String getZip() {
		return zip;
	}
	public void setZip(String zip) {
		this.zip = zip;
	}
	public String getCity() {
		return city;
	}
	public void setCity(String city) {
		this.city = city;
	}
	public String getTelephone() {
		return telephone;
	}
	public void setTelephone(String telephone) {
		this.telephone = telephone;
	}
	public String getFax() {
		return fax;
	}
	public void setFax(String fax) {
		this.fax = fax;
	}
	public String getHrnumber() {
		return hrnumber;
	}
	public void setHrnumber(String hrnumber) {
		this.hrnumber = hrnumber;
	}
	public String getMailbox() {
		return mailbox;
	}
	public void setMailbox(String mailbox) {
		this.mailbox = mailbox;
	}
	public String getWww() {
		return www;
	}
	public void setWww(String www) {
		this.www = www;
	}
	
}
