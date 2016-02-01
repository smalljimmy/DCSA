//
//  PushViewController.h
//  BRS
//
//  Created by cgx on 14-8-1.
//  Copyright (c) 2014年 DouMob. All rights reserved.
//

#import "BaseViewController.h"
#import "NewsCell.h"
#import "NewsInfoView.h"

@interface PushViewController : BaseViewController<UITableViewDataSource,UITableViewDelegate,NewsInfoDelegate>
{
    UITableView *pushTableView;
    NSMutableArray *pushArray;
    
    NewsInfoView *newsInfo;
    
    NSMutableArray *tempPushArray;
    
}

@end
