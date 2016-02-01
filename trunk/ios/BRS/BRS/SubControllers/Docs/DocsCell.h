//
//  DocsCell.h
//  BRS
//
//  Created by cgx on 13-10-28.
//  Copyright (c) 2013年 DouMob. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface DocsCell : UITableViewCell
{
    IBOutlet UILabel *titleLabel;
    IBOutlet UILabel *messageLabel;
    
    IBOutlet UIButton *downLoadButton;
    IBOutlet UILabel *progressLabel;
    IBOutlet UILabel *desLabel;
    IBOutlet UIImageView *desImageView;
    
    
}
@property(nonatomic,retain)UILabel *titleLabel;
@property(nonatomic,retain)UILabel *messageLabel;
@property(nonatomic,retain)UIButton *downLoadButton;
@property(nonatomic,retain)UILabel *progressLabel;
@property(nonatomic,retain)UILabel *desLabel;
@property(nonatomic,retain)UIImageView *desImageView;

@end
