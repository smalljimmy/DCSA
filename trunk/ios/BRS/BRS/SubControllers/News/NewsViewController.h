//
//  NewsViewController.h
//  BRS
//
//  Created by cgx on 13-10-28.
//  Copyright (c) 2013年 DouMob. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "NewsCell.h"
#import "NewsInfoView.h"

@interface NewsViewController : BaseViewController<UITableViewDataSource,UITableViewDelegate,NewsInfoDelegate,UIAlertViewDelegate,NSXMLParserDelegate>
{
    UITableView *newsTableView;
    NSMutableString *tempString;
    NewsInfoView *newsInfo;//详细内容
    
    NSMutableArray *newsArray;
    
    int deleteNum;
    
    MJRefreshHeaderView *_header;
    
    NSMutableArray *itemArray;
    NSMutableArray *titleArray;
    NSMutableArray *descriptionArray;
    NSMutableArray *pubDateArray;
    NSMutableArray *linkArray;
    
    
}

@property(nonatomic,assign)int subtype;
@property(nonatomic,retain)NSString *urlLinking;


@end
