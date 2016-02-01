package ch.goco.entity;

import java.io.Serializable;

public class Docs implements Serializable{

	private static final long serialVersionUID = 1L;

	private int id;
	private String title;
	private String desc;
	private String path;
	
	public Docs(int id,String title, String desc ,String path) {
		super();
		this.id = id;
		this.title = title;
		this.desc = desc;
		this.path = path;
	}
	
	public int getId() {
		return id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public String getTitle() {
		return title;
	}
	public void setTitle(String title) {
		this.title = title;
	}
	public String getDesc() {
		return desc;
	}
	public void setDesc(String desc) {
		this.desc = desc;
	}
	public String getPath() {
		return path;
	}
	public void setPath(String path) {
		this.path = path;
	}
	
}
