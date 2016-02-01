//
//  LegalCell.m
//  BRS
//
//  Created by cgx on 14-5-22.
//  Copyright (c) 2014年 DouMob. All rights reserved.
//

#import "LegalCell.h"

@implementation LegalCell
@synthesize infoLable;
@synthesize nameLabel;

- (id)initWithStyle:(UITableViewCellStyle)style reuseIdentifier:(NSString *)reuseIdentifier
{
    self = [super initWithStyle:style reuseIdentifier:reuseIdentifier];
    if (self) {
        // Initialization code
    }
    return self;
}

- (void)awakeFromNib
{
    // Initialization code
}

- (void)setSelected:(BOOL)selected animated:(BOOL)animated
{
    [super setSelected:selected animated:animated];

    // Configure the view for the selected state
}

-(void)dealloc
{
    [nameLabel release];
    [infoLable release];
    
    [super dealloc];
}

@end
