package ch.goco.entity;

import java.io.Serializable;

public class Language implements Serializable{

	private static final long serialVersionUID = 1L;
	
	private int id;
	private String code;
	private String name;
	private int resId;
	
	public Language(){};
	
	/**
	 * 
	 * @param uid 语言UID
	 * @param code 语言代码
	 * @param name 语言名称
	 * @param resId 图标资源
	 */
	public Language(int id, String code, String name, int resId) {
		super();
		this.id = id;
		this.code = code;
		this.name = name;
		this.resId = resId;
	}
	public int getId() {
		return id;
	}
	public void setId(int id) {
		this.id = id;
	}
	public String getCode() {
		return code;
	}
	public void setCode(String code) {
		this.code = code;
	}
	public String getName() {
		return name;
	}
	public void setName(String name) {
		this.name = name;
	}
	public int getResId() {
		return resId;
	}
	public void setResId(int resId) {
		this.resId = resId;
	}
	
}
