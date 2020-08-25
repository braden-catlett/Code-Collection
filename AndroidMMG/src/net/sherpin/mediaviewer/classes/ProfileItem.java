package net.sherpin.mediaviewer.classes;

public class ProfileItem {
	public String pid;
	public String name;
	public String checked;
	public String desc;
	public String Icon;

	@Override
	public String toString() {
		return (checked != null && checked.compareTo("1") == 0) ? String
				.format("+ %s", name) : name;
	}
}
