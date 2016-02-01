package ch.goco.entity;

import java.io.Serializable;

public class Banner implements Serializable {

	private static final long serialVersionUID = 1L;

	private String url;
	private String path;
	
	public String getUrl() {
		return url;
	}
	public void setUrl(String url) {
		this.url = url;
	}
	public String getPath() {
		return path;
	}
	public void setPath(String path) {
		this.path = path;
	}
}
