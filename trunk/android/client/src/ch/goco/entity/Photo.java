package ch.goco.entity;

import java.io.Serializable;

public class Photo implements Serializable{

	private static final long serialVersionUID = 1L;
	
	private int id;
	private String path;
	
	public Photo(int id, String path) {
		super();
		this.id = id;
		this.path = path;
	}
	public int getId() {
		return id;
	}
	public void setId(int id) {
		this.id = id;
	}
	public String getPath() {
		return path;
	}
	public void setPath(String path) {
		this.path = path;
	}
}
