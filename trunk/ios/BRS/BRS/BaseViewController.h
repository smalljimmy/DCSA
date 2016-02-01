//
//  BaseViewController.h
//  BRS
//
//  Created by cgx on 13-10-24.
//  Copyright (c) 2013年 DouMob. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "LanguageView.h"//语言设置视图

#import "JsonFactory.h"
#import "AsyncImageView.h"
#import "MJRefresh.h"
#import "ReadWriteToDocument.h"

@interface BaseViewController : UIViewController<LanguageSelectDelegate,responseDelegate,UIWebViewDelegate,MJRefreshBaseViewDelegate>
{
    LanguageView *languageView;
    
    AsyncImageView *bgImageView;//整体的背景图片
    AsyncImageView *bannerImageView;//banner
    AsyncImageView *navImageView;//导航栏背景视图
    AsyncImageView *logoImageView;//logo图片
    UIButton *backButton;//返回按钮的图片
    UIButton *itemButton;//语言设置按钮
    
    
    UIView *defaultView;//默认视图

    UIWebView *WebdefaultView;
    
    UILabel *titleLabel;
    
    
    NSString *bannerString;//
    
    ReadWriteToDocument *document;
    
}


@property(nonatomic,retain)UIImageView *navImageView;//导航栏视图
-(void)settingPage:(NSArray *)language;//设置界面

-(void)settingLanguage;

//切换语言
-(void)changeLanguage:(NSString *)language_uid;
//更新图标
-(void)updateIcon:(NSArray *)imageArray;


-(JsonFactory *)requestFactory;

-(void)defaultText:(NSString *)text;
-(void)defaultView;//默认显示地址

//默认的web显示
-(void)WebdefaultView:(NSString *)urlString;

@end
