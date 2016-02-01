package ch.goco.entity;

import java.io.Serializable;
import java.util.Date;

public class RSS implements Serializable{

	private static final long serialVersionUID = 1L;

	private String title;
	private String description;
	private String link;
	private String image;
	private String imageBig;
	private Date date;
	
	public String getTitle() {
		return title;
	}
	public void setTitle(String title) {
		this.title = title;
	}
	public String getDescription() {
		return description;
	}
	public void setDescription(String description) {
		this.description = description;
	}
	public String getLink() {
		return link;
	}
	public void setLink(String link) {
		this.link = link;
	}
	public String getImage() {
		return image;
	}
	public void setImage(String image) {
		this.image = image;
	}
	public String getImageBig() {
		return imageBig;
	}
	public void setImageBig(String imageBig) {
		this.imageBig = imageBig;
	}
	public Date getDate() {
		return date;
	}
	public void setDate(Date date) {
		this.date = date;
	}
	
}
