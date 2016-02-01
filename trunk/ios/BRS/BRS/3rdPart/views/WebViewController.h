//
//  WebViewController.h
//  BRS
//
//  Created by cgx on 14-5-28.
//  Copyright (c) 2014年 DouMob. All rights reserved.
//

#import "BaseViewController.h"

@interface WebViewController : BaseViewController<UIWebViewDelegate>
{
    
}

@property(nonatomic,retain)NSDictionary *webDic;
@property(nonatomic,retain)NSString *linking;

@property(nonatomic,assign)int type;
@end
