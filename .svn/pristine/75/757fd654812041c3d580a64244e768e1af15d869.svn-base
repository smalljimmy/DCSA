package app.fastdev.util;

import android.content.Context;
import android.view.View;
import android.view.animation.Animation.AnimationListener;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;

/**
 * 执行动画的工具类
 */
public class AnimationExecuteUtils {

	public static void fadeIn(Context context,View view,AnimationListener listener){
		executeAnimation(context, view, android.R.anim.fade_in,listener);
	}
	
	public static void fadeOut(Context context,View view,AnimationListener listener){
		executeAnimation(context, view, android.R.anim.fade_out,listener);
	}
	
	public static void executeAnimation(Context context,View view, int resId,AnimationListener listener){
		Animation anim = AnimationUtils.loadAnimation(context, resId);
		executeAnimation(anim, view, listener);
	}
	
	public static void executeAnimation(Animation anim,View view,AnimationListener listener){
		if(listener != null) anim.setAnimationListener(listener);
		view.startAnimation(anim);
	}
}
