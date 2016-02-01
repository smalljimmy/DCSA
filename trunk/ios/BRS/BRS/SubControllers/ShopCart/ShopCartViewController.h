//
//  ShopCartViewController.h
//  BRS
//
//  Created by cgx on 13-10-28.
//  Copyright (c) 2013年 DouMob. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "NewsInfoView.h"


#import "DesUtil.h"


@interface ShopCartViewController : BaseViewController<UITextFieldDelegate,UITextViewDelegate,NewsInfoDelegate,UITableViewDataSource,UITableViewDelegate>
{
    NewsInfoView *newsInfo;//提示内容
    UITextView *textview;
    
    NSString *lagCode;
    
    int subtype;
    
    UITextField *textfield;
    UIView *subView;
    
    NSMutableArray *mutableArray;
    UITableView *tableview;
    
    
}

@property(nonatomic,retain) NSString *lagCode;
@property(nonatomic,assign)int subtype;
@property(nonatomic,retain) NSString *urlLinking;

@end
