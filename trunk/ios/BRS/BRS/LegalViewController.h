//
//  LegalViewController.h
//  BRS
//
//  Created by cgx on 14-2-8.
//  Copyright (c) 2014年 DouMob. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "LegalCell.h"

@interface LegalViewController : BaseViewController<UITableViewDataSource,UITableViewDelegate>
{
    NSArray *legalArray;
    UITableView *legalTableView;
}

@property(nonatomic,assign)int  subtype;
@property(nonatomic,retain)NSString *urlLinking;

@end
