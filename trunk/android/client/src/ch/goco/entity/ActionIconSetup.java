package ch.goco.entity;

import java.io.Serializable;

public class ActionIconSetup implements Serializable{
	
	private static final long serialVersionUID = 1L;
	
	private int type;
	private int subtype;
	private String data;
	
	public ActionIconSetup(int type, int subtype, String data) {
		super();
		this.type = type;
		this.subtype = subtype;
		this.data = data;
	}
	public int getType() {
		return type;
	}
	public void setType(int type) {
		this.type = type;
	}
	public int getSubtype() {
		return subtype;
	}
	public void setSubtype(int subtype) {
		this.subtype = subtype;
	}
	public String getData() {
		return data;
	}
	public void setData(String data) {
		this.data = data;
	}
	
}
