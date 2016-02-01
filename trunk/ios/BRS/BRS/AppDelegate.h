//
//  AppDelegate.h
//  BRS
//
//  Created by cgx on 13-10-15.
//  Copyright (c) 2013年 DouMob. All rights reserved.
//

#import <UIKit/UIKit.h>

#import "CustomNavigationController.h"//自定义导航栏
#import "RootViewController.h"

#import <AudioToolbox/AudioToolbox.h>

@interface AppDelegate : UIResponder <UIApplicationDelegate>
{
    
}

@property (strong, nonatomic) UIWindow *window;
@property(nonatomic,retain)NSDictionary *configDic;
@property(nonatomic,retain)NSString *baseUrl;

@property(nonatomic,retain)NSString *updateTitle;//更新标题
@property(nonatomic,retain)NSString *updateBanner;//更新banner;
@property(nonatomic,retain)NSString *token;
@property(nonatomic,retain)NSString *push;

+(AppDelegate*)setGlobal;


@end
