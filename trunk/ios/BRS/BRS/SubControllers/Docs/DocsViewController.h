//
//  DocsViewController.h
//  BRS
//
//  Created by cgx on 13-10-28.
//  Copyright (c) 2013年 DouMob. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "DocsCell.h"


#import "ASIHTTPRequest.h"

#import "DownFileManage.h"//下载文件管理

#import "ReaderViewController.h"

@interface DocsViewController : BaseViewController<UITableViewDataSource,UITableViewDelegate,DownloadFileDelegate,ReaderViewControllerDelegate>
{
    UITableView *docsTableView;
    
    NSArray *docsArray;
    
    ASIHTTPRequest *req;
    
    DownFileManage *downManage;//下载管理
    
    int flag;
    
    int subtype;
    
    MJRefreshHeaderView *_header;
    
}
@property(nonatomic,assign)int subtype;
@property(nonatomic,retain)NSString *urlLinking;

@end
