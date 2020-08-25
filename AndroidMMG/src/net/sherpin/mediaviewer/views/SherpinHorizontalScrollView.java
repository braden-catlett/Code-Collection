package net.sherpin.mediaviewer.views;

import android.content.Context;
import android.util.AttributeSet;
import android.view.View;
import android.widget.HorizontalScrollView;

public class SherpinHorizontalScrollView extends HorizontalScrollView
{
	private OnScrollViewReachedEndListener scrollend;

	public SherpinHorizontalScrollView(Context context)
	{
		super(context);
	}

	public SherpinHorizontalScrollView(Context context, AttributeSet attrs)
	{
		super(context, attrs);
	}

	public SherpinHorizontalScrollView(Context context, AttributeSet attrs, int defStyle)
	{
		super(context, attrs, defStyle);
	}

	public void setOnScrollViewReachedEndListener(OnScrollViewReachedEndListener listener)
	{
		scrollend = listener;
	}

	@Override
	protected void onScrollChanged(int l, int t, int oldl, int oldt)
	{
		View v = getChildAt(getChildCount() - 1);

		int diff = (v.getRight() - (getWidth() + getScrollX()));

		if (diff <= 0 && scrollend != null)
		{
			scrollend.didReachEnd(this);
		}
		super.onScrollChanged(l, t, oldl, oldt);
	}

}
