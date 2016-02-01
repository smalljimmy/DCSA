//
//  NewsCell.h
//  BRS
//
//  Created by cgx on 13-10-28.
//  Copyright (c) 2013年 DouMob. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface NewsCell : UITableViewCell
{
    IBOutlet UILabel *titleLabel;
    IBOutlet UILabel *messageLabel;
    IBOutlet UILabel *timeLabel;
    IBOutlet UIButton *deleteButton;
    IBOutlet UILabel *messageContentLabel;
    
    
}
@property(nonatomic,retain)UILabel *titleLabel;
@property(nonatomic,retain)UILabel *messageLabel;
@property(nonatomic,retain)UILabel *timeLabel;
@property(nonatomic,retain)UIButton *deleteButton;
@property(nonatomic,retain)UILabel *messageContentLabel;

@end
