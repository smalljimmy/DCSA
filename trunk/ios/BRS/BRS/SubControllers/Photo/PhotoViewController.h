//
//  PhotoViewController.h
//  BRS
//
//  Created by cgx on 13-10-28.
//  Copyright (c) 2013年 DouMob. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "PhotoCell.h"
#import "ImagesViewController.h"

@interface PhotoViewController : BaseViewController<UITableViewDataSource,UITableViewDelegate>
{
    UITableView *photoTableView;
    
    NSArray *photoArray;
    
    MJRefreshHeaderView *_header;
    
}
@property(nonatomic,assign)int subtype;
@property(nonatomic,retain)NSString *urlLinking;

@end
