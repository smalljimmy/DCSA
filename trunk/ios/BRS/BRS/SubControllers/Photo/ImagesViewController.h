//
//  ImagesViewController.h
//  BRS
//
//  Created by cgx on 14-1-15.
//  Copyright (c) 2014年 DouMob. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface ImagesViewController : BaseViewController<UIScrollViewDelegate>
{
    NSArray *imageArr;
    
    UIScrollView *scrollView1;
    UIPageControl *pageControl;
    
    UILabel *pagecontrolView;
    
}

@property(nonatomic,retain)NSArray *imageArr;

@end
