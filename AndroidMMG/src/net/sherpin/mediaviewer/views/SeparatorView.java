package net.sherpin.mediaviewer.views;

import android.content.Context;
import android.graphics.Color;
import android.view.View;

public class SeparatorView extends View
{
	public SeparatorView(Context context)
	{
		super(context);
		this.setBackgroundColor(Color.GRAY);
		this.setMinimumHeight(3);
	}
}
